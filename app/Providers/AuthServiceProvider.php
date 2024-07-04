<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Auth\FilamentGuard;
use Illuminate\Support\Facades\Auth;
class AuthServiceProvider extends ServiceProvider
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
        Auth::extend('admins', function ($app, $name, array $config) {
            return new FilamentGuard(Auth::createUserProvider($config['provider']));
        });
    }
}
