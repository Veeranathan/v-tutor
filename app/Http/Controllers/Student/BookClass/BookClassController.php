<?php

namespace App\Http\Controllers\Student\BookClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Subject;
use App\Models\SubjectTopics;
use App\Models\AdminDisableBookings;
use App\Models\AdminDisableBookingDates;
use App\Models\StudentClassBooking;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\TutorNonAvailabilityDetails;
use App\Models\Grade;
use App\Models\TopicDetail;
use App\Models\Payments;
use App\Models\Commissions;
use App\Models\User;
use App\Models\AcademicProgramPurchase;
use App\Models\AcademicProgramSessionLog;
use App\Services\ZoomService;
use App\Models\ZoomUser;
use App\Models\TutorPayment;
use App\Services\DailyService;

use App\Helpers\TimeSlotHelper;
use Validator;
use App\Mail\StudentClassBookingMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\CancelBookingMail;
use App\Models\TokenModel;
use GuzzleHttp;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Carbon\CarbonTimeZone;
use App\Mail\LearningProgramBookingMail;
use App\Mail\LearningProgramSupportBookingMail;
use App\Mail\LearningProgramTutorBookingMail;
use Illuminate\Support\Facades\Mail;

class BookClassController extends Controller
{
    public function cancelIncompleteBooking($id)
    {
        $bookingInfo = StudentClassBooking::where(['id' => $id])->first();
        StudentClassBooking::where(['id' => $id])->whereIn('booking_status', ['IC'])->delete();
        Payments::where(['booking_id' => $id, 'status' => 'I'])->delete();
        session()->flash("success", "Booking cancelled. You may book again!");
        $getUser = User::where(['id' => $bookingInfo->tutor_id])->first();
        $to_p = url('studentbook-class?search_tutor_nm_studentclass=' . $getUser->f_name . " " . $getUser->l_name . '&search_tutor_id_studentclass=' . $getUser->id . '&search_tutor_selected_name_studentclass=' . $getUser->f_name . " " . $getUser->l_name . '&search_tutor_slug_studentclass=' . $getUser->slug . '&book_subject=' . session('book_subject'));
        return Redirect::to($to_p);
        // return redirect()->route('student.book.class');
    }
    /*
    * Method        : studentBookClass
    * Description   : This method is used to redirect to booking page session variables or from search page
    * Author        : Jayatri
    */
    public function searchTutors(Request $request)
    {
        $keyword = $request->get('query');

        $tutors = User::where('user_type', 'T')
            ->where('status', 'A')
            ->where('draft', 'N')
            ->where('subscription', 'S')
            ->where(function ($q) use ($keyword) {
                $q->where('f_name', 'LIKE', "%$keyword%")
                    ->orWhere('l_name', 'LIKE', "%$keyword%");
            })
            ->limit(10)
            ->get();

        return response()->json($tutors);
    }
    public function ajaxGetDaySlots(Request $request)
    {
        $tutor_id = $request->tutor_id;
        $selectedDate = $request->selected_day;
        $todayDay = \Carbon\Carbon::parse($selectedDate)->dayOfWeekIso;
        $dayNames = [1 => 'Mon', 2 => 'Tues', 3 => 'Wed', 4 => 'Thur', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
        $studentTimezone = @Auth::user()->timezone_id ?? 'UTC';
        // Fetch availability for tutor
        $tutorSlots = MyAvailability::where([
            'teacher_id' => $tutor_id,
            'status'     => 'A'
        ])->get()->map(function ($slot) use ($studentTimezone) {

            // You must build full datetime in UTC first
            $dayIndex = (int) $slot->day; // 1 = Monday
            $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

            $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
            $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

            // Handle overnight times (e.g., 22:00 to 02:00 next day)
            if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                $toUtc->addDay();
            }

            // Convert to student's timezone
            $slot->from_time_student = $fromUtc->copy()->setTimezone($studentTimezone)->format('Y-m-d H:i');
            $slot->to_time_student   = $toUtc->copy()->setTimezone($studentTimezone)->format('Y-m-d H:i');

            return $slot;
        });


        // Group by day of week (1–7)
        $groupedAvailability = collect($tutorSlots)->groupBy('day')->sortKeys();
        $slotsToShow = $groupedAvailability->get($todayDay);
        $displayDay = $todayDay;

        if (empty($slotsToShow) || $slotsToShow->isEmpty()) {
            $nextAvailableDay = $groupedAvailability->keys()->first(function ($day) use ($todayDay) {
                return $day > $todayDay;
            });

            $displayDay = $nextAvailableDay ?? $groupedAvailability->keys()->first();
            $slotsToShow = $groupedAvailability->get($displayDay);
        }

        $html = "<div id='availability-container'>";

        if (!empty($slotsToShow) && $slotsToShow->count()) {
            $displayDayName = $dayNames[$displayDay] ?? 'Day';
            $html .= '<img src="' . public_asset('assets/images/world.png') . '"> <strong>' . $displayDayName . ':</strong> ';

            foreach ($slotsToShow as $slot) {
                $from = date('g:i A', strtotime($slot->from_time_student));
                $to = date('g:i A', strtotime($slot->to_time_student));
                $html .= "{$from} - {$to}, ";
            }

            // Optionally remove trailing comma and space
            $html = rtrim($html, ', ');
        } else {
            $html .= "<div>No available time slots found.</div>";
        }

        $html .= "</div>";
        return response()->json([
            'output' => 'true',
            'html' => $html
        ]);
    }


