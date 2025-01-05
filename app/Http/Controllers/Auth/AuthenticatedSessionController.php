<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

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

        // Login tracking logic
        $user = Auth::user();

        // Get today's date
        $today = Carbon::now()->format('Y-m-d');

        // Increment login count if logging in on a new day
        if ($user->last_login !== $today) {
            $user->increment('login_count');
            $user->last_login = $today;
            $user->save();
        }

        // Promote user to admin after 5 logins on different days
        if ($user->login_count >= 5 && $user->role !== 'admin') {
            $user->role = 'admin';
            $user->save();
        }

        return redirect()->intended(route('shifts.index', absolute: false));
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
