<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
{
    /**
     * Get campaign statistics for the authenticated user's company.
     */
    public function campaignStats(Request $request)
    {
        $companyId = $request->user()->company_id;

        // Cache for 5 minutes
        $cacheKey = "analytics:campaign_stats:{$companyId}";
        $stats = Cache::remember($cacheKey, 300, function () use ($companyId) {
            $totalCampaigns = Campaign::where('company_id', $companyId)->count();

            $byStatus = Campaign::where('company_id', $companyId)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status');

            $byPriority = Campaign::where('company_id', $companyId)
                ->select('priority', DB::raw('count(*) as count'))
                ->groupBy('priority')
                ->get()
                ->pluck('count', 'priority');

            $overdueCount = Campaign::where('company_id', $companyId)
                ->where('due_date', '<', now())
                ->whereNotIn('status', ['completed', 'archived'])
                ->count();

            // Average completion time (in days) for campaigns with workflows completed
            $avgCompletionDays = Campaign::where('company_id', $companyId)
                ->whereHas('workflows', function ($q) {
                    $q->where('stage', 'review')->where('status', 'completed');
                })
                ->with(['workflows' => function ($q) {
                    $q->where('stage', 'review')->where('status', 'completed');
                }])
                ->get()
                ->avg(function ($campaign) {
                    $completedWorkflow = $campaign->workflows->first();
                    if ($completedWorkflow && $completedWorkflow->completed_at && $campaign->created_at) {
                        return $completedWorkflow->completed_at->diffInDays($campaign->created_at);
                    }
                    return null;
                }) ?? 0;

            return [
                'total' => $totalCampaigns,
                'by_status' => $byStatus,
                'by_priority' => $byPriority,
                'overdue' => $overdueCount,
                'avg_completion_days' => round($avgCompletionDays, 1),
            ];
        });

        return response()->json($stats);
    }

    /**
     * Get performance data over time (monthly campaign counts).
     */
    public function performanceOverTime(Request $request)
    {
        $companyId = $request->user()->company_id;

        $data = Campaign::where('company_id', $companyId)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                    'count' => $item->count,
                ];
            });

        return response()->json($data);
    }
}
