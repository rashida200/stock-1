<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommercialMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 'commercial') {
            return $next($request);
        }

        // Redirect based on user type
        if (Auth::check()) {
            switch (Auth::user()->type) {
                case 'admin':
                    return redirect('/admin')->with('error', 'Access denied. Redirected to Admin dashboard.');
                case 'manager':
                    return redirect('/manager')->with('error', 'Access denied. Redirected to Manager dashboard.');
                default:
                    return redirect('/login');
            }
        }

        return redirect('/login');
    }
}
