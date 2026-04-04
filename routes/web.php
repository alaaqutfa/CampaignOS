<?php

// ============================================
// CONTROLLER IMPORTS
// ============================================
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignItemController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\ContractorAssignmentController;
use App\Http\Controllers\ContractorController;
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
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES (no authentication)
// ============================================
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/cookie-policy', [PageController::class, 'cookie'])->name('pages.cookie');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('pages.contact.submit');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::prefix('client/{token}')->group(function () {
    Route::get('/campaigns', [ClientPortalController::class, 'campaigns'])->name('client.campaigns');
    Route::get('/measurements', [ClientPortalController::class, 'measurements'])->name('client.measurements');
});

// Include authentication routes (login, register, password reset, etc.)
require __DIR__ . '/auth.php';

// ============================================
// AUTHENTICATED USER ROUTES (profile management)
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// SUPER ADMIN ROUTES
// Prefix: /super-admin
// Middleware: auth + superadmin role
// ============================================
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

// ============================================
// TENANT (COMPANY) ROUTES
// Middleware: auth, set.tenant, check.company
// ============================================
Route::middleware(['auth', 'set.tenant', 'check.company'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Core resources
    Route::resource('users', UserController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('cities', CityController::class)->except(['show']);
    Route::resource('shops', ShopController::class)->except(['show']);
    Route::resource('clients', ClientController::class);
    // Nested campaign resources
    Route::prefix('campaigns/{campaign}')->group(function () {
        // Campaign items
        Route::resource('items', CampaignItemController::class)->except(['show']);
        Route::post('items/bulk-import', [CampaignItemController::class, 'bulkImport'])->name('items.import');
        Route::get('items/export', [CampaignItemController::class, 'export'])->name('items.export');

        // Measurement assets under each campaign item
        Route::prefix('items/{item}')->group(function () {
            Route::resource('assets', MeasurementAssetController::class)->only(['index', 'create', 'store', 'destroy']);
        });

        // Workflows (nested under campaign, but shallow routes also exist)
        Route::resource('workflows', WorkflowController::class)->except(['edit', 'create']);
    });
    Route::post('campaigns/{campaign}/items/bulk-status', [CampaignItemController::class, 'bulkUpdateStatus'])->name('items.bulk-status');
    Route::post('campaigns/{campaign}/items/bulk-update-all', [CampaignItemController::class, 'bulkUpdateAllStatus'])->name('items.bulk-update-all');
    Route::get('campaigns/{campaign}/export-before-after-pdf', [CampaignController::class, 'exportBeforeAfterPdf'])->name('campaigns.export-before-after-pdf');

    // Shallow workflows (already defined above, but keep separate for clarity)
    Route::resource('campaigns.workflows', WorkflowController::class)->shallow();

    // Contractor assignments
    Route::resource('contractor-assignments', ContractorAssignmentController::class)
        ->parameters(['contractor-assignments' => 'contractor'])
        ->only(['index', 'edit', 'update']);

    // Company subscription management
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
        Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    });
});

// ============================================
// CONTRACTOR ROUTES (measurer or installer role)
// Prefix: /contractor
// Middleware: auth + role:measurer|installer
// ============================================
Route::middleware(['auth', 'role:measurer|installer'])
    ->prefix('contractor')
    ->name('contractor.')
    ->group(function () {
        Route::get('/', [ContractorController::class, 'dashboard'])->name('dashboard');
        Route::get('/regions/{region}/shops', [ContractorController::class, 'shops'])->name('shops');
        Route::post('/regions/{region}/shops', [ContractorController::class, 'storeShop'])->name('shops.store');
        Route::get('/campaign-items/{item}/measure', [ContractorController::class, 'addMeasurement'])->name('measurement');
        Route::post('/campaign-items/{item}/measure', [ContractorController::class, 'storeMeasurement'])->name('measurement.store');
        Route::get('/campaign-items/{item}/install', [ContractorController::class, 'install'])->name('install');
        Route::post('/campaign-items/{item}/install', [ContractorController::class, 'storeInstallation'])->name('install.store');
    });
