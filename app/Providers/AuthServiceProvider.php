<?php
namespace App\Providers;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\City;
use App\Models\Client;
use App\Models\DesignJob;
use App\Models\Issue;
use App\Models\MeasurementAsset;
use App\Models\Shop;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Workflow;
use App\Policies\CampaignItemPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\CityPolicy;
use App\Policies\ClientPolicy;
use App\Policies\DesignJobPolicy;
use App\Policies\IssuePolicy;
use App\Policies\MeasurementAssetPolicy;
use App\Policies\RolePolicy;
use App\Policies\ShopPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkflowPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Campaign::class         => CampaignPolicy::class,
        CampaignItem::class     => CampaignItemPolicy::class,
        MeasurementAsset::class => MeasurementAssetPolicy::class,
        Workflow::class         => WorkflowPolicy::class,
        DesignJob::class        => DesignJobPolicy::class,
        Issue::class            => IssuePolicy::class,
        User::class             => UserPolicy::class,
        Role::class             => RolePolicy::class,
        Subscription::class     => SubscriptionPolicy::class,
        City::class             => CityPolicy::class,
        Shop::class             => ShopPolicy::class,
        Client::class           => ClientPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
