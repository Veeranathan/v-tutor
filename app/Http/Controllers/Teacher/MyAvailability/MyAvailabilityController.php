<?php

namespace App\Http\Controllers\Teacher\MyAvailability;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyAvailability;
use App\Models\Tutor_calander_availability;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Log;


class MyAvailabilityController extends Controller
{
    public function available_page(Request $request)
    {
        $teacher = Auth::user();
        $timezone = $teacher->timezone_id ?? 'UTC';



        $data['available'] = MyAvailability::with('teacher_details')
            ->where('teacher_id', $teacher->id)
            ->where('status', 'A')
            ->get()
            ->map(function ($availability) use ($timezone) {
                $dayIndex = (int)$availability->day; // 1 = Monday
                $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex); // upcoming day

                // Combine with from_time & to_time (no UTC conversion needed)
                $availability->from_time_local = $baseDate->toDateString() . ' ' . $availability->from_time;
                $availability->to_time_local   = $baseDate->toDateString() . ' ' . $availability->to_time;

                return $availability;
            });

        $data['available_json'] = $data['available']->map(function ($availability) {
            return [
                'day' => (int) $availability->day,
                'from' => Carbon::parse($availability->from_time_local)->format('H'),
                'to'   => Carbon::parse($availability->to_time_local)->format('H'),
            ];
        });
        // print_r("subha:" . $data['available_json']);
        return view('teacher.modules.available.available_page')->with($data);
    }



