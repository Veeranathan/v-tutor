<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentClassBooking; // Make sure to import your model
use Carbon\Carbon; // Make sure to import Carbon
use Auth; // Make sure to import Auth

class SessionApiController extends Controller
{
    /**
     * Get the next upcoming booked session for the authenticated student.
     * This method will be called via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextSession(Request $request)
    {
        $nextSession = null;

        if (Auth::check()) {
            $timezone = Auth::user()->timezone_id ?? config('app.timezone');
            $nowInUserTimezone = Carbon::now($timezone);

            $nextSession = StudentClassBooking::where('student_id', Auth::user()->id)
                                ->where('booking_status', 'B') // Only booked sessions
                                ->where(function ($query) use ($nowInUserTimezone) {
                                    $query->whereDate('booking_date', '>', $nowInUserTimezone->toDateString())
                                          ->orWhere(function ($q) use ($nowInUserTimezone) {
                                              $q->whereDate('booking_date', $nowInUserTimezone->toDateString())
                                                ->whereTime('from_time', '>', $nowInUserTimezone->toTimeString());
                                          });
                                })
                                ->with(['getSubject', 'getTutor']) // Eager load relationships
                                ->orderBy('booking_date', 'asc')
                                ->orderBy('from_time', 'asc')
                                ->first();

            // Format the time for JavaScript if a session is found
            if ($nextSession) {
                // Convert to user's timezone and then to an ISO string for JS
                $nextSession->from_time_user_iso = Carbon::parse($nextSession->booking_date . ' ' . $nextSession->from_time)
                                                        ->setTimezone($timezone)
                                                        ->toIso8601String(); // ISO format for JS Date constructor
                // You might want to unset original time fields if not needed, or keep them
            }
        }

        return response()->json(['nextSession' => $nextSession]);
    }
}