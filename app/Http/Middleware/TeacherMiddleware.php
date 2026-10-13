<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      // if (@Auth::user()->user_type == 'T' && @Auth::user()->status == 'A') 
      if (@Auth::user()->user_type == 'T') 
        {
            return $next($request);
        }
        else
        {
             return redirect()->back()->with('error','You are not able to access other features untill admin approves you.');
        }
    }
}
