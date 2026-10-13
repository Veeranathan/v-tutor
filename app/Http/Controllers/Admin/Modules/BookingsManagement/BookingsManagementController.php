<?php

namespace App\Http\Controllers\Admin\Modules\BookingsManagement;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentClassBooking;
use App\Models\Tutor_calander_availability;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Payments;
use App\Models\AcademicProgramSession;
use App\Models\User;
use App\Models\AcademicProgramSessionLog;
use Mail;
use App\Mail\CancelBookingMail;
use Illuminate\Support\Facades\Log;
#stripe
use Stripe\Stripe;
use Carbon\Carbon;



class BookingsManagementController extends Controller
{

    public function bookingManagement(Request $request)
    {

        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $bookings = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade','academicProgramPurchase.academicProgram'])->whereIn('booking_status', ['B', 'C', 'CM']);
        $total_b = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->whereIn('booking_status', ['B', 'C', 'CM']);
        $total_cm = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->whereIn('booking_status', ['B', 'C', 'CM']);
        $total_c = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->whereIn('booking_status', ['B', 'C', 'CM']);
        if (@$request->columns['1']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->columns['1']['search']['value'] . '%');
            });
        }
        if (@$request->columns['2']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('booking_status', $request->columns['2']['search']['value']);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->Where('booking_status', $request->columns['2']['search']['value']);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->Where('booking_status', $request->columns['2']['search']['value']);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->Where('booking_status', $request->columns['2']['search']['value']);
            });
        }
        if (@$request->columns['7']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('student_id', $request->columns['7']['search']['value']);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->Where('student_id', $request->columns['7']['search']['value']);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->Where('student_id', $request->columns['7']['search']['value']);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->Where('student_id', $request->columns['7']['search']['value']);
            });
        }
        if (@$request->columns['8']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('tutor_id', $request->columns['8']['search']['value']);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->Where('tutor_id', $request->columns['8']['search']['value']);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->Where('tutor_id', $request->columns['8']['search']['value']);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->Where('tutor_id', $request->columns['8']['search']['value']);
            });
        }
        if (@$request->columns['9']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereIn('student_grade_id', [$request->columns['9']['search']['value']]);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->whereIn('student_grade_id', [$request->columns['9']['search']['value']]);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->whereIn('student_grade_id', [$request->columns['9']['search']['value']]);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->whereIn('student_grade_id', [$request->columns['9']['search']['value']]);
            });
        }
        if (@$request->columns['10']['search']['value']) {

            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereIn('subject_id', [$request->columns['10']['search']['value']]);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->whereIn('subject_id', [$request->columns['10']['search']['value']]);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->whereIn('subject_id', [$request->columns['10']['search']['value']]);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->whereIn('subject_id', [$request->columns['10']['search']['value']]);
            });
        }
        if (@$request->columns['3']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
        }
        if (@$request->columns['4']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->columns['3']['search']['value'] . " 00:00:00", @$request->columns['4']['search']['value'] . " 23:59:59"]);
            });
        }
        if (@$request->columns['5']['search']['value'] && @$request->columns['6']['search']['value']) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereBetween('booking_date', [@$request->columns['5']['search']['value'], @$request->columns['6']['search']['value']]);
            });
            $total_b = $total_b->where(function ($query) use ($request) {
                $query->whereBetween('booking_date', [@$request->columns['5']['search']['value'], @$request->columns['6']['search']['value']]);
            });
            $total_cm = $total_cm->where(function ($query) use ($request) {
                $query->whereBetween('booking_date', [@$request->columns['5']['search']['value'], @$request->columns['6']['search']['value']]);
            });
            $total_c = $total_c->where(function ($query) use ($request) {
                $query->whereBetween('booking_date', [@$request->columns['5']['search']['value'], @$request->columns['6']['search']['value']]);
            });
        }
        // $total_b = $bookings;
        // $total_cm = $bookings;
        // $total_c = $bookings;

        $ps =  $bookings->count();
        $pp = $bookings;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $bookings = $bookings;
        $p =  $p->count();
        if ($columnIndex == 0) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('booking_no', 'asc');
            } else {
                $bookings = $bookings->orderBy('booking_no', 'desc');
            }
        }
        if ($columnIndex == 1) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('tutor_id', 'asc');
            } else {
                $bookings = $bookings->orderBy('tutor_id', 'desc');
            }
        }
        if ($columnIndex == 2) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('student_id', 'asc');
            } else {
                $bookings = $bookings->orderBy('student_id', 'desc');
            }
        }
        if ($columnIndex == 3) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('subject_id', 'asc');
            } else {
                $bookings = $bookings->orderBy('subject_id', 'desc');
            }
        }
        if ($columnIndex == 4) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('student_grade_id', 'asc');
            } else {
                $bookings = $bookings->orderBy('student_grade_id', 'desc');
            }
        }
        if ($columnIndex == 5) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('booking_amount', 'asc');
            } else {
                $bookings = $bookings->orderBy('booking_amount', 'desc');
            }
        }
        if ($columnIndex == 6) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('booking_date', 'asc');
            } else {
                $bookings = $bookings->orderBy('booking_date', 'desc');
            }
        }
        if ($columnIndex == 7) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('booking_status', 'asc');
            } else {
                $bookings = $bookings->orderBy('booking_status', 'desc');
            }
        }
        if ($columnIndex == 8) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('created_at', 'asc');
            } else {
                $bookings = $bookings->orderBy('created_at', 'desc');
            }
        }
        if ($columnIndex == 9) {
            if ($columnSortOrder == 'asc') {
                $bookings = $bookings->orderBy('id', 'asc');
            } else {
                $bookings = $bookings->orderBy('id', 'desc');
            }
        }
        // if($columnIndex == 10) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('id','desc');
        //     }
        // }
        // if($columnIndex == 11) {
        //     if($columnSortOrder == 'asc') {
        //         $bookings = $bookings->orderBy('id','asc');
        //     } else {
        //         $bookings = $bookings->orderBy('id','desc');
        //     }
        // }
        $bookings = $bookings->orderBy('id', 'desc')->skip($request->start)->take($request->length)->get()->map(function ($booking) {
            
            $booking->program_name = '';

            if ($booking->is_academic_program == 1) {
                $booking->program_name =
                    optional(optional($booking->academicProgramPurchase)->academicProgram)->name ?? '-';
            }
            $booking->student_unique_id = $booking->getStudent->unique_id ?? '';
            $booking->tutor_unique_id = $booking->getTutor->unique_id ?? '';

            // Default fallback
            $studentTimezone = $booking->getStudent->timezone_id ?? 'UTC';
            $tutorTimezone = $booking->getTutor->timezone_id ?? 'UTC';

            // Convert UTC times to respective timezones
            $booking->student_from_time = Carbon::parse($booking->from_time, 'UTC')->setTimezone($booking->timezone_id)->format('H:i:s');
            $booking->student_to_time = Carbon::parse($booking->to_time, 'UTC')->setTimezone($booking->timezone_id)->format('H:i:s');

            $booking->from_time_tutor = Carbon::parse($booking->from_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
            $booking->to_time_tutor = Carbon::parse($booking->to_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');

            // Optional: handle cancelled_on
            if (!empty($booking->cancelled_on)) {
                $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($studentTimezone)->format('Y-m-d H:i:s');
                $booking->cancelled_on_tutor = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($tutorTimezone)->format('Y-m-d H:i:s');
            }

            return $booking;
        });
        $data['aaData'] = $bookings;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;

        $data['total_booked'] = $total_b->whereIn('booking_status', ['B'])->count();
        $data['total_completed'] = $total_cm->whereIn('booking_status', ['CM'])->count();
        $data['total_cancelled'] = $total_c->whereIn('booking_status', ['C'])->count();
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage grades!
    * Author        : Jayatri
    */
    public function index(Request $request)
    {
        try {
            $data['users'] = User::whereNotIn('status', ['D'])->where(['user_type' => 'U'])->select('id', 'status', 'f_name', 'l_name')->where('f_name', '!=', NULL)->orderBy('f_name', 'asc')->get();

            $data['tutors'] = User::whereNotIn('status', ['D'])->where(['user_type' => 'T'])->select('id', 'status', 'f_name', 'l_name')->orderBy('f_name', 'asc')->get();
            $data['grades'] = Grade::whereIn('status', ['A'])->select('id', 'grade_name', 'status')->orderBy('grade_name', 'asc')->get();
            $data['subjects'] = Subject::whereIn('status', ['A'])->select('id', 'subject')->orderBy('subject', 'asc')->get();
            return view('admin.modules.bookings_management.bookings_management', $data);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function bookingCancel(Request $request)
    {
        try {
            $paymentKey = config('services.stripe.stripe-secret');
           $id = $request->id;
            $booking = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['id' => $id])->whereNotIn('booking_status', ['C'])->first();
            if (@$booking) {
                if (@$booking->booking_date == date('Y-m-d') && @$booking->from_time > date('H:i:s')) {
                    StudentClassBooking::where(['id' => $id])->update(['booking_status' => 'C', 'cancelled_by' => 'A', 'cancelled_on' => now()]);
                    Tutor_calander_availability::where(['tutor_id' => $booking->tutor_id, 'date' => $booking->booking_date])->where('start_time', '>=', $booking->from_time)->where('end_time', '<=', $booking->to_time)->update(['booking_status' => 'NB']);
                    $this->sendCancelBookingMail($id);
                    session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
                    return redirect()->back();
                } elseif (@$booking->booking_date > date('Y-m-d')) {
                    StudentClassBooking::where(['id' => $id])->update(['booking_status' => 'C', 'cancelled_on' => now(), 'cancelled_by' => 'A']);
                    Tutor_calander_availability::where(['tutor_id' => $booking->tutor_id, 'date' => $booking->booking_date])->where('start_time', '>=', $booking->from_time)->where('end_time', '<=', $booking->to_time)->update(['booking_status' => 'NB']);
                    $this->sendCancelBookingMail($id);
                    session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
                    return redirect()->back();
                } else {
                    session()->flash("error", "You cannot cancel past bookings!");
                    return redirect()->back();
                }
            } else {
                session()->flash("error", "Booking is already cancelled");
                return redirect()->back();
                // $data['status'] = 0;
                // $data['message'] = "Please provide correct booking details!";
                // return response()->json($data,200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back();
        }
    }
    public function cancelBooking(Request $request)
    {
        try {
            $paymentKey =config('services.stripe.stripe-secret');
            $id = @$request->data['id'];
            $data['bookingDataInformation'] = $booking = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['id' => $id])->whereNotIn('booking_status', ['C'])->first();
            if (@$booking) {
                if (@$data['bookingDataInformation']->booking_date == date('Y-m-d') && @$data['  bookingDataInformation']->from_time <= date('H:i:s')) {
                    session()->flash("", "You cannot cancel a session from the past!");
                    return redirect()->back();
                }
                if (@$booking->booking_date == date('Y-m-d') && @$booking->from_time > date('H:i:s')) {
                    $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();

                    if (@$payment) {
                        $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);

                        $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
                        $HourHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(8);
                        $HourHalfHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(4);
                        if ($HourFullRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 24 hour HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            //100% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled! $" . @$paymetDtls->refund_amount . " has been refunded!");
                        } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            $refundAmount = ($payment->amount * (75 / 100));
                            $stripeAmount = (($payment->amount * (75 / 100)) * 100);
                            //50% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                'amount' => $stripeAmount,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '75', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

                            $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
                            $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
                            $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);

                            $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
                            $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
                            $updC['total_due'] = $getUser->total_due + $tutor_earnings;
                            $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
                            User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!" . (@$paymetDtls->refund_amount) . " has been refunded!");
                        } else if ($HourHalfHalfRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            $refundAmount = ($payment->amount * (50 / 100));
                            $stripeAmount = (($payment->amount * (50 / 100)) * 100);
                            //50% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                'amount' => $stripeAmount,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

                            $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
                            $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
                            $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);

                            $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
                            $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
                            $updC['total_due'] = $getUser->total_due + $tutor_earnings;
                            $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
                            User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!" . (@$paymetDtls->refund_amount) . " has been refunded!");
                        } else if ($HourHalfHalfHalfRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            $refundAmount = ($payment->amount * (25 / 100));
                            $stripeAmount = (($payment->amount * (25 / 100)) * 100);
                            //50% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                'amount' => $stripeAmount,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '25', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

                            $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
                            $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
                            $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);

                            $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
                            $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
                            $updC['total_due'] = $getUser->total_due + $tutor_earnings;
                            $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
                            User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!" . (@$paymetDtls->refund_amount) . " has been refunded!");
                        } else {
                            // no refund
                            $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
                            $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
                            $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
                            $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
                            $updC['total_due'] = $getUser->total_due + $tutor_earnings;
                            $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
                            User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!There is no refund for this booking no!");
                        }
                    } else {
                        session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!There is no refund for this booking no!");
                    }
                    StudentClassBooking::where(['id' => $id])->update(['booking_status' => 'C', 'cancelled_by' => 'A', 'cancelled_on' => now()]);
                    // // Reset academic program session
                    if ($booking->is_academic_program) {
                        $session = AcademicProgramSession::where('student_class_booking_id', $booking->id)->first();
                        if ($session) {
                            \Log::info("Logging academic program session cancellation for Session ID: {$session->id}");

                            AcademicProgramSessionLog::create([
                                'session_id'     => $session->id,
                                'tutor_id'       => $session->tutor_id,
                                'action'         => 'CANCELLED',
                                'action_by'      => Auth::id(),
                                'action_at'      => now()->utc(),
                                'scheduled_date' => $session->scheduled_at,
                                'start_time'     => $session->start_time,
                                'end_time'       => $session->end_time,
                                'reason'         => 'Booking cancelled by Admin',
                            ]);

                            $session->update([
                                'student_class_booking_id' => null,
                                'tutor_id'                 => null,
                                'status'                   => 'pending',
                                'scheduled_at'             => null,
                                'start_time'               => null,
                                'end_time'                 => null,
                                'completed_at'             => null,
                            ]);
                        }
                    }
                    Tutor_calander_availability::where(['tutor_id' => $booking->tutor_id, 'date' => $booking->booking_date])->where('start_time', '>=', $booking->from_time)->where('end_time', '<=', $booking->to_time)->update(['booking_status' => 'NB']);
                    $this->sendCancelBookingMail($id);
                    $data['status'] = 1;
                    $data['message'] = "Booking cancelled";
                    $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                    return response()->json($data, 200);
                } elseif (@$booking->booking_date > date('Y-m-d')) {
                    $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();

                    if (@$payment) {
                        $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);

                        $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
                        if ($HourFullRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 24 hour HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            //100% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled! $" . @$paymetDtls->refund_amount . " has been refunded!");
                        } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {
                            // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
                            $refundAmount = ($payment->amount * (50 / 100));
                            $stripeAmount = (($payment->amount * (50 / 100)) * 100);
                            //50% refund
                            $stripe = \Stripe\Stripe::setApiKey($paymentKey);
                            $t = \Stripe\Refund::create([
                                'charge' => $payment->txn_id,
                                'amount' => $stripeAmount,
                                ['metadata' => ['order_id' => $payment->booking_id]]
                            ]);
                            Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

                            $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
                            $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
                            $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);



                            $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!" . (@$paymetDtls->refund_amount) . " has been refunded!");
                        } else {
                            // no refund

                            $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
                            $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

                            StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
                            $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
                            $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
                            $updC['total_due'] = $getUser->total_due + $tutor_earnings;
                            $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
                            User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

                            session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!There is no refund for this booking no!");
                        }
                    } else {
                        session()->flash("success", "Your booking " . $data['bookingDataInformation']->booking_no . " is now cancelled!There is no refund for this booking no!");
                    }
                   StudentClassBooking::where(['id' => $id])->update(['booking_status' => 'C', 'cancelled_by' => 'A', 'cancelled_on' => now()]);
                    // Reset academic program session
                    if ($booking->is_academic_program) {
                        $session = AcademicProgramSession::where('student_class_booking_id', $booking->id)->first();
                        if ($session) {
                            \Log::info("Logging academic program session cancellation for Session ID: {$session->id}");

                            AcademicProgramSessionLog::create([
                                'session_id'     => $session->id,
                                'tutor_id'       => $session->tutor_id,
                                'action'         => 'CANCELLED',
                                'action_by'      => Auth::id(),
                                'action_at'      => now()->utc(),
                                'scheduled_date' => $session->scheduled_at,
                                'start_time'     => $session->start_time,
                                'end_time'       => $session->end_time,
                                'reason'         => 'Booking cancelled by Admin',
                            ]);

                            $session->update([
                                'student_class_booking_id' => null,
                                'tutor_id'                 => null,
                                'status'                   => 'pending',
                                'scheduled_at'             => null,
                                'start_time'               => null,
                                'end_time'                 => null,
                                'completed_at'             => null,
                            ]);
                        }
                    }
                    Tutor_calander_availability::where(['tutor_id' => $booking->tutor_id, 'date' => $booking->booking_date])->where('start_time', '>=', $booking->from_time)->where('end_time', '<=', $booking->to_time)->update(['booking_status' => 'NB']);
                    $this->sendCancelBookingMail($id);
                    $data['status'] = 1;
                    $data['message'] = "Booking cancelled";
                    return response()->json($data, 200);
                } else {
                    $data['status'] = 0;
                    $data['message'] = "You cannot cancel past bookings!";
                    return response()->json($data, 200);
                }
            } else {
                $data['status'] = 0;
                $data['message'] = "Please provide correct booking details!";
                return response()->json($data, 200);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }
    public function viewDetails($bookingNo)
    {
        $booking = StudentClassBooking::with([
            'getStudent',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade',
            'getPaymentsInfo'
        ])->where('booking_no', $bookingNo)->first();

        if ($booking) {
            
            $adminTimezone = 'Australia/Sydney';
            $rawBookingDate = $booking->getRawOriginal('booking_date');
            $rawFromTime = $booking->getRawOriginal('from_time');
            $rawToTime = $booking->getRawOriginal('to_time');
            $rawCreatedAt = $booking->getRawOriginal('created_at');
            $rawCancelledOn = $booking->getRawOriginal('cancelled_on');
            $rawStudentLoginAt = $booking->getRawOriginal('student_login_at');
            $rawTutorLoginAt = $booking->getRawOriginal('tutor_login_at');

            if ($booking->getTutor) {
                $tutorTimezone = $booking->getTutor->timezone_id;
                if ($rawBookingDate && $rawFromTime) {
                    $booking->setAttribute(
                    'dto_tutor_from_time',
                    Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $rawBookingDate . ' ' . $rawFromTime,
                        'UTC'
                        )->setTimezone($tutorTimezone)->format('h:i a')
                    );
                }

            if ($rawBookingDate && $rawToTime) {

                $booking->setAttribute(
                    'dto_tutor_to_time',
                    Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $rawBookingDate . ' ' . $rawToTime,
                        'UTC'
                    )->setTimezone($tutorTimezone)->format('h:i a')
                );
            }
            if ($rawCreatedAt) {
                $booking->setAttribute(
                    'dto_tutor_created_at',
                    Carbon::parse(
                        $rawCreatedAt,
                        'UTC'
                    )->setTimezone($tutorTimezone)->format('h:i a')
                );
            }

            if ($rawCancelledOn) {
                $booking->setAttribute(
                    'dto_tutor_cancelled_on',
                    Carbon::parse(
                        $rawCancelledOn,
                        'UTC'
                    )->setTimezone($tutorTimezone)->format('h:i a')
                    );
                }
            }

            if ($booking->getStudent) {

                $studentTimezone = $booking->getStudent->timezone_id;

                if ($rawBookingDate && $rawFromTime) {

                    $booking->setAttribute(
                        'dto_student_from_time',
                        Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $rawBookingDate . ' ' . $rawFromTime,
                        'UTC'
                    )->setTimezone($studentTimezone)->format('h:i a')
                );
            }

            if ($rawBookingDate && $rawToTime) {

                $booking->setAttribute(
                    'dto_student_to_time',
                    Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $rawBookingDate . ' ' . $rawToTime,
                        'UTC'
                    )->setTimezone($studentTimezone)->format('h:i a')
                );
            }

            if ($rawCreatedAt) {

                $booking->setAttribute(
                    'dto_student_created_at',
                    Carbon::parse(
                        $rawCreatedAt,
                        'UTC'
                    )->setTimezone($studentTimezone)->format('h:i a')
                );
            }

            if ($rawCancelledOn) {

                $booking->setAttribute(
                    'dto_student_cancelled_on',
                    Carbon::parse(
                        $rawCancelledOn,
                        'UTC'
                    )->setTimezone($studentTimezone)->format('h:i a')
                );
            }

            if ($rawStudentLoginAt) {
                $booking->setAttribute(
                    'dto_admin_student_login_at',
                    Carbon::parse(
                        $rawStudentLoginAt,
                        'UTC'
                    )->setTimezone($adminTimezone)->format('d-m-Y h:i a')
                );
            }

            if ($rawTutorLoginAt) {
                $booking->setAttribute(
                    'dto_admin_tutor_login_at',
                    Carbon::parse(
                        $rawTutorLoginAt,
                        'UTC'
                    )->setTimezone($adminTimezone)->format('d-m-Y h:i a')
                );
            }
        }

        if ($rawBookingDate && $rawFromTime) {

            $booking->setAttribute(
                'dto_admin_from_datetime',
                Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $rawBookingDate . ' ' . $rawFromTime,
                    'UTC'
                )->setTimezone($adminTimezone)
            );
        }

        if ($rawBookingDate && $rawToTime) {

            $booking->setAttribute(
                'dto_admin_to_datetime',
                Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $rawBookingDate . ' ' . $rawToTime,
                    'UTC'
                )->setTimezone($adminTimezone)
            );
        }
        }

        $data['bookingDataInformation'] = $booking;

        return view(
            'admin.modules.bookings_management.view_booking_details',
            $data
        );
    }

    public function sendCancelBookingMail($id)
    {
        try {
            $booking = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->where(['id' => $id])->first();
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
                // $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($Timezone)->format('H:i:s');
                $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone(config('app.timezone'))->format('H:i:s');
            }
            // Log::info('From Time User: ' . ($booking->from_time_user ?? 'null'));
            // Log::info('From Time Tutor: ' . ($booking->from_time_tutor ?? 'null'));
            // Log::info('Cancelled On User: ' . ($booking->cancelled_on_user ?? 'null'));
            // Log::info('Cancelled On Raw: ' . ($booking->cancelled_on ?? 'null'));
            $data['bookingDataInformation'] = $booking;

           // Log::info("Cancel mail Sent to:", $data['data']['mail_send_to']);

            Mail::send(new CancelBookingMail($data));
        } catch (\Exception $e) {

            \Log::error($e->getMessage());
        }
    }
    public function getBookingManagementList(Request $request)
    {

        $data['bookings'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->whereIn('booking_status', ['B', 'C', 'CM']);
        if (@$request->booking_search) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->where('booking_no', 'like', '%' . $request->booking_search . '%');
            });
        }
        if (@$request->col2_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('booking_status', $request->col2_filter);
            });
        }
        if (@$request->col7_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('student_id', $request->col7_filter);
            });
        }
        if (@$request->col8_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('tutor_id', $request->col8_filter);
            });
        }
        if (@$request->col9_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('student_grade_id', $request->col9_filter);
            });
        }
        if (@$request->col10_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->Where('subject_id', $request->col10_filter);
            });
        }

        if (@$request->col3_filter && @$request->col4_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereBetween('created_at', [@$request->col3_filter . " 00:00:00", @$request->col4_filter . " 23:59:59"]);
            });
        }
        if (@$request->col5_filter && @$request->col6_filter) {
            $bookings = $bookings->where(function ($query) use ($request) {
                $query->whereBetween('booking_date', [@$request->col5_filter, @$request->col6_filter]);
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
        header("Content-Disposition: attachment; filename=BookingManagement.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $t;
    }
}
