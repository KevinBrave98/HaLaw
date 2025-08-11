<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestRedirectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyer.dashboard');
        } else if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard.user');
        }

        return $next($request);
    }
}