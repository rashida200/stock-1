<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 'manager') {
            return $next($request);
        }

        // Redirect based on user type
        if (Auth::check()) {
            switch (Auth::user()->type) {
                case 'admin':
                    return redirect('/admin')->with('error', 'Access denied. Redirected to Admin dashboard.');
                case 'commercial':
                    return redirect('/commercial')->with('error', 'Access denied. Redirected to Commercial dashboard.');
                default:
                    return redirect('/login');
            }
        }

        return redirect('/login');
    }
}
