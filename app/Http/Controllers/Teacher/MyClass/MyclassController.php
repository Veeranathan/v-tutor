<?php

namespace App\Http\Controllers\Teacher\MyClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\TutorAcademic;
use App\Models\StudentClassBooking;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MyclassController extends Controller
{


    public function my_class_list(Request $request)
    {
        $user = Auth()->user();
        $timezone = $user->timezone_id ?: 'UTC';

        // ✅ Tutor’s local "today" start and end converted to UTC
        $startOfDayUTC = Carbon::now($timezone)->startOfDay()->setTimezone('UTC');
        $endOfDayUTC   = Carbon::now($timezone)->endOfDay()->setTimezone('UTC');

        Log::info("Tutor day window in UTC: {$startOfDayUTC} → {$endOfDayUTC}");

        // ✅ Query today's classes (UTC window), order by date + time
        // $query = StudentClassBooking::where('tutor_id', $user->id)
        //     ->whereIn('booking_status', ['B', 'CM', 'C'])
        //     ->where(function ($q) use ($startOfDayUTC, $endOfDayUTC) {
        //         $q->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$startOfDayUTC])
        //             ->whereRaw("CONCAT(booking_date, ' ', from_time) <= ?", [$endOfDayUTC]);
        //     })
        //     ->orderByRaw("CONCAT(booking_date, ' ', from_time) ASC"); // ✅ order by full datetime
        
        $query = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
                ])
                ->where('tutor_id', $user->id)
                ->whereIn('booking_status', ['B', 'CM', 'C'])
                ->where(function ($q) use ($startOfDayUTC, $endOfDayUTC) {
                    $q->whereRaw("CONCAT(booking_date, ' ', from_time) >= ?", [$startOfDayUTC])
                    ->whereRaw("CONCAT(booking_date, ' ', from_time) <= ?", [$endOfDayUTC]);
                })
                ->orderByRaw("CONCAT(booking_date, ' ', from_time) ASC"); // ✅ order by full datetime

        // ✅ Log SQL before executing
        $sql = vsprintf(
            str_replace(['%', '?'], ['%%', "'%s'"], $query->toSql()),
            $query->getBindings()
        );
        Log::info("Today's Classes SQL Query: $sql");

        // ✅ Fetch results
        $classes = $query->get();

        // ✅ Optional filter by status
        if ($request->filled('status')) {
            $classes = $classes->where('booking_status', $request->status);
        }

        // ✅ Convert UTC → tutor timezone
        $classes = $classes->map(function ($class) use ($timezone) {
            $fromUTC = Carbon::createFromFormat('Y-m-d H:i:s', "{$class->booking_date} {$class->from_time}", 'UTC');
            $toUTC   = Carbon::createFromFormat('Y-m-d H:i:s', "{$class->booking_date} {$class->to_time}", 'UTC');

            $class->booking_date_user = $fromUTC->copy()->setTimezone($timezone)->toDateString();
            $class->from_time_user    = $fromUTC->setTimezone($timezone)->format('h:i A');
            $class->to_time_user      = $toUTC->setTimezone($timezone)->format('h:i A');

            return $class;
        });

        $data = [
            'classes' => $classes,
            'count_classes' => $classes->count(),
            'res' => $request->all(),
        ];

        return view('teacher.modules.my_class.myclass_list')->with($data);
    }

    public function my_class_upcoming_list(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->timezone_id ?: 'UTC';

        // Tutor current time in their timezone
        $nowTutor = Carbon::now($timezone);
        Log::info("Tutor current time: {$nowTutor->format('Y-m-d H:i:s')} ({$timezone})");

        // Base query: all bookings for the tutor with valid statuses
        // $classesQuery = StudentClassBooking::where('tutor_id', $user->id)
        //     ->whereIn('booking_status', ['B', 'CM', 'C'])
        //     ->orderBy('booking_date', 'ASC')
        //     ->orderBy('from_time', 'ASC');
        
        $classesQuery = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
            ])
            ->where('tutor_id', $user->id)
            ->whereIn('booking_status', ['B', 'CM', 'C'])
            ->orderBy('booking_date', 'ASC')
            ->orderBy('from_time', 'ASC');

        // Optional status filter
        if ($request->filled('status')) {
            $classesQuery->where('booking_status', $request->status);
        }

        // Fetch all candidate classes
        $allClasses = $classesQuery->get();

        // Filter for upcoming sessions **starting after today ends** in tutor's timezone
        $data['classes'] = $allClasses->filter(function ($class) use ($nowTutor, $timezone) {
            $fromLocal = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC')
                ->setTimezone($timezone);

            $toLocal = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC')
                ->setTimezone($timezone);

            Log::info("Booking ID: {$class->booking_no}, Local: "
                . $fromLocal->format('Y-m-d H:i:s') . " - "
                . $toLocal->format('Y-m-d H:i:s'));

            // Only include sessions starting **after today ends**
            return $fromLocal->greaterThan($nowTutor->copy()->endOfDay());
        })->map(function ($class) use ($timezone) {
            $fromLocal = Carbon::parse($class->booking_date . ' ' . $class->from_time, 'UTC')
                ->setTimezone($timezone);
            $toLocal = Carbon::parse($class->booking_date . ' ' . $class->to_time, 'UTC')
                ->setTimezone($timezone);

            $class->booking_date_user = $fromLocal->toDateString();
            $class->from_time_user = $fromLocal->format('h:i A');
            $class->to_time_user = $toLocal->format('h:i A');

            // Optional: store UTC for reference
            $class->from_time_utc = $class->from_time;
            $class->to_time_utc = $class->to_time;

            return $class;
        });

        $data['count_classes'] = $data['classes']->count();
        $data['res'] = $request->all();

        return view('teacher.modules.my_class.myclass_upcoming_list')->with($data);
    }

    public function my_class_past_list(Request $request)
    {
        $user = Auth()->user();
        $timezone = $user->timezone_id ?: 'UTC';

        // ✅ Current tutor local "today" start, converted to UTC
        $todayStartUTC = Carbon::now($timezone)->startOfDay()->setTimezone('UTC');

        // ✅ Build query for past sessions (before now)
        // $query = StudentClassBooking::where('tutor_id', $user->id)
        //     ->whereIn('booking_status', ['B', 'CM', 'C'])
        //     ->whereRaw("CONCAT(booking_date, ' ', from_time) < ?", [$todayStartUTC]);
        
        $query = StudentClassBooking::with([
                'academicProgramPurchase.academicProgram.grade',
                'academicProgramPurchase.academicProgram.branch'
            ])
            ->where('tutor_id', $user->id)
            ->whereIn('booking_status', ['B', 'CM', 'C'])
            ->whereRaw("CONCAT(booking_date, ' ', from_time) < ?", [$todayStartUTC]);

        // ✅ Optional filters
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from_date = Carbon::parse($request->from_date)->toDateString();
            $to_date = Carbon::parse($request->to_date)->toDateString();
            $query->whereBetween('booking_date', [$from_date, $to_date]);
        }

        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('student_grade_id')) {
            $query->where('student_grade_id', $request->student_grade_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // ✅ Order by full datetime descending (latest first)
        $classes = $query->orderByRaw("CONCAT(booking_date, ' ', from_time) DESC")->get();

        // ✅ Convert UTC → tutor timezone
        $data['classes'] = $classes->map(function ($class) use ($timezone) {
            $fromUTC = Carbon::createFromFormat('Y-m-d H:i:s', "{$class->booking_date} {$class->from_time}", 'UTC');
            $toUTC   = Carbon::createFromFormat('Y-m-d H:i:s', "{$class->booking_date} {$class->to_time}", 'UTC');

            $class->booking_date_user = $fromUTC->copy()->setTimezone($timezone)->toDateString();
            $class->from_time_user    = $fromUTC->setTimezone($timezone)->format('h:i A');
            $class->to_time_user      = $toUTC->setTimezone($timezone)->format('h:i A');

            return $class;
        });

        $data['count_classes'] = $classes->count();
        $data['res'] = $request->all();

        // ✅ Fetch filter dropdowns
        $booked_my_students = StudentClassBooking::where('tutor_id', $user->id)->pluck('student_id');
        $data['booked_students'] = User::whereIn('id', $booked_my_students)->orderBy('f_name', 'asc')->get();

        $booked_my_grade = StudentClassBooking::where('tutor_id', $user->id)->pluck('student_grade_id');
        $data['booked_grade'] = Grade::whereIn('id', $booked_my_grade)->orderBy('grade_name', 'asc')->get();

        $booked_my_subjects = StudentClassBooking::where('tutor_id', $user->id)->pluck('subject_id');
        $data['booked_subjects'] = Subject::whereIn('id', $booked_my_subjects)->orderBy('subject', 'asc')->get();

        return view('teacher.modules.my_class.myclass_past_list')->with($data);
    }




    public function viewFeedbackHistory(Request $request, $booking_no)
    {
        $scb = StudentClassBooking::where(['booking_no' => $booking_no])->first();
        if ($scb) {
            $data['scb'] = $scb;
            $timezone = Auth::user()->timezone_id ? Auth::user()->timezone_id : 'UTC';

            $fb_history = StudentClassBooking::select('*')
                ->selectRaw("CONVERT_TZ(from_time, 'UTC', ?) as from_time_user", [$timezone])
                ->selectRaw("CONVERT_TZ(to_time, 'UTC', ?) as to_time_user", [$timezone])
                ->with([
                    'getStudent.getSchool',
                    'getStudent.getSchool.getState',
                    'getStudent.getSchool.getSuburb',
                    'getTutor.languguageToTuor',
                    'getTutor.getTutorAcademic',
                    'getSubject',
                    'getStudentGrade',
                    'getTutor.getTutorShipPlan',
                    'getSubjectTopics'
                ])
                ->where('student_id', $scb->student_id)
                ->where('student_grade_id', $scb->student_grade_id)
                ->where('subject_id', $scb->subject_id)
                ->orderByDesc('from_time_user')
                ->orderByDesc('booking_date')
                ->paginate(1);
            /* ->map(function ($booking) use ($timezone) {
                $booking->{'from_time_user'} = Carbon::parse($booking->from_time, 'UTC')
                    ->setTimezone($timezone)
                    ->format('H:i:s');

                $booking->{'to_time_user'} = Carbon::parse($booking->to_time, 'UTC')
                    ->setTimezone($timezone)
                    ->format('H:i:s');

                return $booking;
            }); */


            $data['fb_history'] = $fb_history;

            return view('teacher.modules.my_class.tutor_view_feedback_history')->with($data);
        }

        session()->flash("error", "Wrong booking id!");
        return redirect()->back();
    }












    public function tutorClassExport(Request $request)
    {
        //dd($request->all());
        //echo url('/');
        $data['data'] = StudentClassBooking::where('tutor_id', Auth()->user()->id)->whereIn('booking_status', ['B', 'CM', 'C']);

        //dd($data['data'] );



        //--------------------------Fetch all past value---------------------------------------
        if ($request->session == "past") {
            $count = StudentClassBooking::where('tutor_id', Auth()->user()->id)->where('booking_date', '<', date('Y-m-d'))->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', '<', date('Y-m-d'));
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
            $count = StudentClassBooking::where('tutor_id', Auth()->user()->id)->where('booking_date', '>', date('Y-m-d'))->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', '>', date('Y-m-d'));
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
            $count = StudentClassBooking::where('tutor_id', Auth()->user()->id)->whereIn('booking_status', ['B', 'CM', 'C'])->where('booking_date', date('Y-m-d'))->whereIn('booking_status', ['B', 'CM', 'C'])->count();
            //dd($count);
            if ($count < 1) {
                return back()->with('error', 'No data.');
            }
            $data['data'] = $data['data']->where('booking_date', date('Y-m-d'));

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
