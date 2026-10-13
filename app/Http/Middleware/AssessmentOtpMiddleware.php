<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LearningProgramAssessment;

class AssessmentOtpMiddleware
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
         $token = $request->route('token')
                ?? $request->query('token') 
                ?? $request->input('token');

        if (!$token) {
            abort(404, 'Invalid or expired link');
        }

        $assessment = LearningProgramAssessment::where('token', $token)->first();

        if (!$assessment) {
            abort(404, 'Invalid or expired link');
        }

        /**
         * Let controller decide OTP generation / expiry handling
         */
        return $next($request);
    }
}
