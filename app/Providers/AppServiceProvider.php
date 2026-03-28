<?php
namespace App\Providers;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\DesignJob;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $modelsToAudit = [Campaign::class, Company::class, User::class, DesignJob::class];
        foreach ($modelsToAudit as $model) {
            $model::created(function ($model) {
                AuditLogService::logModelEvent('created', $model);
            });
            $model::updated(function ($model) {
                AuditLogService::logModelEvent('updated', $model);
            });
            $model::deleted(function ($model) {
                AuditLogService::logModelEvent('deleted', $model);
            });
        }
    }
}
