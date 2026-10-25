<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            static $cachedSettings = null;
            if ($cachedSettings === null) {
                try {
                    if (Schema::hasTable('settings')) {
                        $cachedSettings = Setting::first() ?? false;
                    }
                } catch (\Throwable $e) {
                    $cachedSettings = false;
                }
            }
            $view->with('settings', $cachedSettings ?: null);
        });

        View::composer(['admin.partials.sidebar', 'admin.partials.topbar'], function ($view) {
            $unreadContactsCount = 0;
            try {
                if (Schema::hasTable('contacts')) {
                    $unreadContactsCount = Contact::unread()->count();
                }
            } catch (\Throwable $e) {
                $unreadContactsCount = 0;
            }
            $view->with('unreadContactsCount', $unreadContactsCount);
        });
    }
}
