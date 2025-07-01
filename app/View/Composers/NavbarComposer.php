<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Don't forget to import Auth if you're getting the user from it

class NavbarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get your user data here.
        // For example, if you're using Laravel's authentication:
        $pengguna = Auth::user(); 
        $pengacara = Auth::guard('lawyer')->user();
        
        // Or if you're fetching it from a database or service:
        // $pengguna = \App\Models\User::find(1); // Example: Fetch user with ID 1
        // $pengguna = app(\App\Services\UserService::class)->getCurrentUser(); // Example with a service

        $view->with('pengguna', $pengguna);
        $view->with('pengacara', $pengacara);
    }
}