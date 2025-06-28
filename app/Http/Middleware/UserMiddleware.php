<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user role is User
        if (auth()->user()->role !== 'User') {
            // If user is Admin, redirect to admin dashboard instead of 403
            if (auth()->user()->role === 'Admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Anda adalah admin, silakan gunakan panel admin.');
            }
            
            abort(403, 'Access denied. User privileges required.');
        }

        return $next($request);
    }
} 