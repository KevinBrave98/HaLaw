<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthMiddleware
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
        // Check if user is authenticated using the 'web' guard (default user guard)
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login.show');
        }

        // If lawyer is logged in instead of user, redirect to lawyer dashboard
        if (Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyer.dashboard');
        }

        return $next($request);
    }
}