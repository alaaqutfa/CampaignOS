<?php

// ============================================
// API ROUTES
// ============================================

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\DesignJobController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContractorApiController;

// ============================================
// CONTRACTOR API ROUTES (mobile app)
// Prefix: /api/contractor
// ============================================
Route::prefix('contractor')->group(function () {
    // Public: contractor login
    Route::post('login', [ContractorApiController::class, 'login']);

    // Protected: all contractor endpoints require Sanctum token
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [ContractorApiController::class, 'logout']);
        Route::get('me', [ContractorApiController::class, 'me']);
        Route::get('regions', [ContractorApiController::class, 'regions']);
        Route::get('regions/{region}/shops', [ContractorApiController::class, 'shops']);
        Route::post('regions/{region}/shops', [ContractorApiController::class, 'storeShop']);
        Route::get('measurement-tasks', [ContractorApiController::class, 'measurementTasks']);
        Route::post('measurement-tasks/{item}', [ContractorApiController::class, 'storeMeasurement']);
        Route::get('installation-tasks', [ContractorApiController::class, 'installationTasks']);
        Route::post('installation-tasks/{item}', [ContractorApiController::class, 'storeInstallation']);
    });
});

// ============================================
// GENERAL API ROUTES (web app, requires auth)
// Prefix: /api (implicitly by route service provider)
// Name prefix: api.
// Middleware: web 'auth' (session-based, not Sanctum)
// ============================================
Route::middleware('auth')->name('api.')->group(function () {
    // Workflows (shallow resource)
    Route::apiResource('campaigns.workflows', WorkflowController::class)->shallow();

    // Design jobs
    Route::post('campaigns/{campaign}/design-jobs', [DesignJobController::class, 'store']);
    Route::get('design-jobs/{designJob}', [DesignJobController::class, 'show']);

    // Callback endpoint for external service (Python script) - no auth required
    Route::post('design-jobs/callback', [DesignJobController::class, 'callback'])
        ->name('api.design-jobs.callback');

    // Analytics
    Route::get('analytics/campaign-stats', [AnalyticsController::class, 'campaignStats']);
    Route::get('analytics/performance-over-time', [AnalyticsController::class, 'performanceOverTime']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    // Issues (shallow resource under campaigns)
    Route::apiResource('campaigns.issues', IssueController::class)->shallow();
});
