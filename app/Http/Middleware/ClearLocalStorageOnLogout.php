<?php
// app/Http/Middleware/ClearLocalStorageOnLogout.php

namespace App\Http\Middleware;

use Closure;

class ClearLocalStorageOnLogout
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // If response is a redirect to login, inject script
        if ($response->isRedirection() && str_contains($response->getTargetUrl(), 'login')) {
            session()->flash('clear_localstorage', true);
        }

        return $response;
    }
}