    public function studentBookClass(Request $request, $slug = null, $id = null)
    {
        try {
            $studentTz = Auth::user()->timezone_id ?? 'UTC';
            $user = Auth::user();
            $data['user'] = $user;

            $data['admin_disable_bookings_values'] = $adminDisable = AdminDisableBookings::first();
            $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();
            $data['todayDayIndex'] = Carbon::now($studentTz)->dayOfWeekIso;
            $data['studentz'] = Carbon::now($studentTz)->format('Y-m-d H:i:s');
            $data['dayNames'] = config('sessionsettings.dayNames');
            $data['shortDayNames'] = config('sessionsettings.shortDayNames');
            $data['bookbefore'] = config('sessionsettings.book_before_hours');


            Log::info("Student timezone: $studentTz");
            Log::info("Current student datetime: {$data['studentz']}");

            if ($adminDisable?->disable_booking === 'Y') {
                session()->flash("error", "Booking disabled by admin");
                return redirect()->back();
            }

            $data['nextMaxDate'] = Carbon::now('UTC')->addDays(30)->toDateString();
            $gradeId = $user->grade;

            // Favourites
            $data['favs'] = UserToFavourite::with(['getStudentInfo', 'getTutorInfo.getTutorShipPlan'])
                ->where('user_id', $user->id)
                ->whereHas('getTutorInfo.getTutorShipPlan', fn($q) => $q->where('grade_id', $gradeId))
                ->select('id', 'user_id', 'favourite_user_id')
                ->get();

            $data['grade'] = Grade::where(['id' => $gradeId, 'status' => 'A'])->first();
            $data['all_days'] = [1, 2, 3, 4, 5, 6, 7];

            if ($request->filled('search_tutor_id') || $request->filled('search_tutor_id_studentclass')) {
                $tutorId = $request->search_tutor_id ?? $request->search_tutor_id_studentclass;

                $data['vtutor'] = User::with(['getTutorShipPlan.getSubject'])
                    ->where('id', $tutorId)
                    ->where('status', 'A')
                    ->whereHas('getTutorShipPlan', fn($q) => $q->where('grade_id', $gradeId))
                    ->first();

                $data['subjects'] = TutorshipPlan::with(['getSubject'])
                    ->where(['teacher_id' => $data['vtutor']->id, 'grade_id' => @Auth::user()->grade, 'status' => 'A'])
                    ->get();

                if (!$data['vtutor']) {
                    session()->flash("error", "No tutor found for your grade combination!");
                    return redirect()->back();
                }

                $tutorTz = $data['vtutor']->timezone_id ?? 'UTC';
                Log::info("Tutor timezone: $tutorTz");

                // -------------------------------
                // Tutor Availability
                // -------------------------------
                DB::listen(function ($query) {
                    Log::info('SQL Query', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . ' ms',
                    ]);
                });

                $count = MyAvailability::where([
                    'teacher_id' => $tutorId,
                    'status' => 'A'
                ])->count();
                Log::info("count", [$count]);
                $data['t_my_av_show'] = MyAvailability::where([
                    'teacher_id' => $tutorId,
                    'status' => 'A'
                ])->get()->map(function ($slot) use ($studentTz) {
                    $dayIndex = (int)$slot->day;
                    $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex - 1);

                    // Tutor local times (Sydney)
                    $fromLocal = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'Australia/Sydney');
                    $toLocal = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'Australia/Sydney');
                    if ($toLocal->lte($fromLocal)) $toLocal->addDay();

                    // Convert to student timezone (Perth)
                    $fromStudent = $fromLocal->copy()->setTimezone($studentTz);
                    $toStudent = $toLocal->copy()->setTimezone($studentTz);



                    $slot->from_time_student = $fromStudent->format('H:i');
                    $slot->to_time_student = $toStudent->format('H:i');
                    $slot->from_time_local = $fromLocal->format('H:i');
                    $slot->to_time_local = $toLocal->format('H:i');

                    return $slot;
                })->filter()->sortBy(fn($s) => [$s->day, $s->from_time_student])->groupBy('day');

                Log::info("Tutor availability for all days", [$data['t_my_av_show']]);

                // -------------------------------
                // Booked Sessions
                // -------------------------------
                $data['booked'] = Tutor_calander_availability::where('booking_status', 'B')
                    ->where('tutor_id', $tutorId)
                    ->get()->map(function ($slot) use ($studentTz) {
                        try {
                            $startUtc = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $slot->from_time, 'UTC');
                            $endUtc = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $slot->to_time, 'UTC');

                            $slot->from_time_student = $startUtc->copy()->setTimezone($studentTz)->format('Y-m-d H:i:s');
                            $slot->to_time_student = $endUtc->copy()->setTimezone($studentTz)->format('Y-m-d H:i:s');
                            $slot->date_student = $startUtc->copy()->setTimezone($studentTz)->toDateString();
                        } catch (\Exception $e) {
                            Log::error("Booked slot parse error", ['slot_id' => $slot->id, 'error' => $e->getMessage()]);
                            return null;
                        }
                        return $slot;
                    })->filter();

                Log::info("Tutor booked sessions", [$data['booked']]);

                //                 // 1️⃣ Compute student's local date range
                $todayLocal = Carbon::now($studentTz)->startOfDay();
                $endLocal   = $todayLocal->copy()->addDays(200)->endOfDay();

                // 2️⃣ Convert local range to UTC (for querying date column)
                $todayUTC = $todayLocal->copy()->setTimezone('UTC')->toDateString();
                $endUTC   = $endLocal->copy()->setTimezone('UTC')->toDateString();
                Log::info("todayutc:", [$todayUTC]);
                Log::info("Endutc:", [$endUTC]);
                // 3️⃣ Query not booked slots
                $data['notbook'] = Tutor_calander_availability::where('booking_status', 'NB')
                    ->where('tutor_id', $tutorId)
                    ->whereBetween('date', [$todayUTC, $endUTC])
                    ->whereNotIn('date', $data['all_disabled_booking_dates'])
                    ->get()
                    ->map(function ($slot) use ($studentTz) {

                        // Ensure from_time/to_time exist
                        $fromTime = $slot->from_time ?: '00:00:00';
                        $toTime   = $slot->to_time ?: '00:00:00';

                        // Normalize to H:i:s
                        if (strlen($fromTime) === 5) $fromTime .= ':00';
                        if (strlen($toTime) === 5)   $toTime   .= ':00';

                        // Parse UTC datetime safely
                        try {
                            $startUtc = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $fromTime, 'UTC');
                            $endUtc   = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $toTime, 'UTC');
                        } catch (\Exception $e) {
                            // Log and skip invalid slot
                            Log::warning("Invalid slot datetime", ['slot_id' => $slot->id, 'from_time' => $fromTime, 'to_time' => $toTime]);
                            return null;
                        }

                        // Convert to student's timezone
                        $slot->from_time_student = $startUtc->copy()->setTimezone($studentTz)->format('Y-m-d H:i:s');
                        $slot->to_time_student   = $endUtc->copy()->setTimezone($studentTz)->format('Y-m-d H:i:s');

                        // Local date for easy filtering
                        $slot->date_student = $startUtc->copy()->setTimezone($studentTz)->toDateString();

                        return $slot;
                    })
                    ->filter(); // remove any null slots

                // 4️⃣ Log the not booked slots
                Log::info("Tutor Not Booked Sessions", [$data['notbook']]);                // -------------------------------
                // Today Availability (cutoff check)
                // -------------------------------
                $tutorNow = Carbon::now($tutorTz);
                $cutoffTimeStr = config('sessionsettings.max_end_time') ?: '20:00';
                if (strlen($cutoffTimeStr) === 5) $cutoffTimeStr .= ':00';

                // Log::info("Tutor cutoff time string: $cutoffTimeStr");

                try {
                    $cutoff = Carbon::createFromFormat('H:i:s', $cutoffTimeStr, $tutorTz);
                } catch (\Exception $e) {
                    Log::error("Cutoff time parse error: " . $e->getMessage());
                    $cutoff = $tutorNow->copy()->endOfDay();
                }

                $lastBookingTime = $cutoff->copy()->subHours(config('sessionsettings.book_before_hours'));

                if ($tutorNow->gte($lastBookingTime)) {
                    $data['today_get_available_dates'] = [];
                } else {
                    $minSlotUtc = $tutorNow->copy()
                        ->addHours(config('sessionsettings.book_before_hours'))
                        ->setTimezone('UTC')
                        ->format('Y-m-d H:i:s');

                    $tutorStartUtc = Carbon::today($tutorTz)->startOfDay()->setTimezone('UTC');
                    $tutorEndUtc = Carbon::today($tutorTz)->endOfDay()->setTimezone('UTC');

                    Log::info("Today UTC range", ['start' => $tutorStartUtc, 'end' => $tutorEndUtc]);
                    Log::info("Minimum UTC slot for today", ['min' => $minSlotUtc]);

                    $todaySlotsExist = Tutor_calander_availability::where('tutor_id', $tutorId)
                        ->where('booking_status', 'NB')
                        ->where('date', Carbon::now($tutorTz)->toDateString())
                        ->where('start_time', '>=', Carbon::parse($minSlotUtc)->format('H:i:s'))
                        ->exists();

                    $data['today_get_available_dates'] = $todaySlotsExist ? [Carbon::now($tutorTz)->toDateString()] : [];
                }

                Log::info("Today available dates", [$data['today_get_available_dates']]);

                // -------------------------------
                // Future available dates (timezone aware)
                // -------------------------------
                $studentTz = $studentTz ?? 'UTC';
                $tutorTz = $tutorTz ?? 'UTC';

                $utcNow = Carbon::now('UTC');
                $utcEnd = Carbon::now('UTC')->addDays(200)->endOfDay();

                $futureSlots = Tutor_calander_availability::where('tutor_id', $tutorId)
                    ->where('booking_status', 'NB')
                    ->whereBetween('date', [$utcNow->toDateString(), $utcEnd->toDateString()])
                    ->whereNotIn('date', $data['all_disabled_booking_dates'])
                    ->get(['id', 'date', 'start_time', 'end_time']);

                Log::info("Fetched NB future slots (UTC)", $futureSlots->toArray());

                $convertedDates = [];

                foreach ($futureSlots as $slot) {
                    try {
                        $fromUtc = Carbon::parse("{$slot->date} {$slot->start_time}", 'UTC');
                        $fromStudent = $fromUtc->clone()->setTimezone($studentTz);

                        // Only include slots that respect the "book_before_hours" rule
                        $minBookingTime = Carbon::now($studentTz)->addHours(config('sessionsettings.book_before_hours'));
                        if ($fromStudent->gte($minBookingTime)) {
                            $convertedDates[] = $fromStudent->toDateString();

                            // Log::info("Slot conversion", [
                            //     'slot_id' => $slot->id,
                            //     'utc_date' => $slot->date . " - " . $slot->start_time,
                            //     'student_date' => $fromStudent->toDateString() . " - " . $fromStudent->format('Y-m-d H:i:s'),
                            //     'included' => true
                            // ]);
                        } else {
                            Log::info("Slot skipped (less than book_before_hours)", [
                                'slot_id' => $slot->id,
                                'student_date' => $fromStudent->format('Y-m-d H:i:s'),
                                'min_booking_time' => $minBookingTime->format('Y-m-d H:i:s')
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error("Slot conversion error", [
                            'slot_id' => $slot->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                $uniqueConvertedDates = collect($convertedDates)->unique()->sort()->values()->toArray();

                // Merge with today's valid dates (already checked against cutoff)
                $data['get_available_dates'] = array_values(array_unique(array_merge(
                    $uniqueConvertedDates,
                    $data['today_get_available_dates'] ?? []
                )));

                Log::info("✅ [Timezone-adjusted available dates respecting book_before_hours]", [$data['get_available_dates']]);
            }

            session(['book_subject' => 0]);
            session(['book_grade' => 0]);
            session(['save_search_on_click_tutor_id' => 0]);
            session(['save_on_click_value' => 'NA']);
            $data['key'] = @$request->all();
            $data['book_subject'] = @$request->book_subject;


            $data['key'] = $request->all();
            $data['book_subject'] = $request->book_subject;

            return view('student.modules.studentbook_class.studentbook_class')->with($data);
        } catch (\Exception $e) {
            Log::error("studentBookClass exception: " . $e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }


    public function getTopicsBySubject($subject_id)
    {
        $topics = SubjectTopics::where('subject_id', $subject_id)->get(['id', 'topics']);
        return response()->json($topics);
    }



    public function ajaxCheckingBookingSlot(Request $request)
    {
        try {
            $bookingDate = date('Y-m-d', strtotime($request->data['booking_date']));
            $dayNumber = Carbon::parse($bookingDate)->dayOfWeekIso; // Monday=1, Sunday=7
            Log::info("Day:", [$dayNumber]);
            $tutor_id    = trim($request->data['tutor_id']);
            $student     = auth()->user();
            $teacher     = User::findOrFail($tutor_id);

             $tutorAvailability = MyAvailability::where('teacher_id', $teacher->id)
            ->where('status', 'A')
            ->where('day', $dayNumber)
            ->get(['id','from_time', 'to_time']);

            $teachertimezone = $teacher->timezone_id ?? 'UTC';
            $studenttimezone = $student->timezone_id ?? 'UTC';

            Log::info('===========================================================');
            Log::info('Booking Date: ' . $bookingDate);
            Log::info('Teacher Time now: ' . Carbon::now($teachertimezone)->toDateTimeString());
            Log::info('Student Time now: ' . Carbon::now($studenttimezone)->toDateTimeString());
            Log::info('UTC Time now: ' . Carbon::now('UTC')->toDateTimeString());
            $minStartTime = Carbon::parse(config('sessionsettings.min_start_time'), $teachertimezone);

            $maxEndTime = Carbon::parse(config('sessionsettings.max_end_time'), $teachertimezone);
            // Log::info('Max End Time (Tutor TZ): ' . $maxEndTime->toDateTimeString());

            $skippedSlots = []; // Array to track skipped slots with reasons

            // Admin blocked dates
            $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')
                ->pluck('disable_booking_date')->toArray();

            if (in_array($bookingDate, $all_disabled_booking_dates)) {
                //  Log::info("Booking date {$bookingDate} blocked by admin.");
                return [
                    'output'  => 'false',
                    'message' => 'The date is already blocked by admin. Please contact support.',
                ];
            }

            // Tutor "today" and cutoff
            $tutorNow = Carbon::now($teachertimezone);
            $bookingDateInTutorTZ = Carbon::parse($bookingDate, $teachertimezone);
            $isTodayInTutorTZ = $bookingDateInTutorTZ->isSameDay($tutorNow);
            $cutoffTime = $tutorNow->copy()->addHours(config('sessionsettings.book_before_hours'));
            //  Log::info('Tutor cutoff time: ' . $cutoffTime->toDateTimeString());

            $bookingDateTutorTZ = Carbon::parse($bookingDate, $teachertimezone);

            // Get UTC range for that date in tutor's timezone
            $startUtc = $bookingDateTutorTZ->copy()->startOfDay()->setTimezone('UTC');
            $endUtc   = $bookingDateTutorTZ->copy()->endOfDay()->setTimezone('UTC');

            Log::info("Start UTC for [$bookingDate]: " . $startUtc->toDateTimeString());
            Log::info("End UTC for [$bookingDate]: " . $endUtc->toDateTimeString());



            // Query using whereBetween
            $availableSlots = Tutor_calander_availability::where('tutor_id', $teacher->id)
                ->where('booking_status', 'NB')
                ->where('day', $dayNumber)
                ->whereBetween('date', [$startUtc->toDateString(), $endUtc->toDateString()]);

            Log::info("Teacher:", [$teacher->id]);
            Log::info("Start UTC:", [$startUtc->toDateString()]);
            Log::info("End UTC:", [$endUtc->toDateString()]);


            // Log SQL
            $sql = $availableSlots->toSql();
            $bindings =  $availableSlots->getBindings();
            foreach ($bindings as $binding) {
                $value = is_numeric($binding) ? $binding : "'$binding'";
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }
            Log::info("Booking update query: $sql");

            $availableSlots = $availableSlots->get();

            Log::info("query details", [$availableSlots]);

            Log::info('Available slots count: ' . $availableSlots->count());
            $teachertimezone = $teacher->timezone_id ?? 'UTC';
            $studenttimezone = $student->timezone_id ?? 'UTC';

            foreach ($availableSlots as $slot) {
                // 1️⃣ Parse DB UTC datetime
                $slotStartUtc = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $slot->start_time, 'UTC');
                $slotEndUtc   = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . ($slot->end_time ?? $slot->start_time), 'UTC');

                // 2️⃣ Convert to student timezone
                $slotStartStudent = $slotStartUtc->copy()->setTimezone($studenttimezone);
                $slotEndStudent   = $slotEndUtc->copy()->setTimezone($studenttimezone);

                Log::info('Available Slot (Student TZ): ' . $slotStartStudent->format('Y-m-d H:i:s')
                    . ' to ' . $slotEndStudent->format('Y-m-d H:i:s'));
            }


            // Tutor non-availability
            $nonAvailableSlots = TutorNonAvailabilityDetails::where('tutor_id', $teacher->id)
                ->whereDate('unavialable_date', $bookingDate)
                ->get();

            // Log::info('Non Available slots count: ' . $nonAvailableSlots->count());
            foreach ($nonAvailableSlots as $slot) {
                $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time, 'UTC')
                    ->setTimezone($studenttimezone)
                    ->setDateFrom(Carbon::parse($bookingDate, $studenttimezone));

                $slotEnd = Carbon::createFromFormat('H:i:s', $slot->end_time ?? $slot->start_time, 'UTC')
                    ->setTimezone($studenttimezone)
                    ->setDateFrom(Carbon::parse($bookingDate, $studenttimezone));

                Log::info('Non Available Slot (Student TZ): ' . $slotStart->format('Y-m-d H:i:s') . ' to ' . $slotEnd->format('Y-m-d H:i:s'));
            }



            Log::info("student timezone:", [$studenttimezone]);
            // Student bookings
            $studentBookings = StudentClassBooking::where('student_id', $student->id)
                //->where('booking_date', $bookingDate) // this is the local booking date filter
                ->whereBetween('booking_date', [$startUtc->toDateString(), $endUtc->toDateString()])
                ->whereIn('booking_status', ['B']);


                Log::info("Student:", [$student->id]);
            Log::info("Start UTC:", [$startUtc->toDateString()]);
            Log::info("End UTC:", [$endUtc->toDateString()]);


            // Log SQL
            $sql = $studentBookings->toSql();
            $bindings =  $studentBookings->getBindings();
            foreach ($bindings as $binding) {
                $value = is_numeric($binding) ? $binding : "'$binding'";
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }
            Log::info("Student Bookings select query: $sql");
            $studentBookings = $studentBookings->get(['booking_date', 'from_time', 'to_time']);

            Log::info("UTC Student bookings raw", [$studentBookings]);

            $studentBookedRanges = $studentBookings->map(function ($b) use ($studenttimezone) {
                // Build UTC datetimes from DB values
                $fromUtc = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $b->booking_date . ' ' . $b->from_time,
                    'UTC' // tell Carbon the DB time is UTC
                );

                $toUtc = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $b->booking_date . ' ' . $b->to_time,
                    'UTC'
                );

                // handle overnight (to_time <= from_time)
                if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                    $toUtc->addDay();
                }

                // convert to student’s timezone
                $fromLocal = $fromUtc->copy()->setTimezone($studenttimezone);
                $toLocal   = $toUtc->copy()->setTimezone($studenttimezone);

                Log::info('Mapped student booking', [
                    'utc_from'   => $fromUtc->format('Y-m-d H:i:s T'),
                    'utc_to'     => $toUtc->format('Y-m-d H:i:s T'),
                    'local_from' => $fromLocal->format('Y-m-d H:i:s T'),
                    'local_to'   => $toLocal->format('Y-m-d H:i:s T'),
                ]);

                return [
                    'from' => $fromLocal,
                    'to'   => $toLocal,
                ];
            });

            // Tutor bookings
            $tutorBookings = StudentClassBooking::where('tutor_id', $teacher->id)
                ->whereBetween('booking_date', [$startUtc, $endUtc])
                ->whereIn('booking_status', ['B'])
                ->get(['from_time', 'to_time']);
            //Log::info("UTC Date and times",[]);

            $tutorBookedRanges = $tutorBookings->map(function ($b) use ($teachertimezone, $bookingDate) {
                $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $b->from_time, 'UTC');
                $toUtc   = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $b->to_time, 'UTC');
                if ($toUtc->lessThanOrEqualTo($fromUtc)) $toUtc->addDay();
                return ['from' => $fromUtc->copy()->setTimezone($teachertimezone), 'to' => $toUtc->copy()->setTimezone($teachertimezone)];
            });

            // Process slots
            $slotRanges = $availableSlots->map(function ($slot) use (
                $bookingDate,
                $studenttimezone,
                $teachertimezone,
                $cutoffTime,
                $isTodayInTutorTZ,
                $studentBookedRanges,
                $tutorBookedRanges,
                $nonAvailableSlots,
                $tutorAvailability,
                &$skippedSlots
            ) {
                // 1️⃣ Parse DB UTC datetime
                $slotStartUtc = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . $slot->start_time, 'UTC');
                $slotEndUtc   = Carbon::createFromFormat('Y-m-d H:i:s', $slot->date . ' ' . ($slot->end_time ?? $slot->start_time), 'UTC');

                // Ensure overnight slot handled
                if ($slotEndUtc->lessThanOrEqualTo($slotStartUtc)) {
                    $slotEndUtc->addDay();
                }

                // 2️⃣ Convert to tutor timezone
                $slotStartTutor = $slotStartUtc->copy()->setTimezone($teachertimezone);
                $slotEndTutor   = $slotEndUtc->copy()->setTimezone($teachertimezone);

               $insideTutorRange = $tutorAvailability->contains(
                        function ($availability) use ($slot, $slotStartTutor, $slotEndTutor) {

                            if ($availability->id != $slot->available_id) {
                                return false;
                            }

                            $availableFrom = $slotStartTutor->copy()
                                ->setTimeFromTimeString($availability->from_time);

                            $availableTo = $slotStartTutor->copy()
                                ->setTimeFromTimeString($availability->to_time);

                            if ($availableTo->lessThanOrEqualTo($availableFrom)) {
                                $availableTo->addDay();
                            }

                            return $slotStartTutor->greaterThanOrEqualTo($availableFrom)
                                && $slotEndTutor->lessThanOrEqualTo($availableTo);
                        }
                    );

                    if (!$insideTutorRange) {
                        $skippedSlots[] = "Skipped: available_id mismatch or outside availability range";
                        return null;
                    }

                // Skip if before today's cutoff
                if ($isTodayInTutorTZ && $slotStartTutor->lt($cutoffTime)) {
                    $skippedSlots[] = "{$slotStartTutor->format('H:i')} - {$slotEndTutor->format('H:i')} skipped: before cutoff time {$cutoffTime->format('H:i')}";
                    return null;
                }

                // Tutor bookings overlap
                $tutorOverlap = $tutorBookedRanges->first(fn($range) => $slotStartTutor->lt($range['to']) && $slotEndTutor->gt($range['from']));
                if ($tutorOverlap) {
                    $skippedSlots[] = "{$slotStartTutor->format('H:i')} - {$slotEndTutor->format('H:i')} skipped: overlaps tutor booking";
                    return null;
                }

                // Non-availability overlap
                foreach ($nonAvailableSlots as $nas) {
                    $naStart = Carbon::createFromFormat('H:i:s', $nas->start_time, 'UTC')->setTimezone($teachertimezone)->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
                    $naEnd   = Carbon::createFromFormat('H:i:s', $nas->end_time, 'UTC')->setTimezone($teachertimezone)->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
                    if ($naEnd->lessThanOrEqualTo($naStart)) $naEnd->addDay();

                    if ($slotStartTutor->lt($naEnd) && $slotEndTutor->gt($naStart)) {
                        $skippedSlots[] = "{$slotStartTutor->format('H:i')} - {$slotEndTutor->format('H:i')} skipped: overlaps non-availability {$naStart->format('H:i')} - {$naEnd->format('H:i')}";
                        return null;
                    }
                }

                // 3️⃣ Convert to student timezone for final output
                $slotStartStudent = $slotStartUtc->copy()->setTimezone($studenttimezone);
                $slotEndStudent   = $slotEndUtc->copy()->setTimezone($studenttimezone);

                // Student bookings overlap
                $overlap = $studentBookedRanges->first(fn($range) => $slotStartStudent->lt($range['to']) && $slotEndStudent->gt($range['from']));
                if ($overlap) {
                    $skippedSlots[] = "{$slotStartStudent->format('H:i')} - {$slotEndStudent->format('H:i')} skipped: overlaps student booking";
                    return null;
                }

                // ✅ Return formatted slot
                return [
                    'from' => $slotStartStudent->format('h:i A'),
                    'to'   => $slotEndStudent->format('h:i A')
                ];
            })->filter()->values()->toArray();


            if (!empty($skippedSlots)) {
                //  Log::info('Skipped Slots Summary:', $skippedSlots);
            }






            $minStartTime = Carbon::parse($minStartTime);






            // ✅ Log the generated slots
            Log::info('Generated Slot Ranges:', $slotRanges);
            if (!empty($skippedSlots)) {
                Log::info('Skipped Slots Summary:', $skippedSlots);
            }





            Log::info("minStartTime: $minStartTime");
            // $maxEndTime = Carbon::parse($maxEndTime); // your existing max end time
            // $cutoff = $maxEndTime->copy()->subHour();   // max_end_time - 1 hour

            // // 1️⃣ Sort the slots by 'from' time
            // $sortedSlots = collect($slotRanges)
            //     ->sortBy(fn($slot) => Carbon::parse($slot['from']))
            //     ->values();
            // Log::info('Generated sortedSlots Slot Ranges:', [$sortedSlots]);
            // // Make sure min/max times are Carbon instances in the tutor timezone
            // $minStartTime = Carbon::parse($minStartTime, $teachertimezone)
            //     ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
            // $maxEndTime = Carbon::parse($maxEndTime, $teachertimezone)
            //     ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));

            // // Filter slots
            // $filteredSlots = collect($slotRanges)->filter(function ($slot) use ($minStartTime, $maxEndTime, $bookingDate, $teachertimezone) {
            //     // Parse slot times with correct date & timezone
            //     $slotFrom = Carbon::createFromFormat('h:i A', $slot['from'], $teachertimezone)
            //         ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
            //     $slotTo = Carbon::createFromFormat('h:i A', $slot['to'], $teachertimezone)
            //         ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));

            //     return $slotFrom->gte($minStartTime) && $slotTo->lte($maxEndTime);
            // })->values();

            // // Pluck start/end times if needed
            // $filteredStartTimes = $filteredSlots->pluck('from')->values();
            // $filteredEndTimes   = $filteredSlots->pluck('to')->values();

            // Log::info('Filtered Slot Ranges:', $filteredSlots->toArray());

            // // 4️⃣ Optional: log for debugging
            // Log::info('Filtered Slot Ranges:', $filteredSlots->toArray());

            $minStartTime = Carbon::parse($minStartTime, $teachertimezone)
                ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
            $maxEndTime = Carbon::parse($maxEndTime, $teachertimezone)
                ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));

            // Sort slots by start time
            $sortedSlots = collect($slotRanges)
                ->sortBy(fn($slot) => Carbon::createFromFormat('h:i A', $slot['from'], $teachertimezone))
                ->values();

            Log::info('Generated sortedSlots Slot Ranges:', [$sortedSlots]);

            // Filter slots: remove any that start after maxEndTime (or end after maxEndTime)
            $filteredSlots = $sortedSlots->filter(function ($slot) use ($minStartTime, $maxEndTime, $bookingDate, $teachertimezone) {
                $slotFrom = Carbon::createFromFormat('h:i A', $slot['from'], $teachertimezone)
                    ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));
                $slotTo = Carbon::createFromFormat('h:i A', $slot['to'], $teachertimezone)
                    ->setDateFrom(Carbon::parse($bookingDate, $teachertimezone));

                return $slotFrom->gte($minStartTime) && $slotFrom->lte($maxEndTime);
            })
                // ✅ Remove duplicates based on both from+to values
                ->unique(fn($slot) => $slot['from'] . '-' . $slot['to'])
                ->values();

            $filteredStartTimes = $filteredSlots->pluck('from')->values();
            $filteredEndTimes   = $filteredSlots->pluck('to')->values();

            Log::info('Filtered Slot Ranges (after deduplication):', $filteredSlots->toArray());

            // Log::info('Filtered Start Times: ' . json_encode($filteredStartTimes));
            // Log::info('Filtered End Times: ' . json_encode($filteredEndTimes));


            return [
                'output'      => 'true',
                'message'     => 'Available times fetched.',
                'start_times' => $filteredStartTimes,
                'end_times'   => $filteredEndTimes,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'output'  => 'false',
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }




    public function ajaxCheckTimeSlot(Request $request)
    {
        try {
            $booking_date = trim($request->data['booking_date']);
            $tutor_id = trim($request->data['tutor_id']);
            $from_time = date('H:i:s', strtotime(trim($request->data['from_time'])));

            $data['from_time'] = $from_time;
            $data['get_available_id'] = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->where('start_time', '>=', $from_time)->groupBy('available_id')->pluck('available_id')->take(1)->toArray();

            $data['get_available_end_times'] = Tutor_calander_availability::whereIn('available_id', $data['get_available_id'])->where('start_time', '>=', $from_time)->where(['tutor_id' => $tutor_id, 'date' => $booking_date])->orderBy('end_time', 'asc')->get();


            $getEndTimes = [];
            $getBookedEndTimes = [];
            $maxETime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->where('end_time', '>=', $from_time)->whereIn('available_id', $data['get_available_id'])->max('end_time');
            $data['max_available_end_times'] = date('h:i a', strtotime($maxETime));
            $i = 0;
            $maxEndTimeValue = $data['max_available_end_times'];
            if (@$data['get_available_end_times']) {
                foreach (@$data['get_available_end_times'] as $t) {
                    if (date('H:i:s', strtotime($t->start_time)) >= $from_time) {
                        if (@$t->booking_status == 'B' || @$t->booking_status == 'NA') {
                            if ($i == 0) {
                                $maxEndTimeValue = date('h:i a', strtotime($t->start_time));
                            }
                            array_push($getBookedEndTimes, date('h:i a', strtotime($t->start_time)));
                            $i++;
                        } elseif ((@$t->booking_status == 'NB')) {
                            array_push($getEndTimes, date('h:i a', strtotime($t->end_time)));
                        }
                    }
                }
            }
            $maxEndTimeValue = $maxEndTimeValue;
            // dd($data['get_available_end_times']);

            $data['max_available_end_times'] = $maxEndTimeValue;
            $data['getBookedEndTimes'] = $getBookedEndTimes;
            $data['getEndTimes'] = $getEndTimes;
            return response()->json($data, 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }
    public function ajaxCheckBookingDate(Request $request)
    {
        try {

            $tutor_id = trim($request->data['tutor_id']);
            $bookingDate = date("Y-m-d", strtotime($request->data['get_booking_date']));
            $from_time = date("H:i:s", strtotime($request->data['from_time']));
            $to_time = date("H:i:s", strtotime($request->data['to_time']));
            $day = date("D", strtotime($request->data['get_booking_date']));
            if (@$bookingDate < date('Y-m-d')) {
                $data['output'] = 'false';
                $data['message'] = 'Date is not available';
                return response()->json($data, 200);
            }
            if (@$bookingDate == date('Y-m-d')) {
                $new_time = date("H:i:s", strtotime('+1 hours'));
                if ($from_time <= $new_time || $to_time <= $new_time) {
                    $data['output'] = 'false';
                    $data['message'] = 'Choose another time slot';
                    return response()->json($data, 200);
                }
            }
            $admin_disable_bookings_values = AdminDisableBookings::first();
            $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();

            if ($day == "Mon") {
                $dValue = 1;
            }
            if ($day == "Tue") {
                $dValue = 2;
            }
            if ($day == "Wed") {
                $dValue = 3;
            }
            if ($day == "Thu") {
                $dValue = 4;
            }
            if ($day == "Fri") {
                $dValue = 5;
            }
            if ($day == "Sat") {
                $dValue = 6;
            }
            if ($day == "Sun") {
                $dValue = 7;
            }
            if ($bookingDate < date('Y-m-d')) {
                if ($from_time <= date('H:i:s') || $to_time <= date('H:i:s')) {
                    $data['output'] = 'false';
                    $data['condition_no'] = '5';
                    return response()->json($data, 200);
                }
            }
            if (@$admin_disable_bookings_values->disable_booking == 'Y') {
                $data['output'] = 'false';
                $data['condition_no'] = '11';
                $data['message'] = 'You cannot make bookings at this time. Please contact support';
                return response()->json($data, 200);
            } elseif (in_array($bookingDate, $all_disabled_booking_dates)) {
                $data['output'] = 'false';
                $data['condition_no'] = '11';
                $data['message'] = 'You cannot make bookings for this particular date.Please contact support!Choose available slot!';
                return response()->json($data, 200);
            }
            // check whether tutor is available or not
            $starttime = $from_time;  // your start time
            $endtime = $to_time;  // End time
            $duration = '60';  // split by 30 mins

            $array_of_time = array();
            $start_time    = strtotime($starttime); //change to strtotime
            $end_time      = strtotime($endtime); //change to strtotime

            $add_mins  = $duration * 60;
            while ($start_time <= $end_time) // loop between time
            {
                $array_of_time[] = date("h:i:s", $start_time);
                $start_time += $add_mins; // to check endtie=me
            }
            $length = count($array_of_time);
            $from_to_times = [];
            $get_all_from_times = [];
            $get_all_to_times = [];

            for ($k = 0; $k < $length; $k++) {
                $data = [];
                if ($k + 1 < $length) {
                    $data['from_time'] = $array_of_time[$k];
                    $data['to_time'] = $array_of_time[$k + 1];
                    $frmT = "'" . $data['from_time'] . "'";
                    $toT = "'" . $data['to_time'] . "'";
                    array_push($from_to_times, $data);
                    array_push($get_all_from_times, $frmT);
                    array_push($get_all_to_times, $toT);
                }
            }
            $timeSlotCount = count($from_to_times);
            // check available or not
            $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

            $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
                $query->whereBetween('end_time', [$from_time, $to_time]);
            });

            $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

            if ($chkBDtFrmTimeToTime > 0) {
                $data['output'] = 'false';
                $data['condition_no'] = '2';
                $data['message'] = 'In between some time slots are booked!' . "chkBDtFrmTimeToTime : " . $chkBDtFrmTimeToTime . " timeSlotCount : " . $timeSlotCount;
                return response()->json($data, 200);
            }
            // check available if
            $chkADtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

            $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
                $query->whereBetween('end_time', [$from_time, $to_time]);
            });

            $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();

            if ($chkADtFrmTimeToTime <= 0) {
                $data['output'] = 'false';
                $data['condition_no'] = '3';
                $data['message'] = 'Time slot is not available';
                $data['d'] = 'Time slot is not available' . "chkADtFrmTimeToTime : " . $chkADtFrmTimeToTime . " timeSlotCount : " . $timeSlotCount;
                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
            $data['output'] = 'false';
            return response()->json($data, 200);
        }
    }
    public function getStudentGradeTutorData(Request $request)
    {
        $gradeId = @Auth::user()->grade;
        $stateId = @Auth::user()->state;
        $timezone_id = @Auth::user()->timezone_id;
        if (@$gradeId) {
            $data['grade_tutors'] = User::with(['getTutorShipPlan'])->where(['status' => 'A', 'user_type' => 'T']);
            if (@$request->search_u_name) {
                $data['grade_tutors'] = $data['grade_tutors']->where(function ($query) use ($request) {
                    $query->Where('f_name', 'like', '%' . $request->search_u_name . '%')
                        ->orWhere('l_name', 'like', '%' . $request->search_u_name . '%')
                        ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->search_u_name . '%');
                });
            }
            $data['grade_tutors'] = $data['grade_tutors']->whereHas('getTutorShipPlan', function ($q) use ($gradeId, $request) {
                $q->where(['grade_id' => $gradeId]);
            });
            $data['grade_tutors'] = $data['grade_tutors']->where(function ($q) use ($stateId) {
                $q->where(['state' => $stateId]);
            });
            //$data['grade_tutors'] = $data['grade_tutors']->where(function($q) use($timezone_id){
            //$q->where(['timezone_id'=>$timezone_id]);
            //});
            if (@$request->book_grade && @$request->book_subject) {
                $gradeId = (int)(@$request->book_grade);
                $subjectslug = @$request->book_subject;
                $subject = Subject::where(['slug' => $subjectslug])->first();
                if (@$subject) {
                    $data['grade_tutors'] = $data['grade_tutors']->whereHas('getTutorShipPlan', function ($q) use ($request, $subject, $gradeId) {
                        $q->where(['grade_id' => $gradeId, 'subject_id' => $subject->id]);
                    });
                } else {
                    $data['grade_tutors'] = $data['grade_tutors']->whereHas('getTutorShipPlan', function ($q) use ($request, $subject, $gradeId) {
                        $q->where(['grade_id' => $gradeId]);
                    });
                }
            } else {
                $gradeId = (int)(@$request->book_grade);
                // $subjectslug = @$request->book_subject;
                // $subject =Subject::where(['slug'=>$subjectslug])->first();
                $data['grade_tutors'] = $data['grade_tutors']->whereHas('getTutorShipPlan', function ($q) use ($request, $gradeId) {
                    $q->where(['grade_id' => $gradeId]);
                });
            }
            $data['grade_tutors'] = $data['grade_tutors']->select('id', 'f_name', 'l_name', 'user_type', 'slug', 'status')->get();
            $data['grade_id'] = $gradeId;
        } else {
            $gradeId = (int)(@$request->book_grade);
            $subjectslug = @$request->book_subject;
            $subject = Subject::where(['slug' => $subjectslug])->first();
            $data['grade_tutors'] = User::with(['getTutorShipPlan'])->where(['status' => 'A', 'user_type' => 'T']);
            if (@$request->search_u_name) {
                $data['grade_tutors'] = $data['grade_tutors']->where(function ($query) use ($request) {
                    $query->Where('f_name', 'like', '%' . $request->search_u_name . '%')
                        ->orWhere('l_name', 'like', '%' . $request->search_u_name . '%')
                        ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->search_u_name . '%');
                });
            }
            $data['grade_tutors'] = $data['grade_tutors']->whereHas('getTutorShipPlan', function ($q) use ($request, $subject, $gradeId) {
                $q->where(['grade_id' => $gradeId, 'subject_id' => $subject->id]);
            });
            $data['grade_tutors'] = $data['grade_tutors']->select('id', 'f_name', 'l_name', 'user_type', 'slug', 'status')->orderBy('f_name', 'asc')->get();
            $data['subject_id'] = @$subject->id;

            // $data['grade_tutors'] = [];
            $data['grade_id'] = @$gradeId;
        }
        return response()->json($data, 200);
    }
    /*
    * Method        : insertBookingToPaymentTable
    * Description   : This method is used to insert into payment table
    * Author        : Jayatri
    */
    public function insertBookingToPaymentTable($bookingId)
    {
        $payment = Payments::where(['booking_id' => $bookingId])->first();
        $bookingInfo = StudentClassBooking::where(['id' => $bookingId])->first();
        if (!@$payment && @$bookingInfo) {

            $crPaymentData['booking_id'] = $bookingId;
            $crPaymentData['status'] = 'I';
            $crPaymentData['amount'] = $bookingInfo->booking_amount + $bookingInfo->stripe_charge;
            $crPayment = Payments::create($crPaymentData);
        }
    }



    public function bookAClass(Request $request)
    {
        //  try {
        $userTimezone = Auth::user()->timezone_id ?? config('app.timezone');
        $admin_disable_bookings_values = AdminDisableBookings::first();
        $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')
            ->toArray();

        if (@$admin_disable_bookings_values->disable_booking == 'Y') {
            session()->flash("error", "Choose available time slot2");
            return redirect()->back();
        }

        $request->validate([
            'tutor_id' => 'required',
            'selected_booked_date' => 'required|date|after_or_equal:today',
            'from_time' => 'required',
            'to_time' => 'required|after:from_time',
            'subject_id' => 'required|exists:subjects,id',
            'session_focus' => 'required|exists:topic_details,id',
            'subject_area' => 'required',
        ]);

        // --------------------------
        // 1️⃣ Convert user input to UTC
        // --------------------------
        $fromLocal = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $request->selected_booked_date . ' ' . date('H:i:s', strtotime($request->from_time)),
            $userTimezone
        );

        $toLocal = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $request->selected_booked_date . ' ' . date('H:i:s', strtotime($request->to_time)),
            $userTimezone
        );

        $fromUtc = $fromLocal->copy()->setTimezone('UTC');
        $toUtc = $toLocal->copy()->setTimezone('UTC');

        $bookingDateUtc = $fromUtc->format('Y-m-d');
        $fromTimeUtc = $fromUtc->format('H:i:s');
        $toTimeUtc = $toUtc->format('H:i:s');

        $day = date("D", strtotime($request->selected_booked_date));
        $tutor_id = $request->tutor_id;

        // Map day to numeric value
        $dayMap = ['Mon' => 1, 'Tue' => 2, 'Wed' => 3, 'Thu' => 4, 'Fri' => 5, 'Sat' => 6, 'Sun' => 7];
        $dValue = $dayMap[$day] ?? null;

        // --------------------------
        // 2️⃣ Check disabled bookings
        // --------------------------
        if (@$admin_disable_bookings_values->disable_booking == 'Y') {
            session()->flash("error", "You cannot make bookings at this time. Please contact support");
            return redirect()->back();
        } elseif (in_array($bookingDateUtc, $all_disabled_booking_dates)) {
            session()->flash("error", "This date is not available! Choose another date! This date is blocked!");
            return redirect()->back();
        }

        // --------------------------
        // 3️⃣ Check booking date validity
        // --------------------------
        $currentDate = Carbon::now($userTimezone)->format('Y-m-d');
        $currentTime = Carbon::now($userTimezone)->format('H:i:s');
        Log::info("Booking Date:", [$bookingDateUtc]);

        // if ($bookingDateUtc < $currentDate) {
        //     session()->flash("error", "Choose available time slot! Tutor is not available!");
        //     return redirect()->back();
        // }

        // if ($bookingDateUtc == $currentDate && ($fromLocal->format('H:i:s') <= $currentTime || $toLocal->format('H:i:s') <= $currentTime)) {
        //     session()->flash("error", "Choose available time slot! Tutor is not available today!");
        //     return redirect()->back();
        // }

        // --------------------------
        // 4️⃣ Generate time slots array
        // --------------------------
        $startTime = strtotime($fromTimeUtc);
        $endTime = strtotime($toTimeUtc);
        $duration = 60 * 60; // 60 minutes

        $array_of_time = [];
        while ($startTime <= $endTime) {
            $array_of_time[] = date("H:i:s", $startTime);
            $startTime += $duration;
        }

        $from_to_times = [];
        $get_all_from_times = [];
        $get_all_to_times = [];
        $length = count($array_of_time);

        for ($k = 0; $k < $length; $k++) {
            if ($k + 1 < $length) {
                $data['from_time'] = $array_of_time[$k];
                $data['to_time'] = $array_of_time[$k + 1];
                $from_to_times[] = $data;
                $get_all_from_times[] = "'" . $data['from_time'] . "'";
                $get_all_to_times[] = "'" . $data['to_time'] . "'";
            }
        }

        // --------------------------
        // 5️⃣ Check availability with Tutor_calander_availability
        // --------------------------
        $chkBDtFrmTimeToTime = Tutor_calander_availability::where([
            'tutor_id' => $tutor_id,
            'booking_status' => 'B',
            'date' => $bookingDateUtc
        ])->where('start_time', '>=', $fromTimeUtc)
            ->where(function ($query) use ($fromTimeUtc, $toTimeUtc) {
                $query->whereBetween('end_time', [$fromTimeUtc, $toTimeUtc]);
            })->count();

        // --------------------------
        // 6️⃣ Check if student already has booking
        // --------------------------
        $chkStudentBooking = StudentClassBooking::where([
            'student_id' => Auth::id(),
            'booking_date' => $bookingDateUtc
        ])->whereIn('booking_status', ['B'])
            ->where('from_time', '>=', $fromTimeUtc)
            ->where(function ($query) use ($fromTimeUtc, $toTimeUtc) {
                $query->whereBetween('to_time', [$fromTimeUtc, $toTimeUtc]);
            })->count();

        if ($chkStudentBooking > 0) {
            session()->flash("error", "You have already booked another tutor at the same date and time!");
            return redirect()->back();
        }

        // --------------------------
        // 7️⃣ Check tutor availability with NB status
        // --------------------------
        $chkADtFrmTimeToTime = Tutor_calander_availability::where([
            'tutor_id' => $tutor_id,
            'booking_status' => 'NB',
            'date' => $bookingDateUtc
        ])->where('start_time', '>=', $fromTimeUtc)
            ->where(function ($query) use ($fromTimeUtc, $toTimeUtc) {
                $query->whereBetween('end_time', [$fromTimeUtc, $toTimeUtc]);
            })->count();

        // --------------------------
        // 8️⃣ Fetch tutor's plan
        // --------------------------
        $getTutorShipPlan = TutorshipPlan::where([
            'teacher_id' => $request->tutor_id,
            'grade_id' => Auth::user()->grade,
            'subject_id' => $request->subject_id,
            'status' => 'A'
        ])->first();

        if (!$getTutorShipPlan) {
            session()->flash("error", "Tutor's tutorship plan based on tutor, grade, subject is not found!");
            return redirect()->back();
        }

        $currentDiff = $toUtc->diffInMinutes($fromUtc);

        $com = Commissions::first();
        $tutorInfoDetails = User::find($request->tutor_id);

        // --------------------------
        // 9️⃣ Prepare booking data
        // --------------------------
        $createB = [
            'booking_no' => 'V' . time(),
            'student_id' => Auth::id(),
            'hourly_rate' => $getTutorShipPlan->hourly_rate,
            'tutor_id' => $request->tutor_id,
            'student_grade_id' => Auth::user()->grade,
            'subject_id' => $request->subject_id,
            'topic_details_id' => $request->session_focus,
            'subject_area' => $request->subject_area,
            'session_topic' => $request->session_topic ?? null,
            'problem_areas' => $request->problem_areas ?? null,
            'session_outcome' => $request->session_outcome ?? null,
            'from_time' => $fromTimeUtc,
            'to_time' => $toTimeUtc,
            'booking_date' => $bookingDateUtc,
            'timezone_id' => $userTimezone,
            'booking_status' => 'IC',
            'payment_method' => 'O',
            'booking_amount' => ($currentDiff * ($getTutorShipPlan->hourly_rate / 60)),
            'stripe_charge' => (config('sessionsettings.GST') * ($currentDiff * ($getTutorShipPlan->hourly_rate / 60))),
        ];

        if ($tutorInfoDetails) {
            $createB['tutor_earnings'] = $createB['booking_amount'] - ($createB['booking_amount'] * ($tutorInfoDetails->commission_percentage) / 100);
            $createB['admin_percentage'] = $tutorInfoDetails->commission_percentage;
            $createB['admin_commission'] = ($createB['booking_amount'] * ($tutorInfoDetails->commission_percentage) / 100);
        }

        if ($createB['booking_amount'] <= 0) {
            session()->flash("error", "Booking amount cannot be 0!");
            return redirect()->back();
        }

        // --------------------------
        // 10️⃣ Create booking
        // --------------------------
        $bookingInfo = StudentClassBooking::create($createB);

        // Generate booking_no properly
        $bookingNo = 'VT00000' . $bookingInfo->id;
        $bookingInfo->update(['booking_no' => $bookingNo]);

        $bookingInfo = StudentClassBooking::find($bookingInfo->id);

        // --------------------------
        // 11️⃣ Add to favourite if not exists
        // --------------------------
        $isInsFav = UserToFavourite::where([
            'favourite_user_id' => $bookingInfo->tutor_id,
            'user_id' => Auth::id()
        ])->first();

        if (!$isInsFav) {
            UserToFavourite::create([
                'favourite_user_id' => $bookingInfo->tutor_id,
                'user_id' => Auth::id()
            ]);
        }

        // --------------------------
        // 12️⃣ Insert into payment table
        // --------------------------
        $this->insertBookingToPaymentTable($bookingInfo->id);

        session()->flash("success", "Booking order " . $bookingInfo->booking_no . " received. Complete booking within the next 15 minutes to confirm");

        return redirect()->route('payment.init', ['track' => encrypt($bookingInfo->id)]);
        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage());
        //     session()->flash("error", $e->getMessage());
        //     return redirect()->back();
        // }
    }


    // public function bookAClass(Request $request)
    // {
    //   //  Log::info('bookAClass called with request: ', $request->all());
    //     try {
    //         $userTimezone = Auth::user()->timezone_id ?? config('app.timezone');
    //         $admin_disable_bookings_values = AdminDisableBookings::first();
    //         $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();
    //         if (@$admin_disable_bookings_values->disable_booking == 'Y') {
    //             session()->flash("error", "Choose available time slot2");
    //             return redirect()->back();
    //         }

    //         $request->validate([
    //             'tutor_id' => 'required',
    //             'selected_booked_date' => 'required|date|after_or_equal:today',
    //             'from_time' => 'required',
    //             'to_time' => 'required|after:from_time',
    //             'subject_id' => 'required|exists:subjects,id',
    //             'session_focus' => 'required|exists:topic_details,id',
    //             'subject_area' => 'required',
    //             // 'session_topic' => 'required|string|max:255',
    //         ]);
    //         // fetch date time day from request
    //         $bookingDate = date("Y-m-d", strtotime($request->selected_booked_date));
    //         $from_time = date("H:i:s", strtotime($request->from_time));
    //         $to_time = date("H:i:s", strtotime($request->to_time));
    //         $from_db_time = (new DateTime($request->from_time, new DateTimeZone($userTimezone)))
    //             ->setTimezone(new DateTimeZone('UTC'))
    //             ->format('H:i:s');

    //         $to_db_time = (new DateTime($request->to_time, new DateTimeZone($userTimezone)))
    //             ->setTimezone(new DateTimeZone('UTC'))
    //             ->format('H:i:s');
    //         // dd($from_time, $to_time, $from_db_time, $to_db_time);
    //         $day = date("D", strtotime($request->selected_booked_date));
    //         $tutor_id = $request->tutor_id;
    //         //get day value
    //         if ($day == "Mon") {
    //             $dValue = 1;
    //         }
    //         if ($day == "Tue") {
    //             $dValue = 2;
    //         }
    //         if ($day == "Wed") {
    //             $dValue = 3;
    //         }
    //         if ($day == "Thu") {
    //             $dValue = 4;
    //         }
    //         if ($day == "Fri") {
    //             $dValue = 5;
    //         }
    //         if ($day == "Sat") {
    //             $dValue = 6;
    //         }
    //         if ($day == "Sun") {
    //             $dValue = 7;
    //         }
    //         if (@$admin_disable_bookings_values->disable_booking == 'Y') {
    //             session()->flash("error", "You cannot make bookings at this time. Please contact support");
    //             return redirect()->back();
    //         } elseif (in_array($bookingDate, $all_disabled_booking_dates)) {
    //             session()->flash("error", "This date is not available!Choose another date!This date is blocked!");
    //             return redirect()->back();
    //         }
    //         if ($bookingDate < date('Y-m-d')) {
    //             session()->flash("error", "Choose available time slot!Tutor is not available!Today from time to time should be greater than current time!");
    //             return redirect()->back();
    //         }
    //         if ($bookingDate == date('Y-m-d') && $from_time >= date("H:i:s", strtotime('+1 hours'))) {
    //             $new_time = date("H:i:s", strtotime('+1 hours'));
    //             if ($from_time <= $new_time || $to_time <= $new_time) {
    //                 session()->flash("error", "Choose available time slot!Tutor is not available!Today from time to time should be greater than current time!");
    //                 return redirect()->back();
    //             }
    //         }
    //         if ($bookingDate == date('Y-m-d')) {
    //             $new_time = date("H:i:s", strtotime('+1 hours'));
    //             if ($from_time <= $new_time || $to_time <= $new_time) {
    //                 session()->flash("error", "Choose available time slot!Tutor is not available!Today from time to time should be greater than current time!");
    //                 return redirect()->back();
    //             }
    //         }
    //         // check whether tutor is available or not
    //         $starttime = $from_time;  // your start time
    //         $endtime = $to_time;  // End time
    //         $duration = '60';  // split by 30 mins

    //         $array_of_time = array();
    //         $start_time    = strtotime($starttime); //change to strtotime
    //         $end_time      = strtotime($endtime); //change to strtotime

    //         $add_mins  = $duration * 60;
    //         while ($start_time <= $end_time) // loop between time
    //         {
    //             $array_of_time[] = date("h:i:s", $start_time);
    //             $start_time += $add_mins; // to check endtie=me
    //         }
    //         $length = count($array_of_time);
    //         $from_to_times = [];
    //         $get_all_from_times = [];
    //         $get_all_to_times = [];

    //         for ($k = 0; $k < $length; $k++) {
    //             $data = [];
    //             if ($k + 1 < $length) {
    //                 $data['from_time'] = $array_of_time[$k];
    //                 $data['to_time'] = $array_of_time[$k + 1];
    //                 $frmT = "'" . $data['from_time'] . "'";
    //                 $toT = "'" . $data['to_time'] . "'";
    //                 array_push($from_to_times, $data);
    //                 array_push($get_all_from_times, $frmT);
    //                 array_push($get_all_to_times, $toT);
    //             }
    //         }
    //         $timeSlotCount = count($from_to_times);
    //         // check available or not
    //         $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_db_time);

    //         $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_db_time, $to_db_time) {
    //             $query->whereBetween('end_time', [$from_db_time, $to_db_time]);
    //         });

    //         $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();



    //         $chkBDtFrmTimeToTime = StudentClassBooking::where(['student_id' => @Auth::user()->id, 'booking_date' => $bookingDate])->whereIn('booking_status', ['B'])->where('from_time', '>=', $from_db_time);
    //         $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_db_time, $to_db_time) {
    //             $query->whereBetween('to_time', [$from_db_time, $to_db_time]);
    //         });
    //         $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

    //         if ($chkBDtFrmTimeToTime > 0) {
    //             session()->flash("error", "You have already booked other tutor with same date and time!");
    //             return redirect()->back();
    //         }
    //         //
    //         // check available if
    //         $chkADtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $bookingDate])->where('start_time', '>=', $from_db_time);

    //         $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function ($query) use ($request, $from_db_time, $to_db_time) {
    //             $query->whereBetween('end_time', [$from_db_time, $to_db_time]);
    //         });

    //         $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();




    //         $getTutorShipPlan = TutorshipPlan::where(['teacher_id' => $request->tutor_id, 'grade_id' => @Auth::user()->grade, 'subject_id' => $request->subject_id, 'status' => 'A'])->first();
    //         if (!@$getTutorShipPlan) {
    //             session()->flash("error", "Tutor's tutorship plan based on tutor,grade,subject is not found!");
    //             return redirect()->back();
    //         }
    //         // $getTutorShipPlan->hourly_rate will provide 30 min  changed on 25-10-2021  as per feedback point
    //         // reschedule duration should be same as per booking duration

    //         $currentDiff = (strtotime($to_time) - strtotime($from_time)) / 60;
    //         $com = Commissions::first();
    //         $tutorInfoDetails = User::where(['id' => $request->tutor_id])->first();

    //         $createB['booking_no'] = 'V' . time();
    //         $createB['student_id'] = @Auth::user()->id;
    //         $createB['hourly_rate'] = $getTutorShipPlan->hourly_rate;
    //         $createB['tutor_id'] = $request->tutor_id;
    //         $createB['student_grade_id'] = @Auth::user()->grade;
    //         $createB['subject_id'] = $request->subject_id;
    //         $createB['topic_details_id'] = $request->session_focus;
    //         $createB['subject_area'] = $request->subject_area;
    //         $createB['session_topic'] = $request->session_topic;
    //         $createB['problem_areas'] = $request->problem_areas;
    //         $createB['session_outcome'] = $request->session_outcome;
    //         $createB['from_time'] = $from_db_time;
    //         $createB['to_time'] = $to_db_time;
    //         $createB['booking_date'] = $bookingDate;
    //         $createB['timezone_id'] = @Auth::user()->timezone_id;
    //         $createB['booking_status'] = 'IC';
    //         $createB['payment_method'] = 'O';
    //         $createB['booking_amount'] = ($currentDiff * ($getTutorShipPlan->hourly_rate / 60));
    //         $createB['stripe_charge'] = (config('sessionsettings.GST') * $createB['booking_amount']);
    //         // if(@$com){
    //         //     $createB['tutor_earnings'] = $createB['booking_amount'] - ($createB['booking_amount'] * ($com->commission)/100);
    //         //     $createB['admin_percentage'] = $com->commission;
    //         //     $createB['admin_commission'] = ($createB['booking_amount'] * ($com->commission)/100);
    //         // }
    //         if (@$tutorInfoDetails) {
    //             $createB['tutor_earnings'] = $createB['booking_amount'] - ($createB['booking_amount'] * ($tutorInfoDetails->commission_percentage) / 100);
    //             $createB['admin_percentage'] = $tutorInfoDetails->commission_percentage;
    //             $createB['admin_commission'] = ($createB['booking_amount'] * ($tutorInfoDetails->commission_percentage) / 100);
    //         }
    //         if (@$createB['booking_amount'] <= 0) {
    //             session()->flash("error", "Booking amount cannot be 0!");
    //             return redirect()->back();
    //         }
    //         $bookingInfo = StudentClassBooking::create($createB);
    //      //   Log::info('Booking created with ID: ' . $bookingInfo->id . ' at ' . $bookingInfo->created_at);

    //         $bookingNo = 'VT00000' . $bookingInfo->id;
    //         $t = StudentClassBooking::where(['id' => $bookingInfo->id, 'booking_no' => $bookingNo])->first();
    //         if (@$t) {
    //             $a = StudentClassBooking::where(['id' => $bookingInfo->id])->first();
    //             $bookingNo = 'VT00000' . $a->id;
    //             StudentClassBooking::where(['id' => $bookingInfo->id])->update(['booking_no' => $bookingNo]);
    //         } else {
    //             StudentClassBooking::where(['id' => $bookingInfo->id])->update(['booking_no' => $bookingNo]);
    //         }


    //         $bookingInfo = StudentClassBooking::where(['id' => $bookingInfo->id])->first();
    //         // $updBookinggetMyAvailability = Tutor_calander_availability::where(['tutor_id'=>$request->tutor_id,'day'=>$dValue,'date'=>$bookingDate])->where('start_time','>=',$from_time)->where('end_time','<=',$to_time);
    //         // $updBookinggetMyAvailability = $updBookinggetMyAvailability->update(['booking_status'=>'B']);
    //         // 2021 november
    //         // $updBookinggetMyAvailability = Tutor_calander_availability::where(['tutor_id'=>$tutor_id,'booking_status'=>'NB','date'=>$bookingDate])->where('start_time','>=',$from_time);

    //         // $updBookinggetMyAvailability = $updBookinggetMyAvailability->where(function($query) use($request,$from_time,$to_time) {
    //         //     $query->whereBetween('end_time',[$from_time,$to_time]);
    //         // });
    //         // $updBookinggetMyAvailability = $updBookinggetMyAvailability->update(['booking_status'=>'B']);
    //         // add to favourite
    //         $isInsFav = UserToFavourite::where(['favourite_user_id' => $bookingInfo->tutor_id, 'user_id' => @Auth::user()->id])->first();
    //         if (!@$isInsFav) {
    //             $addUserToFav['favourite_user_id'] = $bookingInfo->tutor_id;
    //             $addUserToFav['user_id'] = @Auth::user()->id;
    //             $fav = UserToFavourite::create($addUserToFav);
    //         }
    //         // $this->sendBookingMail($bookingInfo->booking_no);
    //         session()->flash("success", " Booking order " . $bookingInfo->booking_no . " received. Complete booking within the next 15 minutes to confirm");

    //         // jayatri 10-11-2021 insert into payment table
    //         $this->insertBookingToPaymentTable($bookingInfo->id);
    //         //   $this->createMeeting($bookingInfo->id);

    //         // dd($bookingInfo->id);
    //         return redirect()->route('payment.init', ['track' => encrypt($bookingInfo->id)]);
    //     } catch (\Exception $e) {
    //         \Log::error($e->getMessage());
    //         session()->flash("error", $e->getMessage());
    //         return redirect()->back();
    //     }
    // }
    public function sendBookingMail($bookingNo)
    {
        try {
            // $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade','getPaymentsInfo'])->where(['booking_no'=>$bookingNo])->first();
            // $data['mail_send_to'] = 'S';
            // Mail::send(new StudentClassBookingMail($data));
            // $data['mail_send_to'] = 'T';
            // Mail::send(new StudentClassBookingMail($data));
            // $data['mail_send_to'] = 'O';
            // Mail::send(new StudentClassBookingMail($data));
        } catch (\Exception $e) {

            \Log::error($e->getMessage());
        }
    }
    public function sendCancelBookingMail($bookingNo)
    {
        try {
            $booking  = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->first();
            if ($booking && $booking->getTutor) {
                $tutorTimezone = $booking->getTutor->timezone_id ?? 'UTC';
                $booking->from_time_tutor = Carbon::parse($booking->from_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
                $booking->to_time_tutor = Carbon::parse($booking->to_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
                $booking->created_at_tutor = Carbon::parse($booking->created_at, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
                $booking->cancelled_on_tutor = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone(config('app.timezone'))->format('H:i:s');
                // $booking->cancelled_on_tutor = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
            }
            if ($booking && $booking->getStudent) {
                $Timezone = $booking->getStudent->timezone_id ?? 'UTC';
                $booking->from_time_user = Carbon::parse($booking->from_time, 'UTC')->setTimezone($Timezone)->format('H:i:s');
                $booking->to_time_user = Carbon::parse($booking->to_time, 'UTC')->setTimezone($Timezone)->format('H:i:s');
                $booking->created_at_user = Carbon::parse($booking->created_at, 'UTC')->setTimezone($Timezone)->format('H:i:s');
                $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone(config('app.timezone'))->format('H:i:s');
                // $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($Timezone)->format('H:i:s');
            }
            // Log::info('From Time User: ' . ($booking->from_time_user ?? 'null'));
            // Log::info('From Time Tutor: ' . ($booking->from_time_tutor ?? 'null'));
            // Log::info('Cancelled On User: ' . ($booking->cancelled_on_user ?? 'null'));
            // Log::info('Cancelled On Raw: ' . ($booking->cancelled_on ?? 'null'));
            $data['bookingDataInformation'] = $booking;
            Mail::send(new CancelBookingMail($data));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
    public function ajaxDtTimeCheckingBookingSlot(Request $request)
    {
        try {
            $tutor_id = trim($request->data['tutor_id']);
            $bookingDate = trim($request->data['get_booking_date']);
            $from_time_raw = trim($request->data['from_time']);
            $to_time_raw = trim($request->data['to_time']);

            // Get student and tutor timezones
            $student_timezone = Auth::user()->timezone ?? 'UTC';
            $tutor = User::findOrFail($tutor_id);
            $tutor_timezone = $tutor->timezone ?? 'UTC';

            // Combine date and time in student's timezone
            $fromStudentTZ = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . date("H:i:s", strtotime($from_time_raw)), $student_timezone);
            $toStudentTZ = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . date("H:i:s", strtotime($to_time_raw)), $student_timezone);

            // Convert to tutor's timezone
            $fromTutorTZ = $fromStudentTZ->copy()->setTimezone($tutor_timezone);
            $toTutorTZ = $toStudentTZ->copy()->setTimezone($tutor_timezone);

            $convertedBookingDate = $fromTutorTZ->format('Y-m-d');
            $from_time = $fromTutorTZ->format('H:i:s');
            $to_time = $toTutorTZ->format('H:i:s');
            $day = $fromTutorTZ->format('D'); // Mon, Tue, etc.

            $dValue = [
                "Mon" => 1,
                "Tue" => 2,
                "Wed" => 3,
                "Thu" => 4,
                "Fri" => 5,
                "Sat" => 6,
                "Sun" => 7
            ][$day];

            // Check availability
            $check = MyAvailability::where('day', $dValue)
                ->where('teacher_id', $tutor_id)
                ->where('from_time', '<=', $from_time)
                ->where('to_time', '>=', $from_time)
                ->where('status', 'A')
                ->first();

            $check1 = MyAvailability::where('day', $dValue)
                ->where('teacher_id', $tutor_id)
                ->where('from_time', '<', $to_time)
                ->where('from_time', '>', $from_time)
                ->where('to_time', '<', $to_time)
                ->where('status', 'A')
                ->first();

            $check3 = MyAvailability::where('day', $dValue)
                ->where('teacher_id', $tutor_id)
                ->where('from_time', '<', $to_time)
                ->where('to_time', '>', $to_time)
                ->where('status', 'A')
                ->first();

            $check4 = MyAvailability::where('day', $dValue)
                ->where('teacher_id', $tutor_id)
                ->where('from_time', $from_time)
                ->first();

            if (!($check || $check1 || $check3 || $check4)) {
                return "false";
            }

            // Check tutor calendar availability
            $isChecktoMyAvailability = Tutor_calander_availability::where([
                'tutor_id' => $tutor_id,
                'day' => $dValue,
                'booking_status' => 'NB',
                'date' => $convertedBookingDate
            ])->where('end_time', '=', $to_time)->first();

            $isCheckfromMyAvailability = Tutor_calander_availability::where([
                'tutor_id' => $tutor_id,
                'day' => $dValue,
                'booking_status' => 'NB',
                'date' => $convertedBookingDate
            ])->where('start_time', '=', $from_time)->first();

            if (!($isChecktoMyAvailability && $isCheckfromMyAvailability)) {
                return "false";
            }

            // Check if booking is in the future
            $nowTutorTime = \Carbon\Carbon::now($tutor_timezone);
            if ($convertedBookingDate <= $nowTutorTime->format('Y-m-d')) {
                if ($from_time <= $nowTutorTime->format('H:i:s') || $to_time <= $nowTutorTime->format('H:i:s')) {
                    return "false";
                }
            }

            // Check if already booked
            $isBooked = StudentClassBooking::where([
                'tutor_id' => $tutor_id,
                'booking_date' => $convertedBookingDate,
                'booking_status' => 'B'
            ])->where('from_time', '>=', $from_time)
                ->where('to_time', '<=', $to_time)
                ->count();

            if ($isBooked > 0) {
                return "false";
            }

            return "true";
        } catch (\Exception $e) {
            \Log::error("Booking slot check error: " . $e->getMessage());
            return "false";
        }
    }

    public function studentBookingConfirmation($bookingNo)
    {



        $timezone = Auth::user()->timezone_id ?? 'UTC';
        //Log::info('studentBookingConfirmation called with bookingNo: ' . $bookingNo . ' and timezone: ' . $timezone . ' for user ID: ' . @Auth::user()->id);
        // DB::listen(function ($query) {
        //     Log::info('Full SQL: ' . TimeSlotHelper::getRealSql($query));
        // });
        $bookingDataInformation = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['student_id' => @Auth::user()->id, 'id' => $bookingNo])->first();
        //  Log::info('Booking data retrieved: ' . json_encode($bookingDataInformation));
        if ($bookingDataInformation) {
            $bookingDataInformation->from_time_user = Carbon::parse($bookingDataInformation->from_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
            $bookingDataInformation->to_time_user = Carbon::parse($bookingDataInformation->to_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
        }
        $data['bookingDataInformation'] = $bookingDataInformation;
        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();
        //dd('studentBookingConfirmation called with bookingNo: ' . $data['bookingDataInformation']);
        if (@$data['bookingDataInformation']) {

            if (@Auth::user()->id == $data['bookingDataInformation']->student_id) {
                if (@$data['bookingDataInformation']) {
                    $data['t_my_av_show'] = MyAvailability::where(['teacher_id' => $data['bookingDataInformation']->tutor_id, 'status' => 'A'])->get()->map(function ($slot) use ($timezone) {

                        // You must build full datetime in UTC first
                        $dayIndex = (int) $slot->day; // 1 = Monday
                        $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

                        $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
                        $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

                        // Handle overnight times (e.g., 22:00 to 02:00 next day)
                        if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                            $toUtc->addDay();
                        }

                        // Convert to student's timezone
                        $slot->from_time_student = $fromUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');
                        $slot->to_time_student   = $toUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');

                        return $slot;
                    });
                }

                return view('student.modules.studentbook_class.student_bookingconfirmation')->with($data);
            } else {
                session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
                return redirect()->back();
            }
        } else {
            session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
            return redirect()->back();
        }
    }
    public function cancelBooking($bookingNo) {}
    public function studentCancelBooking($bookingNo)
    {
        // $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade'])->where(['booking_no'=>$bookingNo])->first();
        // if(@Auth::user()->id == $data['bookingDataInformation']->student_id){
        //     if(@$data['bookingDataInformation']){
        //         $data['t_my_av_show'] = MyAvailability::where(['teacher_id'=>$data['bookingDataInformation']->tutor_id,'status'=>'A'])->get();
        //     }
        //     return view('student.modules.studentbook_class.student_booking_cancelled')->with($data);
        // }else{
        //     session()->flash("error","You are trying to see the booking details which is not associated with your account!");
        //     return redirect()->back();
        // }

    }


    // public function createMeeting($id)
    // {
    //     date_default_timezone_set('Australia/Sydney');
    //     $client1 = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
    //     $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
    //     $token = TokenModel::where('id', 1)->first();
    //     $accessToken = json_decode($token->access_token);
    //     // return $accessToken->access_token;

    //     try {
    //         $BookingDetails = StudentClassBooking::where('id', $id)->first();
    //         $user = User::with(['getTimezone'])->where(['id' => @Auth::user()->id])->first();
    //         $startTime = $BookingDetails->booking_date . "T" . $BookingDetails->from_time;
    //         $endTime = $BookingDetails->booking_date . "T" . $BookingDetails->to_time;

    //         $from_time = @$BookingDetails->from_time;
    //         $to_time = @$BookingDetails->to_time;
    //         $currentDiff = (((strtotime($to_time) - strtotime($from_time)) / 60) / 60);

    //         $concurrentMeetings = StudentClassBooking::where(['booking_date' => $BookingDetails->booking_date])->whereIn('booking_status', ['B']);
    //         $concurrentMeetings = $concurrentMeetings->where(function ($query) use ($BookingDetails) {
    //             $query->whereBetween('from_time', [$BookingDetails->from_time, $BookingDetails->to_time]);
    //         });
    //         $concurrentMeetings = $concurrentMeetings->where(function ($query) use ($BookingDetails) {
    //             $query->whereBetween('to_time', [$BookingDetails->from_time, $BookingDetails->to_time]);
    //         });
    //         $concurrentMeetings = $concurrentMeetings->count();

    //         $totLastConcurrentIncomplete = StudentClassBooking::where(['booking_date' => $BookingDetails->booking_date])->whereIn('booking_status', ['IC']);

    //         $totLastConcurrentIncomplete = $totLastConcurrentIncomplete->where(function ($query) use ($BookingDetails) {
    //             $query->whereBetween('from_time', [$BookingDetails->from_time, $BookingDetails->to_time]);
    //         });
    //         $totLastConcurrentIncomplete = $totLastConcurrentIncomplete->where(function ($query) use ($BookingDetails) {
    //             $query->whereBetween('to_time', [$BookingDetails->from_time, $BookingDetails->to_time]);
    //         });
    //         $totLastConcurrentIncomplete = $totLastConcurrentIncomplete->count();
    //         $concurrentMeetings =   $totLastConcurrentIncomplete + $concurrentMeetings;







    //         $zoom_emails_arr = ["me", "zoom@v-tutor.com.au", "zoom@v-tutor.com.au"];
    //         if ($concurrentMeetings == 0) {
    //             $concurrentMeetingA = 'me';
    //         } elseif ($concurrentMeetings == 1) {
    //             $concurrentMeetingA = 'zoom@v-tutor.com.au';
    //         } elseif ($concurrentMeetings == 2) {
    //             $concurrentMeetingA = 'zoom@v-tutor.com.au';
    //         } else {
    //             $concurrentMeetingA = 'me';
    //         }
    //         $response = $client->request('POST', 'v2/users/' . $concurrentMeetingA . '/meetings', [
    //             "headers" => [
    //                 "Authorization" => "Bearer $accessToken->access_token"
    //             ],
    //             'json' => [
    //                 "topic" => "Meeting for " . @$BookingDetails->booking_no,
    //                 "type" => 2,
    //                 "timezone" => "Australia/" . @$user->getTimezone->city,
    //                 "start_time" => $startTime, //"2021-07-09T20:30:00",
    //                 "duration" => 60, // 30 mins
    //                 "end_time" => $endTime,
    //                 "jbh_time" => 5,
    //                 "password" => "123456",
    //                 "settings" => [
    //                     "host_video" => true,
    //                     "participant_video" => true,
    //                     "waiting_room" => true,
    //                     "allow_multiple_devices" => false,
    //                     "calendar_type" => 2,
    //                     "join_before_host" => false,
    //                     "jbh_time" => 5,
    //                     "mute_upon_entry" => false,
    //                     "show_share_button" => false,
    //                     "allow_multiple_devices" => false,
    //                     "watermark" => false,
    //                     "audio" => "voip",
    //                     "auto_recording" => "cloud"
    //                 ]
    //             ],
    //         ]);

    //         $data = json_decode($response->getBody());
    //         $up = array(
    //             'start_url' => $data->start_url,
    //             'join_url' => $data->join_url,
    //             'total_responce' => $response->getBody(),
    //         );
    //         $a = StudentClassBooking::where('id', $id)->update($up);
    //     } catch (\Exception $e) {
    //         if (401 == $e->getCode()) {
    //             $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
    //             $response = $client->request('POST', '/oauth/token', [
    //                 "headers" => [
    //                     "Authorization" => "Basic " . base64_encode(env('CLIENT_ID') . ':' . env('CLIENT_SECRET'))
    //                 ],
    //                 'form_params' => [
    //                     "grant_type" => "refresh_token",
    //                     "refresh_token" => $accessToken->refresh_token
    //                 ],
    //             ]);
    //             // $db->update_access_token($response->getBody());
    //             TokenModel::where('id', 1)->update(['access_token' => $response->getBody()]);

    //             $this->createMeeting($id);
    //         } else {
    //             echo $e->getMessage();
    //         }
    //     }
    // }
    //zoom link create function
    // public function createMeetingOld($id)
    // {

    //     $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
    //     $token = TokenModel::where('id', 1)->first();
    //     $accessToken = json_decode($token->access_token);
    //     // return $accessToken->access_token;

    //     try {
    //         $BookingDetails = StudentClassBooking::where('id', $id)->first();
    //         $user = User::with(['getTimezone'])->where(['id' => @Auth::user()->id])->first();
    //         $startTime = $BookingDetails->booking_date . "T" . $BookingDetails->from_time;
    //         $endTime = $BookingDetails->booking_date . "T" . $BookingDetails->to_time;

    //         $from_time = @$BookingDetails->from_time;
    //         $to_time = @$BookingDetails->to_time;
    //         $currentDiff = (((strtotime($to_time) - strtotime($from_time)) / 60) / 60);
    //         // $startTime=date('Y-m-d')."T"."12:50:00";
    //         // $newtimestamp = date(strtotime('H:i:s  + 15 minute'));
    //         // $newtimestamp = date(strtotime('H:i:s  + 40 minute'));

    //         // $startTime=date('Y-m-d')."T".$newtimestamp;
    //         // $startTime=date('Y-m-d')."T".date("H:i:s");
    //         // $newtimestamp = date(strtotime('H:i:s  + 30 minute'));
    //         //echo date('Y-m-d H:i:s', $newtimestamp);
    //         //$startTime=date('Y-m-d')."T".date('H:i:s', $newtimestamp);

    //         // $startTime=date('Y-m-d')."T".date("H:i:s",strtotime('+5 minutes'));
    //         // $newtimestamp = date(strtotime('H:i:s  + 15 minute'));
    //         // $newtimestamp = date(strtotime('H:i:s  + 40 minute'));

    //         // $startTime=date('Y-m-d')."T".$newtimestamp;
    //         // $startTime=date('Y-m-d')."T".date("H:i:s");
    //         // $newtimestamp = date(strtotime('H:i:s  + 30 minute'));
    //         //echo date('Y-m-d H:i:s', $newtimestamp);
    //         //$startTime=date('Y-m-d')."T".date('H:i:s', $newtimestamp);

    //         $response = $client->request('POST', 'v2/users/me/meetings', [
    //             "headers" => [
    //                 "Authorization" => "Bearer $accessToken->access_token"
    //             ],
    //             'json' => [
    //                 "topic" => "Meeting for " . @$BookingDetails->booking_no,
    //                 "type" => 2,
    //                 "timezone" => "Australia/" . @$user->getTimezone->city,
    //                 "start_time" => $startTime, //"2021-07-09T20:30:00",
    //                 "duration" => 60, // 30 mins
    //                 "end_time" => $endTime,
    //                 "jbh_time" => 5,
    //                 "password" => "123456",
    //                 "settings" => [
    //                     "host_video" => true,
    //                     "participant_video" => true,
    //                     "waiting_room" => true,
    //                     "allow_multiple_devices" => false,
    //                     "calendar_type" => 2,
    //                     "join_before_host" => true,
    //                     "jbh_time" => 5,
    //                     "mute_upon_entry" => false,
    //                     "show_share_button" => false,
    //                     "allow_multiple_devices" => false,
    //                     "watermark" => false,
    //                     "audio" => "voip",
    //                     "auto_recording" => "cloud"
    //                 ]
    //             ],
    //         ]);


    //         $data = json_decode($response->getBody());
    //         //Update 3 columb of zoom related on booking table
    //         $up = array(
    //             'start_url' => $data->start_url,
    //             'join_url' => $data->join_url,
    //             'total_responce' => $response->getBody(),
    //         );
    //         $a = StudentClassBooking::where('id', $id)->update($up);

    //         //return $response->getBody();

    //     } catch (\Exception $e) {
    //         if (401 == $e->getCode()) {
    //             $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
    //             $response = $client->request('POST', '/oauth/token', [
    //                 "headers" => [
    //                     "Authorization" => "Basic " . base64_encode(env('CLIENT_ID') . ':' . env('CLIENT_SECRET'))
    //                 ],
    //                 'form_params' => [
    //                     "grant_type" => "refresh_token",
    //                     "refresh_token" => $accessToken->refresh_token
    //                 ],
    //             ]);
    //             // $db->update_access_token($response->getBody());
    //             TokenModel::where('id', 1)->update(['access_token' => $response->getBody()]);

    //             $this->createMeeting($id);
    //         } else {
    //             echo $e->getMessage();
    //         }
    //     }
    // }

    public function ajaxGetGradeSubjectTimeDateAmount(Request $request)
    {
        try {
            $booking_date = trim($request->data['booking_date']);
            $tutor_id = trim($request->data['tutor_id']);
            $subject_id = trim($request->data['subject']);
            $topic_id = trim($request->data['topic_id']);
            $from_time = date('h:i a', strtotime(trim($request->data['from_time'])));
            $to_time = date('h:i a', strtotime(trim($request->data['to_time'])));

            $getTutorShipPlan = TutorshipPlan::where(['teacher_id' => $tutor_id, 'grade_id' => @Auth::user()->grade, 'subject_id' => $subject_id, 'status' => 'A'])->first();
            $currentDiff = (strtotime($to_time) - strtotime($from_time)) / 60;
            $tutorInfoDetails = User::where(['id' => $tutor_id])->first();
            $data['payable_amount'] = ($currentDiff * ($getTutorShipPlan->hourly_rate / 60));

            $data['topic_details'] = TopicDetail::with(['getSubject', 'getGrade', 'getBranch', 'getTopic'])->where('status', 'A')->where('topic_id', $topic_id)->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }
   public function academicBookingView($purchaseId)
    {
    try {

        $student = Auth::user();
        $studentTz = $student->timezone_id ?? 'UTC';

        // ---------------------------------
        // Get Academic Purchase
        // ---------------------------------
        $purchase = AcademicProgramPurchase::with('academicProgram')
            ->where('id', $purchaseId)
            ->where('user_id', $student->id)
            ->where('payment_status', 'paid')
            ->firstOrFail();

        if (!$purchase->assigned_tutor_id) {
            session()->flash('error', 'Tutor not assigned yet.');
            return redirect()->back();
        }

        $tutorId = $purchase->assigned_tutor_id;

        $tutor = User::where('id', $tutorId)
            ->where('status', 'A')
            ->firstOrFail();

        $tutorTz = $tutor->timezone_id ?? 'UTC';

        // ---------------------------------
        // Admin Booking Check
        // ---------------------------------
        $adminDisable = AdminDisableBookings::first();

        if ($adminDisable?->disable_booking === 'Y') {
            session()->flash("error", "Booking disabled by admin");
            return redirect()->back();
        }

        $disabledDates = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')
            ->toArray();

        // ---------------------------------
        // Get Future NB Slots
        // ---------------------------------
        $utcNow = Carbon::now('UTC');
        //$utcEnd = Carbon::now('UTC')->addDays(200)->endOfDay();
        $expiryUtc = Carbon::parse($purchase->expires_at, 'UTC')->endOfDay();

        // If already expired, block immediately
        if ($expiryUtc->lt($utcNow)) {
            session()->flash("error", "This academic program has expired.");
            return redirect()->back();
        }

        $utcEnd = $expiryUtc;

        $slots = Tutor_calander_availability::where('tutor_id', $tutorId)
            ->where('booking_status', 'NB')
            ->whereBetween('date', [$utcNow->toDateString(), $utcEnd->toDateString()])
            ->whereNotIn('date', $disabledDates)
            ->get(['id', 'date', 'start_time', 'end_time']);

        $availableDates = [];

        $minBookingTime = Carbon::now($studentTz)
            ->addHours(config('sessionsettings.book_before_hours'));

        foreach ($slots as $slot) {

            $startUtc = Carbon::parse("{$slot->date} {$slot->start_time}", 'UTC');
            $startStudent = $startUtc->copy()->setTimezone($studentTz);

            // Respect book_before_hours
            if ($startStudent->gte($minBookingTime)) {
                $availableDates[] = $startStudent->toDateString();
            }
        }

        $availableDates = collect($availableDates)
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // ---------------------------------
        // Tutor Weekly Availability 
        // ---------------------------------
        $t_my_av_show = MyAvailability::where([
                'teacher_id' => $tutorId,
                'status' => 'A'
            ])
            ->get()
            ->map(function ($slot) use ($studentTz, $tutorTz) {

                $dayIndex = (int)$slot->day;

                $baseDate = Carbon::now($tutorTz)
                    ->startOfWeek()
                    ->addDays($dayIndex - 1);

                // Tutor local time
                $fromLocal = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $baseDate->toDateString() . ' ' . $slot->from_time,
                    $tutorTz
                );

                $toLocal = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $baseDate->toDateString() . ' ' . $slot->to_time,
                    $tutorTz
                );

                if ($toLocal->lte($fromLocal)) {
                    $toLocal->addDay();
                }

                // Convert to student timezone
                $fromStudent = $fromLocal->copy()->setTimezone($studentTz);
                $toStudent   = $toLocal->copy()->setTimezone($studentTz);

                $slot->from_time_student = $fromStudent->format('H:i');
                $slot->to_time_student   = $toStudent->format('H:i');

                return $slot;
            })
            ->filter()
            ->sortBy(fn($s) => [$s->day, $s->from_time_student])
            ->groupBy('day');

        $data = [];
        $data['purchase'] = $purchase;
        $data['tutor'] = $tutor;
        $data['available_dates'] = $availableDates;
        $data['studentTz'] = $studentTz;
        $data['t_my_av_show'] = $t_my_av_show;
        $data['todayDayIndex'] = Carbon::now($studentTz)->dayOfWeekIso;
        $data['dayNames'] = config('sessionsettings.dayNames');
        $data['shortDayNames'] = config('sessionsettings.shortDayNames');
        return view('student.modules.studentbook_class.academic_book_session', $data);

    } catch (\Exception $e) {

        Log::error("academicBookingView error: " . $e->getMessage());
        session()->flash("error", "Something went wrong.");
        return redirect()->back();
    }
}
public function bookAcademicSession(Request $request)
{
    try {

        DB::beginTransaction();

        $userTimezone = Auth::user()->timezone_id ?? config('app.timezone');
        $studentId = Auth::id();

        $request->validate([
            'tutor_id' => 'required',
            'purchase_id' => 'required|exists:academic_program_purchases,id',
            'selected_booked_date' => 'required|date|after_or_equal:today',
            'from_time' => 'required',
            'to_time' => 'required|after:from_time',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        /*
        -------------------------------------------------------
         CHECK ADMIN DISABLED BOOKINGS
        -------------------------------------------------------
        */

        $admin_disable_bookings_values = AdminDisableBookings::first();
        $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')
            ->toArray();

        if (@$admin_disable_bookings_values->disable_booking == 'Y') {
            DB::rollBack();
            return redirect()->back()->with('error', 'Bookings are temporarily disabled.');
        }

        /*
        -------------------------------------------------------
        CHECK ACADEMIC PROGRAM PURCHASE
        -------------------------------------------------------
        */

        $purchase = AcademicProgramPurchase::where('id', $request->purchase_id)
            ->where('user_id', $studentId)
            ->where('payment_status', 'paid')
            ->lockForUpdate()
            ->first();

        if (!$purchase) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Invalid academic program.');
        }

        $remainingSessions = $purchase->sessions()
            ->where('status', 'pending')
            ->count();

        if ($remainingSessions <= 0) {
            DB::rollBack();
            return redirect()->back()->with('error', 'No remaining sessions available.');
        }

        /*
        -------------------------------------------------------
        CONVERT TO UTC
        -------------------------------------------------------
        */

        $fromLocal = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $request->selected_booked_date . ' ' . date('H:i:s', strtotime($request->from_time)),
            $userTimezone
        );

        $toLocal = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $request->selected_booked_date . ' ' . date('H:i:s', strtotime($request->to_time)),
            $userTimezone
        );

        $fromUtc = $fromLocal->copy()->setTimezone('UTC');
        $toUtc   = $toLocal->copy()->setTimezone('UTC');

        $bookingDateUtc = $fromUtc->format('Y-m-d');
        $fromTimeUtc    = $fromUtc->format('H:i:s');
        $toTimeUtc      = $toUtc->format('H:i:s');

        if (in_array($bookingDateUtc, $all_disabled_booking_dates)) {
            DB::rollBack();
            return redirect()->back()->with('error', 'This date is blocked.');
        }

        /*
        -------------------------------------------------------
        GENERATE TIME SLOTS ARRAY (1 hour slots)
        -------------------------------------------------------
        */

        $startTime = strtotime($fromTimeUtc);
        $endTime = strtotime($toTimeUtc);
        $duration = 60 * 60;

        $array_of_time = [];
        while ($startTime <= $endTime) {
            $array_of_time[] = date("H:i:s", $startTime);
            $startTime += $duration;
        }

        /*
        -------------------------------------------------------
         CHECK TUTOR ALREADY BOOKED (B)
        -------------------------------------------------------
        */

        $chkBDtFrmTimeToTime = Tutor_calander_availability::where([
            'tutor_id' => $request->tutor_id,
            'booking_status' => 'B',
            'date' => $bookingDateUtc
        ])
        ->where('start_time', '>=', $fromTimeUtc)
        ->whereBetween('end_time', [$fromTimeUtc, $toTimeUtc])
        ->count();

        if ($chkBDtFrmTimeToTime > 0) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Tutor already booked at this time.');
        }

        /*
        -------------------------------------------------------
        CHECK STUDENT DOUBLE BOOKING
        -------------------------------------------------------
        */

        $chkStudentBooking = StudentClassBooking::where([
            'student_id' => $studentId,
            'booking_date' => $bookingDateUtc
        ])
        ->where('booking_status', 'B')
        ->where('from_time', $fromTimeUtc)
        ->where('to_time', $toTimeUtc)
        ->exists();

        if ($chkStudentBooking) {
            DB::rollBack();
            return redirect()->back()->with('error', 'You already booked this time slot.');
        }

        /*
        -------------------------------------------------------
        CHECK TUTOR NB AVAILABILITY
        -------------------------------------------------------
        */

        $chkADtFrmTimeToTime = Tutor_calander_availability::where([
            'tutor_id' => $request->tutor_id,
            'booking_status' => 'NB',
            'date' => $bookingDateUtc
        ])
        ->where('start_time', $fromTimeUtc)
        ->where('end_time', $toTimeUtc)
        ->count();

        if ($chkADtFrmTimeToTime <= 0) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Tutor not available for selected time.');
        }

        /*
        -------------------------------------------------------
        FETCH TUTORSHIP PLAN
        -------------------------------------------------------
        */

        // $getTutorShipPlan = TutorshipPlan::where([
        //     'teacher_id' => $request->tutor_id,
        //     'grade_id' => $request->grade_id,
        //     'subject_id' => $request->subject_id,
        //     'status' => 'A'
        // ])->first();

        // if (!$getTutorShipPlan) {
        //     DB::rollBack();
        //     return redirect()->back()->with('error', 'Tutor plan not found.');
        // }

     

        $program = $purchase->academicProgram;

        if (!$program || $program->number_of_sessions <= 0) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Invalid academic program configuration.');
        }

        $totalPrice     = $program->price;
        $totalSessions  = $program->number_of_sessions;

        $perSessionFullAmount = round($totalPrice / $totalSessions, 2);

        $tutorPercentage = 70;
        $perSessionAmount = round(($perSessionFullAmount * $tutorPercentage) / 100, 2);

        $commissionAmount = round($perSessionFullAmount - $perSessionAmount, 2);
           /*
        -------------------------------------------------------
        CREATE BOOKING (CONFIRMED)
        -------------------------------------------------------
        */

        $booking = StudentClassBooking::create([
            'booking_no' => 'V' . time(),
            'student_id' => Auth::id(),
            'tutor_id' => $request->tutor_id,
            'student_grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
            'topic_details_id' => null,
            'subject_area' => null,
            'session_topic' => null,
            'problem_areas' => null,
            'session_outcome' => null,
            'from_time' => $fromTimeUtc,
            'to_time' => $toTimeUtc,
            'booking_date' => $bookingDateUtc,
            'timezone_id' => $userTimezone,
            'booking_status' => 'B',
            'payment_method' => 'O',
            'is_academic_program' => 1,
            'academic_program_purchase_id' => $purchase->id,
            'hourly_rate'    => 0,
            'booking_amount' => $perSessionAmount,
            'stripe_charge'  => 0,
        ]);    

        /*
        -------------------------------------------------------
          MARK SESSION AS BOOKED
        -------------------------------------------------------
        */

        $session = $purchase->sessions()
            ->where('status', 'pending')
            ->first();

        if ($session) {
            $session->update([
                'status' => 'scheduled',
                'student_class_booking_id' => $booking->id,
                'scheduled_at' => $bookingDateUtc,
                'tutor_id' => $request->tutor_id,
                'start_time'   => $fromTimeUtc,     
                'end_time'     => $toTimeUtc,
            ]);

            AcademicProgramSessionLog::create([
                'session_id'     => $session->id,
                'tutor_id'       => $request->tutor_id,
                'action'         => 'BOOKED',
                'action_by'      => Auth::id(),
                'action_at'      => now()->utc(),
                'scheduled_date' => $bookingDateUtc,
                'start_time'     => $fromTimeUtc,
                'end_time'       => $toTimeUtc,
                'reason'         => 'Session booked by student',
            ]);
        }

        /*
        -------------------------------------------------------
        UPDATE TUTOR AVAILABILITY
        -------------------------------------------------------
        */

        Tutor_calander_availability::where([
            'tutor_id' => $request->tutor_id,
            'booking_status' => 'NB',
            'date' => $bookingDateUtc,
            'start_time' => $fromTimeUtc,
            'end_time' => $toTimeUtc,
        ])->update(['booking_status' => 'B']);

        /*
        -------------------------------------------------------
         CREATE TUTOR PAYMENT
        -------------------------------------------------------
        */

        TutorPayment::create([
            'booking_id' => $booking->id,
            'tutor_id' => $booking->tutor_id,
            'commission_amount' => $commissionAmount,
            'tutor_amount' => $perSessionAmount,
            'booking_status' => 1,
            'payment_status' => 0,
        ]);
     /*
    //  -------------------------------------------------------
    //    Create Zoom Meeting
    //     -------------------------------------------------------
    //     */

    //     $zoomUser = ZoomUser::where('tutor_id', $booking->tutor_id)->first();

    //     if ($zoomUser) {

    //         $payload = [
    //             "topic" => "Academic Program Session " . $booking->booking_no,
    //             "type" => 2,
    //             "timezone" => $userTimezone,
    //             "start_time" => $fromLocal->format('Y-m-d\TH:i:s'),
    //             "duration" => $toLocal->diffInMinutes($fromLocal),
    //             "password" => "123456",
    //             "use_pmi" => true,
    //         ];

    //         $zoomData = app(ZoomService::class)
    //             ->createMeetingForUser($zoomUser->zoom_user_id, $payload);

    //         $booking->update([
    //             'start_url' => $zoomData['start_url'] ?? null,
    //             'join_url'  => $zoomData['join_url'] ?? null,
    //             'total_responce' => json_encode($zoomData)
    //         ]);
    //     }
        /*
        -------------------------------------------------------
         Daily.co Meeting Room
        -------------------------------------------------------
        */
        $dailyService = app(DailyService::class);

        $roomName = "session-" . $booking->booking_no;

        // Create private room
        // $room = $dailyService->createRoom($roomName);
        $room = $dailyService->createRoom($roomName);
            if (!isset($room['url'])) {
                Log::error('Daily room creation failed', [
                'response' => $room
                ]);
                DB::rollBack();
                return redirect()->back()->with(
                    'error',
                    'Unable to create meeting room. Please try again.'
                );
            }

        // Generate tokens
        $tutor = User::find($booking->tutor_id);
        $student = User::find($booking->student_id);

        $tokenExpiry = $toUtc->timestamp + 3600; 

        $tutorToken = $dailyService->generateToken($roomName, $tutor->full_name . " (Tutor)",  true, $tokenExpiry);

        $studentToken = $dailyService->generateToken($roomName,$student->full_name . " (Student)", false, $tokenExpiry);

        // Create secure URLs
        $tutorUrl = $room['url'] . '?t=' . $tutorToken['token'];
        $studentUrl = $room['url'] . '?t=' . $studentToken['token'];

        // Save in DB
        $booking->update([
            'start_url' => $tutorUrl,
            'join_url'  => $studentUrl,
            'total_responce' => json_encode($room)
        ]);
        /*
        -------------------------------------------------------
        SEND MAIL
        -------------------------------------------------------
        */

      //  $this->sendBookingMail($booking->booking_no);

        // Support Notification Email
        try {
            $student = User::find($booking->student_id);
            $tutor = User::find($booking->tutor_id);
            $program = $purchase->academicProgram;
            // Mail::send(new LearningProgramBookingMail(
            //     $booking,
            //     $student,
            //     $tutor,
            //     $program
            // ));
            Mail::send(new LearningProgramSupportBookingMail(
                $booking,
                $student,
                $tutor,
                $program
            ));

            Mail::send(new LearningProgramTutorBookingMail(
                $booking,
                $student,
                $tutor,
                $program
            ));

        } catch (\Exception $e) {

            Log::error("Learning Program Booking Mail Error: " . $e->getMessage());
        }

        DB::commit();

        return redirect()->route('student.academic.booking.confirmation', $booking->id);

    } catch (\Exception $e) {

        DB::rollBack();
        Log::error("Academic Booking Error: " . $e->getMessage());

        return redirect()->back()->with('error', $e->getMessage());
    }
}
public function studentAcademicBookingConfirmation($bookingId)
{
    $booking = \App\Models\StudentClassBooking::with([
        'getStudent',
        'getTutor',
        'academicProgramPurchase.academicProgram.branch',
        'academicProgramPurchase.academicProgram.grade'
    ])
    ->where('id', $bookingId)
    ->where('student_id', auth()->id())
    ->firstOrFail();

    return view(
        'student.modules.studentbook_class.academic_booking_confirmation',
        compact('booking')
    );
}
}
