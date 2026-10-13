<?php

namespace App\Http\Controllers\Teacher\TeacherMyPayments;

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
use App\Models\Tutor_transaction;
use App\Models\User;
use Validator;

class TeacherMyPaymentsController extends Controller
{
    public function teacherMyPayments(Request $request)
    {

        $data['tutor_earnings'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['C', 'CM'])->where(['tutor_id' => @Auth::user()->id])->sum('tutor_earnings');
        $data['admin_commission'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['C', 'CM'])->where(['tutor_id' => @Auth::user()->id])->sum('admin_commission');
        // dd($data);
        // $data['myPayments'] = StudentClassBooking::with(['getPaymentsInfo','getStudent','getTutor','getSubject','getStudentGrade'])->where(['tutor_id'=>@Auth::user()->id]);
        // if(@$request->from_date && @$request->to_date){
        //     $from_date = date('Y-m-d h:i:s',strtotime($request->from_date));
        //     $to_date = date('Y-m-d h:i:s',strtotime($request->to_date));
        //     $data['myPayments'] = $data['myPayments']->where(function($query) use($from_date,$to_date) {
        //         $query->whereBetween('created_at',[$from_date,$to_date]);
        //     });
        // }
        // $data['myPayments'] = $data['myPayments']->orderBy('id','desc')->get();
        $data['tot_payments'] = StudentClassBooking::with(['getPaymentsInfo'])->whereIn('booking_status', ['CM'])->where(['tutor_id' => @Auth::user()->id])->count();
        return view('teacher.modules.teacher_my_payments.teacher_my_payments')->with($data);
    }
    public function teacherGMyPayments(Request $request)
    {
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $bookings = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['CM'])->where(['tutor_id' => @Auth::user()->id]);
        if (@$request->columns['1']['search']['value']) {
            $from_date = date('Y-m-d', strtotime($request->columns['1']['search']['value']));
            $bookings = $bookings->where(function ($query) use ($from_date) {
                $query->where('booking_date', '>=', $from_date);
            });
        }
        if (@$request->columns['2']['search']['value']) {
            $to_date = date('Y-m-d', strtotime($request->columns['2']['search']['value']));
            $bookings = $bookings->where(function ($query) use ($to_date) {
                $query->where('booking_date', '<=', $to_date);
            });
        }
        $ps =  $bookings->count();
        $pp = $bookings;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $bookings = $bookings;
        $p =  $p->count();
        $bookings1 = $bookings->get();
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['booking_no'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['booking_no'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }

        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['getStudent']['f_name'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['getStudent']['f_name'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['booking_date'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['booking_date'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['from_time'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['from_time'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['getStudentGrade']['grade_name'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['getStudentGrade']['grade_name'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['getSubject']['subject'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['getSubject']['subject'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['booking_status'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['booking_status'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['booking_amount'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['booking_amount'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        if ($columnSortOrder == 'asc') {
            $bookings2 = $bookings1->sortBy(function ($bookings, $key) {
                return $bookings['id'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        } else {
            $bookings2 = $bookings1->sortByDesc(function ($bookings, $key) {
                return $bookings['id'];
            });

            $bookings = $bookings2->slice($request->start, $request->length)->values()->all();
        }
        // if($columnIndex == 0) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('booking_no','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('booking_no','desc');
        //     }
        // }
        // if($columnIndex == 1) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('tutor_id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('tutor_id','desc');
        //     }
        // }
        // if($columnIndex == 2) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('student_id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('student_id','desc');
        //     }
        // }
        // if($columnIndex ==3) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('subject_id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('subject_id','desc');
        //     }
        // }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('student_grade_id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('student_grade_id','desc');
        //     }
        // }
        // if($columnIndex == 5) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('booking_amount','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('booking_amount','desc');
        //     }
        // }
        // if($columnIndex == 6) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('booking_date','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('booking_date','desc');
        //     }
        // }
        // if($columnIndex == 7) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('booking_status','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('booking_status','desc');
        //     }
        // }
        // if($columnIndex == 8) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('created_at','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('created_at','desc');
        //     }
        // }
        // if($columnIndex == 9) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('id','desc');
        //     }
        // }
        // $bookings = $bookings->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $bookings;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function teacherAMyPayments() {}
    // public function teacherGAMyPayments(){

    // }
    public function teacherGAMyPayments(Request $request)
    {

        $data['bookings'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['CM'])->where('tutor_id', @Auth::user()->id);
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
      <th style="border:1px solid black;background-color
      :lime">Zoom url</th>
      <th style="border:1px solid black;background-color
      :lime">Transaction Id</th>
      <th style="border:1px solid black;background-color
      :lime">Invoice Id</th>
            </tr>
            ';
        if (@$data['bookings']) {
            foreach (@$data['bookings'] as $value) {
                // booking status 
                /*if ($value->booking_status == "B") {
                    $status = "Booked";
                } elseif ($value->booking_status == "C") {
                    $status = "Cancelled";
                } elseif ($value->booking_status == "I") {
                    $status = "In Progress";
                } else*/if ($value->booking_status == "CM") {
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
        <td style="border:1px solid black;">' . date('h:i a', strtotime(@$value->from_time)) . '</td>
        <td style="border:1px solid black;">' . date('h:i a', strtotime(@$value->to_time)) . '</td>
        <td style="border:1px solid black;">' . @$value->booking_date . '</td>

        <td style="border:1px solid black;">' . @$status . '</td>
        <td style="border:1px solid black;">' . @$payment_method . '</td>
        <td style="border:1px solid black;">' . @$value->join_url . '</td>
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












    public function transaction_his(Request $request)
    {
        //dd("j");
        $data['payment_history'] = Tutor_transaction::orderBy('id')->where('tutor_id', Auth()->user()->id);
        if ($request->from_date || $request->to_date || $request->perpous) {

            @$from_date = date('Y-m-d', strtotime($request->from_date));
            @$to_prev = $request->to_date;
            @$to = date('Y-m-d', strtotime($to_prev . ' + 1 days'));
            // dd($request->all(),$from_date,$to);

            if ($from_date && $to) {
                $data['payment_history'] = $data['payment_history']->whereBetween('created_at', [$from_date, $to]);
            }
            if ($request->perpous) {
                $data['payment_history'] = $data['payment_history']->where('purpose', $request->perpous);
            }


            $data['res'] = $request->all();
        }
        $data['payment_history'] = $data['payment_history']->with('tutor')->get();
        $userDetails = User::where('id', Auth()->user()->id)->first();

        $data['tutor_id'] = Auth()->user()->id;
        $data['tutor_name'] = $userDetails->f_name . " " . $userDetails->l_name;
        // dd( $data['tutor_name'],$data['payment_history']);
        $data['userDetails'] = User::where('id', Auth()->user()->id)->first();
        return view('teacher.modules.teacher_my_payments.transaction_history')->with($data);
    }


    public function downloadTutorPayments(Request $request)
    {
        $data['myPayments'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->whereIn('booking_status', ['B', 'C', 'CM'])->where(['tutor_id' => @Auth::user()->id]);
        if (@$request->from_date) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $data['myPayments'] = $data['myPayments']->where(function ($query) use ($from_date) {
                $query->where('booking_date', '>=', $from_date);
            });
        }
        if (@$request->to_date) {
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $data['myPayments'] = $data['myPayments']->where(function ($query) use ($to_date) {
                $query->where('booking_date', '<=', $to_date);
            });
        }
        $data['myPayments'] = $data['myPayments']->orderBy('id', 'desc')->get();
        $t = '';
        $t .= '<table>
            <tr>
                <th style="border:1px solid black;background-color
                :lime">Booking ID</th>
                <th style="border:1px solid black;background-color
                :lime">Date</th>
                <th style="border:1px solid black;background-color
                :lime">Grade</th>
                <th style="border:1px solid black;background-color
                :lime">Subject</th>
                <th style="border:1px solid black;background-color
                :lime">Student Name</th>
                <th style="border:1px solid black;background-color
                :lime">Session Rate</th>
                <th style="border:1px solid black;background-color
                :lime">Post Commission</th>
            </tr>
            ';
        if (@$data['myPayments']) {
            foreach (@$data['myPayments'] as $value) {
                $rText = "";
                if (@$value->getPaymentsInfo->refund_amount > 0) {
                    $rText = "( $ " . @$value->getPaymentsInfo->refund_amount . " refunded)";
                }
                $t .= '
                <tr>
                    <td style="border:1px solid black;">' . @$value->booking_no . '</td>
                    <td style="border:1px solid black;">' . @$value->booking_date . '</td>
                    <td style="border:1px solid black;">' . @$value->getStudentGrade->grade_name . '</td>
                    <td style="border:1px solid black;">' . @$value->getSubject->subject . '</td>
                    <td style="border:1px solid black;">' . @$value->getStudent->f_name . " " . @$value->getStudent->f_name . '</td>
                    <td style="border:1px solid black;"> $ ' . @$value->booking_amount . $rText . '</td>
                    <td style="border:1px solid black;"> $' . @$value->tutor_earnings . '</td>
                    
                </tr>';
            }
        }
        $t .= '</table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=TutorPayments.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
