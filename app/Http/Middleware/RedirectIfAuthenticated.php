<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
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
        }

        return $next($request);
    }
}
