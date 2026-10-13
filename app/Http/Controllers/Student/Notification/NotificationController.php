<?php

namespace App\Http\Controllers\Student\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Subject;
use App\Models\StudentClassBooking;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\Payments;
use App\Models\SubjectTopics;
use Validator;
use Mail;
use App\Mail\StudentClassBookingMail;
use App\Mail\CancelBookingMail;
use App\Models\AdminDisableBookingDates;
use App\Models\AdminDisableBookings;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Fetches upcoming bookings for a student, returning only the essential data.
     * This is specifically for use with frontend components like a notification bell.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUpcomingBookingsForNotification()
    {
        try {
            // Get the user's timezone, defaulting to UTC if not set.
            $userTimezone = Auth::user()->timezone_id ?? 'UTC';

            // Get the current time in the user's timezone, then convert it to UTC for the database query.
            $nowInUserTimezone = Carbon::now($userTimezone);
            $nowInUtc = $nowInUserTimezone->copy()->setTimezone('UTC');

            // Fetch bookings. The database values for booking_date and from_time are in UTC,
            // so we must query against a UTC timestamp to get accurate results.
            $bookings = StudentClassBooking::where('student_id', Auth()->user()->id)
                ->where('booking_status', 'B')
                // Combine the date and time columns from the database and check if they are in the future
                ->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$nowInUtc])
                ->orderBy('booking_date')
                ->orderBy('from_time')
                ->with(['getTutor:id,f_name,l_name'])
                ->get();

            // Format the bookings and convert the times to the user's timezone.
            $formattedBookings = $bookings->map(function ($booking) use ($userTimezone) {
                // Create a Carbon instance from the UTC stored date and time, and then set the timezone.
                $fromTime = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC')->setTimezone($userTimezone);
                $toTime = Carbon::parse($booking->booking_date . ' ' . $booking->to_time, 'UTC')->setTimezone($userTimezone);

                return [
                    'bookingId' => $booking->id,
                    'bookingNo' => $booking->booking_no,
                    'tutorName' => optional($booking->getTutor)->f_name . ' ' . optional($booking->getTutor)->l_name,
                    'bookingDate' => $fromTime->format('Y-m-d'), // Correctly formatted date in user's timezone
                    'fromTime' => $fromTime->format('h:i A'), // Correctly formatted time in user's timezone
                    'toTime' => $toTime->format('h:i A'), // Correctly formatted time in user's timezone
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedBookings,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching upcoming bookings for notification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bookings.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetches today's upcoming bookings for a student.
     * This is specifically for use with a banner alert.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodaysUpcomingBookingsForBanner()
    {
        try {
            // Get the user's timezone and the current time in that timezone.
            $userTimezone = Auth::user()->timezone_id ?? 'UTC';
            $nowInUserTimezone = Carbon::now($userTimezone);

            // Determine the start and end of the user's day, then convert these to UTC for the query.
            $startOfUserDayInUtc = $nowInUserTimezone->copy()->startOfDay()->setTimezone('UTC');
            $endOfUserDayInUtc = $nowInUserTimezone->copy()->endOfDay()->setTimezone('UTC');

            $bookings = StudentClassBooking::where('student_id', Auth()->user()->id)
                ->where('booking_status', 'B')
                // Query for bookings where the combined date and time fall within the user's "today" in UTC.
                ->whereRaw("CONCAT(booking_date, ' ', from_time) BETWEEN ? AND ?", [$startOfUserDayInUtc, $endOfUserDayInUtc])
                // Also ensure the booking time is in the future.
                ->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$nowInUserTimezone->copy()->setTimezone('UTC')])
                ->orderBy('from_time', 'ASC')
                ->with(['getTutor:id,f_name,l_name', 'getSubject:id,subject'])
                ->get();

            $formattedBookings = $bookings->map(function ($booking) use ($userTimezone) {
    $fromTime = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC')->setTimezone($userTimezone);
    $toTime = Carbon::parse($booking->booking_date . ' ' . $booking->to_time, 'UTC')->setTimezone($userTimezone);

    return [
        'bookingId'   => $booking->id,
        'bookingNo'   => $booking->booking_no,
        'bookingDate' => $fromTime->format('Y-m-d'),   // Clean date
        'fromTime'    => $fromTime->format('h:i A'),  // 07:00 PM
        'toTime'      => $toTime->format('h:i A'),    // 08:00 PM
    ];
});

            return response()->json([
                'status' => 200,
                'message' => 'Today\'s upcoming bookings fetched successfully.',
                'bookings' => $formattedBookings,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching today\'s upcoming bookings for banner: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Failed to fetch today\'s upcoming bookings.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getNotificationDetails(Request $request)
{
    $bookingId = $request->query('booking_id');

    if (!$bookingId) {
        session()->flash("error", "No booking ID was provided.");
        return redirect()->back();
    }

    $timezone = Auth::user()->timezone_id ?? 'UTC';

    $bookingDataInformation = StudentClassBooking::with([
        'getStudent',
        'getTutor.languguageToTuor',
        'getTutor.getTutorAcademic',
        'getSubject',
        'getStudentGrade',
        'getTutor.getTutorShipPlan',
        'getSubjectTopics'
    ])
    ->where(['id' => $bookingId, 'student_id' => Auth::user()->id])
    ->first();

    if ($bookingDataInformation) {
        // Combine booking_date with from_time and to_time to avoid invalid date issues
        $fromDateTimeUtc = Carbon::parse(
            $bookingDataInformation->booking_date . ' ' . $bookingDataInformation->from_time,
            'UTC'
        );
        $toDateTimeUtc = Carbon::parse(
            $bookingDataInformation->booking_date . ' ' . $bookingDataInformation->to_time,
            'UTC'
        );

        // Store user timezone formatted values
        $bookingDataInformation->booking_date_user = $fromDateTimeUtc
            ->copy()
            ->setTimezone($timezone)
            ->format('Y-m-d'); // Only date

        $bookingDataInformation->from_time_user = $fromDateTimeUtc
            ->copy()
            ->setTimezone($timezone)
            ->format('h:i A'); // Time only

        $bookingDataInformation->to_time_user = $toDateTimeUtc
            ->copy()
            ->setTimezone($timezone)
            ->format('h:i A'); // Time only
    }

    $data['bookingDataInformation'] = $bookingDataInformation;
    $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
    $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')
        ->pluck('disable_booking_date')
        ->toArray();

    if ($bookingDataInformation && Auth::user()->id == $bookingDataInformation->student_id) {
        $data['t_my_av_show'] = MyAvailability::where([
            'teacher_id' => $bookingDataInformation->tutor_id,
            'status' => 'A'
        ])->get()->map(function ($slot) use ($timezone) {
            $dayIndex = (int) $slot->day;
            $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

            $fromUtc = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $baseDate->toDateString() . ' ' . $slot->from_time,
                'UTC'
            );
            $toUtc = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $baseDate->toDateString() . ' ' . $slot->to_time,
                'UTC'
            );

            if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                $toUtc->addDay();
            }

            $slot->from_time_student = $fromUtc
                ->copy()
                ->setTimezone($timezone)
                ->format('Y-m-d h:i A');
            $slot->to_time_student = $toUtc
                ->copy()
                ->setTimezone($timezone)
                ->format('Y-m-d h:i A');

            return $slot;
        });

        $data['now'] = Carbon::now('UTC')->setTimezone($timezone);

        return view('student.modules.notification.student_class_notification')->with($data);
    }

    session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
    return redirect()->back();
}
}
