<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PenghuniMiddleware
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

        // Check if user has active penghuni status
        if (!auth()->user()->hasActivePenghuni()) {
            // Redirect to user dashboard with informative message instead of showing 403 error
            return redirect()->route('user.dashboard')
                ->with('info', 'Anda tidak memiliki status penghuni aktif. Silakan melakukan booking kamar terlebih dahulu untuk mengakses fitur penghuni.');
        }

        return $next($request);
    }
} 