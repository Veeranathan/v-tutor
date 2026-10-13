<?php

namespace App\Http\Controllers\Student\MyClasses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Subject;
use App\Models\StudentClassBooking;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\Grade;
use App\Models\User;
use carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Log;

class MyClassesController extends Controller
{
    // public function studentMyClasses(Request $request)
    // {
    //     //$data['past_session_student_booked_classes'] = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade'])->get();
    //     $timezone= Auth::user()->timezone_id ? Auth::user()->timezone_id : 'UTC';
    //     $data['classes'] = StudentClassBooking::where('student_id', Auth()->user()->id)->orderBy('from_time', 'ASC')->orderBy('booking_date', 'ASC')->where('booking_date', date('Y-m-d'))->whereIn('booking_status', ['B', 'CM', 'C']);
    //     if (@$request->status) {
    //         if ($request->status) {
    //             $data['classes'] = $data['classes']->where('booking_status', $request->status);
    //         }
    //         $data['res'] = $request->all();
    //     }

    //     $data['classes'] = $data['classes']->get()->map(function ($class) use ($timezone) {
    //         $class->from_time_user = Carbon::parse($class->from_time)->timezone($timezone)->format('Y-m-d H:i:s');
    //         $class->to_time_user = Carbon::parse($class->to_time)->timezone($timezone)->format('Y-m-d H:i:s');
    //         return $class;
    //     });;
    //     $data['count_classes'] = StudentClassBooking::where('student_id', Auth()->user()->id)->orderBy('from_time', 'ASC')->orderBy('booking_date', 'ASC')->where('booking_date', date('Y-m-d'))->whereIn('booking_status', ['B', 'CM', 'C'])->count();
    //     return view('student.modules.my_classes.student_my_classes')->with($data);
    // }







