<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccessDouble
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $input = explode('-', $role);
        if ( auth()->user()->role == $input[0] ) {
            return $next($request);
        }
        elseif( auth()->user()->role == $input[1] ) {
            return $next($request);

        }
        abort(403);
    }

}