<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

        // Check if user role is Admin
        if (auth()->user()->role !== 'Admin') {
            // If user is regular User, redirect to user dashboard instead of 403
            if (auth()->user()->role === 'User') {
                return redirect()->route('user.dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki hak akses admin.');
            }
            
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
} 