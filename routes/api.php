<?php
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\DesignJobController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContractorApiController;

Route::prefix('contractor')->group(function () {
    Route::post('login', [ContractorApiController::class, 'login']);
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
