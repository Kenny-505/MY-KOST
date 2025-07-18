<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Role-based redirect after login
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/user/dashboard');
        }

        // if ($user->isAdmin()) {
        //     return redirect()->intended(route('admin.dashboard'));
        // } else {
        //     // Check if user route exists, otherwise fallback to dashboard
        //     if (route()->has('user.dashboard')) {
        //         return redirect()->intended(route('user.dashboard'));
        //     } else {
        //         return redirect()->intended(route('dashboard', absolute: false));
        //     }
        // }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