    public function studentMyClassesDatatable(Request $request)
    {
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $bookings = StudentClassBooking::whereIn('status', ['B', 'C', 'CM']);
        if (@$request->columns['1']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
        }
        $ps =  $bookings->count();
        $pp = $bookings;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $bookings = $bookings;
        $p =  $p->count();
        if ($columnIndex == 0) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('id', 'asc');
            } else {
                $bookings = $bookings->orderBy('id', 'desc');
            }
        }
        if ($columnIndex == 1) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('id', 'asc');
            } else {
                $bookings = $bookings->orderBy('id', 'desc');
            }
        }
        if ($columnIndex == 2) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('id', 'asc');
            } else {
                $bookings = $bookings->orderBy('id', 'desc');
            }
        }
        $bookings = $bookings->orderBy('id', 'desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $bookings;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }

    public function studentMyClasses(Request $request)
    {
        $student = Auth::user();
        $timezone = $student->timezone_id ?: 'UTC';

        $nowStudent = Carbon::now($timezone);
        $todayStartStudent = $nowStudent->copy()->startOfDay();
        $todayEndStudent   = $nowStudent->copy()->endOfDay();

        // Convert today's start/end to UTC for DB query
        $todayStartUTC = $todayStartStudent->copy()->setTimezone('UTC');
        $todayEndUTC   = $todayEndStudent->copy()->setTimezone('UTC');

        // $classesQuery = StudentClassBooking::where('student_id', $student->id)
        //     ->whereIn('booking_status', ['B', 'CM', 'C'])
        //     ->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$todayStartUTC])
        //     ->whereRaw("CONCAT(booking_date, ' ', from_time) <= ?", [$todayEndUTC])
        //     ->orderByRaw("CONCAT(booking_date, ' ', from_time) ASC");
        
        $classesQuery = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
            ])
            ->where('student_id', Auth::id())
            ->whereIn('booking_status', ['B', 'CM', 'C'])
            ->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$todayStartUTC])
            ->whereRaw("CONCAT(booking_date, ' ', from_time) <= ?", [$todayEndUTC])
            ->orderByRaw("CONCAT(booking_date, ' ', from_time) ASC"); 

        if ($request->filled('status')) {
            $classesQuery->where('booking_status', $request->status);
        }

        $classes = $classesQuery->get()->map(function ($class) use ($timezone) {
            $fromUTC = Carbon::parse("{$class->booking_date} {$class->from_time}", 'UTC');
            $toUTC   = Carbon::parse("{$class->booking_date} {$class->to_time}", 'UTC');

            $class->from_time_user = $fromUTC->clone()->setTimezone($timezone)->format('h:i A');
            $class->to_time_user   = $toUTC->clone()->setTimezone($timezone)->format('h:i A');
            $class->booking_date_user = $fromUTC->clone()->setTimezone($timezone)->toDateString();

            return $class;
        });

        $data = [
            'classes' => $classes,
            'count_classes' => $classes->count(),
            'res' => $request->all(),
        ];

        return view('student.modules.my_classes.student_my_classes')->with($data);
    }


  public function studentMyClassesUpcoming(Request $request)
{
    $timezone = Auth::user()->timezone_id ?: 'UTC';
    $nowStudent = Carbon::now($timezone);
    $data['currentStudentTime'] = $nowStudent->format('Y-m-d H:i:s');

    // $classesQuery = StudentClassBooking::where('student_id', Auth::id())
    //     ->whereIn('booking_status', ['B', 'CM', 'C'])
    //     ->orderBy('booking_date', 'ASC')
    //     ->orderBy('from_time', 'ASC');

    $classesQuery = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
            ])
            ->where('student_id', Auth::id())
            ->whereIn('booking_status', ['B', 'CM', 'C'])
            ->orderBy('booking_date', 'ASC')
            ->orderBy('from_time', 'ASC'); 

    if ($request->filled('status')) {
        $classesQuery->where('booking_status', $request->status);
    }

    $allClasses = $classesQuery->get();

    // ✅ Only include sessions strictly after the student's *current local date*
    $data['classes'] = $allClasses->filter(function ($class) use ($timezone, $nowStudent) {
        $fromLocal = Carbon::parse("{$class->booking_date} {$class->from_time}", 'UTC')
            ->setTimezone($timezone);

        // show only after today
        return $fromLocal->isAfter($nowStudent->copy()->endOfDay());
    })->map(function ($class) use ($timezone) {
        $from = Carbon::parse("{$class->booking_date} {$class->from_time}", 'UTC')->setTimezone($timezone);
        $to   = Carbon::parse("{$class->booking_date} {$class->to_time}", 'UTC')->setTimezone($timezone);

        $class->from_time_user = $from->format('h:i A');
        $class->to_time_user   = $to->format('h:i A');
        $class->booking_date_user = $from->format('Y-m-d');

        return $class;
    });

    $data['count_classes'] = $data['classes']->count();
    $data['res'] = $request->all();

    return view('student.modules.my_classes.student_upcoming')->with($data);
}



    public function studentMyClassesPast(Request $request)
    {
        $timezone = Auth::user()->timezone_id ?: 'UTC';

        // Student's current time in their timezone
        $nowStudent = Carbon::now($timezone);
        Log::info("Student current time: {$nowStudent->format('Y-m-d H:i:s')} ({$timezone})");

        // Base query: all bookings for the student with valid statuses
        // $classesQuery = StudentClassBooking::where('student_id', Auth::id())
        //     ->whereIn('booking_status', ['B', 'CM', 'C'])
        //     ->orderBy('booking_date', 'DESC')
        //     ->orderBy('from_time', 'DESC');

        $classesQuery = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
            ])
            ->where('student_id', Auth::id())
            ->whereIn('booking_status', ['B', 'CM', 'C'])
            ->orderBy('booking_date', 'DESC')
            ->orderBy('from_time', 'DESC');

        // Optional filters
        if ($request->filled('status')) {
            $classesQuery->where('booking_status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromUTC = Carbon::parse($request->from_date, $timezone)
                ->startOfDay()
                ->setTimezone('UTC');
            $toUTC = Carbon::parse($request->to_date, $timezone)
                ->endOfDay()
                ->setTimezone('UTC');

            $classesQuery->whereBetween('booking_date', [
                $fromUTC->toDateString(),
                $toUTC->toDateString()
            ]);
        }

        // Fetch all candidate classes
        $allClasses = $classesQuery->get();

        // Filter for past sessions based on student's local date
        $data['classes'] = $allClasses->filter(function ($class) use ($nowStudent, $timezone) {
            $fromLocal = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC')
                ->setTimezone($timezone);

            $toLocal = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC')
                ->setTimezone($timezone);

            Log::info("Booking ID: {$class->booking_no}, Local: "
                . $fromLocal->format('Y-m-d H:i:s') . " - "
                . $toLocal->format('Y-m-d H:i:s'));

            // Only consider sessions **before today** in student's timezone
            return $fromLocal->toDateString() < $nowStudent->toDateString();
        })->map(function ($class) use ($timezone) {
            $fromLocal = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC')
                ->setTimezone($timezone);
            $toLocal = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC')
                ->setTimezone($timezone);

            $class->from_time_user = $fromLocal->format('Y-m-d H:i:s');
            $class->to_time_user   = $toLocal->format('Y-m-d H:i:s');

            return $class;
        });

        $data['count_classes'] = $data['classes']->count();
        $data['res'] = $request->all();

        return view('student.modules.my_classes.student_past')->with($data);
    }






    // public function studentMyClasses(Request $request)
    // {
    //     // Student timezone or default to UTC
    //     $timezone = Auth::user()->timezone_id ?: 'UTC';
    //     $data['currentStudentTime'] = Carbon::now($timezone)->format('Y-m-d H:i:s');
    //     // Student's local today start/end
    //     $studentTodayStart = Carbon::now($timezone)->startOfDay();
    //     $studentTodayEnd   = Carbon::now($timezone)->endOfDay();

    //     // Just filter by booking_date in student tz
    //     $todayStudentDate = $studentTodayStart->toDateString();
    //     $todayUTC = Carbon::now(Auth::user()->timezone_id ?: 'UTC')
    //         ->startOfDay()          // today 00:00 in user timezone
    //         ->setTimezone('UTC')    // convert to UTC
    //         ->toDateString();

    //     $classesQuery = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->whereDate('booking_date',  $todayUTC)
    //         ->orderBy('from_time', 'ASC');

    //     if ($request->filled('status')) {
    //         $classesQuery->where('booking_status', $request->status);
    //     }

    //     // Map to add converted times
    //     $data['classes'] = $classesQuery->get()->map(function ($class) use ($timezone) {
    //         // combine booking_date + from_time/to_time into one UTC datetime first
    //         $fromUTC = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC');
    //         $toUTC   = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC');

    //         $class->from_time_user = $fromUTC->clone()->timezone($timezone)->format('Y-m-d H:i:s');
    //         $class->to_time_user   = $toUTC->clone()->timezone($timezone)->format('Y-m-d H:i:s');

    //         return $class;
    //     });

    //     // Count uses the same date filter
    //     $data['count_classes'] = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->whereDate('booking_date', $todayStudentDate)
    //         ->count();

    //     $data['res'] = $request->all();

    //     return view('student.modules.my_classes.student_my_classes')->with($data);
    // }


    // public function studentMyClassesUpcoming(Request $request)
    // {
    //     $timezone = Auth::user()->timezone_id ?: 'UTC';

    //     // student time right now
    //     $nowStudent = Carbon::now($timezone);
    //     $data['currentStudentTime'] = $nowStudent->format('Y-m-d H:i:s');

    //     // start of tomorrow (student tz), then convert to UTC
    //     $tomorrowStartUTC = $nowStudent->copy()
    //         ->addDay()
    //         ->startOfDay()
    //         ->setTimezone('UTC');

    //     // this is the real cutoff for DB comparisons
    //     $cutoffDate = $tomorrowStartUTC->toDateString(); // Y-m-d

    //     $todayUTC = Carbon::now(Auth::user()->timezone_id ?: 'UTC')
    //         ->startOfDay()          // today 00:00 in user timezone
    //         ->setTimezone('UTC')    // convert to UTC
    //         ->toDateString();
    //     $classesQuery = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->where('booking_date', '>', $todayUTC) // only bookings on/after tomorrow UTC
    //         ->orderBy('booking_date', 'ASC')
    //         ->orderBy('from_time', 'ASC');

    //     //  dd($classesQuery);

    //     if ($request->filled('status')) {
    //         $classesQuery->where('booking_status', $request->status);
    //     }

    //     $classes = $classesQuery->get();

    //     // convert back for display
    //     $data['classes'] = $classes->map(function ($class) use ($timezone) {
    //         $fromUTC = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC');
    //         $toUTC   = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC');

    //         $class->from_time_user = $fromUTC->timezone($timezone)->format('Y-m-d H:i:s');
    //         $class->to_time_user   = $toUTC->timezone($timezone)->format('Y-m-d H:i:s');

    //         return $class;
    //     });

    //     $data['count_classes'] = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->where('booking_date', '>', $cutoffDate)
    //         ->count();

    //     $data['res'] = $request->all();

    //     return view('student.modules.my_classes.student_upcoming')->with($data);
    // }


    // public function studentMyClassesPast(Request $request)
    // {
    //     $timezone = Auth::user()->timezone_id ?: 'UTC';



    //     // Student's current local date converted to UTC
    //     $studentTodayStartUTC = Carbon::now($timezone)
    //         ->startOfDay()
    //         ->setTimezone('UTC');

    //     $todayUTC = $studentTodayStartUTC->toDateString(); // Y-m-d in UTC

    //     // Base query: all past classes before today (UTC)
    //     $classesQuery = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->where('booking_date', '<', $todayUTC) // <— only days before today
    //         ->orderBy('booking_date', 'DESC')
    //         ->orderBy('from_time', 'DESC');

    //     // Optional status filter
    //     if ($request->filled('status')) {
    //         $classesQuery->where('booking_status', $request->status);
    //     }

    //     // Optional date range filter (user enters local dates)
    //     if ($request->filled('from_date') && $request->filled('to_date')) {
    //         $fromUTC = Carbon::parse($request->from_date, $timezone)
    //             ->startOfDay()->setTimezone('UTC');
    //         $toUTC = Carbon::parse($request->to_date, $timezone)
    //             ->endOfDay()->setTimezone('UTC');

    //         $classesQuery->whereBetween('booking_date', [
    //             $fromUTC->toDateString(),
    //             $toUTC->toDateString()
    //         ]);
    //     }

    //     $data['classes'] = $classesQuery->get()->map(function ($class) use ($timezone) {
    //         $fromUTC = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC');
    //         $toUTC   = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC');

    //         $class->from_time_user = $fromUTC->timezone($timezone)->format('Y-m-d H:i:s');
    //         $class->to_time_user   = $toUTC->timezone($timezone)->format('Y-m-d H:i:s');

    //         return $class;
    //     });

    //     $data['count_classes'] = StudentClassBooking::where('student_id', Auth::id())
    //         ->whereIn('booking_status', ['B', 'CM', 'C'])
    //         ->where('booking_date', '<', $todayUTC)
    //         ->count();

    //     $data['res'] = $request->all();

    //     return view('student.modules.my_classes.student_past')->with($data);
    // }








    public function studentClassExport(Request $request)
    {
        //dd($request->all());
        //echo url('/');
        $data['data'] = StudentClassBooking::where('student_id', Auth()->user()->id)->whereIn('booking_status', ['B', 'CM', 'C']);

        //dd($data['data'] );

        $mtz = Auth::user()->timezone_id ?: 'UTC';
        $todayUTC = Carbon::now($mtz)
            ->startOfDay()          // today 00:00 in user timezone
            ->setTimezone('UTC')    // convert to UTC
            ->toDateString();       // Y-m-d
        //--------------------------Fetch all past value---------------------------------------
        if ($request->session == "past") {
            $count = StudentClassBooking::where('student_id', Auth()->user()->id)->where('booking_date', '<', $todayUTC)->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', '<', $todayUTC);
            // if(@$request->from_date || @$request->to_date){
            //      // dd($request->all());
            //     @$from_date = date('Y-m-d', strtotime($request->from_date));
            //     @$to_prev= $request->to_date;
            //     @$to=date('Y-m-d', strtotime($to_prev/*. ' + 1 days'*/));
            //    // dd($request->all(),$from_date,$to);
            //      if($from_date && $to){
            //          $data['data']=$data['data']->whereBetween('booking_date',[$from_date, $to]);
            //      }
            //  }

            if ($request->status) {
                $data['data'] = $data['data']->where('booking_status', $request->status);
            }
            $zyz = $data['data']->get();
            if (count($zyz) < 1) {
                return back()->with('error', 'No data.');
            }
        }



        //--------------------------Fetch all future value---------------------------------------
        if ($request->session == "future") {
            $count = StudentClassBooking::where('student_id', Auth()->user()->id)->where('booking_date', '>', $todayUTC)->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', '>', $todayUTC);
            // if(@$request->from_date || @$request->to_date){
            //      // dd($request->all());
            //     @$from_date = date('Y-m-d', strtotime($request->from_date));
            //     @$to_prev= $request->to_date;
            //     @$to=date('Y-m-d', strtotime($to_prev/*. ' + 1 days'*/));
            //    // dd($request->all(),$from_date,$to);
            //      if($from_date && $to){
            //          $data['data']=$data['data']->whereBetween('booking_date',[$from_date, $to]);
            //      }
            //  }

            if ($request->status) {
                $data['data'] = $data['data']->where('booking_status', $request->status);
            }
            $zyz = $data['data']->get();
            if (count($zyz) < 1) {
                return back()->with('error', 'No data.');
            }
        }

        //--------------------------Fetch all present value---------------------------------------
        if ($request->session == "present") {
            $count = StudentClassBooking::where('student_id', Auth()->user()->id)->where('booking_date', $todayUTC)->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            //dd($count);
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', $todayUTC);

            if ($request->status) {
                $data['data'] = $data['data']->where('booking_status', $request->status);
            }
            $zyz = $data['data']->get();
            if (count($zyz) < 1) {
                return back()->with('error', 'No data.');
            }
        }


        $abc =  $data['data']->orderBy('id', 'desc')->with(['getStudent', 'getTutor', 'getSubject', 'getStudentGrade'])->get();
        //dd($abc);
        $data = '';

        $data .= '<table>
      <tr>
      <th style="border:1px solid black;background-color
      :lime">Booking id</th>
      <th style="border:1px solid black;background-color
      :lime">Student name</th>
      <th style="border:1px solid black;background-color
      :lime">Tutor name</th>
      <th style="border:1px solid black;background-color
      :lime">Grade</th>
      <th style="border:1px solid black;background-color
      :lime">Subject</th>
      <th style="border:1px solid black;background-color
      :lime">From time</th>
      <th style="border:1px solid black;background-color
      :lime">To time</th>
      <th style="border:1px solid black;background-color
      :lime">Booking date</th>
      <th style="border:1px solid black;background-color
      :lime">Status</th>

      <th style="border:1px solid black;background-color
      :lime">Payment</th>




      </tr>
      ';
        foreach (@$abc as $value) {
            // booking status
            if ($value->booking_status == "B") {
                $status = "Booked";
            } elseif ($value->booking_status == "C") {
                $status = "Cancelled";
            } elseif ($value->booking_status == "I") {
                $status = "In Progress";
            } else {
                $status = "Completed";
            }

            @$value->payment_method = "Online";


            $data .= '
        <tr>
        <td style="border:1px solid black;">' . @$value->booking_no . '</td>
        <td style="border:1px solid black;">' . @$value->getStudent->f_name . " " . @$value->getStudent->l_name . '</td>
        <td style="border:1px solid black;">' . @$value->getTutor->f_name . " " . @$value->getTutor->l_name . '</td>
        <td style="border:1px solid black;">' . @$value->getStudentGrade->grade_name . '</td>
        <td style="border:1px solid black;">' . @$value->getSubject->subject . '</td>
        <td style="border:1px solid black;">' . @$value->from_time . '</td>
        <td style="border:1px solid black;">' . @$value->to_time . '</td>
        <td style="border:1px solid black;">' . @$value->booking_date . '</td>

        <td style="border:1px solid black;">' . @$status . '</td>
        <td style="border:1px solid black;">' . @$value->payment_method . '</td>



        </tr>';
        }
        $data .= '</table>';

        //dd($data);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=StudentClassRecord.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        // dd($data);
        echo $data;
        // return view('admin.modules.employers.manage_employers',$data);
    }
}
