<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // الإحصائيات الأساسية
        $totalCompanies      = Company::count();
        $totalUsers          = User::where('is_super_admin', false)->count();
        $activePlans         = Plan::where('is_active', true)->count();
        $totalCampaigns      = Campaign::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();

        // أحدث الشركات (آخر 5)
        $latestCompanies = Company::latest()->take(5)->get();

        // أحدث المستخدمين (آخر 5)
        $latestUsers = User::where('is_super_admin', false)
            ->latest()
            ->take(5)
            ->get();

        // أحدث الحملات (آخر 5)
        $latestCampaigns = Campaign::with('company')
            ->latest()
            ->take(5)
            ->get();

        // إحصائيات شهرية لعدد الشركات (آخر 6 أشهر)
        $monthlyCompanies = Company::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // إحصائيات شهرية للمستخدمين (آخر 6 أشهر)
        $monthlyUsers = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->where('is_super_admin', false)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('super-admin.dashboard', [
            'totalCompanies'      => $totalCompanies,
            'totalUsers'          => $totalUsers,
            'activePlans'         => $activePlans,
            'totalCampaigns'      => $totalCampaigns,
            'activeSubscriptions' => $activeSubscriptions,
            'latestCompanies'     => $latestCompanies,
            'latestUsers'         => $latestUsers,
            'latestCampaigns'     => $latestCampaigns,
            'monthlyCompanies'    => $monthlyCompanies,
            'monthlyUsers'        => $monthlyUsers,
        ]);
    }
}
