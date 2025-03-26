<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
        // In AppServiceProvider or a custom provider

        // Load all settings once and share them globally
        $settings = Cache::remember('app_settings', 60 * 60, function () {
            return \App\Models\Settings::all()->pluck('value', 'key')->toArray();
        });

        // Share the settings globally using a singleton or the config system
        app()->singleton('settings', function () use ($settings) {
            return $settings;
        });
    }
}
