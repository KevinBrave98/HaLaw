<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\Pengguna;
use App\Models\Pengacara;

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
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return match (true) {
                $user instanceof Pengguna => '/reset-password/pengguna' . '?token=' . $token . '&email=' . urlencode($user->email),
                $user instanceof Pengacara => '/reset-password/pengacara' . '?token=' . $token . '&email=' . urlencode($user->email),
                // other user types
                default => throw new \Exception("Invalid user type"),
            };
        });
    }
}
