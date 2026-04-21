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
        app('router')->aliasMiddleware('admin', \App\Http\Middleware\Admin::class);
        //app('router')->aliasMiddleware('organizer', \App\Http\Middleware\OrganizerMiddleware::class);
        //app('router')->aliasMiddleware('approved', \App\Http\Middleware\ApprovedOrganizerMiddleware::class);
    }
}
