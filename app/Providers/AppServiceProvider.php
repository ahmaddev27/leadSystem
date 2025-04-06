<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

    public function boot()
    {
        // Get settings from DB and cache them
        $settings = Cache::rememberForever('app_settings', function () {
            return DB::table('settings')->pluck('value', 'key')->toArray();
        });

     View::share('settings', $settings);
    }

}
