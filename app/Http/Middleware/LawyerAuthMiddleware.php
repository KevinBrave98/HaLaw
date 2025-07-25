<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If regular user is logged in, redirect to user dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard.user');
        } else if (!Auth::guard('lawyer')->check()) {
            return redirect()->route('lawyerLogin.show');
        }
        
        return $next($request);
    }
}