<?php

namespace App\Http\Controllers\Teacher\DateExclusionList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyAvailability;
use App\Models\Tutor_calander_availability;
use App\Models\AdminDisableBookings;
use App\Models\AdminDisableBookingDates;
use App\Models\TutorNonAvailabilityDetails;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DateExclusionListController extends Controller
{
    /*
    * Method        : viewDateExclusionList
    * Description   : This method is to show view date exxclusion list
    * Author        : Jayatri
    */
    public function viewMyDateExclusionList(Request $request)
    {
        $teacher = Auth::user();
        $timezone = $teacher->timezone_id ?? 'UTC';
        $todayInTutorTimezone = Carbon::now($timezone)->format('Y-m-d');
        $data['now'] = Carbon::now($timezone)->format('Y-m-d H:i:s');
        $data['all_disabled_booking_dates'] = $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();

        $data['nextMaxDate'] = date('Y-m-d', strtotime("+30 days"));
        $data['get_available_dates'] = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NB'])->where('date', '>=', $todayInTutorTimezone)->where('date', '<=', $data['nextMaxDate'])->whereNotIn('date', $all_disabled_booking_dates)->groupBy('date')->pluck('date')->toArray();
        Log::info("Available dates for tutor ID " . Auth::user()->id . ": " . json_encode($data['get_available_dates']));
        $data['getTutorCalDatesTimes'] = TutorNonAvailabilityDetails::where(['tutor_id' => @Auth::user()->id])->get()->map(function ($nonavailability) use ($timezone) {
            $dayIndex = (int)$nonavailability->day;
            $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

            $startTime = $nonavailability->start_time;
            $endTime = $nonavailability->end_time;

            // Skip if missing start or end
            if (empty($startTime) || empty($endTime)) {
                return $nonavailability;
            }

            // Ensure format is H:i:s (add :00 if missing seconds)
            if (strlen($startTime) === 5) $startTime .= ':00';
            if (strlen($endTime) === 5) $endTime .= ':00';

            try {
                $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $startTime, 'UTC');
                $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $endTime, 'UTC');

                if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                    $toUtc->addDay();
                }

                $nonavailability->start_time_local = $fromUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');
                $nonavailability->end_time_local = $toUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');
            } catch (\Exception $e) {
                // Log the issue if needed
                Log::error("Invalid time format for TutorNonAvailabilityDetails ID {$nonavailability->id}: " . $e->getMessage());
            }

            return $nonavailability;
        });
        // print_r($data['getTutorCalDatesTimes']);
        return view('teacher.modules.manage_date_exclusion_list.manage_date_exclusion_list')->with($data);
    }

    public function updateMyDateExclusionList(Request $request)
    {
        $request->validate([
            'selected_date' => 'required|date',
            'from_time' => 'nullable|date_format:h:i A',
            'to_time' => 'nullable|date_format:h:i A',
        ]);

        $teacher = Auth::user();
        $timezone = $teacher->timezone_id ?? 'UTC';
        $bookingDate = Carbon::parse($request->selected_date)->format('Y-m-d');

        // Validate against disabled dates
        $disabledDates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();
        if (in_array($bookingDate, $disabledDates)) {
            return $this->error("The date is already blocked by admin. Please contact support.");
        }

        // Validate time slots are not in the past
        if (!$this->validateFutureTime($bookingDate, $request->from_time, $request->to_time, $timezone)) {
            return $this->error("Date / Time must be greater than the current time.");
        }

        // Convert times to UTC
        [$fromUtc, $toUtc, $fromTime, $toTime] = $this->convertTimesToUTC($bookingDate, $request->from_time, $request->to_time, $timezone);

        // Validate booked time conflict
        if ($this->hasBookedConflict($teacher->id, $bookingDate, $fromTime, $toTime)) {
            return $this->error("Time range includes booked sessions. Please cancel them first.");
        }

        // Validate available slot match
        if (!$this->validateAvailableSlotMatch($teacher->id, $bookingDate, $fromUtc, $toUtc)) {
            return $this->error("Selected time does not match available slots.");
        }

        // Save exclusion
        TutorNonAvailabilityDetails::create([
            'tutor_id' => $teacher->id,
            'unavialable_date' => $bookingDate,
            'start_time' => $fromUtc,
            'end_time' => $toUtc,
        ]);
     //   Log::info("Date exclusion added for tutor ID {$teacher->id} on {$bookingDate} from {$fromUtc} to {$toUtc}");
        // Update calendar availability
        $this->blockCalendarSlots($teacher->id, $bookingDate, $fromUtc, $toUtc);

        session()->flash("success", "Date added to exclusion list.");
        return redirect()->back();
    }

    private function error($msg)
    {
        session()->flash("error", $msg);
        return redirect()->back();
    }

    private function validateFutureTime($date, $fromTime, $toTime, $timezone)
    {
        if ($date < now()->toDateString()) return false;

        if ($date === now($timezone)->toDateString()) {
            $now = now($timezone)->format('H:i:s');
            return strtotime($fromTime) > strtotime($now) && strtotime($toTime) > strtotime($now);
        }

        return true;
    }

    private function convertTimesToUTC($date, $from, $to, $tz)
    {
        $fromUtc = $toUtc = $fromTime = $toTime = null;

        if ($from) {
            $fromTime = Carbon::parse($from)->format('H:i:s');
            $fromUtc = Carbon::parse("$date $from", $tz)->setTimezone('UTC')->format('H:i:s');
        }

        if ($to) {
            $toTime = Carbon::parse($to)->format('H:i:s');
            $toUtc = Carbon::parse("$date $to", $tz)->setTimezone('UTC')->format('H:i:s');
        }

        return [$fromUtc, $toUtc, $fromTime, $toTime];
    }

    private function hasBookedConflict($tutorId, $date, $from, $to)
    {
        return Tutor_calander_availability::where([
            'tutor_id' => $tutorId,
            'booking_status' => 'B',
            'date' => $date,
        ])
            ->where('start_time', '>=', $from)
            ->whereBetween('end_time', [$from, $to])
            ->exists();
    }

    private function validateAvailableSlotMatch($tutorId, $date, $fromUtc, $toUtc)
    {
        $slots = $this->generateHourlySlots($fromUtc, $toUtc);
      //  Log::info("Generated slots for tutor ID {$tutorId} on {$date}: " . json_encode($slots));

        $available = Tutor_calander_availability::where([
            'tutor_id' => $tutorId,
            'booking_status' => 'NB',
            'date' => $date,
        ])
            ->where(function ($query) use ($slots) {
                foreach ($slots as $slot) {
                    $query->orWhere(function ($q) use ($slot) {
                        $q->where('start_time', $slot['start'])
                            ->where('end_time', $slot['end']);
                    });
                }
            })
            ->count();

      //  Log::info("Available slots count for tutor ID {$tutorId} on {$date}: {$available}");

        return count($slots) === $available;
    }

    private function generateHourlySlots($from, $to)
    {
        $slots = [];
        $start = strtotime($from);
        $end = strtotime($to);

        while ($start + 3600 <= $end) {
            $slotStart = date('H:i:s', $start);
            $slotEnd = date('H:i:s', $start + 3600);
            $slots[] = ['start' => $slotStart, 'end' => $slotEnd];
            $start += 3600;
        }

        return $slots;
    }

    protected function blockCalendarSlots($tutorId, $bookingDate, $fromTime, $toTime)
    {
        $from = Carbon::createFromFormat('H:i:s', $fromTime);
        $to   = Carbon::createFromFormat('H:i:s', $toTime);

        // Log::info("Booking Date: $bookingDate");
        // Log::info("FromTime (UTC): $fromTime");
        // Log::info("ToTime (UTC): $toTime");

        if ($from->gt($to)) {
            // Case: 22:00 → 02:00 (crosses midnight)

            // Part 1: Update slots from fromTime to 23:59 on the same day
            Tutor_calander_availability::where('tutor_id', $tutorId)
                ->where('date', $bookingDate)
                ->where('booking_status', 'NB')
                ->whereTime('start_time', '>=', $from->format('H:i:s'))
                ->update(['booking_status' => 'NA']);

            // Part 2: Also update early morning slots (00:00–toTime) still on same day (like your case)
            Tutor_calander_availability::where('tutor_id', $tutorId)
                ->where('date', $bookingDate)
                ->where('booking_status', 'NB')
                ->whereTime('start_time', '>=', '00:00:00')
                ->whereTime('end_time', '<=', $to->format('H:i:s'))
                ->update(['booking_status' => 'NA']);

            // Optionally handle next day if future data stores like that
            $nextDate = Carbon::parse($bookingDate)->addDay()->format('Y-m-d');
            Tutor_calander_availability::where('tutor_id', $tutorId)
                ->where('date', $nextDate)
                ->where('booking_status', 'NB')
                ->whereTime('start_time', '>=', '00:00:00')
                ->whereTime('end_time', '<=', $to->format('H:i:s'))
                ->update(['booking_status' => 'NA']);

           // Log::info("Handled midnight crossover for: $bookingDate and optionally $nextDate");
        } else {
            // Same day exclusion
            Tutor_calander_availability::where('tutor_id', $tutorId)
                ->where('date', $bookingDate)
                ->where('booking_status', 'NB')
                ->whereTime('start_time', '>=', $from->format('H:i:s'))
                ->whereTime('end_time', '<=', $to->format('H:i:s'))
                ->update(['booking_status' => 'NA']);

           // Log::info("Updated normal range on $bookingDate between $fromTime and $toTime");
        }
    }







    /*
    * Method        : updateMyDateExclusionList
    * Description   : This method is to update date exxclusion list
    * Author        : Jayatri
    */
    // public function updateMyDateExclusionList(Request $request)
    // {

    //     if (@$request->all()) {
    //         $teacher = Auth::user();
    //         $timezone = $teacher->timezone_id ?? 'UTC';
    //         $data['all_disabled_booking_dates'] = $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();

    //         $bookingDate = date('Y-m-d', strtotime($request->selected_date));
    //         // if (@$request->from_time) {
    //         //     $from_time = date('H:i:s', strtotime($request->from_time));
    //         // }
    //         // if (@$request->to_time) {
    //         //     $to_time = date('H:i:s', strtotime($request->to_time));
    //         // }

    //         if (@$request->from_time) {
    //             $from_time = date('H:i:s', strtotime($request->from_time));
    //             $from_db_time = Carbon::parse($request->selected_booked_date . ' ' . $request->from_time, $timezone)
    //                 ->setTimezone('UTC')
    //                 ->format('H:i:s');
    //         }
    //         if (@$request->to_time) {
    //             $to_time = date('H:i:s', strtotime($request->to_time));
    //             $to_db_time = Carbon::parse($request->selected_booked_date . ' ' . $request->to_time, $timezone)
    //                 ->setTimezone('UTC')
    //                 ->format('H:i:s');
    //         }

    //         if (@$request->from_time && @$request->to_time) {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
    //         } else {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'B', 'date' => $bookingDate]);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
    //         }
    //         if ($chkBDtFrmTimeToTime > 0) {
    //             session()->flash("error", "Cannot exclude date / time as class(es) have been booked. You may choose to cancel those sessions from 'My Sessions' T&C's apply");
    //             return redirect()->back();
    //         }
    //         /******new conditions******/
    //         if (@$request->from_time && @$request->to_time) {

    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NA', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
    //             if ($chkBDtFrmTimeToTime > 0) {
    //                 session()->flash("error", "Cannot exclude date / time as class(es) have been booked. You may choose to cancel those sessions from My Sessions T&C's apply");
    //                 return redirect()->back();
    //             }
    //         }
    //         /************ Main Conditions********************************/
    //         if (@$request->from_time && @$request->to_time) {

    //             $day = date("D", strtotime($request->selected_date));
    //             $tutor_id = @Auth::user()->id;
    //             //get day value
    //             if ($day == "Mon") {
    //                 $dValue = 1;
    //             }
    //             if ($day == "Tue") {
    //                 $dValue = 2;
    //             }
    //             if ($day == "Wed") {
    //                 $dValue = 3;
    //             }
    //             if ($day == "Thu") {
    //                 $dValue = 4;
    //             }
    //             if ($day == "Fri") {
    //                 $dValue = 5;
    //             }
    //             if ($day == "Sat") {
    //                 $dValue = 6;
    //             }
    //             if ($day == "Sun") {
    //                 $dValue = 7;
    //             }

    //             if (in_array($bookingDate, $all_disabled_booking_dates)) {
    //                 session()->flash("error", "The date is already blocked by admin. Please contact support");
    //                 return redirect()->back();
    //             }
    //             if ($bookingDate < date('Y-m-d')) {
    //                 session()->flash("error", "1 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!");
    //                 return redirect()->back();
    //             }
    //             if ($bookingDate == date('Y-m-d')) {
    //                 if ($from_time <= date('H:i:s') || $to_time <= date('H:i:s')) {
    //                     session()->flash("error", "2 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!");
    //                     return redirect()->back();
    //                 }
    //             }
    //             // check whether tutor is available or not
    //             $starttime = $from_time;  // your start time
    //             $endtime = $to_time;  // End time
    //             $duration = '60';  // split by 30 mins

    //             $array_of_time = array();
    //             $start_time    = strtotime($starttime); //change to strtotime
    //             $end_time      = strtotime($endtime); //change to strtotime

    //             $add_mins  = $duration * 60;
    //             while ($start_time <= $end_time) // loop between time
    //             {
    //                 $array_of_time[] = date("h:i:s", $start_time);
    //                 $start_time += $add_mins; // to check endtie=me
    //             }
    //             $length = count($array_of_time);
    //             $from_to_times = [];
    //             $get_all_from_times = [];
    //             $get_all_to_times = [];

    //             for ($k = 0; $k < $length; $k++) {
    //                 $data = [];
    //                 if ($k + 1 < $length) {
    //                     $data['from_time'] = $array_of_time[$k];
    //                     $data['to_time'] = $array_of_time[$k + 1];
    //                     $frmT = "'" . $data['from_time'] . "'";
    //                     $toT = "'" . $data['to_time'] . "'";
    //                     array_push($from_to_times, $data);
    //                     array_push($get_all_from_times, $frmT);
    //                     array_push($get_all_to_times, $toT);
    //                 }
    //             }
    //             $timeSlotCount = count($from_to_times);
    //             // check available or not
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

    //             if ($chkBDtFrmTimeToTime > 0) {
    //                 session()->flash("error", "3 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 return redirect()->back();
    //             }
    //             // check available if
    //             $chkADtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $bookingDate])->where('start_time', '>=', $from_db_time);

    //             $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function ($query) use ($request, $from_db_time, $to_db_time) {
    //                 $query->whereBetween('end_time', [$from_db_time, $to_db_time]);
    //             });

    //             $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();

    //             if ($chkADtFrmTimeToTime <= 0) {
    //                 session()->flash("error", "4 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 return redirect()->back();
    //             }
    //             // dd($timeSlotCount . " - " . $chkADtFrmTimeToTime);
    //             if ($timeSlotCount == $chkADtFrmTimeToTime) {
    //             } else {

    //                 session()->flash("error", "5 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 return redirect()->back();
    //             }
    //         }
    //         /***********************Add and Update start********************************/
    //         $crTutorNonAvilability['tutor_id'] = @Auth::user()->id;
    //         $crTutorNonAvilability['unavialable_date'] = $request->selected_date;
    //         if (@$request->from_time) {
    //             $crTutorNonAvilability['start_time'] = $from_db_time;
    //         }
    //         if (@$request->to_time) {
    //             $crTutorNonAvilability['end_time'] = $to_db_time;
    //         }
    //         $tutorNonAvilabilityDetails = TutorNonAvailabilityDetails::create($crTutorNonAvilability);
    //         // else{
    //         if (@$request->from_time && @$request->to_time) {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NB', 'date' => $bookingDate])->where('start_time', '>=', $from_time);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->update(['booking_status' => 'NA']);
    //             session()->flash("success", "Date added to exclusion list");
    //         } else {
    //             Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NB', 'date' => $bookingDate])->update(['booking_status' => 'NA']);
    //             session()->flash("success", "Date added to exclusion list");
    //         }
    //         // }
    //         /****************************Update end****************************/
    //     }
    //     return redirect()->back();
    // }
    /*
    * Method        : viewDateExclusionList
    * Description   : This method is to show view date exxclusion list
    * Author        : Jayatri
    */
    // public function ajaxCheckingDateExclusion(Request $request)
    // {
    //     try {
    //         //  return $request;

    //         $data_get_selected_date = $request->data['selected_date'];


    //         //conditions
    //         $data['all_disabled_booking_dates'] = $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();

    //         $bookingDate = date('Y-m-d', strtotime($request->data['selected_date']));
    //         //dd(Auth::user());
    //         $teacher = Auth::user();
    //         $timezone = $teacher->timezone_id ?? 'UTC';
    //         $minSTimeUtc = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->min('start_time');

    //         $data['minSTime'] = $minSTimeUtc
    //             ? Carbon::createFromFormat('H:i:s', $minSTimeUtc, 'UTC')->setTimezone($timezone)->format('h:i A')
    //             : null;

    //         $maxSTimeUtc = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->max('start_time');

    //         $data['maxSTime'] = $maxSTimeUtc
    //             ? Carbon::createFromFormat('H:i:s', $maxSTimeUtc, 'UTC')->setTimezone($timezone)->format('h:i A')
    //             : null;


    //         $minTTimeUtc = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->min('end_time');

    //         $data['minTTime'] = $minTTimeUtc
    //             ? Carbon::createFromFormat('H:i:s', $minTTimeUtc, 'UTC')->setTimezone($timezone)->format('h:i A')
    //             : null;

    //         $maxTTimeUtc = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->max('end_time');

    //         $data['maxTTime'] = $maxTTimeUtc
    //             ? Carbon::createFromFormat('H:i:s', $maxTTimeUtc, 'UTC')->setTimezone($timezone)->format('h:i A')
    //             : null;

    //         $data['get_available_start_times'] = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->groupBy('start_time')
    //             ->pluck('start_time')
    //             ->map(function ($time) use ($timezone) {
    //                 return Carbon::createFromFormat('H:i:s', $time, 'UTC')->setTimezone($timezone)->format('h:i A');
    //             })->toArray();

    //         $data['get_available_end_times'] = Tutor_calander_availability::where([
    //             'tutor_id' => Auth::user()->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->groupBy('end_time')
    //             ->pluck('end_time')
    //             ->map(function ($time) use ($timezone) {
    //                 return Carbon::createFromFormat('H:i:s', $time, 'UTC')->setTimezone($timezone)->format('h:i A');
    //             })->toArray();


    //         if (@$request->data['from_time']) {
    //             $from_time = date('H:i:s', strtotime($request->data['from_time']));
    //             $from_db_time = Carbon::parse($request->selected_booked_date . ' ' . $request->data['from_time'], $timezone)
    //                 ->setTimezone('UTC')
    //                 ->format('H:i:s');
    //         }
    //         if (@$request->data['to_time']) {
    //             $to_time = date('H:i:s', strtotime($request->data['to_time']));
    //             $to_db_time = Carbon::parse($request->selected_booked_date . ' ' . $request->data['to_time'], $timezone)
    //                 ->setTimezone('UTC')
    //                 ->format('H:i:s');
    //         }
    //         //dd("DB Date: " . $bookingDate . " From Time: " . $from_db_time . " To Time: " . $to_db_time);

    //         if (@$request->data['from_time'] && @$request->data['to_time']) {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
    //         } else {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'B', 'date' => $bookingDate]);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
    //         }
    //         if ($chkBDtFrmTimeToTime > 0) {
    //             // session()->flash("error","Cannot exclude date / time as class(es) have been booked. You may choose to cancel those sessions from My Sessions");
    //             // return redirect()->back();
    //             $data['output'] = 'false';
    //             $data['condition_no'] = '1';
    //             $data['message'] = "Cannot exclude date / time as class(es) have been booked. You may choose to cancel those sessions from 'My Sessions' T&C's apply";
    //             return $data;
    //         }
    //         /******new conditions******/
    //         if (@$request->data['from_time'] && @$request->data['to_time']) {

    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NA', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

    //             if ($chkBDtFrmTimeToTime > 0) {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '2';
    //                 $data['message'] = "Cannot exclude date / time as class(es) have been booked. You may choose to cancel those sessions from My Sessions T&C's apply";
    //                 return $data;
    //                 // session()->flash("error","This date & time is already added previously!");
    //                 // return redirect()->back();
    //             }
    //         }
    //         /************ Main Conditions********************************/
    //         if (@$request->data['from_time'] && @$request->data['to_time']) {

    //             $day = date("D", strtotime($request->selected_date));
    //             $tutor_id = @Auth::user()->id;
    //             //get day value
    //             if ($day == "Mon") {
    //                 $dValue = 1;
    //             }
    //             if ($day == "Tue") {
    //                 $dValue = 2;
    //             }
    //             if ($day == "Wed") {
    //                 $dValue = 3;
    //             }
    //             if ($day == "Thu") {
    //                 $dValue = 4;
    //             }
    //             if ($day == "Fri") {
    //                 $dValue = 5;
    //             }
    //             if ($day == "Sat") {
    //                 $dValue = 6;
    //             }
    //             if ($day == "Sun") {
    //                 $dValue = 7;
    //             }
    //             // if(@$admin_disable_bookings_values->disable_booking == 'Y'){
    //             //     session()->flash("error","The date is already blocked by admin. Please contact support");
    //             //     return redirect()->back();
    //             // }
    //             if (in_array($bookingDate, $all_disabled_booking_dates)) {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '3';
    //                 $data['message'] = 'The date is already blocked by admin. Please contact support!';
    //                 return $data;
    //                 // session()->flash("error","The date is already blocked by admin. Please contact support");
    //                 // return redirect()->back();
    //             }
    //             if ($bookingDate < date('Y-m-d')) {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '5';
    //                 $data['message'] = '11 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!';
    //                 return $data;
    //                 // session()->flash("error","22 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!");
    //                 // return redirect()->back();
    //             }
    //             if ($bookingDate == date('Y-m-d')) {
    //                 if ($from_time <= date('H:i:s') || $to_time <= date('H:i:s')) {

    //                     $data['output'] = 'false';
    //                     $data['condition_no'] = '5';
    //                     $data['message'] = '33 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!';
    //                     return $data;
    //                     // session()->flash("error","44 Date / Time not applicable to availability. Please ensure you choose based on your schedule.Today from time to time should be greater than current time!");
    //                     // return redirect()->back();
    //                 }
    //             }
    //             // check whether tutor is available or not
    //             $starttime = $from_time;  // your start time
    //             $endtime = $to_time;  // End time
    //             $duration = '60';  // split by 30 mins

    //             $array_of_time = array();
    //             $start_time    = strtotime($starttime); //change to strtotime
    //             $end_time      = strtotime($endtime); //change to strtotime

    //             $add_mins  = $duration * 60;
    //             while ($start_time <= $end_time) // loop between time
    //             {
    //                 $array_of_time[] = date("h:i:s", $start_time);
    //                 $start_time += $add_mins; // to check endtie=me
    //             }
    //             $length = count($array_of_time);
    //             $from_to_times = [];
    //             $get_all_from_times = [];
    //             $get_all_to_times = [];

    //             for ($k = 0; $k < $length; $k++) {
    //                 $data = [];
    //                 if ($k + 1 < $length) {
    //                     $data['from_time'] = $array_of_time[$k];
    //                     $data['to_time'] = $array_of_time[$k + 1];
    //                     $frmT = "'" . $data['from_time'] . "'";
    //                     $toT = "'" . $data['to_time'] . "'";
    //                     array_push($from_to_times, $data);
    //                     array_push($get_all_from_times, $frmT);
    //                     array_push($get_all_to_times, $toT);
    //                 }
    //             }
    //             //dd(count($from_to_times));
    //             $timeSlotCount = count($from_to_times);
    //             // check available or not
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'B', 'date' => $bookingDate])->where('start_time', '>=', $from_time);

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($request, $from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });

    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

    //             if ($chkBDtFrmTimeToTime > 0) {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '6';
    //                 $data['message'] = '55 Date / Time not applicable to availability. Please ensure you choose based on your schedule.';
    //                 return $data;
    //                 // session()->flash("error","66 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 // return redirect()->back();
    //             }
    //             // check available if
    //             //$data['log'] = "chkADtFrmTimeToTime" . $from_time . " - ". $to_time;
    //             $chkADtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $bookingDate])->where('start_time', '>=', $from_db_time);

    //             $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function ($query) use ($request, $from_db_time, $to_db_time) {
    //                 $query->whereBetween('end_time', [$from_db_time, $to_db_time]);
    //             });

    //             $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();

    //             if ($chkADtFrmTimeToTime <= 0) {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '7';
    //                 $data['message'] = '77 Date / Time not applicable to availability. Please ensure you choose based on your schedule.';
    //                 return $data;
    //                 // session()->flash("error","77 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 // return redirect()->back();
    //             }
    //             // dd($timeSlotCount . " - " . $chkADtFrmTimeToTime);
    //             if ($timeSlotCount == $chkADtFrmTimeToTime) {
    //                 $data['output'] = 'true';
    //                 $data['condition_no'] = '9';
    //                 $data['message'] = 'Available';
    //                 return $data;
    //             } else {
    //                 $data['output'] = 'false';
    //                 $data['condition_no'] = '11';
    //                 $data['message'] = '88 Date / Time not applicable to availability. Please ensure you choose based on your schedule.';
    //                 return $data;
    //                 // return 'false';
    //                 // session()->flash("error","88 Date / Time not applicable to availability. Please ensure you choose based on your schedule.");
    //                 //     return redirect()->back();
    //             }
    //         } else {
    //             $data['output'] = 'true';
    //             $data['condition_no'] = '12';
    //             $data['message'] = 'Available';
    //             return $data;
    //         }
    //         // end of conditions
    //     } catch (\Exception $e) {
    //         \Log::error($e->getMessage());
    //         $data['output'] = 'false';
    //         $data['condition_no'] = '14';
    //         $data['message'] = $e->getMessage();
    //         return $data;
    //     }
    // }




    //   public function ajaxCheckingDateExclusion(Request $request)
    // {
    //     try {
    //         $bookingDate = date('Y-m-d', strtotime($request->data['selected_date']));
    //         $teacher = Auth::user();
    //         $timezone = $teacher->timezone_id ?? 'UTC';

    //         // Check if admin blocked the date
    //         $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();

    //         if (in_array($bookingDate, $all_disabled_booking_dates)) {
    //             return [
    //                 'output' => 'false',
    //                 'message' => 'The date is already blocked by admin. Please contact support.',
    //             ];
    //         }

    //         // Fetch all NB slots
    //         $availableSlots = Tutor_calander_availability::where([
    //             'tutor_id' => $teacher->id,
    //             'booking_status' => 'NB',
    //             'date' => $bookingDate
    //         ])->get();

    //         // Fetch tutor non-availability
    //         $nonAvailableSlots = TutorNonAvailabilityDetails::where('tutor_id', $teacher->id)
    //             ->whereDate('unavialable_date', $bookingDate)
    //             ->get();

    //         // Filter out slots that overlap with non-availability
    //         $filteredSlots = $availableSlots->filter(function ($slot) use ($nonAvailableSlots, $timezone) {
    //             $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time, 'UTC');
    //             $slotEnd   = Carbon::createFromFormat('H:i:s', $slot->end_time, 'UTC');

    //             foreach ($nonAvailableSlots as $na) {
    //                 $naStart = Carbon::createFromFormat('H:i:s', $na->start_time, $timezone)->setTimezone('UTC');
    //                 $naEnd   = Carbon::createFromFormat('H:i:s', $na->end_time, $timezone)->setTimezone('UTC');

    //                 // Exclude slots that overlap with non-availability
    //                 if (
    //                     ($slotStart >= $naStart && $slotStart < $naEnd) ||     // start inside NA
    //                     ($slotEnd > $naStart && $slotEnd <= $naEnd) ||         // end inside NA
    //                     ($slotStart <= $naStart && $slotEnd >= $naEnd)         // full overlap
    //                 ) {
    //                     return false;
    //                 }
    //             }
    //             return true;
    //         });

    //         // Convert times to tutor's timezone and sort
    //         $fromTimes = $filteredSlots->pluck('start_time')->unique()->map(function ($time) use ($timezone) {
    //             return Carbon::createFromFormat('H:i:s', $time, 'UTC')->setTimezone($timezone)->format('h:i A');
    //         })->sortBy(function ($time) {
    //             return Carbon::createFromFormat('h:i A', $time)->format('H:i');
    //         })->values()->toArray();

    //         $toTimes = $filteredSlots->pluck('end_time')->unique()->map(function ($time) use ($timezone) {
    //             return Carbon::createFromFormat('H:i:s', $time, 'UTC')->setTimezone($timezone)->format('h:i A');
    //         })->sortBy(function ($time) {
    //             return Carbon::createFromFormat('h:i A', $time)->format('H:i');
    //         })->values()->toArray();

    //         return [
    //             'output' => 'true',
    //             'message' => 'Available times fetched.',
    //             'get_available_start_times' => $fromTimes,
    //             'get_available_end_times' => $toTimes,
    //         ];
    //     } catch (\Exception $e) {
    //         \Log::error($e->getMessage());
    //         return [
    //             'output' => 'false',
    //             'message' => 'Error: ' . $e->getMessage(),
    //         ];
    //     }
    // }

    public function ajaxCheckingDateExclusion(Request $request)
    {
        try {
           // Log::info("===== Date Exclusion Check Start =====");

            $bookingDate = date('Y-m-d', strtotime($request->data['selected_date']));
            $teacher = Auth::user();
            $timezone = $teacher->timezone_id ?? 'UTC';

            $isToday = $bookingDate === Carbon::now($timezone)->format('Y-m-d');
            $currentTime = Carbon::now($timezone);

            // Log::info("Tutor ID: {$teacher->id}");
            // Log::info("Tutor Timezone: {$timezone}");
            // Log::info("Selected Date (bookingDate): {$bookingDate}");
            // Log::info("Current Date in Timezone: " . Carbon::now($timezone)->format('Y-m-d'));
            // Log::info("Current Time in Timezone: " . $currentTime->format('H:i:s'));
            // Log::info("Is Today? " . ($isToday ? 'Yes' : 'No'));

            // Check admin disabled booking dates
            $all_disabled_booking_dates = AdminDisableBookingDates::where('status', 'A')
                ->pluck('disable_booking_date')
                ->toArray();

            if (in_array($bookingDate, $all_disabled_booking_dates)) {
             //   Log::info("Date blocked by admin.");
             //   Log::info("===== Date Exclusion Check End =====");
                return [
                    'output' => 'false',
                    'message' => 'The date is already blocked by admin. Please contact support.',
                ];
            }

            // Fetch available booking slots
            $availableSlots = Tutor_calander_availability::where([
                'tutor_id' => $teacher->id,
                'booking_status' => 'NB',
                'date' => $bookingDate
            ])->get();

            // Fetch non-availability slots
            $nonAvailableSlots = TutorNonAvailabilityDetails::where('tutor_id', $teacher->id)
                ->whereDate('unavialable_date', $bookingDate)
                ->get();

            $nonAvailableTimes = [];

            foreach ($nonAvailableSlots as $slot) {
                $start = Carbon::createFromFormat('H:i:s', $slot->start_time, 'UTC')->setTimezone($timezone);
                $end = Carbon::createFromFormat('H:i:s', $slot->end_time, 'UTC')->setTimezone($timezone);

                while ($start < $end) {
                    $nonAvailableTimes[] = $start->format('h:i A');
                    $start->addMinutes(60); // Adjust interval here if needed
                }
            }

            // Remove duplicates & sort
            $nonAvailableTimes = collect($nonAvailableTimes)->unique()->sortBy(function ($time) {
                return Carbon::createFromFormat('h:i A', $time)->format('H:i');
            })->values()->toArray();

            // Filter and format start times
            $fromTimes = $availableSlots->pluck('start_time')->unique()->map(function ($time) use ($timezone, $isToday, $currentTime, $bookingDate) {
                $slotTime = Carbon::createFromFormat('H:i:s', $time, 'UTC')
                    ->setTimezone($timezone)
                    ->setDateFrom(Carbon::parse($bookingDate, $timezone)); // Set correct date

               // Log::info("Slot Time: " . $slotTime->format('Y-m-d H:i:s') . " | Current Time: " . $currentTime->format('Y-m-d H:i:s'));

                // Correct logic: Skip only if it's today AND slot is earlier than now
                if ($isToday && $slotTime->lessThanOrEqualTo($currentTime)) {
                  //  Log::info("Skipping past start time: " . $slotTime->format('H:i:s'));
                    return null;
                }

                return $slotTime->format('h:i A');
            })->filter()->sortBy(function ($time) {
                return Carbon::createFromFormat('h:i A', $time)->format('H:i');
            })->values()->toArray();

            // Format end times
            if (empty($fromTimes)) {
                $toTimes = [];
            } else {
                $toTimes = $availableSlots->pluck('end_time')->unique()->map(function ($time) use ($timezone) {
                    return Carbon::createFromFormat('H:i:s', $time, 'UTC')->setTimezone($timezone)->format('h:i A');
                })->sortBy(function ($time) {
                    return Carbon::createFromFormat('h:i A', $time)->format('H:i');
                })->values()->toArray();
            }

            // Log::info("Filtered Start Times: ", $fromTimes);
            // Log::info("Filtered End Times: ", $toTimes);
            // Log::info("Non-Available Times: ", $nonAvailableTimes);
            // Log::info("===== Date Exclusion Check End =====");

            return [
                'output' => 'true',
                'message' => 'Available times fetched.',
                'get_available_start_times' => $fromTimes,
                'get_available_end_times' => $toTimes,
            ];
        } catch (\Exception $e) {
            Log::error("Error in ajaxCheckingDateExclusion: " . $e->getMessage());
            return [
                'output' => 'false',
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }







    public function getDateFromToTimes(Request $request)
    {
        try {
            $booking_date = trim($request->data['selected_date']);
            $tutor_id = @Auth::user()->id;

            $data['get_available_start_times'] = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->groupBy('start_time')->pluck('start_time')->toArray();

            $minSTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->min('start_time');
            $data['min_available_start_times'] = date('h:i a', strtotime($minSTime));

            $maxSTime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->max('start_time');
            $data['max_available_start_times'] = date('h:i a', strtotime($maxSTime));

            $data['get_available_end_times'] = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->groupBy('end_time')->pluck('end_time')->toArray();

            $min_end_times = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->min('end_time');
            $data['min_available_end_times'] = date('h:i a', strtotime($min_end_times));

            $maxETime = Tutor_calander_availability::where(['tutor_id' => $tutor_id, 'booking_status' => 'NB', 'date' => $booking_date])->max('end_time');
            $data['max_available_end_times'] = date('h:i a', strtotime($maxETime));
            return response()->json($data, 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }
    public function deleteNonAvilability($id)
    {
        $getTutorNonAV = TutorNonAvailabilityDetails::find($id);

        if (!$getTutorNonAV) {
            session()->flash("error", "ID is wrong! Please provide correct ID!");
            return redirect()->back();
        }

        $tutorId = Auth::user()->id;
        $from_time = $getTutorNonAV->start_time;
        $to_time = $getTutorNonAV->end_time;
        $unavialable_date = $getTutorNonAV->unavialable_date;

        if ($from_time && $to_time) {
            $from = Carbon::createFromFormat('H:i:s', $from_time);
            $to = Carbon::createFromFormat('H:i:s', $to_time);

            if ($from->gt($to)) {
                // Handle midnight crossover
                // Part 1: Update current date slots (e.g., 22:00 → 23:59)
                Tutor_calander_availability::where('tutor_id', $tutorId)
                    ->where('date', $unavialable_date)
                    ->where('booking_status', 'NA')
                    ->whereTime('start_time', '>=', $from_time)
                    ->update(['booking_status' => 'NB']);

                // Part 2: Update early morning slots on same day (00:00 → $to_time)
                Tutor_calander_availability::where('tutor_id', $tutorId)
                    ->where('date', $unavialable_date)
                    ->where('booking_status', 'NA')
                    ->whereTime('start_time', '>=', '00:00:00')
                    ->whereTime('end_time', '<=', $to_time)
                    ->update(['booking_status' => 'NB']);

                // Optionally future-proof: Also check the next day
                $nextDate = Carbon::parse($unavialable_date)->addDay()->format('Y-m-d');
                Tutor_calander_availability::where('tutor_id', $tutorId)
                    ->where('date', $nextDate)
                    ->where('booking_status', 'NA')
                    ->whereTime('start_time', '>=', '00:00:00')
                    ->whereTime('end_time', '<=', $to_time)
                    ->update(['booking_status' => 'NB']);
            } else {
                // Normal slot range on same day
                Tutor_calander_availability::where('tutor_id', $tutorId)
                    ->where('date', $unavialable_date)
                    ->where('booking_status', 'NA')
                    ->whereTime('start_time', '>=', $from_time)
                    ->whereTime('end_time', '<=', $to_time)
                    ->update(['booking_status' => 'NB']);
            }

            session()->flash("success", "Exclusion deleted successfully!");
        } else {
            // Full-day exclusion removal
            Tutor_calander_availability::where('tutor_id', $tutorId)
                ->where('date', $unavialable_date)
                ->where('booking_status', 'NA')
                ->update(['booking_status' => 'NB']);

            session()->flash("success", "Exclusion deleted successfully");
        }

        // Delete exclusion record
        $getTutorNonAV->delete();

        return redirect()->back();
    }

    // public function deleteNonAvilability($id)
    // {
    //     $getTutorNonAV = TutorNonAvailabilityDetails::where('id', $id)->first();
    //     if (@$getTutorNonAV) {
    //         $from_time = @$getTutorNonAV->start_time;
    //         $to_time = @$getTutorNonAV->end_time;
    //         $unavialable_date = @$getTutorNonAV->unavialable_date;
    //         if (@$getTutorNonAV->start_time && @$getTutorNonAV->end_time) {
    //             $chkBDtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NA', 'date' => $unavialable_date])->where('start_time', '>=', $from_time);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($from_time, $to_time) {
    //                 $query->whereBetween('end_time', [$from_time, $to_time]);
    //             });
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->update(['booking_status' => 'NB']);
    //             session()->flash("success", "Date & Time deleted successfully!");
    //         } else {
    //             Tutor_calander_availability::where(['tutor_id' => @Auth::user()->id, 'booking_status' => 'NA', 'date' => $unavialable_date])->where('booking_status', ['NA'])->update(['booking_status' => 'NB']);
    //             session()->flash("success", "Date & Time deleted successfully");
    //         }
    //         TutorNonAvailabilityDetails::where('id', $id)->delete();
    //         session()->flash("success", "Date & Time deleted successfully");
    //         return redirect()->back();
    //     } else {
    //         session()->flash("error", "id is wrong!Please provide correct id!");
    //         return redirect()->back();
    //     }
    // }
}
