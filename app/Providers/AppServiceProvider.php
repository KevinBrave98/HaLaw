<?php

namespace App\Providers;

use App\Models\Riwayat;
use App\Models\Pengguna;
use App\Models\Pengacara;
use App\Observers\RiwayatObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\View\Composers\NavbarComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        View::composer('components.layout_user', NavbarComposer::class);
        View::composer('components.layout_lawyer', NavbarComposer::class);
        Riwayat::observe(RiwayatObserver::class);
    }
}
