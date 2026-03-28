<?php

namespace App\Http\Controllers;

use App\Models\CampaignItem;
use App\Models\MeasurementAsset;
use App\Models\Region;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ContractorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:measurer|installer']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $regions = $user->assignedRegions;

        $tasks = collect();

        if ($user->hasRole('measurer')) {
            $tasks = $tasks->merge($user->measurementTasks()->with(['campaign', 'shop', 'shop.region'])->get());
        }
        if ($user->hasRole('installer')) {
            $tasks = $tasks->merge($user->installationTasks()->with(['campaign', 'shop', 'shop.region'])->get());
        }

        return view('contractor.dashboard', compact('regions', 'tasks'));
    }

    public function shops(Region $region)
    {
        $user = Auth::user();
        if (!$user->assignedRegions->contains($region->id)) {
            abort(403);
        }

        $shops = $region->shops()->with('campaignItems')->get();

        return view('contractor.shops', compact('region', 'shops'));
    }

    public function storeShop(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $shop = Shop::create([
            'company_id' => Auth::user()->company_id,
            'city_id' => $region->city_id,
            'region_id' => $region->id,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('contractor.shops', $region)->with('success', 'Shop added.');
    }

    public function addMeasurement(CampaignItem $item)
    {
        $this->authorize('update', $item);
        $user = Auth::user();
        if ($item->assigned_measurer_id != $user->id) {
            abort(403);
        }

        return view('contractor.measurement', compact('item'));
    }

    public function storeMeasurement(Request $request, CampaignItem $item)
    {
        $this->authorize('update', $item);
        $user = Auth::user();
        if ($item->assigned_measurer_id != $user->id) {
            abort(403);
        }

        $request->validate([
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'unit' => 'required|in:cm,inch,pixel',
            'material' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'text' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $item->update([
            'width' => $request->width,
            'height' => $request->height,
            'unit' => $request->unit,
            'material' => $request->material,
            'quantity' => $request->quantity,
            'text' => $request->text,
            'status' => 'measured',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type' => 'before',
                'file_path' => $path,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'mime_type' => $request->file('image')->getMimeType(),
                'size' => $request->file('image')->getSize(),
                'uploaded_by' => $user->id,
                'captured_at' => now(),
            ]);
        }

        return redirect()->route('contractor.dashboard')->with('success', 'Measurement saved.');
    }

    public function install(CampaignItem $item)
    {
        $user = Auth::user();
        if ($item->assigned_installer_id != $user->id) {
            abort(403);
        }

        return view('contractor.install', compact('item'));
    }

    public function storeInstallation(Request $request, CampaignItem $item)
    {
        $user = Auth::user();
        if ($item->assigned_installer_id != $user->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:installed,failed',
            'failure_reason' => 'required_if:status,failed|nullable|string',
            'before_image' => 'nullable|image|max:10240',
            'after_image' => 'nullable|image|max:10240',
        ]);

        $item->status = $request->status;
        if ($request->status === 'failed') {
            $item->failure_reason = $request->failure_reason;
        } else {
            $item->installed_by = $user->id;
            $item->installed_at = Carbon::now();
        }
        $item->save();

        // رفع الصور
        if ($request->hasFile('before_image')) {
            $path = $request->file('before_image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type' => 'before',
                'file_path' => $path,
                'original_name' => $request->file('before_image')->getClientOriginalName(),
                'mime_type' => $request->file('before_image')->getMimeType(),
                'size' => $request->file('before_image')->getSize(),
                'uploaded_by' => $user->id,
                'captured_at' => now(),
            ]);
        }

        if ($request->hasFile('after_image')) {
            $path = $request->file('after_image')->store('measurements', 'public');
            MeasurementAsset::create([
                'campaign_item_id' => $item->id,
                'type' => 'after',
                'file_path' => $path,
                'original_name' => $request->file('after_image')->getClientOriginalName(),
                'mime_type' => $request->file('after_image')->getMimeType(),
                'size' => $request->file('after_image')->getSize(),
                'uploaded_by' => $user->id,
                'captured_at' => now(),
            ]);
        }

        return redirect()->route('contractor.dashboard')->with('success', 'Installation updated.');
    }
}
