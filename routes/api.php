<?php
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\DesignJobController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->name('api.')->group(function () {
    Route::apiResource('campaigns.workflows', WorkflowController::class)->shallow();
    Route::post('campaigns/{campaign}/design-jobs', [DesignJobController::class, 'store']);
    Route::get('design-jobs/{designJob}', [DesignJobController::class, 'show']);
    // Callback endpoint without auth (since Python will call it)
    Route::post('design-jobs/callback', [DesignJobController::class, 'callback'])->name('api.design-jobs.callback');
    // Analytics
    Route::get('analytics/campaign-stats', [AnalyticsController::class, 'campaignStats']);
    Route::get('analytics/performance-over-time', [AnalyticsController::class, 'performanceOverTime']);
    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    // Issues
    Route::apiResource('campaigns.issues', IssueController::class)->shallow();
});
