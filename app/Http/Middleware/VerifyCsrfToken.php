<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    protected $addHttpCookie = true;

    protected $except = [
        'api/zoom/webhook',
        'api/zoom/webhook-usercreate',
        '/contact-us',
    ];

    public function handle($request, Closure $next)
    {
        // Log the current session token and the token submitted in the form (if any)
        // Log::info('CSRF Debug:', [
        //     'session_token' => $request->session()->token(),  // The token stored in session
        //     'input_token' => $request->input('_token'),       // The token submitted in the form
        //     'cookies' => $request->cookies->all(),            // All cookies sent by the browser
        //     'url' => $request->fullUrl(),
        // ]);

        return parent::handle($request, $next);
    }
}
