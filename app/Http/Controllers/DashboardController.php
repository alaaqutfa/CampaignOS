<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\City;
use App\Models\Shop;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_super_admin) {
            return redirect()->route('super-admin.dashboard');
        }
        $companyId = auth()->user()->company_id;

        $stats = [
            'total_campaigns'        => Campaign::where('company_id', $companyId)->count(),
            'active_campaigns'       => Campaign::where('company_id', $companyId)
                ->where('status', 'active')
                ->count(),
            'total_measurements'     => CampaignItem::whereHas('campaign', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->count(),
            'pending_measurements'   => CampaignItem::whereHas('campaign', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->where('status', 'pending')->count(),
            'installed_measurements' => CampaignItem::whereHas('campaign', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })->where('status', 'installed')->count(),
            'total_cities'           => City::where('company_id', $companyId)->count(),
            'total_shops'            => Shop::where('company_id', $companyId)->count(),
        ];

        $recentMeasurements = CampaignItem::with(['campaign', 'shop', 'recordedBy'])
            ->whereHas('campaign', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'recentMeasurements'));
    }
}
