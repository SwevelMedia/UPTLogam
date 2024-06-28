<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
        return view('auth.loginNew');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Mendapatkan pengguna yang sedang login
        $user = $request->user();

        // Memeriksa jika peran pengguna adalah admin
        if ($user->role === 'admin') {
            // Redirect ke dashboard admin
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } elseif ($user->role === 'ppic') {
            return redirect()->intended(RouteServiceProvider::PPIC);
        } elseif ($user->role === 'programmer') {
            return redirect()->intended(RouteServiceProvider::PROG);
        } elseif ($user->role === 'drafter') {
            return redirect()->intended(RouteServiceProvider::PROG);
        } elseif ($user->role === 'toolman') {
            return redirect()->intended(RouteServiceProvider::TOOLMAN);
        } elseif ($user->role === 'operator') {
            return redirect()->intended(RouteServiceProvider::OPERATOR);
        } elseif ($user->role === 'machiner') {
            return redirect()->intended(RouteServiceProvider::MACHINER);
        } else {
            return 'Maaf anda tidak memiliki akses!';
        }
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
