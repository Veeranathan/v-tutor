<?php

namespace App\Http\Controllers\Teacher\ViewBookingDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Subject;
use App\Models\SubjectTopics;
use App\Models\StudentClassBooking;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\Payments;
use App\Models\Grade;
use App\Models\AcademicProgramSession;
use App\Models\User;
use Validator;
use Mail;
use App\Mail\StudentClassBookingMail;
use App\Mail\CancelBookingMail;
use Illuminate\Support\Carbon;

#stripe
use Stripe\Stripe;
use App\Models\AdminDisableBookingDates;
use App\Models\AdminDisableBookings;
use Illuminate\Support\Facades\Log;

class ViewBookingDetailsController extends Controller
{
    public function sendCancelBookingMail($bookingNo)
    {
        try {
            $booking = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->first();
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
            $data['mail_send_to'] = 'S';
            $data['email'] = $data['bookingDataInformation']['getStudent']['email'];
            Mail::send(new CancelBookingMail($data));

            $data['mail_send_to'] = 'T';
            $data['email'] = $data['bookingDataInformation']['getTutor']['email'];
            Mail::send(new CancelBookingMail($data));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
    // public function cancelBookedClass($bookingNo)
    // {
    //     $paymentKey = config('services.stripe.stripe-secret');
    //     $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent', 'getTutor.getState', 'getTutor.getTimezone', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo, 'booking_status' => 'B'])->whereNotIn('booking_status', ['C'])->first();
    //     if (@$data['bookingDataInformation']) {
    //         if (@$data['bookingDataInformation']->booking_date == date('Y-m-d') && @$data['bookingDataInformation']->from_time < date('H:i:s')) {
    //             session()->flash("error", "You cannot cancel a session from the past!");
    //             return redirect()->back();
    //         }
    //         // $ddd = (Carbon::parse($data['bookingDataInformation']->booking_date." ".$data['bookingDataInformation']->from_time))->subhours(12);
    //         // $date = date('Y-m-d h:i:s', strtotime('-12 hour'));
    //         // if($ddd <= date('Y-m-d H:i:s')){
    //         //     session()->flash("error","A tutor should only be able to cancel his/her session before 12 hours!");
    //         //     return redirect()->back();
    //         // }
    //         if (@$data['bookingDataInformation']->booking_date == date('Y-m-d') && @$data['bookingDataInformation']->from_time > date('H:i:s')) {
    //             StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->update(['booking_status' => 'C', 'cancelled_by' => 'T', 'cancelled_on' => now()]);
    //             Tutor_calander_availability::where(['tutor_id' => $data['bookingDataInformation']->tutor_id, 'date' => $data['bookingDataInformation']->booking_date])->where('start_time', '>=', $data['bookingDataInformation']->from_time)->where('end_time', '<=', $data['bookingDataInformation']->to_time)->update(['booking_status' => 'NB']);
    //             $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //             if (@$payment) {
    //                 $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);
    //                 $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
    //                 $HourHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(8);
    //                 $HourHalfHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(4);
    //                 if ($HourFullRefund >= date('Y-m-d H:i:s')) {

    //                     //100% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled! $".@$paymetDtls->refund_amount." has been refunded!");
    //                 } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {

    //                     $refundAmount = ($payment->amount * (75 / 100));
    //                     $stripeAmount = (($payment->amount * (75 / 100)) * 100);
    //                     //50% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         'amount' => $stripeAmount,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '75', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                     $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                     $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $commission, 'admin_commission' => $admin_ord_commission]);

    //                     $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                     $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                     $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                     $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                     User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                 } else if ($HourHalfHalfRefund >= date('Y-m-d H:i:s')) {

    //                     $refundAmount = ($payment->amount * (50 / 100));
    //                     $stripeAmount = (($payment->amount * (50 / 100)) * 100);
    //                     //50% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         'amount' => $stripeAmount,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                     $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                     $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $commission, 'admin_commission' => $admin_ord_commission]);

    //                     $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                     $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                     $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                     $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                     User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                 } else if ($HourHalfHalfHalfRefund >= date('Y-m-d H:i:s')) {

    //                     $refundAmount = ($payment->amount * (25 / 100));
    //                     $stripeAmount = (($payment->amount * (25 / 100)) * 100);
    //                     //50% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         'amount' => $stripeAmount,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '25', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                     $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                     $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $admin_ord_commission, 'admin_commission' => $admin_ord_commission]);

    //                     $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                     $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                     $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                     $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                     User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                 } else {
    //                     // no refund
    //                     $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
    //                     $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                     $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                     $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                     $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                     $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                     User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //                 }
    //             } else {
    //                 session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                 // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //             }
    //             // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled");
    //             session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //             try {
    //                 $this->sendCancelBookingMail($data['bookingDataInformation']->booking_no);
    //             } catch (\Exception $e) {
    //                 \Log::error($e->getMessage());
    //             }
    //             return redirect()->back();
    //         }
    //         if (@$data['bookingDataInformation']->booking_date > date('Y-m-d')) {
    //             StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getSubjectTopics'])->where(['booking_no' => $bookingNo])->update(['booking_status' => 'C', 'cancelled_on' => now(), 'cancelled_by' => 'T']);
    //             Tutor_calander_availability::where(['tutor_id' => $data['bookingDataInformation']->tutor_id, 'date' => $data['bookingDataInformation']->booking_date])->where('start_time', '>=', $data['bookingDataInformation']->from_time)->where('end_time', '<=', $data['bookingDataInformation']->to_time)->update(['booking_status' => 'NB']);
    //             $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //             $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //             if (@$payment) {
    //                 $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);

    //                 $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
    //                 if ($HourFullRefund >= date('Y-m-d H:i:s')) {
    //                     // dd("if greater than equal 24 hour HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                     //100% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled! $".@$paymetDtls->refund_amount." has been refunded!");
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                 } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {
    //                     // dd("if greater than equal 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                     $refundAmount = ($payment->amount * (50 / 100));
    //                     $stripeAmount = (($payment->amount * (50 / 100)) * 100);
    //                     //50% refund
    //                     $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                     $t = \Stripe\Refund::create([
    //                         'charge' => $payment->txn_id,
    //                         'amount' => $stripeAmount,
    //                         ['metadata' => ['order_id' => $payment->booking_id]]
    //                     ]);
    //                     Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                     $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                     $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                     $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);



    //                     $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                 } else {
    //                     // no refund
    //                     $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
    //                     $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

    //                     StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                     $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                     $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                     $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                     $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                     User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //                 }
    //             } else {
    //                 // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //                 session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //             }
    //             // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled");
    //             try {
    //                 $this->sendCancelBookingMail($data['bookingDataInformation']->booking_no);
    //             } catch (\Exception $e) {
    //                 \Log::error($e->getMessage());
    //             }

    //             return redirect()->back();
    //         } else {
    //             session()->flash("error", "You cannot cancel your past bookings!");
    //             return redirect()->back();
    //         }
    //     } else {
    //         // session()->flash("error","The boooking is already cancelled!");
    //         session()->flash("error", "Wrong booking id!");
    //         return redirect()->back();
    //     }
    // }

    public function cancelBookedClass($bookingNo)
    {
        $paymentKey = config('services.stripe.stripe-secret');

        $data['bookingDataInformation'] = StudentClassBooking::with([
            'getStudent',
            'getTutor.getState',
            'getTutor.getTimezone',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade'
        ])
            ->where(['booking_no' => $bookingNo, 'booking_status' => 'B'])
            ->whereNotIn('booking_status', ['C'])
            ->first();

        if (!@$data['bookingDataInformation']) {
            session()->flash("error", "Wrong booking id or already cancelled!");
            return redirect()->back();
        }

        // Prevent cancelling past sessions
        if (
            $data['bookingDataInformation']->booking_date == date('Y-m-d') &&
            $data['bookingDataInformation']->from_time < date('H:i:s')
        ) {
            session()->flash("error", "You cannot cancel a session from the past!");
            return redirect()->back();
        }

        //  Mark booking as cancelled
        // StudentClassBooking::where(['booking_no' => $bookingNo])->update([
        //     'booking_status' => 'C',
        //     'cancelled_by'   => 'T',
        //     'cancelled_on'   => now()
        // ]);
        // Get booking first
        $booking = StudentClassBooking::where([
            'booking_no' => $bookingNo
        ])->first();
    
        if ($booking) {
            if ($booking->is_academic_program) {
                $sessionStart = \Carbon\Carbon::parse($booking->booking_date . ' ' . $booking->from_time);
                $now = \Carbon\Carbon::now();

                if ($sessionStart->diffInHours($now) < 6) {
                    session()->flash(
                        'error',
                        'Academic Program sessions can only be cancelled at least 6 hours before the scheduled session.'
                    );
                    return redirect()->back();
                }
            }
            // Cancel booking
            $booking->update([
                'booking_status' => 'C',
                'cancelled_by'   => 'T',
                'cancelled_on'   => now()
            ]);

            // If academic program, log action and reset session
            if ($booking->is_academic_program) {
                $session = AcademicProgramSession::where('student_class_booking_id', $booking->id)->first();

                if ($session) {
                    Log::info('Im inside cancel session: ' .$session );
                // Create audit snapshot log before resetting session data
                    AcademicProgramSessionLog::create([
                        'session_id'     => $session->id,
                        'tutor_id'       => $session->tutor_id,
                        'action'         => 'CANCELLED',
                        'action_by'      => Auth::id(),
                        'action_at'      => now()->utc(),
                        'scheduled_date' => $session->scheduled_at,
                        'start_time'     => $session->start_time,
                        'end_time'       => $session->end_time,
                        'reason'         => 'Booking cancelled by Tutor',
                    ]);

                    $session->update([
                        'student_class_booking_id' => null,
                        'tutor_id'     => null,
                        'status'       => 'pending',
                        'scheduled_at' => null,
                        'start_time'   => null,
                        'end_time'     => null,
                        'completed_at' => null,
                    ]);
                }
            }
        }

        //Free up tutor calendar slot
        Tutor_calander_availability::where([
            'tutor_id' => $data['bookingDataInformation']->tutor_id,
            'date'     => $data['bookingDataInformation']->booking_date
        ])
            ->where('start_time', '>=', $data['bookingDataInformation']->from_time)
            ->where('end_time', '<=', $data['bookingDataInformation']->to_time)
            ->update(['booking_status' => 'NB']);

        // Handle payment refund (Always 100% refund for tutor cancellations)
        $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();

        if ($payment) {
            try {
                \Stripe\Stripe::setApiKey($paymentKey);

                $refund = \Stripe\Refund::create([
                    'charge'   => $payment->txn_id,
                    'metadata' => ['order_id' => $payment->booking_id]
                ]);

                Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update([
                    'refund_response' => json_encode($refund),
                    'refund_id'       => $refund->id,
                    'refund_type'     => '100',
                    'refund_amount'   => $payment->amount,
                    'refund_status'   => 'S'
                ]);

                // Reset tutor and admin earnings for this booking
                StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])
                    ->update(['tutor_earnings' => 0, 'admin_commission' => 0]);  

                session()->flash("success", "Booking cancelled successfully.");
            } catch (\Exception $e) {
                \Log::error('Refund error: ' . $e->getMessage());
                session()->flash("error", "Booking cancelled, but refund could not be processed. Please contact admin.");
            }
        } else {
            session()->flash("success", "Booking cancelled successfully (no payment record found).");
        }

        // Send cancellation email (non-blocking)
        try {
            $this->sendCancelBookingMail($data['bookingDataInformation']->booking_no);
        } catch (\Exception $e) {
            Log::error('Cancel email error: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function viewDetails($bookingNo)
    {
        $timezone = Auth::user()->timezone_id ?? 'UTC';

        $bookingDataInformation = StudentClassBooking::with([
            'getStudent.getSchool',
            'getStudent.getSchool.getState',
            'getStudent.getSchool.getSuburb',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade',
            'getTutor.getTutorShipPlan',
            'getSubjectTopics',
            'academicProgramPurchase.academicProgram.grade',
            'academicProgramPurchase.academicProgram.branch'
        ])->where('booking_no', $bookingNo)->first();

        if ($bookingDataInformation) {
            // ✅ Combine booking_date + time before conversion
            $fromUTC = Carbon::parse($bookingDataInformation->booking_date . ' ' . $bookingDataInformation->from_time, 'UTC');
            $toUTC = Carbon::parse($bookingDataInformation->booking_date . ' ' . $bookingDataInformation->to_time, 'UTC');

            $bookingDataInformation->booking_date_user = $fromUTC->copy()->setTimezone($timezone)->format('Y-m-d');
            $bookingDataInformation->from_time_user = $fromUTC->copy()->setTimezone($timezone)->format('Y-m-d H:i:s');
            $bookingDataInformation->to_time_user = $toUTC->copy()->setTimezone($timezone)->format('Y-m-d H:i:s');
        }

        $data['bookingDataInformation'] = $bookingDataInformation;
        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')
            ->toArray();

        if ($bookingDataInformation) {
            // ✅ Convert tutor’s availability times using combined date/time if available
            $data['t_my_av_show'] = MyAvailability::where([
                'teacher_id' => $bookingDataInformation->tutor_id,
                'status' => 'A'
            ])->get()->map(function ($class) use ($timezone) {
                if (!empty($class->date)) {
                    $fromUTC = Carbon::parse($class->date . ' ' . $class->from_time, 'UTC');
                    $toUTC = Carbon::parse($class->date . ' ' . $class->to_time, 'UTC');
                } else {
                    // fallback in case 'date' is missing
                    $fromUTC = Carbon::parse($class->from_time, 'UTC');
                    $toUTC = Carbon::parse($class->to_time, 'UTC');
                }

                $class->from_time_user = $fromUTC->setTimezone($timezone)->format('Y-m-d H:i:s');
                $class->to_time_user = $toUTC->setTimezone($timezone)->format('Y-m-d H:i:s');
                return $class;
            });

            return view('teacher.modules.my_class.view_class_details')->with($data);
        } else {
            session()->flash("error", "No data found for the given booking number.");
            return redirect()->back();
        }
    }


    public function teacherSessionFeedbackSave(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'booking_id'             => 'required|exists:student_class_bookings,id',
        ], [
            'booking_id.required' => 'Please try again later or contact admin',
            'booking_id.exists'   => 'Please try again later or contact admin',
        ]);

        // Add a combined message for the three related fields
        $validator->after(function ($validator) use ($request) {
            if (
                empty($request->session_summary) ||
                empty($request->session_recommendations) ||
                empty($request->permission_grade)
            ) {
                $validator->errors()->add(
                    'session_feedback_group',
                    'Please Enter Session Feedback, Recommendations & Permission Grade.'
                );
            }
        });

        $validator->validate();


        $timezone = Auth::user()->timezone_id ? Auth::user()->timezone_id : 'UTC';
        $bookingDataInformation = StudentClassBooking::where(['id' => $request->booking_id])->first();
        if ($bookingDataInformation) {
            if ($bookingDataInformation->session_summary) {
                session()->flash("error", "Session Feedback already submitted!");
                return redirect()->back();
            }

            $bookingDataInformation->session_summary = $request->session_summary;
            $bookingDataInformation->session_recommendations = $request->session_recommendations;
            $bookingDataInformation->permission_grade = $request->permission_grade;
            if ($bookingDataInformation->save()) {
                session()->flash("success", "Session feedback saved successfully!");
                return redirect()->back();
            } else {
                session()->flash("error", "Session feedback saving failed!");
                return redirect()->back();
            }
        } else {
            session()->flash("error", "Something went wrong, please try again later!");
            return redirect()->back();
        }
    }
}
