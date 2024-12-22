<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 'admin') {
            return $next($request);
        }

        // Redirect based on user type
        if (Auth::check()) {
            switch (Auth::user()->type) {
                case 'manager':
                    return redirect('/manager')->with('error', 'Access denied. Redirected to Manager dashboard.');
                case 'commercial':
                    return redirect('/commercial')->with('error', 'Access denied. Redirected to Commercial dashboard.');
                default:
                    return redirect('/login');
            }
        }

        return redirect('/login');
    }
}
