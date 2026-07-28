<?php

namespace App\Providers;

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
        if (class_exists(\App\Models\Category::class)) {
            try {
                \Illuminate\Support\Facades\View::share('categories', \App\Models\Category::all());
            } catch (\Exception $e) {
                // Prevent migration errors if DB is not ready
            }
        }
    }
}
