<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LearningProgramAssessment;

class AssessmentStartMiddleware
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
            abort(404, 'Assessment link expired');
        }

        $assessment = LearningProgramAssessment::where('token', $token)->first();

        if (!$assessment) {
            abort(404, 'Assessment link expired');
        }

        // OTP not verified
        if (is_null($assessment->otp_verified_at)) {
            abort(404, 'Assessment link expired');
         }

         // OTP verification valid only for 24 hours
        $verificationExpiry = $assessment->otp_verified_at->addHours(24);

        if ($verificationExpiry->isPast()) {
            abort(404, 'Assessment link expired');
        }

            return $next($request);
    }
}
