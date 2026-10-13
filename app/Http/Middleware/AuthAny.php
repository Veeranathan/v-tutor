<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAny
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
     {
        if (auth()->check()) {
            return $next($request);
        }

        if (auth('tutor')->check()) {
            auth()->login(auth('tutor')->user());
            return $next($request);
        }

        return response()->json([
            'error' => 'Unauthenticated'
        ], 401);
    }
}
