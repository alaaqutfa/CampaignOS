<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignItemController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorize('view', $campaign);
        $items = $campaign->items()->with(['shop.city', 'shop.region', 'recordedBy', 'assets', 'assignedMeasurer', 'assignedInstaller'])->get();
        return view('campaigns.show', compact('campaign', 'items'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('addMeasurement', $campaign);
        $companyId  = Auth::user()->company_id;
        $shops      = Shop::where('company_id', $companyId)->with('city', 'region')->get();
        $measurers  = User::where('company_id', $companyId)->role('measurer')->get();
        $installers = User::where('company_id', $companyId)->role('installer')->get();

        return view('campaigns.items.create', compact('campaign', 'shops', 'measurers', 'installers'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('addMeasurement', $campaign);

        $validated = $request->validate([
            'shop_id'               => 'required|exists:shops,id',
            'material'              => 'required|string|max:255',
            'quantity'              => 'required|integer|min:1',
            'width'                 => 'required|numeric|min:0.01',
            'height'                => 'required|numeric|min:0.01',
            'unit'                  => 'required|in:cm,inch,pixel',
            'text'                  => 'nullable|string',
            'notes'                 => 'nullable|string',
            'assigned_measurer_id'  => 'nullable|exists:users,id',
            'assigned_installer_id' => 'nullable|exists:users,id',
        ]);

        $sqm = ($validated['width'] * $validated['height'] * $validated['quantity']) / 10000;

        $printFileName = $this->generatePrintFileName($campaign, $validated);

        $item = $campaign->items()->create([
            'shop_id'               => $validated['shop_id'],
            'material'              => $validated['material'],
            'quantity'              => $validated['quantity'],
            'width'                 => $validated['width'],
            'height'                => $validated['height'],
            'unit'                  => $validated['unit'],
            'text'                  => $validated['text'],
            'print_file_name'       => $printFileName,
            'sqm'                   => $sqm,
            'recorded_by'           => Auth::user()->id,
            'notes'                 => $validated['notes'],
            'status'                => 'pending',
            'assigned_measurer_id'  => $validated['assigned_measurer_id'],
            'assigned_installer_id' => $validated['assigned_installer_id'],
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement added successfully.');
    }

    public function edit(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('update', $item);
        $companyId  = Auth::user()->company_id;
        $shops      = Shop::where('company_id', $companyId)->with('city', 'region')->get();
        $measurers  = User::where('company_id', $companyId)->role('measurer')->get();
        $installers = User::where('company_id', $companyId)->role('installer')->get();

        return view('campaigns.items.edit', compact('campaign', 'item', 'shops', 'measurers', 'installers'));
    }

    public function update(Request $request, Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('update', $item);

        // لا يمكن تعديل القياس بعد التركيب أو الرفض
        // if (! in_array($item->status, ['pending', 'designed', 'printed'])) {
        //     return redirect()->back()->with('error', 'Cannot edit measurement after installation or rejection.');
        // }

        $validated = $request->validate([
            'shop_id'               => 'required|exists:shops,id',
            'material'              => 'required|string|max:255',
            'quantity'              => 'required|integer|min:1',
            'width'                 => 'required|numeric|min:0.01',
            'height'                => 'required|numeric|min:0.01',
            'unit'                  => 'required|in:cm,inch,pixel',
            'text'                  => 'nullable|string',
            'notes'                 => 'nullable|string',
            'assigned_measurer_id'  => 'nullable|exists:users,id',
            'assigned_installer_id' => 'nullable|exists:users,id',
        ]);

        $sqm = ($validated['width'] * $validated['height'] * $validated['quantity']) / 10000;

        $item->update([
            'shop_id'               => $validated['shop_id'],
            'material'              => $validated['material'],
            'quantity'              => $validated['quantity'],
            'width'                 => $validated['width'],
            'height'                => $validated['height'],
            'unit'                  => $validated['unit'],
            'text'                  => $validated['text'],
            'sqm'                   => $sqm,
            'notes'                 => $validated['notes'],
            'assigned_measurer_id'  => $validated['assigned_measurer_id'],
            'assigned_installer_id' => $validated['assigned_installer_id'],
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement updated successfully.');
    }

    public function destroy(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Measurement deleted successfully.');
    }

    protected function generatePrintFileName($campaign, $data)
    {
        $shop = Shop::find($data['shop_id']);
        return sprintf(
            '%s - %s - %sx%s - %s',
            $campaign->title,
            $shop->name,
            $data['width'],
            $data['height'],
            $data['material']
        );
    }
}
