<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestRedirectMiddleware
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
        // If trying to access login page and already authenticated, redirect them
        if ($request->routeIs('login')) {
            if (Auth::guard('lawyer')->check()) {
                return redirect()->route('lawyer.dashboard');
            }
            
            if (Auth::guard('web')->check()) {
                return redirect()->route('dashboard.user');
            }
        }

        return $next($request);
    }
}