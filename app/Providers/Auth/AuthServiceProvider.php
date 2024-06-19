<?php

declare(strict_types=1);

namespace App\Providers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Auth::provider('auth_user_provider', function ($app, array $config) {
            return new AuthUserProvider($app['hash'], $config['model']);
        });
    }
}
