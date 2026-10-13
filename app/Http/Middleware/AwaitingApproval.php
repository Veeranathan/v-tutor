<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AwaitingApproval
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
        if (@Auth::user()->user_type == 'T' ) 
        {
            if( @Auth::user()->status == 'AA'){
            return $next($request);
            }else{
                 return redirect()->back();
            }
        }
        else
        {
             return redirect()->back();
        }
    }
}
