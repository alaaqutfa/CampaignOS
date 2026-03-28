<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignItemController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MeasurementAssetController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\RoleController as SuperAdminRoleController;
use App\Http\Controllers\SuperAdmin\SubscriptionController as SuperAdminSubscriptionController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\ContractorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/cookie-policy', [PageController::class, 'cookie'])->name('pages.cookie');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('pages.contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');

require __DIR__ . '/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin routes
Route::prefix('super-admin')
    ->name('super-admin.')
    ->middleware(['auth', 'superadmin'])
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('companies', CompanyController::class);
        Route::resource('users', SuperAdminUserController::class);
        Route::resource('plans', PlanController::class);
        Route::resource('roles', SuperAdminRoleController::class);
        Route::resource('subscriptions', SuperAdminSubscriptionController::class)
            ->only(['index', 'show', 'update', 'destroy']);
    });

Route::middleware(['auth', 'set.tenant', 'check.company'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('campaigns.workflows', WorkflowController::class)->shallow();
    Route::resource('campaigns', CampaignController::class);
    Route::resource('cities', CityController::class)->except(['show']);
    Route::resource('shops', ShopController::class)->except(['show']);

    Route::prefix('campaigns/{campaign}')->group(function () {
        Route::resource('items', CampaignItemController::class)->except(['show']);
        Route::prefix('items/{item}')->group(function () {
            Route::resource('assets', MeasurementAssetController::class)->only(['index', 'create', 'store', 'destroy']);
        });
        Route::resource('workflows', WorkflowController::class)->except(['edit', 'create']);
    });
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    });
});

Route::middleware(['auth', 'role:measurer|installer'])->prefix('contractor')->name('contractor.')->group(function () {
    Route::get('/', [ContractorController::class, 'dashboard'])->name('dashboard');
    Route::get('/regions/{region}/shops', [ContractorController::class, 'shops'])->name('shops');
    Route::post('/regions/{region}/shops', [ContractorController::class, 'storeShop'])->name('shops.store');
    Route::get('/campaign-items/{item}/measure', [ContractorController::class, 'addMeasurement'])->name('measurement');
    Route::post('/campaign-items/{item}/measure', [ContractorController::class, 'storeMeasurement'])->name('measurement.store');
    Route::get('/campaign-items/{item}/install', [ContractorController::class, 'install'])->name('install');
    Route::post('/campaign-items/{item}/install', [ContractorController::class, 'storeInstallation'])->name('install.store');
});
