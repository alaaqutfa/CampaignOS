<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    public function campaigns($token)
    {
        $client    = Client::where('access_token', $token)->firstOrFail();
        $campaigns = $client->campaigns()->with('company')->get();
        return view('client-portal.campaigns', compact('client', 'campaigns'));
    }

    public function measurements(Request $request, $token)
    {
        $client = Client::where('access_token', $token)->firstOrFail();

        // جلب الحملة المحددة (إذا وجدت) لعرض عنوانها
        $campaign = null;
        if ($request->has('campaign_id')) {
            $campaign = Campaign::where('id', $request->campaign_id)
                ->where('client_id', $client->id)
                ->first();
        }

        // بناء الاستعلام الأساسي
        $query = CampaignItem::whereHas('campaign', function ($q) use ($client) {
            $q->where('client_id', $client->id);
        });

        // فلتر حسب الحملة
        if ($campaign) {
            $query->whereHas('campaign', fn($q) => $q->where('id', $campaign->id));
        }

        // فلتر حسب المدينة (city_id)
        if ($request->filled('city_id')) {
            $query->whereHas('shop', fn($q) => $q->where('city_id', $request->city_id));
        }

        // فلتر حسب الحالة (status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلتر حسب المحل (shop_id)
        if ($request->filled('shop_id')) {
            $query->where('shop_id', $request->shop_id);
        }

        // جلب القياسات مع العلاقات
        $items = $query->with(['campaign', 'shop.city', 'assets'])->paginate(12);

        $items->appends($request->only(['campaign_id', 'city_id', 'shop_id', 'status']));

        // جلب قائمة المدن المتاحة (للفلتر) بناءً على الحملة المحددة أو جميع حملات العميل
        $citiesQuery = CampaignItem::whereHas('campaign', function ($q) use ($client) {
            $q->where('client_id', $client->id);
        });
        if ($campaign) {
            $citiesQuery->whereHas('campaign', fn($q) => $q->where('id', $campaign->id));
        }
        $cities = $citiesQuery->with('shop.city')
            ->get()
            ->pluck('shop.city')
            ->filter()
            ->unique('id')
            ->values();

        // جلب قائمة المحلات للفلتر (اختياري)
        $shopsQuery = CampaignItem::whereHas('campaign', function ($q) use ($client) {
            $q->where('client_id', $client->id);
        });
        if ($campaign) {
            $shopsQuery->whereHas('campaign', fn($q) => $q->where('id', $campaign->id));
        }
        $shops = $shopsQuery->with('shop')
            ->get()
            ->pluck('shop')
            ->filter()
            ->unique('id')
            ->values();

        // قائمة الحالات المتاحة (يمكن تعريفها ثابتة)
        $statuses = ['pending', 'measured', 'designed', 'printed', 'installed', 'rejected'];

        return view('client-portal.measurements', compact('client', 'items', 'campaign', 'cities', 'shops', 'statuses'));
    }
}
