<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    protected $redirectPaths = [
        'admin' => '/home',
        'manager' => '/stock',
        'commercial' => '/stock'
    ];

    public function handle(Request $request, Closure $next, $role)
    {
        // If user is not logged in, redirect to login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userType = Auth::user()->type;

        // If user has the correct role, proceed
        if ($userType === $role) {
            return $next($request);
        }

        // If user is trying to access their own dashboard, prevent redirect loop
        $currentPath = $request->path();
        $userDashboard = trim($this->redirectPaths[$userType] ?? '/login', '/');

        if ($currentPath === $userDashboard) {
            return $next($request);
        }

        // Redirect to appropriate dashboard with message
        return redirect($this->redirectPaths[$userType] ?? '/login')
            ->with('error', 'Access denied. Redirected to ' . ucfirst($userType) . ' dashboard.');
    }
}
