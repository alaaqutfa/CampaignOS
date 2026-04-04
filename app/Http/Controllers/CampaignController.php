<?php
namespace App\Http\Controllers;

use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::with(['creator', 'items.shop.city', 'workflows'])
            ->where('company_id', $request->user()->company_id)
            ->latest()
            ->paginate(20);

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $clients = Client::where('company_id', Auth::user()->company_id)->get();
        return view('campaigns.create', compact('clients'));
    }

    public function store(StoreCampaignRequest $request)
    {
        $campaign = Campaign::create([
            'company_id' => $request->user()->company_id,
            'title'      => $request->title,
            'client_id'  => $request->client_id,
            'location'   => $request->location,
            'status'     => $request->status ?? 'draft',
            'priority'   => $request->priority ?? 'medium',
            'due_date'   => $request->due_date,
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {

        $this->authorize('view', $campaign);
        $campaign->load([
            'creator',
            'items.shop.city',
            'items.recordedBy',
            'items.installedBy',
            'items.assets',
            'workflows.assignee',
        ]);
        $items = CampaignItem::where('campaign_id', $campaign->id)
            ->with(['shop.city', 'shop.region', 'recordedBy', 'assets', 'assignedMeasurer', 'assignedInstaller'])
            ->paginate(100);
        $cities = CampaignItem::where('campaign_id', $campaign->id)
            ->with('shop.city')
            ->get()
            ->pluck('shop.city')
            ->filter()
            ->unique('id')
            ->values();

        return view('campaigns.show', compact('campaign', 'items', 'cities'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        $clients = Client::where('company_id', Auth::user()->company_id)->get();
        return view('campaigns.edit', compact('campaign', 'clients'));
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        $campaign->update($request->validated());

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }

    public function exportBeforeAfterPdf(Request $request, Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $cityId = $request->city_id;

        if (! $cityId) {
            abort(400, 'City is required');
        }

        $items = $campaign->items()
            ->whereHas('shop', function ($q) use ($cityId) {
                $q->where('city_id', $cityId);
            })
            ->with([
                'assets' => fn($q) => $q->whereIn('type', ['before', 'after']),
                'shop.city',
                'shop.region',
            ])
            ->get()
            ->groupBy(fn($item) => $item->shop->region->name ?? 'No Region');

        $pdf = Pdf::loadView('campaigns.pdf.before-after', [
            'campaign' => $campaign,
            'grouped'  => $items,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("campaign_{$campaign->id}_city_{$cityId}.pdf");
    }
}
