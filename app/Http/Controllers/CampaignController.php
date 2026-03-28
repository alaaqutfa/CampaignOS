<?php
namespace App\Http\Controllers;

use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::with(['creator', 'items.shop.city', 'workflows'])
            ->where('company_id', $request->user()->company_id)
            ->latest()
            ->paginate(15);

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(StoreCampaignRequest $request)
    {
        $campaign = Campaign::create([
            'company_id'  => $request->user()->company_id,
            'title'       => $request->title,
            'client_name' => $request->client_name,
            'location'    => $request->location,
            'status'      => $request->status ?? 'draft',
            'priority'    => $request->priority ?? 'medium',
            'due_date'    => $request->due_date,
            'created_by'  => $request->user()->id,
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
        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
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
}
