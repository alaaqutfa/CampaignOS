<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\MeasurementAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeasurementAssetController extends Controller
{
    public function index(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('view', $item);
        $assets = $item->assets()->latest()->get();
        return view('campaigns.items.assets.index', compact('campaign', 'item', 'assets'));
    }

    public function create(Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('updateInstallation', $item);
        return view('campaigns.items.assets.create', compact('campaign', 'item'));
    }

    public function store(Request $request, Campaign $campaign, CampaignItem $item)
    {
        $this->authorize('updateInstallation', $item);

        $request->validate([
            'type' => 'required|in:before,after',
            'image' => 'required|image|max:10240', // 10MB max
            'captured_at' => 'nullable|date',
        ]);

        $path = $request->file('image')->store('campaign-assets', 'public');

        $asset = $item->assets()->create([
            'type' => $request->type,
            'file_path' => $path,
            'original_name' => $request->file('image')->getClientOriginalName(),
            'mime_type' => $request->file('image')->getMimeType(),
            'size' => $request->file('image')->getSize(),
            'uploaded_by' => auth()->id(),
            'captured_at' => $request->captured_at ?? now(),
        ]);

        if ($request->type === 'after' && $item->status !== 'installed') {
            $item->update([
                'status' => 'installed',
                'installed_by' => auth()->id(),
                'installed_at' => now(),
            ]);
        }

        return redirect()->route('assets.index', [$campaign, $item])
            ->with('success', 'Image uploaded successfully.');
    }

    public function destroy(Campaign $campaign, CampaignItem $item, MeasurementAsset $asset)
    {
        $this->authorize('delete', $asset);
        Storage::disk('public')->delete($asset->file_path);
        $asset->delete();

        return redirect()->route('assets.index', [$campaign, $item])
            ->with('success', 'Image deleted successfully.');
    }
}
