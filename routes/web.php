<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\FlagController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QueryTypeController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ContactQueryController;
use App\Http\Controllers\Admin\ProductGroupController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\ProductFeatureController;
use App\Http\Controllers\Admin\ProductDocumentController;
use App\Http\Controllers\Admin\TeamPerformanceController;
use App\Http\Controllers\Admin\OrderInformationController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/', [HomeController::class, 'frontHome'])->name('front.home');
// Frontend routes
Route::get('/companies/{company:slug}', [App\Http\Controllers\CompanyController::class, 'show'])->name('companies.show');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Search suggestions (AJAX)
Route::get('/products/search/suggestions', [ProductController::class, 'searchSuggestions'])
    ->name('products.search.suggestions');

// About Us Page
Route::get('/about-us', function () {
    return view('front.about');
})->name('about');
// Show all products in a group
Route::get('/product-groups/{group:slug}', [ProductController::class, 'index'])
    ->name('products.index');


Route::get('/partners', function() {
    $companies = \App\Models\Company::active()
        ->with('activeProductGroups')
        ->ordered()
        ->get();
    
    return view('front.partners.index', compact('companies'));
})->name('partners.index');



   // News frontend routes
Route::get('/news', function() {
    $allNews = \App\Models\News::published()
        ->orderBy('published_date', 'desc')
        ->paginate(9);
    
    return view('front.news.index', compact('allNews'));
})->name('news.index');

Route::get('/news/{news:slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Show single product details
Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('products/{product}/details/edit', [ProductDetailController::class, 'edit'])
        ->name('products.details.edit');

    Route::put('products/{product}/details', [ProductDetailController::class, 'update'])
        ->name('products.details.update');

        Route::get('products/by-group', [App\Http\Controllers\Admin\ProductController::class, 'byGroup'])
        ->name('products.by-group');


        // Product Features Routes
Route::prefix('products/{product}/features')->name('products.features.')->group(function () {
    Route::get('create', [ProductFeatureController::class, 'create'])->name('create');
    Route::post('/', [ProductFeatureController::class, 'store'])->name('store');
    Route::get('{feature}/edit', [ProductFeatureController::class, 'edit'])->name('edit');
    Route::put('{feature}', [ProductFeatureController::class, 'update'])->name('update');
    Route::delete('{feature}', [ProductFeatureController::class, 'destroy'])->name('destroy');
});

// Companies Management
Route::resource('companies', CompanyController::class);
Route::post('companies/reorder', [CompanyController::class, 'reorder'])->name('companies.reorder');

// Settings Routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/', [SettingController::class, 'update'])->name('update');
});

// Team Members Management
Route::resource('team-members', TeamMemberController::class);
Route::post('team-members/reorder', [TeamMemberController::class, 'reorder'])->name('team-members.reorder');

// News Routes
Route::resource('news', NewsController::class)->except(['show']);


// In your admin routes group
Route::get('/order-information', [OrderInformationController::class, 'edit'])->name('order-information.edit');
Route::put('/order-information', [OrderInformationController::class, 'update'])->name('order-information.update');



// Contact Query Admin Routes
Route::prefix('contact-queries')->name('contact-queries.')->group(function () {
    Route::get('/', [ContactQueryController::class, 'index'])->name('index');
    Route::get('/{contactQuery}', [ContactQueryController::class, 'show'])->name('show');
    Route::put('/{contactQuery}/status', [ContactQueryController::class, 'updateStatus'])->name('update-status');
    Route::put('/{contactQuery}/assign', [ContactQueryController::class, 'assignToUser'])->name('assign');

    Route::get('/{contactQuery}/response', [ContactQueryController::class, 'showResponseForm'])->name('show-response-form');
    Route::post('/{contactQuery}/response', [ContactQueryController::class, 'recordResponse'])->name('record-response');
});

// Team Performance Routes
Route::get('/team-performance', [TeamPerformanceController::class, 'index'])->name('team-performance.index');
Route::post('/team-performance/update-metrics', [TeamPerformanceController::class, 'updateMetrics'])->name('team-performance.update-metrics');

// Query Types Management
Route::resource('query-types', QueryTypeController::class);
Route::post('query-types/reorder', [QueryTypeController::class, 'reorder'])->name('query-types.reorder');

// Product Documents Routes
Route::resource('products.documents', ProductDocumentController::class)
    ->parameters(['documents' => 'document'])
    ->except(['show']);
    // Menu routes
    Route::resource('menus', MenuController::class);

    // Bulk update menus (parent + submenus)
    Route::post('/menus/bulk-update', [MenuController::class, 'bulkUpdate'])->name('menus.bulkUpdate');

    // Reorder menu
    Route::post('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');

    // Social Links
    Route::resource('social-links', SocialLinkController::class);

    // Flags
    Route::resource('flags', FlagController::class);

    // Admin Dashboard
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Banner Routes
    Route::resource('banners', BannerController::class);
    Route::post('banners/reorder', [BannerController::class, 'reorder'])->name('banners.reorder');

     Route::resource('product-groups', ProductGroupController::class);
     Route::resource('product-groups.products', AdminProductController::class);

});

