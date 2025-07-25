<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If lawyer is logged in, redirect to lawyer dashboard
        if (Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyer.dashboard');
        } else if (!Auth::guard('web')->check()) {  // Be specific about the guard
            return redirect()->route('userLogin.show');
        }
        
        return $next($request);
    }
}