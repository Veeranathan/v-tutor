<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;
use User;
class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (Auth::check()) {
            // dd(Cache::has('user-is-online-' . Auth::user()->id));
            if(!Cache::has('user-is-online-' . Auth::user()->id)){
                // return route('login');
                // User::where('id',Auth::user()->id)->update(['online_status'=>'N']);
                Auth::logout();
                // return redirect()->route('login');
                if(request()->segment(1) == 'admin'){
                    return redirect()->back();
                }else{
                    return redirect()->route('login');
                }
                
            }
            // $expiresAt = Carbon::now()->addMinutes(15);
            // Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
        }
        return $next($request);
    }
}