public function saveSlots(Request $request)
{
    Log::info("🎯 [saveSlots] Request received", $request->all());

    $user = Auth::user();
    $slotsByDay = $request->input('slots');

    if (empty($slotsByDay)) {
        return response()->json(['message' => 'No slots provided.'], 422);
    }

    $savedSlots = [];

    foreach ($slotsByDay as $dayName => $slots) {
        $dayNumber = date('N', strtotime($dayName)); // 1=Monday ... 7=Sunday
        $slot = $slots[0]; // Assuming single slot per day

        try {
            // Create time slots intervals (default 60 mins)
            $interval = 60;
            $startTime = Carbon::createFromFormat('H:i', $slot['start']);
            $endTime   = Carbon::createFromFormat('H:i', $slot['end']);

            $timeSlots = [];
            while ($startTime->lt($endTime)) {
                $slotEnd = $startTime->copy()->addMinutes($interval);
                if ($slotEnd->gt($endTime)) {
                    $slotEnd = $endTime->copy();
                }
                $timeSlots[] = ['from' => $startTime->format('H:i:s'), 'to' => $slotEnd->format('H:i:s')];
                $startTime = $slotEnd;
            }

            // Save availability definition
            $availability = MyAvailability::firstOrCreate([
                'teacher_id' => $user->id,
                'status'     => 'A',
                'day'        => $dayNumber,
                'from_time'  => $slot['start'],
                'to_time'    => $slot['end'],
            ]);

            $savedSlots[] = $availability;

            // Generate dates for next 90 days
            $period = CarbonPeriod::create(Carbon::today($user->timezone_id), Carbon::today($user->timezone_id)->addDays(200));

            foreach ($period as $date) {
                if ($date->dayOfWeekIso != $dayNumber) continue;

                foreach ($timeSlots as $slot) {
                    // Tutor's local datetime
                    $slotStartLocal = Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $date->format('Y-m-d') . ' ' . $slot['from'],
                        $user->timezone_id
                    );

                    $slotEndLocal = Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $date->format('Y-m-d') . ' ' . $slot['to'],
                        $user->timezone_id
                    );

                    // Convert to UTC (handles daylight saving automatically)
                    $slotStartUtc = $slotStartLocal->copy()->timezone('UTC');
                    $slotEndUtc   = $slotEndLocal->copy()->timezone('UTC');

                    // Skip if already booked
                    $alreadyBooked = Tutor_calander_availability::where([
                        'tutor_id'       => $user->id,
                        'day'            => $dayNumber,
                        'date'           => $slotStartUtc->format('Y-m-d'),
                        'start_time'     => $slotStartUtc->format('H:i:s'),
                        'end_time'       => $slotEndUtc->format('H:i:s'),
                        'booking_status' => 'B',
                    ])->exists();

                    if ($alreadyBooked) continue;

                    Tutor_calander_availability::updateOrCreate(
                        [
                            'tutor_id'   => $user->id,
                            'day'        => $dayNumber,
                            'date'       => $slotStartUtc->format('Y-m-d'),
                            'start_time' => $slotStartUtc->format('H:i:s'),
                            'end_time'   => $slotEndUtc->format('H:i:s'),
                        ],
                        [
                            'available_id'   => $availability->id,
                            'booking_status' => 'NB',
                        ]
                    );
                }
            }

        } catch (\Exception $e) {
            Log::error("❌ [saveSlots] Error processing slot", [
                'slot' => $slot,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
        }
    }

    return response()->json([
        'data' => $savedSlots,
        'message' => 'Availability saved successfully.'
    ]);
}




    // public function saveSlots(Request $request)
    // {
    //     Log::info("🎯 [saveSlots] Request received", $request->all());

    //     $user = Auth::user();
    //     $timezone = $user->timezone_id ?? 'UTC';
    //     $slotsByDay = $request->input('slots');

    //     if (empty($slotsByDay)) {
    //         return response()->json(['message' => 'No slots provided.'], 422);
    //     }

    //     $savedSlots = [];

    //     foreach ($slotsByDay as $dayName => $slots) {
    //         $dayNumber = date('N', strtotime($dayName)); // 1=Monday ... 7=Sunday
    //         Log::info("🗓 [saveSlots] Processing day={$dayName} (dayNumber={$dayNumber}) for user_id={$user->id}");

    //         foreach ($slots as $slot) {
    //             $startTime = strpos($slot['start'], ':') === false ? "{$slot['start']}:00" : $slot['start'];
    //             $endTime   = strpos($slot['end'], ':') === false ? "{$slot['end']}:00" : $slot['end'];

    //             try {
    //                 // 1️⃣ Convert to Carbon in user's timezone
    //                 $fromLocal = Carbon::createFromFormat('H:i', $startTime, $timezone);
    //                 $toLocal   = Carbon::createFromFormat('H:i', $endTime, $timezone);

    //                 if ($toLocal->lessThanOrEqualTo($fromLocal)) {
    //                     $toLocal->addDay(); // overnight slot
    //                 }

    //                 Log::info("⏱ [saveSlots] Local times", [
    //                     'from_local' => $fromLocal->toDateTimeString(),
    //                     'to_local'   => $toLocal->toDateTimeString(),
    //                     'timezone'   => $timezone
    //                 ]);

    //                 // 2️⃣ Convert to UTC (preserve actual UTC date & time)
    //                 $fromUTC = $fromLocal->copy()->setTimezone('UTC');
    //                 $toUTC   = $toLocal->copy()->setTimezone('UTC');

    //                 Log::info("🌐 [saveSlots] Converted UTC times", [
    //                     'from_utc' => $fromUTC->toDateTimeString(),
    //                     'to_utc'   => $toUTC->toDateTimeString(),
    //                 ]);

    //                 // 3️⃣ Split into hourly slots
    //                 $intervalMinutes = 60;
    //                 $slotStart = $fromUTC->copy();
    //                 $timeSlots = [];

    //                 while ($slotStart->lt($toUTC)) {
    //                     $slotEnd = $slotStart->copy()->addMinutes($intervalMinutes);
    //                     if ($slotEnd->gt($toUTC)) $slotEnd = $toUTC->copy();

    //                     $timeSlots[] = [
    //                         'from' => $slotStart->format('H:i:s'),
    //                         'to'   => $slotEnd->format('H:i:s'),
    //                         'date' => $slotStart->format('Y-m-d') // correct UTC date
    //                     ];

    //                     $slotStart = $slotEnd;
    //                 }

    //                 Log::info("🔹 [saveSlots] Generated " . count($timeSlots) . " slot(s) in UTC");

    //                 // 4️⃣ Generate slots for next 90 days
    //                 for ($i = 0; $i < 90; $i++) {
    //                     $targetDate = Carbon::now($timezone)->startOfDay()->addDays($i);
    //                     $targetDay  = $targetDate->dayOfWeek === 0 ? 7 : $targetDate->dayOfWeek;

    //                     if ($targetDay != $dayNumber) continue;

    //                     foreach ($timeSlots as $tSlot) {
    //                         $dateUTC = Carbon::createFromFormat('Y-m-d H:i:s', $tSlot['date'] . ' ' . $tSlot['from'], 'UTC')->format('Y-m-d');

    //                         $alreadyBooked = Tutor_calander_availability::where([
    //                             'tutor_id'      => $user->id,
    //                             'day'           => $dayNumber,
    //                             'date'          => $dateUTC,
    //                             'start_time'    => $tSlot['from'],
    //                             'end_time'      => $tSlot['to'],
    //                             'booking_status'=> 'B',
    //                         ])->exists();

    //                         if ($alreadyBooked) {
    //                             Log::info("⚠️ [saveSlots] Slot already booked, skipping", [
    //                                 'date_utc' => $dateUTC,
    //                                 'from' => $tSlot['from'],
    //                                 'to'   => $tSlot['to']
    //                             ]);
    //                             continue;
    //                         }

    //                         $saved = Tutor_calander_availability::updateOrCreate(
    //                             [
    //                                 'tutor_id'   => $user->id,
    //                                 'day'        => $dayNumber,
    //                                 'date'       => $dateUTC,
    //                                 'start_time' => $tSlot['from'],
    //                                 'end_time'   => $tSlot['to'],
    //                             ],
    //                             [
    //                                 'available_id'   => $availability->id ?? null,
    //                                 'booking_status' => 'NB',
    //                             ]
    //                         );

    //                         Log::info("✅ [saveSlots] Saved slot", [
    //                             'date_utc' => $dateUTC,
    //                             'from' => $tSlot['from'],
    //                             'to'   => $tSlot['to'],
    //                             'record_id' => $saved->id
    //                         ]);

    //                         $savedSlots[] = $saved;
    //                     }
    //                 }

    //             } catch (\Exception $e) {
    //                 Log::error("❌ [saveSlots] Error processing slot: {$startTime}-{$endTime}", [
    //                     'error' => $e->getMessage(),
    //                     'line'  => $e->getLine(),
    //                     'file'  => $e->getFile()
    //                 ]);
    //             }
    //         }
    //     }

    //     if (empty($savedSlots)) {
    //         return response()->json(['message' => 'No slots saved. They may already exist or be booked.'], 409);
    //     }

    //     return response()->json([
    //         'message' => 'Slots saved successfully.',
    //         'count'   => count($savedSlots),
    //         'data'    => $savedSlots
    //     ]);
    // }





    // public function deleteSlot(Request $request)
    // {
    //     //  Log::info('Deleting slot request received: ' . json_encode($request->all()));

    //     $user = Auth::user();
    //     $timezone = $user->timezone_id ?? 'UTC';

    //     $day = $request->input('day');
    //     $from = $request->input('from');
    //     $to = $request->input('to');

    //     // Log::info("Deleting slot for user ID: {$user->id} in timezone: {$timezone}");

    //     // Normalize time format: always use H:i:s
    //     $fromFormatted = strlen($from) === 5 ? $from . ':00' : $from;
    //     $toFormatted = strlen($to) === 5 ? $to . ':00' : $to;

    //     try {
    //         $fromUTC = Carbon::parse($from, $timezone)->setTimezone('UTC')->format('H:i:s');
    //         $toUTC = Carbon::parse($to, $timezone)->setTimezone('UTC')->format('H:i:s');
    //     } catch (\Exception $e) {
    //         Log::error("Time format error", [
    //             'userId' => $user->id,
    //             'exception' => $e,
    //         ]);
    //         return response()->json(['success' => false, 'message' => 'Invalid time format.']);
    //     }

    //     //  Log::info("Deleting slot for user ID: {$user->id} on day: {$day} from: {$fromUTC} to: {$toUTC}");

    //     $availability = MyAvailability::where('teacher_id', $user->id)
    //         ->where('day', $day)
    //         ->where('from_time', $fromUTC)
    //         ->where('to_time', $toUTC)
    //         ->first();

    //     if ($availability) {
    //         Tutor_calander_availability::where('available_id', $availability->id)->delete();
    //         $availability->delete();

    //         return response()->json(['success' => true, 'data' => $availability, 'message' => 'Slot deleted successfully.']);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Slot not found.']);
    // }

 public function deleteSlot(Request $request)
{
    $user = Auth::user();
    $timezone = $user->timezone_id ?? 'UTC';

    $day = $request->input('day'); // 1 = Monday
    $from = $request->input('from');
    $to = $request->input('to');

    Log::info("📝 [deleteSlot] Request received", $request->all());

    // Normalize time format: always H:i:s
    $fromFormatted = strlen($from) === 5 ? $from . ':00' : $from;
    $toFormatted   = strlen($to) === 5 ? $to . ':00' : $to;

    Log::info("🔍 [deleteSlot] Extracted values", [
        'day' => $day,
        'from' => $fromFormatted,
        'to' => $toFormatted,
        'timezone' => $timezone
    ]);

    // Find availability (local times)
    $availability = MyAvailability::where('teacher_id', $user->id)
        ->where('day', $day)
        ->where('from_time', $fromFormatted)
        ->where('to_time', $toFormatted)
        ->where('status', 'A')
        ->first();

    Log::info("📌 [deleteSlot] Availability found?", ['availability' => $availability]);

    if (!$availability) {
        return response()->json(['success' => false, 'message' => 'Slot not found.']);
    }

    // Delete related calendar entries for next 90 days
    $today = Carbon::now()->startOfDay();
    $endDate = $today->copy()->addDays(90);

    // Convert local + date to UTC for calendar table
    $calendarSlots = Tutor_calander_availability::where('available_id', $availability->id)
        ->whereBetween('date', [$today->toDateString(), $endDate->toDateString()])
        ->get();

    Log::info("📅 [deleteSlot] Calendar entries to delete", $calendarSlots->toArray());

    // Delete calendar entries
    Tutor_calander_availability::where('available_id', $availability->id)
        ->whereBetween('date', [$today->toDateString(), $endDate->toDateString()])
        ->delete();

    // Delete availability
    $availability->delete();

    return response()->json([
        'success' => true,
        'message' => 'Slot and associated calendar entries deleted successfully.',
        'deleted_calendar_count' => $calendarSlots->count()
    ]);
}






    public function time_chk(Request $request)
    {
        @$time = $request->time;
        @$format = $request->format;
        if ($format == "AM") {

            $date = strtotime(date('Y-m-d ' . $time . ':00')) + 30 * 60;
        } else {
            $exp = explode(":", $time);

            if ($exp[0] == "12") {
                $new = $time;
                $date = strtotime(date('Y-m-d ' . $new . ':00')) + 1 * 30 * 60;
            } else {
                $new = $time;
                $date = strtotime(date('Y-m-d ' . $new . ':00')) + 12 * 60 * 60 + 30 * 60;
            }

            // $date= date('H:i:s',strtotime('+12hour',strtotime($date2)));
        }
        // $time=explode($request->time, " ");
        return response()->json(['time' => @$date, 'format' => @$time]);
    }








    // public function aval_ins(Request $request)
    // {
    //     $request->validate([
    //         'day' => 'required',
    //         'from_time' => 'required',
    //         'to_time' => 'required',
    //     ]);

    //     $user = Auth::user();

    //     $timezone = $user->timezone_id ?? 'UTC';

    //     // Convert from_time (e.g., "10:30 AM") to UTC
    //     $from = Carbon::createFromFormat('h:i A', $request->from_time, $timezone);
    //     $fromTimeUTC = $from->copy()->setTimezone('UTC')->format('H:i:s');

    //     // Convert to_time (e.g., "12:00 PM") to UTC
    //     $to = Carbon::createFromFormat('h:i A', $request->to_time, $timezone);
    //     $toTimeUTC = $to->copy()->setTimezone('UTC')->format('H:i:s');

    //     $dayOfWeek = (int) $request->day + 1;

    //     // Check for conflicts
    //     $conflict = MyAvailability::where('teacher_id', $user->id)
    //         ->where('day', $dayOfWeek)
    //         ->where('status', 'A')
    //         ->where(function ($query) use ($fromTimeUTC, $toTimeUTC) {
    //             $query->whereBetween('from_time', [$fromTimeUTC, $toTimeUTC])
    //                 ->orWhereBetween('to_time', [$fromTimeUTC, $toTimeUTC])
    //                 ->orWhere(function ($q) use ($fromTimeUTC, $toTimeUTC) {
    //                     $q->where('from_time', '<=', $fromTimeUTC)->where('to_time', '>=', $toTimeUTC);
    //                 });
    //         })->exists();

    //     if ($conflict) {
    //         return back()->with('error', 'Time slot already added. Choose a slot with no conflicts.');
    //     }

    //     // Save availability
    //     $availability = new MyAvailability();
    //     $availability->teacher_id = $user->id;
    //     $availability->status = 'A';
    //     $availability->day = $dayOfWeek;
    //     $availability->from_time = $fromTimeUTC;
    //     $availability->to_time = $toTimeUTC;
    //     $availability->save();
    //     Log::info("Saved availability for user ID: " . $user->id . " on day: " . $dayOfWeek . " from: " . $fromTimeUTC . " to: " . $toTimeUTC);

    //     $interval = 60; // slot size in minutes
    //     $fromTimeUTC = $fromTimeUTC; // input in UTC
    //     $toTimeUTC = $toTimeUTC;
    //     $dayOfWeek = $dayOfWeek; // Example: 2 = Tuesday
    //     $userId = $user->id;

    //     // 1. Delete past calendar entries
    //     Tutor_calander_availability::where('date', '<', now('UTC')->toDateString())
    //         ->where('tutor_id', $userId)
    //         ->delete();

    //     // 2. Generate UTC-based time slots
    //     $timeSlots = [];
    //     $from = Carbon::createFromFormat('H:i:s', $fromTimeUTC, 'UTC');
    //     $to   = Carbon::createFromFormat('H:i:s', $toTimeUTC, 'UTC');

    //     // Fix overnight times
    //     if ($to->lessThanOrEqualTo($from)) {
    //         $to->addDay(); // spans midnight
    //     }

    //     Log::info("Generating time slots from: " . $from->format('H:i:s') . " to: " . $to->format('H:i:s') . " with interval: " . $interval . " minutes");

    //     $current = $from->copy();
    //     while ($current < $to) {
    //         $slotEnd = $current->copy()->addMinutes($interval);
    //         Log::info("Current slot: " . $current->format('H:i:s') . " to " . $slotEnd->format('H:i:s'));

    //         if ($slotEnd <= $to) {
    //             $timeSlots[] = [
    //                 'from' => $current->format('H:i:s'),
    //                 'to'   => $slotEnd->format('H:i:s'),
    //             ];
    //             Log::info("Slot saved: " . $current->format('H:i:s') . " to " . $slotEnd->format('H:i:s'));
    //         }

    //         $current = $slotEnd;
    //     }


    //     // 3. Loop for next 90 days
    //     for ($i = 0; $i < 90; $i++) {
    //         $targetDate = Carbon::now('UTC')->addDays($i);

    //         // Match only selected weekday (0 = Sunday)
    //         //if ($targetDate->dayOfWeek == $dayOfWeek) {
    //         $dateStr = $targetDate->format('Y-m-d');

    //         foreach ($timeSlots as $slot) {
    //             $alreadyBooked = Tutor_calander_availability::where([
    //                 ['tutor_id', $userId],
    //                 ['start_time', $slot['from']],
    //                 ['end_time', $slot['to']],
    //                 ['date', $dateStr],
    //                 ['day', $dayOfWeek],
    //                 ['booking_status', 'B'],
    //             ])->exists();

    //             if (!$alreadyBooked) {
    //                 Tutor_calander_availability::create([
    //                     'tutor_id'       => $userId,
    //                     'available_id'   => $availability->id,
    //                     'start_time'     => $slot['from'],   // saved in UTC
    //                     'end_time'       => $slot['to'],     // saved in UTC
    //                     'date'           => $dateStr,        // saved in UTC
    //                     'day'            => $dayOfWeek,
    //                     'booking_status' => 'NB',
    //                 ]);
    //             }
    //         }
    //         //}
    //     }


    //     //Comment by subha
    //     // // Delete old calendar entries
    //     // Tutor_calander_availability::where('date', '<', date('Y-m-d'))
    //     //     ->where('tutor_id', $user->id)->delete();

    //     // // Create slots for next 90 days
    //     // $interval = 60; // Minutes
    //     // $fromTimestamp = strtotime($fromTimeUTC);
    //     // $toTimestamp = strtotime($toTimeUTC);

    //     // $timeSlots = [];
    //     // while ($fromTimestamp < $toTimestamp) {
    //     //     $start = date("H:i", $fromTimestamp);
    //     //     $fromTimestamp += $interval * 60;
    //     //     $end = date("H:i", $fromTimestamp);
    //     //     if ($fromTimestamp <= $toTimestamp) {
    //     //         $timeSlots[] = [
    //     //             'from' => $start,
    //     //             'to' => $end
    //     //         ];
    //     //     }
    //     // }

    //     // for ($i = 0; $i < 90; $i++) {
    //     //     $checkDay = ($dayOfWeek == 7) ? 0 : $dayOfWeek;
    //     //     if (date('w', strtotime("+$i days")) == $checkDay) {
    //     //         $date = date('Y-m-d', strtotime("+$i days"));
    //     //         foreach ($timeSlots as $slot) {
    //     //             $exists = Tutor_calander_availability::where([
    //     //                 ['tutor_id', $user->id],
    //     //                 ['start_time', $slot['from']],
    //     //                 ['end_time', $slot['to']],
    //     //                 ['date', $date],
    //     //                 ['day', $dayOfWeek],
    //     //                 ['booking_status', 'B'],
    //     //             ])->first();

    //     //             if (!$exists) {
    //     //                 Tutor_calander_availability::create([
    //     //                     'tutor_id' => $user->id,
    //     //                     'available_id' => $availability->id,
    //     //                     'start_time' => $slot['from'],
    //     //                     'end_time' => $slot['to'],
    //     //                     'date' => $date,
    //     //                     'day' => $dayOfWeek,
    //     //                     'booking_status' => 'NB',
    //     //                 ]);
    //     //             }
    //     //         }
    //     //     }
    //     // }

    //     return back()->with('success', 'Tutor slot added.');
    // }











    // public function aval_dlt(Request $request)
    // {

    //     $srch_booking = Tutor_calander_availability::where('available_id', $request->id)->where('booking_status', 'B')->where('date', '>=', date('Y-m-d'))->first();
    //     if ($srch_booking) {
    //         $allBooked = Tutor_calander_availability::where('available_id', $request->id)->where('booking_status', 'B')->where('date', '>=', date('Y-m-d'))->get();
    //         $blank = [];
    //         foreach ($allBooked as $val) {

    //             array_push($blank, date(' Y/m/d ', strtotime(@$val->date)) . "(" . date('h:i A', strtotime(@$val->start_time)) . "-" . date('h:i A', strtotime(@$val->end_time)) . ")");
    //         }
    //         $dates = implode(" , ", $blank);

    //         return response()->json(['dates' => @$dates, 'msg' => 'data']);
    //     } else {

    //         $allData = Tutor_calander_availability::where('available_id', $request->id)->get();

    //         foreach ($allData as $dl) {
    //             Tutor_calander_availability::where('id', $dl->id)->where('booking_status', 'NB')->delete();
    //         }
    //         $dlt = MyAvailability::where('teacher_id', Auth()->user()->id)->where('id', $request->id)->delete();

    //         return response()->json(['msg' => 'nodata']);
    //     }
    // }













    public function fetch_from_time(Request $request)
    {
        $fetch_from_timeDetails = MyAvailability::where('teacher_id', Auth()->user()->id)->where('day', (int)($request->id) + 1)->orderBy('to_time', 'desc')->first();
        $lastTime = $fetch_from_timeDetails->to_time;
        $lastTimeMiliSecond = strtotime(date('Y-m-d ' . $lastTime)) + 1 * 30 * 60;
        return response()->json(['ids' => @$lastTimeMiliSecond]);
        //database from time theke
        //totime +30....
        //fromtime-30
        /*
         4-4:30

         3-3:45 korle hbe na so : to_time=3:45, to_time_plus=to_time+30min
                             so :whereBetween('from_time',[to_time,to_time_plus])


         */
    }
}
