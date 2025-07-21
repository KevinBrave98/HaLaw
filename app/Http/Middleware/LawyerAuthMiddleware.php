<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if lawyer is authenticated using the 'lawyer' guard
        if (!Auth::guard('lawyer')->check()) {
            return redirect()->route('login.show');
        }

        // If user is logged in instead of lawyer, redirect to user dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard.user');
        }

        return $next($request);
    }
}