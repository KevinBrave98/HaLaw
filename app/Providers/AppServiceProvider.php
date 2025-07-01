<?php

namespace App\Providers;

use App\Models\Pengguna;
use App\Models\Pengacara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\View\Composers\NavbarComposer;

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
        View::composer('components.layout_user', NavbarComposer::class);
        View::composer('components.layout_lawyer', NavbarComposer::class);
    }
}
