<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CounterController as AdminCounterController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HomepageCarouselController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/gallery/photos', [GalleryController::class, 'photos'])->name('gallery.photos');
Route::get('/gallery/videos', [GalleryController::class, 'videos'])->name('gallery.videos');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/password', [AdminAuthController::class, 'showPasswordForm'])->name('password.edit');
        Route::post('/password', [AdminAuthController::class, 'updatePassword'])->name('password.update');

        Route::get('/page-content', [PageContentController::class, 'edit'])->name('page-content.edit');
        Route::post('/page-content', [PageContentController::class, 'update'])->name('page-content.update');

        Route::resource('homepage-carousel-images', HomepageCarouselController::class)->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);
        Route::resource('counters', AdminCounterController::class)->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);
        Route::resource('testimonials', AdminTestimonialController::class)->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);
        Route::resource('faqs', AdminFaqController::class)->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('team-members', AdminTeamMemberController::class)->except(['show']);
        Route::resource('blogs', AdminBlogController::class)->except(['show']);
        Route::resource('galleries', AdminGalleryController::class)->except(['show']);
        Route::get('/about', [AdminAboutController::class, 'edit'])->name('about.edit');
        Route::post('/about', [AdminAboutController::class, 'update'])->name('about.update');

        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
