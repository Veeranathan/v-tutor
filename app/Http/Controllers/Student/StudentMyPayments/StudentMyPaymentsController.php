<?php

namespace App\Http\Controllers\Student\StudentMyPayments;

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
use App\Models\Payments;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StudentMyPaymentsController extends Controller
{
    public function studentMyPayments(Request $request)
    {
        //$timezone = @Auth::user()->timezone_id;

        $data['tot_payments'] = StudentClassBooking::with(['getPaymentsInfo'])->whereIn('booking_status', ['B', 'C', 'CM'])->where(['student_id' => @Auth::user()->id])->count();
        return view('student.modules.student_my_payments.student_my_payments')->with($data);
    }
    // public function studentGMyPayments(Request $request){
    //     $columnIndex = $request->order[0]['column'];
    //     $columnSortOrder = $request->order[0]['dir'];
    //     $bookings = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade','getPaymentsInfo'])->whereIn('booking_status',['B','C','CM'])->where(['student_id'=>@Auth::user()->id]);
    //     if(@$request->columns['1']['search']['value']){
    //         $from_date = date('Y-m-d',strtotime($request->columns['1']['search']['value']));
    //         $bookings = $bookings->where(function($query) use($from_date) {
    //             $query->where('booking_date','>=',$from_date);
    //         });
    //     }
    //     if(@$request->columns['2']['search']['value']){
    //         $to_date = date('Y-m-d',strtotime($request->columns['2']['search']['value']));
    //         $bookings = $bookings->where(function($query) use($to_date) {
    //             $query->where('booking_date','<=',$to_date);
    //         });
    //     }
    //     $ps =  $bookings->count();
    //     $pp = $bookings;
    //     $pp = $pp->count();
    //     $limit = $request->length;
    //     $p = $bookings = $bookings;
    //     $p =  $p->count();
    //     $timezone = @Auth::user()->timezone_id;
    //     $bookings1 = $bookings->get()->map(function ($class) use ($timezone) {

    //         $class->from_time_user = Carbon::parse($class->from_time)->timezone($timezone)->format('Y-m-d H:i:s');
    //         $class->to_time_user = Carbon::parse($class->to_time)->timezone($timezone)->format('Y-m-d H:i:s');
    //         Log::info('Timezone: ' . $class->from_time_user . ' ' . $class->to_time_user. ' for booking No: ' . $class->booking_no);
    //         return $class;
    //     });
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['booking_no'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['booking_no'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }

    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['getTutor']['f_name'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['getTutor']['f_name'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['booking_date'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['booking_date'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['from_time'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['from_time'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['getStudentGrade']['grade_name'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['getStudentGrade']['grade_name'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['getSubject']['subject'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['getSubject']['subject'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['booking_status'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['booking_status'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['booking_amount'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['booking_amount'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     if($columnSortOrder == 'asc') {
    //         $bookings2 = $bookings1->sortBy(function($bookings, $key) {
    //             return $bookings['id'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     else
    //     {
    //         $bookings2 = $bookings1->sortByDesc(function($bookings, $key) {
    //             return $bookings['id'];
    //         });

    //         $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
    //     }
    //     // if($columnIndex == 0) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('booking_no','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('booking_no','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 1) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('tutor_id','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('tutor_id','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 2) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('booking_date','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('booking_date','desc');
    //     //     }
    //     // }
    //     // if($columnIndex ==3) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('from_time','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('from_time','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 4) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('student_grade_id','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('student_grade_id','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 5) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('id','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('id','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 6) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('booking_status','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('booking_status','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 7) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('booking_amount','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('booking_amount','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 8) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('created_at','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('created_at','desc');
    //     //     }
    //     // }
    //     // if($columnIndex == 9) {
    //     //     if($columnSortOrder == 'asc') {
    //     //         $bookings = $bookings->orderBy('id','asc');
    //     //     } else {
    //     //         $bookings = $bookings->orderBy('id','desc');
    //     //     }
    //     // }
    //     // $bookings = $bookings->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
    //     $data['aaData'] = $bookings;
    //     $data["draw"] = intval($request->draw);
    //     $data['iTotalRecords'] = $ps;
    //     $data["iTotalDisplayRecords"] = $pp;
    //     return response()->json($data);
    // }

    public function studentGMyPayments(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->timezone_id;

        $bookings = StudentClassBooking::with([
            'getStudent',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade',
            'getPaymentsInfo'
        ])
            ->whereIn('booking_status', ['B', 'C', 'CM'])
            ->where('student_id', $user->id);

        // Date filtering
        if (!empty($request->columns[1]['search']['value'])) {
            $from_date = date('Y-m-d', strtotime($request->columns[1]['search']['value']));
            $bookings->where('created_at', '>=', $from_date);
        }

        if (!empty($request->columns[2]['search']['value'])) {
            $to_date = date('Y-m-d', strtotime($request->columns[2]['search']['value']));
            $bookings->where('created_at', '<=', $to_date);
        }

        $totalRecords = $bookings->count();

        // Fetch & transform timezone-aware times
        $bookings = $bookings->latest()->get()->map(function ($class) use ($timezone) {
            $class->from_time_user = Carbon::parse($class->from_time)->timezone($timezone)->format('Y-m-d H:i:s');
            $class->to_time_user = Carbon::parse($class->to_time)->timezone($timezone)->format('Y-m-d H:i:s');
            return $class;
        });

        // Sorting
        $columnIndex = $request->order[0]['column'];
        $sortOrder = $request->order[0]['dir'] ?? 'desc';

        $columns = [
            0 => 'booking_no',
            1 => 'getTutor.f_name',
            2 => 'booking_date',
            3 => 'from_time_user',
            4 => 'getStudentGrade.grade_name',
            5 => 'getSubject.subject',
            6 => 'booking_status',
            7 => 'booking_amount',
            8 => 'id'
        ];

        $sortField = $columns[$columnIndex] ?? 'id';

        // Handle nested sorting
        $bookings = $bookings->sortBy(function ($booking) use ($sortField) {
            return data_get($booking, $sortField);
        }, SORT_REGULAR, $sortOrder === 'desc');

        // Paginate
        $pagedBookings = $bookings->slice($request->start, $request->length)->values();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'aaData' => $pagedBookings,
        ]);
    }

    public function studentAMyPayments() {}
    // public function studentGAMyPayments(){

    // }
    public function studentGAMyPayments(Request $request)
    {

        $data['bookings'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['B', 'C', 'CM'])->where('student_id', @Auth::user()->id);

        if (@$request->from_date) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $data['bookings'] = $data['bookings']->where(function ($query) use ($from_date) {
                $query->where('booking_date', '>=', $from_date);
            });
        }
        if (@$request->to_date) {
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $data['bookings'] = $data['bookings']->where(function ($query) use ($to_date) {
                $query->where('booking_date', '<=', $to_date);
            });
        }

        $data['bookings'] = $data['bookings']->orderBy('id', 'desc')->get();
        $t = '';
        $t .= '<table>
            <tr>
                <th style="border:1px solid black;background-color:lime">Booking id</th>
                <th style="border:1px solid black;background-color:lime">Student name</th>
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
                :lime">Session</th>
                <th style="border:1px solid black;background-color
                :lime">Session Amount</th>
                <th style="border:1px solid black;background-color
                :lime">Payment</th>
                <th style="border:1px solid black;background-color
                :lime">Transaction Id</th>

            </tr>
            ';
        if (@$data['bookings']) {
            foreach (@$data['bookings'] as $value) {
                // booking status
                if ($value->booking_status == "B") {
                    $status = "Booked";
                } elseif ($value->booking_status == "C") {
                    $status = "Cancelled";
                } elseif ($value->booking_status == "I") {
                    $status = "In Progress";
                } elseif ($value->booking_status == "CM") {
                    $status = "Completed";
                } else {
                    $status = "";
                }
                $payment_method = "Online";
                $t .= '
        <tr>
        <td style="border:1px solid black;">' . @$value->booking_no . '</td>
        <td style="border:1px solid black;">' . @$value->getStudent->f_name . " " . @$value->getStudent->l_name . '</td>
        <td style="border:1px solid black;">' . @$value->getTutor->f_name . " " . @$value->getTutor->l_name . '</td>
        <td style="border:1px solid black;">' . @$value->getStudentGrade->grade_name . '</td>
        <td style="border:1px solid black;">' . @$value->getSubject->subject . '</td>
        <td style="border:1px solid black;">' . @$value->booking_date . " " . date('h:i a', strtotime(@$value->from_time)) . " - " . date('h:i a', strtotime(@$value->to_time)) . '</td>
        <td style="border:1px solid black;">' . @$status . '</td>
        <td style="border:1px solid black;"> $' . @$value->booking_amount . ' ($ ' . @$value->refund_amount . ' refunded )</td>
        <td style="border:1px solid black;">' . @$value->getPaymentsInfo->txn_id . '</td>

        </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=MyPayments.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
