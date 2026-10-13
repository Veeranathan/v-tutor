<?php

namespace App\Http\Controllers\Student\ViewBookingDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Subject;
use App\Models\StudentClassBooking;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\Payments;
use App\Models\Grade;
use App\Models\SubjectTopics;
use App\Models\AcademicProgramSession;
use App\Models\AcademicProgramSessionLog;
use App\Models\User;
use Validator;

use Mail;
use App\Mail\StudentClassBookingMail;
use App\Mail\CancelBookingMail;
use Illuminate\Support\Carbon;
#stripe
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use App\Models\AdminDisableBookingDates;
use App\Models\AdminDisableBookings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\TutorPayment;

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
                $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone(config('app.timezone'))->format('H:i:s');
                // $booking->cancelled_on_user = Carbon::parse($booking->cancelled_on, 'UTC')->setTimezone($Timezone)->format('H:i:s');
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
    public function calculateRefund($bookingNo, $bookingDataInformation) {}
    public function updateBookingDetails($bookingNo, $bookingDataInformation) {}
    public function updateBookingTutorCalendar($bookingNo, $bookingDataInformation)
    {
        StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->update(['booking_status' => 'C', 'cancelled_by' => 'S', 'cancelled_on' => now()]);
        Tutor_calander_availability::where(['tutor_id' => $bookingDataInformation->tutor_id, 'date' => $data['bookingDataInformation']->booking_date])->where('start_time', '>=', $bookingDataInformation->from_time)->where('end_time', '<=', $bookingDataInformation->to_time)->update(['booking_status' => 'NB']);
        $bookingId = $data['bookingDataInformation']->id;

        $affected = TutorPayment::where(['booking_id' => $bookingId])
            ->update([
                'booking_status' => 2

            ]);

        try {
            if ($affected > 0) {
                \Log::info("TutorPayment updated successfully", [
                    'booking_id' => $bookingId,
                    'rows_affected' => $affected
                ]);
            } else {
                \Log::warning("TutorPayment update affected 0 rows", [
                    'booking_id' => $bookingId,
                    'existing_record' => TutorPayment::where('booking_id', $bookingId)->first()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("TutorPayment update failed", [
                'booking_id' => $data['bookingDataInformation']->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    // public function cancelBookedClass($bookingNo)
    // {
    //     try {
    //         $paymentKey = config('services.stripe.stripe-secret');
    //         $data['bookingDataInformation'] = $bookingDataInformation = StudentClassBooking::with(['getTutor.getState', 'getTutor.getTimezone', 'getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getSubjectTopics'])->where(['booking_no' => $bookingNo, 'booking_status' => 'B'])->first();

    //         if (@$data['bookingDataInformation']) {

    //             if (@$data['bookingDataInformation']->booking_date == date('Y-m-d') && @$data['bookingDataInformation']->from_time < date('H:i:s')) {
    //                 session()->flash("error", "You cannot cancel a session from the past!");
    //                 return redirect()->back();
    //             }
    //             if (@$data['bookingDataInformation']->booking_date == date('Y-m-d') && @$data['bookingDataInformation']->from_time > date('H:i:s')) {


    //                 $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();

    //                 if (@$payment) {
    //                     $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);

    //                     $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
    //                     $HourHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(8);
    //                     $HourHalfHalfHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(4);
    //                     if ($HourFullRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than 24 hour HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         //100% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled! $".@$paymetDtls->refund_amount." has been refunded!");
    //                         // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled! $".@$paymetDtls->refund_amount." has been refunded!");
    //                     } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         $refundAmount = ($payment->amount * (75 / 100));
    //                         $stripeAmount = (($payment->amount * (75 / 100)) * 100);
    //                         //50% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             'amount' => $stripeAmount,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '75', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                         $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                         $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                         $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                         $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                         $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                         $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                         $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                         User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                     } else if ($HourHalfHalfRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         $refundAmount = ($payment->amount * (50 / 100));
    //                         $stripeAmount = (($payment->amount * (50 / 100)) * 100);
    //                         //50% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             'amount' => $stripeAmount,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                         $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                         $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                         $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                         $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                         $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                         $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                         $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                         User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                     } else if ($HourHalfHalfHalfRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         $refundAmount = ($payment->amount * (25 / 100));
    //                         $stripeAmount = (($payment->amount * (25 / 100)) * 100);
    //                         //50% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             'amount' => $stripeAmount,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '25', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                         $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                         $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                         $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                         $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                         $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                         $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                         $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                         User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);

    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                     } else {

    //                         // no refund
    //                         // session()->flash("success","Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");


    //                         $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
    //                         $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                         $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                         if (@$getUser) {
    //                             $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                             $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                             $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                             User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);
    //                         }


    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     }
    //                 } else {
    //                     session()->flash("success", "Booking is not cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //                 }
    //                 $bookingId = $data['bookingDataInformation']->id;

    //                 $affected = TutorPayment::where(['booking_id' => $bookingId])
    //                     ->update([
    //                         'booking_status' => 2,
    //                         'payment_status' => DB::raw("CASE WHEN payment_status = '1' THEN '2' ELSE '0' END")
    //                     ]);

    //                 try {
    //                     if ($affected > 0) {
    //                         \Log::info("TutorPayment updated successfully", [
    //                             'booking_id' => $bookingId,
    //                             'rows_affected' => $affected
    //                         ]);
    //                     } else {
    //                         \Log::warning("TutorPayment update affected 0 rows", [
    //                             'booking_id' => $bookingId,
    //                             'existing_record' => TutorPayment::where('booking_id', $bookingId)->first()
    //                         ]);
    //                     }
    //                 } catch (\Exception $e) {
    //                     \Log::error("TutorPayment update failed", [
    //                         'booking_id' => $data['bookingDataInformation']->id ?? null,
    //                         'error' => $e->getMessage(),
    //                         'trace' => $e->getTraceAsString()
    //                     ]);
    //                 }
    //                 StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->update(['booking_status' => 'C', 'cancelled_by' => 'S', 'cancelled_on' => now()]);
    //                 Tutor_calander_availability::where(['tutor_id' => $data['bookingDataInformation']->tutor_id, 'date' => $data['bookingDataInformation']->booking_date])->where('start_time', '>=', $data['bookingDataInformation']->from_time)->where('end_time', '<=', $data['bookingDataInformation']->to_time)->update(['booking_status' => 'NB']);
    //                 try {
    //                     $this->sendCancelBookingMail($data['bookingDataInformation']->booking_no);
    //                 } catch (\Exception $e) {
    //                     \Log::error($e->getMessage());
    //                 }
    //                 return redirect()->back();
    //             } else if (@$data['bookingDataInformation']->booking_date > date('Y-m-d')) {
    //                 $payment = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                 if (@$payment) {
    //                     $HourFullRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(24);

    //                     $HourHalfRefund = (Carbon::parse($data['bookingDataInformation']->booking_date . " " . $data['bookingDataInformation']->from_time))->subhours(12);
    //                     if ($HourFullRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than equal 24 hour HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         //100% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '100', 'refund_amount' => $payment->amount, 'refund_status' => 'S']);


    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => 0, 'admin_commission' => 0]);

    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled! $".@$paymetDtls->refund_amount." has been refunded!");
    //                     } else if ($HourHalfRefund >= date('Y-m-d H:i:s')) {
    //                         // dd("if greater than equal 12 hour $HourFullRefund : ".$HourFullRefund.' current time'.date('Y-m-d H:i:s'));
    //                         $refundAmount = ($payment->amount * (50 / 100));
    //                         $stripeAmount = (($payment->amount * (50 / 100)) * 100);
    //                         //50% refund
    //                         $stripe = \Stripe\Stripe::setApiKey($paymentKey);
    //                         $t = \Stripe\Refund::create([
    //                             'charge' => $payment->txn_id,
    //                             'amount' => $stripeAmount,
    //                             ['metadata' => ['order_id' => $payment->booking_id]]
    //                         ]);
    //                         Payments::where(['booking_id' => $data['bookingDataInformation']->id])->update(['refund_response' => json_encode(@$t), 'refund_id' => @$t['id'], 'refund_type' => '50', 'refund_amount' => $refundAmount, 'refund_status' => 'S']);

    //                         $rest_of_amount = ($data['bookingDataInformation']->booking_amount - $refundAmount);
    //                         $admin_ord_commission = ($rest_of_amount * ($data['bookingDataInformation']->admin_percentage / 100));
    //                         $tutor_earnings  = $rest_of_amount - $admin_ord_commission;
    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);



    //                         $paymetDtls = Payments::where(['booking_id' => $data['bookingDataInformation']->id])->first();
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!".(@$paymetDtls->refund_amount)." has been refunded!");
    //                     } else {
    //                         // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");

    //                         $tutor_earnings = $data['bookingDataInformation']->tutor_earnings;
    //                         $admin_ord_commission = $data['bookingDataInformation']->admin_commission;

    //                         StudentClassBooking::where(['id' => $data['bookingDataInformation']->id])->update(['tutor_earnings' => $tutor_earnings, 'admin_commission' => $admin_ord_commission]);
    //                         $getUser = User::where(['id' => $data['bookingDataInformation']->tutor_id])->first();
    //                         $updC['total_earning'] = $getUser->total_earning + $tutor_earnings;
    //                         $updC['total_due'] = $getUser->total_due + $tutor_earnings;
    //                         $updC['total_commission'] = $getUser->total_commission + $admin_ord_commission;
    //                         User::where(['id' => $data['bookingDataInformation']->tutor_id])->update($updC);
    //                         session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                     }
    //                 } else {
    //                     // session()->flash("success","Booking cancelled. You may book again!Your booking ".$data['bookingDataInformation']->booking_no." is now cancelled!There is no refund for this booking no!");
    //                     session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");
    //                 }
    //                 StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade'])->where(['booking_no' => $bookingNo])->update(['booking_status' => 'C', 'cancelled_by' => 'S', 'cancelled_on' => now()]);
    //                 Tutor_calander_availability::where(['tutor_id' => $data['bookingDataInformation']->tutor_id, 'date' => $data['bookingDataInformation']->booking_date])->where('start_time', '>=', $data['bookingDataInformation']->from_time)->where('end_time', '<=', $data['bookingDataInformation']->to_time)->update(['booking_status' => 'NB']);
    //                 session()->flash("success", "Booking cancelled. Refunds are subject to conditions. Refer cancellation policy for more details");

    //                 try {
    //                     $this->sendCancelBookingMail($data['bookingDataInformation']->booking_no);
    //                 } catch (\Exception $e) {
    //                     \Log::error($e->getMessage());
    //                 }
    //                 return redirect()->back();
    //             } else {
    //                 session()->flash("error", "You cannot cancel your past bookings!");
    //                 return redirect()->back();
    //             }
    //         } else {
    //             session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
    //             return redirect()->back();
    //         }
    //     } catch (\Exception $e) {
    //         session()->flash("error", $e->getMessage());
    //         return redirect()->back();
    //     }
    // }

    public function cancelBookedClass($bookingNo)
    {
        try {
            $paymentKey = config('services.stripe.stripe-secret');

            // 🔹 Fetch booking with all relationships
            $booking = StudentClassBooking::with([
                'getTutor.getState',
                'getTutor.getTimezone',
                'getStudent',
                'getTutor.languguageToTuor',
                'getTutor.getTutorAcademic',
                'getSubject',
                'getStudentGrade',
                'getSubjectTopics'
            ])
                ->where([
                    'booking_no' => $bookingNo,
                    'booking_status' => 'B'
                ])
                ->first();

            Log::info("Cancel Booking Request", [$bookingNo]);

            if (!$booking) {
                session()->flash("error", "Invalid booking or already cancelled!");
                return back();
            }

            // 🔹 Combine booking date & time (stored in UTC)
            $classStartUtc = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
            $bookingCreatedUtc = Carbon::parse($booking->created_at, 'UTC');
            $nowUtc = Carbon::now('UTC');

            // 🔹 Check if class already started
            if ($classStartUtc->isPast()) {
                session()->flash("error", "You cannot cancel a past session!");
                return back();
            }

            // Academic Program: cancellation allowed only if more than 6 hours remain
            if ($booking->is_academic_program) {

            $hoursBefore = $nowUtc->diffInHours($classStartUtc, false);

            if ($hoursBefore < 6) {
            session()->flash(
                'error',
                'Learning Program sessions can only be cancelled at least 6 hours before the scheduled session.'
            );

            return back();
            }
            }

            // 🔹 Calculate differences
            $hoursBefore = $nowUtc->diffInHours($classStartUtc, false);
            $minutesSinceBooking = $bookingCreatedUtc->diffInMinutes($nowUtc, false);

            Log::info("Hours before class: {$hoursBefore}, Minutes since booking: {$minutesSinceBooking}");

            // 🔹 Refund policy definition
            // Key structure:
            //   - 'within_booking_minutes' handles 30-min special case
            //   - 'hours_before' handles standard policy tiers
            $refundPolicy = [
                'within_booking_minutes' => [
                    'threshold' => 30,   // 30 minutes since booking
                    'refund' => 100      // Full refund
                ],
                'hours_before' => [
                    24 => 100,   // More than 24 hours → full refund
                    6  => 50,    // 6–24 hours → 50%
                    0  => 0      // Less than 6 hours → no refund
                ]
            ];

            // 🔹 Determine refund percentage
            $refundPercent = 0;

            // Case 1: Cancelled within 30 minutes of booking
            if ($minutesSinceBooking <= $refundPolicy['within_booking_minutes']['threshold']) {
                $refundPercent = $refundPolicy['within_booking_minutes']['refund'];
                Log::info("Full refund due to 30-minute cancellation window.");
            }
            // Case 2: Based on hours before class
            else {
                foreach ($refundPolicy['hours_before'] as $hours => $percent) {
                    if ($hoursBefore >= $hours) {
                        $refundPercent = $percent;
                        break;
                    }
                }
            }

            Log::info("Applicable refund percentage", [$refundPercent]);

            // 🔹 Find payment info
            $payment = Payments::where('booking_id', $booking->id)->first();

            // 🔹 Process refund if applicable
            if ($payment && $refundPercent > 0) {
                \Stripe\Stripe::setApiKey($paymentKey);

                $refundAmount = ($payment->amount * ($refundPercent / 100));
                $stripeAmount = (int)($refundAmount * 100); // Stripe uses cents

                $refundResponse = \Stripe\Refund::create([
                    'charge' => $payment->txn_id,
                    'amount' => $stripeAmount,
                    'metadata' => ['order_id' => $payment->booking_id],
                ]);

                Payments::where('booking_id', $booking->id)->update([
                    'refund_response' => json_encode($refundResponse),
                    'refund_id' => $refundResponse->id ?? null,
                    'refund_type' => (string)$refundPercent,
                    'refund_amount' => $refundAmount,
                    'refund_status' => 'S'
                ]);

                Log::info("Refund processed", [
                    'refund_percent' => $refundPercent,
                    'refund_amount' => $refundAmount,
                ]);
            }

            // 🔹 Tutor/Admin Earnings
            $tutorEarnings = 0;
            $adminCommission = 0;

            if ($refundPercent == 100) {
                // Full refund → no earnings
                $tutorEarnings = 0;
                $adminCommission = 0;
            } elseif ($refundPercent > 0 && $refundPercent < 100) {
                // Partial refund → distribute retained amount
                $retainedAmount = $booking->booking_amount * ((100 - $refundPercent) / 100);
                $adminCommission = $retainedAmount * ($booking->admin_percentage / 100);
                $tutorEarnings = $retainedAmount - $adminCommission;

                $tutor = User::find($booking->tutor_id);
                if ($tutor) {
                    $tutor->increment('total_earning', $tutorEarnings);
                    $tutor->increment('total_due', $tutorEarnings);
                    $tutor->increment('total_commission', $adminCommission);
                }
            } else {
                // No refund → tutor keeps all
                $tutorEarnings = $booking->tutor_earnings;
                $adminCommission = $booking->admin_commission;

                $tutor = User::find($booking->tutor_id);
                if ($tutor) {
                    $tutor->increment('total_earning', $tutorEarnings);
                    $tutor->increment('total_due', $tutorEarnings);
                    $tutor->increment('total_commission', $adminCommission);
                }
            }

            // 🔹 Update booking
            $booking->update([
                'booking_status' => 'C',
                'cancelled_by' => 'S',
                'cancelled_on' => now('UTC'),
                'tutor_earnings' => $tutorEarnings,
                'admin_commission' => $adminCommission,
            ]);

            // 🔹 Free up tutor slot
            Tutor_calander_availability::where([
                'tutor_id' => $booking->tutor_id,
                'date' => $booking->booking_date,
            ])
                ->where('start_time', '>=', $booking->from_time)
                ->where('end_time', '<=', $booking->to_time)
                ->update(['booking_status' => 'NB']);

            // 🔹 Update tutor payment status
            TutorPayment::where('booking_id', $booking->id)
                ->update([
                    'booking_status' => 2

                ]);

            // 🔹 Send cancellation email
            try {
                $this->sendCancelBookingMail($booking->booking_no);
            } catch (\Exception $e) {
                Log::error("Failed to send cancellation email", [
                    'booking_no' => $booking->booking_no,
                    'error' => $e->getMessage(),
                ]);
            }

            // If academic program booking, reset session
            if ($booking->is_academic_program) {

            $session = AcademicProgramSession::where('student_class_booking_id', $booking->id)->first();

            if ($session) {
                AcademicProgramSessionLog::create([
                    'session_id'     => $session->id,
                    'tutor_id'       => $session->tutor_id,
                    'action'         => 'CANCELLED',
                    'action_by'      => Auth::id(),
                    'action_at'      => now()->utc(),
                    'scheduled_date' => $session->scheduled_at,
                    'start_time'     => $session->start_time,
                    'end_time'       => $session->end_time,
                    'reason'         => 'Booking cancelled by Student',
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

            session()->flash("success", "Booking cancelled successfully. Refund processed as per policy.");
            return back();
        } catch (\Exception $e) {
            Log::error("Error in cancelBookedClass", [
                'booking_no' => $bookingNo,
                'error' => $e->getMessage(),
            ]);
            session()->flash("error", "Something went wrong: " . $e->getMessage());
            return back();
        }
    }



    public function viewDetails($bookingNo)
    {
        $timezone = Auth::user()->timezone_id ?? 'UTC';

        $bookingDataInformation = StudentClassBooking::with([
            'getStudent',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade',
            'getTutor.getTutorShipPlan',
            'getSubjectTopics',
            'getTopicDetails',
            'academicProgramPurchase.academicProgram.grade',
            'academicProgramPurchase.academicProgram.branch'
        ])->where(['booking_no' => $bookingNo])->first();
        // dd($bookingDataInformation);


        if ($bookingDataInformation) {

            $bookingDataInformation->booking_date_user = Carbon::parse($bookingDataInformation->booking_date, 'UTC')
                ->setTimezone($timezone)
                ->format('Y-m-d'); // or include time if needed


            // Convert booking times to user's timezone
            $bookingDataInformation->from_time_user = Carbon::parse($bookingDataInformation->from_time, 'UTC')
                ->setTimezone($timezone)->format('H:i:s');

            $bookingDataInformation->to_time_user = Carbon::parse($bookingDataInformation->to_time, 'UTC')
                ->setTimezone($timezone)->format('H:i:s');
        }

        $data['bookingDataInformation'] = $bookingDataInformation;
        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')
            ->pluck('disable_booking_date')->toArray();

        if ($bookingDataInformation && Auth::user()->id == $bookingDataInformation->student_id) {
            // dd($bookingDataInformation->getTutor);
            // Fetch availability and convert to student's timezone
            /* $data['t_my_av_show'] = MyAvailability::where([
                'teacher_id' => $bookingDataInformation->tutor_id,
                'status' => 'A'
            ])->get()->map(function ($slot) use ($timezone) {

                $dayIndex = (int) $slot->day;
                $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

                $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
                $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

                if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                    $toUtc->addDay();
                }

                $slot->from_time_student = $fromUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');
                $slot->to_time_student = $toUtc->copy()->setTimezone($timezone)->format('Y-m-d H:i');

                return $slot;
            }); */

            $studentTimezone = @Auth::user()->timezone_id ?? 'UTC';
            $data['t_my_av_show'] = MyAvailability::where([
                'teacher_id' => $bookingDataInformation->tutor_id,
                'status'     => 'A'
            ])
                ->get()
                ->map(function ($slot) use ($studentTimezone) {

                    $dayIndex = (int) $slot->day; // 1 = Monday
                    $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex - 1); // adjust because addDays(1) means Tuesday

                    $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
                    $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

                    if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                        $toUtc->addDay();
                    }

                    $slot->from_time_student = $fromUtc->copy()->setTimezone($studentTimezone)->format('H:i');
                    $slot->to_time_student   = $toUtc->copy()->setTimezone($studentTimezone)->format('H:i');

                    return $slot;
                })
                ->sortBy(function ($slot) {
                    return [$slot->day, $slot->from_time_student]; // sorting by day and start time
                })
                ->groupBy('day');

            // Add timezone-aware now
            $data['now'] = Carbon::now('UTC')->setTimezone($timezone);

            $data['todayDayIndex'] = Carbon::now($timezone)->dayOfWeekIso;

            $data['dayNames'] = config('sessionsettings.dayNames');
            $data['shortDayNames'] = config('sessionsettings.shortDayNames');
            // dd($data['shortDayNames'], $data['t_my_av_show']);

            return view('student.modules.my_classes.view_student_class')->with($data);
        }

        session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
        return redirect()->back();
    }

    public function viewDetailsPaymentInfo($bookingNo)
    {
        $timezone = Auth::user()->timezone_id ?? 'UTC';
        $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getTutor.getTutorShipPlan', 'getPaymentsInfo', 'getSubjectTopics'])->where(['booking_no' => $bookingNo])->first();
        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status', 'A')->pluck('disable_booking_date')->toArray();
        if (@$data['bookingDataInformation']) {
            if (@Auth::user()->id == $data['bookingDataInformation']->student_id) {
                if (@$data['bookingDataInformation']) {
                    $data['t_my_av_show'] = MyAvailability::where(['teacher_id' => $data['bookingDataInformation']->tutor_id, 'status' => 'A'])->get();
                }

                $studentTimezone = @Auth::user()->timezone_id ?? 'UTC';
                $data['t_my_av_show'] = MyAvailability::where([
                    'teacher_id' => $data['bookingDataInformation']->tutor_id,
                    'status'     => 'A'
                ])
                    ->get()
                    ->map(function ($slot) use ($studentTimezone) {

                        $dayIndex = (int) $slot->day; // 1 = Monday
                        $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex - 1); // adjust because addDays(1) means Tuesday

                        $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
                        $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

                        if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                            $toUtc->addDay();
                        }

                        $slot->from_time_student = $fromUtc->copy()->setTimezone($studentTimezone)->format('H:i');
                        $slot->to_time_student   = $toUtc->copy()->setTimezone($studentTimezone)->format('H:i');

                        return $slot;
                    })
                    ->sortBy(function ($slot) {
                        return [$slot->day, $slot->from_time_student]; // sorting by day and start time
                    })
                    ->groupBy('day');

                // Add timezone-aware now
                $data['now'] = Carbon::now('UTC')->setTimezone($timezone);

                $data['todayDayIndex'] = Carbon::now($timezone)->dayOfWeekIso;

                $data['dayNames'] = config('sessionsettings.dayNames');
                $data['shortDayNames'] = config('sessionsettings.shortDayNames');

                return view('student.modules.student_my_payments.student_my_payments_payment_details')->with($data);
            } else {
                session()->flash("error", "You are trying to see the booking details which is not associated with your account!");
                return redirect()->back();
            }
        } else {
            session()->flash("error", "Booking details which is not associated with your account!");
            return redirect()->back();
        }
    }
}
