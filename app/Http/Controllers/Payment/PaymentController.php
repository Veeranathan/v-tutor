<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\StudentClassBooking;
use App\Models\Payments;
use App\Models\Promotion;
use App\Models\PromoCodeUsage;
use App\Models\User;
use App\Models\Tutor_calander_availability;
use App\Models\UserToFavourite;
use App\Models\MyAvailability;
use App\Services\ZoomService;
use App\Models\ZoomUser;
use App\Models\TutorPayment;


use Validator;
#stripe
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Auth;
use Mail;
use DB;
use App\Mail\StudentClassBookingMail;
use App\Mail\TutorClassBookingMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Mail\CancelBookingMail;
use Illuminate\Support\Carbon;
use App\Models\TokenModel;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp;
use App\Services\DailyService;

class PaymentController extends Controller
{

    public function createCheckoutSession(Request $request)
    {
        // Log::info("Creating Stripe Checkout Session", [
        //     'order_no' => $request->order_no,
        //     'amount' => $request->amount,
        //     'email' => $request->email
        // ]);
        \Stripe\Stripe::setApiKey(config('services.stripe.stripe-secret'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => 'Booking: ' . $request->order_no,
                    ],
                    'unit_amount' => $request->amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $request->email,
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}&orderId=' . $request->orderId,
            'cancel_url' => route('payment.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

   public function success(Request $request)
{
    try {
        \Stripe\Stripe::setApiKey(config('services.stripe.stripe-secret'));

        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect()->route('my.profile')->with('error', 'Invalid payment session.');
        }

        // Retrieve Stripe session and PaymentIntent
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
        $paymentIntent = \Stripe\PaymentIntent::retrieve(
            $session->payment_intent,
            ['expand' => ['charges']]
        );

        $charge = $paymentIntent->charges->data[0] ?? null;

        if (!$charge && isset($paymentIntent->latest_charge)) {
            $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
        }

        if (!$charge) {
            Log::error("Unable to retrieve charge");
            return redirect()->route('my.profile')->with('error', 'Payment verification failed.');
        }

        // Update Payments
        Payments::where(['booking_id' => $request->orderId])->update([
            'status' => 'S',
            'response' => json_encode($charge),
            'txn_id' => $charge->id ?? null,
        ]);

        // Update Booking status
        StudentClassBooking::where(['id' => $request->orderId])->update([
            'booking_status' => 'B'
        ]);

        // Fetch booking info
        $bookingInfo = StudentClassBooking::where(['id' => $request->orderId])->first();

        /* --------------------------------------------------------------------
            SAVE PROMO CODE USAGE (ALL PROMO TYPES: 0%, 25%, 50%, 75%, 100%)
        ---------------------------------------------------------------------*/
        if (!empty($bookingInfo->discount_code)) {

            $promo = Promotion::where('discount_code', $bookingInfo->discount_code)->first();

            if ($promo) {

                // Ensure promo is saved only once for this tutor/student
                $exists = PromoCodeUsage::where('promo_code_id', $promo->id)
                    ->where('student_id', $bookingInfo->student_id)
                    ->where('tutor_id', $bookingInfo->tutor_id)
                    ->first();

                if (!$exists) {
                    PromoCodeUsage::create([
                        'promo_code_id' => $promo->id,
                        'booking_id'    => $bookingInfo->id,
                        'student_id'    => $bookingInfo->student_id,
                        'tutor_id'      => $bookingInfo->tutor_id,
                        'used_at'       => now(),
                        'status'        => 'booked',
                    ]);

                    Log::info("Promo usage saved", [
                        'promo' => $promo->discount_code,
                        'booking' => $bookingInfo->id
                    ]);
                }
            }
        }

        /* --------------------------------------------------------------------
            INSERT TUTOR PAYMENT ENTRY
        ---------------------------------------------------------------------*/
        try {
            TutorPayment::create([
                'booking_id'        => $bookingInfo->id,
                'tutor_id'          => $bookingInfo->tutor_id,
                'commission_amount' => $bookingInfo->admin_commission,
                'tutor_amount'      => $bookingInfo->tutor_earnings,
                'booking_status'    => 1,
                'payment_status'    => 0,
            ]);
        } catch (\Exception $e) {
            Log::error("TutorPayment insert failed: ".$e->getMessage());
        }

        /* --------------------------------------------------------------------
            TIMEZONE CONVERSION
        ---------------------------------------------------------------------*/
        $studentTimezone = $bookingInfo->timezone_id ?? 'Australia/Sydney';

        $fromUTC = Carbon::parse("{$bookingInfo->booking_date} {$bookingInfo->from_time}", 'UTC');
        $toUTC   = Carbon::parse("{$bookingInfo->booking_date} {$bookingInfo->to_time}", 'UTC');

        $bookingInfo->from_time_user  = $fromUTC->copy()->setTimezone($studentTimezone)->format('H:i:s');
        $bookingInfo->to_time_user    = $toUTC->copy()->setTimezone($studentTimezone)->format('H:i:s');
        $bookingInfo->booking_date_user = $fromUTC->copy()->setTimezone($studentTimezone)->format('Y-m-d');

        $localStart = Carbon::createFromFormat('Y-m-d H:i:s', "{$bookingInfo->booking_date_user} {$bookingInfo->from_time_user}", $studentTimezone);
        $localEnd   = Carbon::createFromFormat('Y-m-d H:i:s', "{$bookingInfo->booking_date_user} {$bookingInfo->to_time_user}", $studentTimezone);

        $utcStart = $localStart->clone()->setTimezone('UTC');
        $utcEnd   = $localEnd->clone()->setTimezone('UTC');

        if ($utcEnd->lt($utcStart)) {
            $utcEnd->addDay();
        }

        $startDate = $utcStart->toDateString();
        $startTime = $utcStart->toTimeString();
        $endTime   = $utcEnd->toTimeString();

        /* --------------------------------------------------------------------
            UPDATE TUTOR AVAILABILITY
        ---------------------------------------------------------------------*/
        Tutor_calander_availability::where('tutor_id', $bookingInfo->tutor_id)
            ->where('booking_status', 'NB')
            ->where('date', $startDate)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->update(['booking_status' => 'B']);

        /* --------------------------------------------------------------------
            ZOOM MEETING CREATION
        ---------------------------------------------------------------------*/
        // $zoomUser = ZoomUser::where('tutor_id', $bookingInfo->tutor_id)->first();

        // if ($zoomUser) {
        //     $payload = [
        //         "topic" => "Meeting for " . $bookingInfo->booking_no,
        //         "type" => 2,
        //         "timezone" => $studentTimezone,
        //         "start_time" => $localStart->format('Y-m-d\TH:i:s'),
        //         "duration" => $localEnd->diffInMinutes($localStart),
        //         "password" => "123456",
        //         "use_pmi" => true,
        //     ];

        //     $zoomData = app(ZoomService::class)->createMeetingForUser($zoomUser->zoom_user_id, $payload);

        //     StudentClassBooking::where('id', $bookingInfo->id)->update([
        //         'start_url' => $zoomData['start_url'] ?? null,
        //         'join_url'  => $zoomData['join_url'] ?? null,
        //         'total_responce' => json_encode($zoomData)
        //     ]);
        // }

        /* --------------------------------------------------------------------
        DAILY MEETING CREATION
        ---------------------------------------------------------------------*/

        $dailyService = app(DailyService::class);

        $roomName = "session-" . $bookingInfo->booking_no;

        // Create private room
        $room = $dailyService->createRoom($roomName);

        $tutor = User::find($bookingInfo->tutor_id);
        $student = User::find($bookingInfo->student_id);

        $tokenExpiry = $utcEnd->timestamp + 3600;

        $tutorToken = $dailyService->generateToken($roomName, $tutor->full_name . " (Tutor)", true, $tokenExpiry);

        $studentToken = $dailyService->generateToken($roomName, $student->full_name . " (Student)", false, $tokenExpiry);

        // Secure URLs
        $tutorUrl = $room['url'] . '?t=' . $tutorToken['token'];
        $studentUrl = $room['url'] . '?t=' . $studentToken['token'];

        StudentClassBooking::where('id', $bookingInfo->id)->update(['start_url' => $tutorUrl, 'join_url'  => $studentUrl, 'total_responce' => json_encode($room)]);
        /* --------------------------------------------------------------------
            SEND EMAIL
        ---------------------------------------------------------------------*/
        $this->sendBookingMail($bookingInfo->booking_no);

        return redirect()->route('student.booking.confirmation', $request->orderId);

    } catch (\Exception $e) {
        Log::error("Success error: ".$e->getMessage());
        session()->flash("error", $e->getMessage());
        return redirect()->route('my.profile');
    }
}

    // public function success(Request $request)
    // {
    //     \Stripe\Stripe::setApiKey(config('services.stripe.stripe-secret'));
    //     // Log::info("Stripe Payment Success", [
    //     //     'orderId' => $request->orderId,
    //     //     'session_id' => $request->get('session_id')
    //     // ]);

    //     // Get the Checkout Session ID
    //     $sessionId = $request->get('session_id');

    //     if (!$sessionId) {
    //         return redirect()->route('my.profile')->with('error', 'Invalid payment session.');
    //     }

    //     // Retrieve session
    //     $session = \Stripe\Checkout\Session::retrieve($sessionId);

    //     // Retrieve PaymentIntent and expand charges
    //     $paymentIntent = \Stripe\PaymentIntent::retrieve(
    //         $session->payment_intent,
    //         ['expand' => ['charges']]
    //     );

    //     // Try to get charge from expanded data
    //     $charge = $paymentIntent->charges->data[0] ?? null;

    //     // Fallback: retrieve charge via latest_charge if data is empty
    //     if (!$charge && isset($paymentIntent->latest_charge)) {
    //         $charge = \Stripe\Charge::retrieve($paymentIntent->latest_charge);
    //     }

    //     if (!$charge) {
    //         Log::error("Unable to retrieve charge for PaymentIntent", ['payment_intent' => $paymentIntent->id]);
    //         return redirect()->route('my.profile')->with('error', 'Payment could not be verified.');
    //     }

    //     // Now safe to log and update DB
    //     // Log::info("Stripe Charge Details", [
    //     //     'charge_id' => $charge->id,
    //     //     'amount' => $charge->amount,
    //     //     'currency' => $charge->currency,
    //     //     'status' => $charge->status,
    //     //     'payment_method' => $charge->payment_method_details->type ?? null
    //     // ]);

    //     Payments::where(['booking_id' => $request->orderId])->update([
    //         'status' => 'S',
    //         'response' => json_encode($charge),
    //         'txn_id' => $charge->id ?? null,
    //     ]);

    //     StudentClassBooking::where(['id' => $request->orderId])->update([
    //         'booking_status' => 'B'
    //     ]);



    //     // Update tutor availability
    //     $bookingInfo = StudentClassBooking::where(['id' => $request->orderId])->first();

    //     $bookingStart = Carbon::parse("{$bookingInfo->booking_date_user} {$bookingInfo->from_time}", $bookingInfo->timezone)
    //         ->setTimezone('UTC'); // Convert to UTC for DB
    //     $bookingEnd = Carbon::parse("{$bookingInfo->booking_date_user} {$bookingInfo->to_time}", $bookingInfo->timezone)
    //         ->setTimezone('UTC');

    //     Log::info("Booking Start", [$bookingStart]);
    //     Log::info("Booking End", [$bookingEnd]);

    //     $query = Tutor_calander_availability::where('tutor_id', $bookingInfo->tutor_id)
    //         ->where('booking_status', 'NB')
    //         ->whereRaw("TIMESTAMP(date, start_time) >= ?", [$bookingStart->toDateTimeString()])
    //         ->whereRaw("TIMESTAMP(date, end_time) <= ?", [$bookingEnd->toDateTimeString()]);

    //     // Get SQL and bindings
    //     $sql = $query->toSql();
    //     $bindings = $query->getBindings();

    //     // Replace ? placeholders with bindings manually
    //     foreach ($bindings as $binding) {
    //         $value = is_numeric($binding) ? $binding : "'$binding'";
    //         $sql = preg_replace('/\?/', $value, $sql, 1);
    //     }

    //     Log::info("Booking update query: $sql");

    //     // Execute update
    //     $affected = $query->update(['booking_status' => 'B']);
    //     Log::info("Rows updated: $affected");



    //     // Tutor_calander_availability::where([
    //     //     'tutor_id' => $bookingInfo->tutor_id,
    //     //     'booking_status' => 'NB',
    //     //     'date' => $bookingInfo->booking_date_user
    //     // ])->where('start_time', '>=', $bookingInfo->from_time)
    //     //     ->where(function ($query) use ($bookingInfo) {
    //     //         $query->whereBetween('end_time', [$bookingInfo->from_time, $bookingInfo->to_time]);
    //     //     })
    //     //     ->update(['booking_status' => 'B']);
    //     // $this->createMeeting($bookingInfo->id);
    //     $BookingDetails = StudentClassBooking::where('id', $bookingInfo->id)->first();
    //     $zoomUser = ZoomUser::where('tutor_id', $bookingInfo->tutor_id)->first();
    //     //  Log::info("tutor Zoom user id",[$zoomUser->id]);
    //     if (!$zoomUser || !$zoomUser->pmi) {
    //         throw new \RuntimeException("No PMI found for this user.");
    //     }

    //     // Format start time
    //     $startTime = "{$BookingDetails->booking_date}T{$BookingDetails->from_time}:00";
    //     $timezone = $user->getTimezone->city ?? "Australia/Sydney";

    //     $payload = [
    //         "topic" => "Meeting for " . @$BookingDetails->booking_no,
    //         "type" => 2, // Scheduled
    //         "timezone" => $timezone,
    //         "start_time" => $startTime,
    //         "duration" => 30,
    //         "password" => "123456",
    //         "use_pmi" => true, // ✅ force PMI usage
    //         "settings" => [
    //             "host_video" => true,
    //             "participant_video" => true,
    //             "waiting_room" => true,
    //             "join_before_host" => false,
    //             "mute_upon_entry" => true,
    //             "audio" => "voip",
    //             "auto_recording" => "cloud"
    //         ],
    //         "tracking_fields" => [
    //             [
    //                 "field" => "booking_id",
    //                 "value" => @$BookingDetails->id
    //             ]
    //         ]
    //     ];

    //     Log::info("Zoom User PMI", [$zoomUser->pmi]);
    //     // Create meeting with PMI
    //     $data = app(ZoomService::class)->createMeetingForUser($zoomUser->zoom_user_id, $payload);
    //     Log::info("Meeting Link", [$data]);
    //     StudentClassBooking::where('id', $bookingInfo->id)->update([
    //         'start_url' => $data['start_url'] ?? null,
    //         'join_url'  => $data['join_url'] ?? null,
    //         'total_responce' => json_encode($data)
    //     ]);
    //     // Log::info("Booking updated successfully", [
    //     //     'booking_id' => $bookingInfo->id,
    //     //     'tutor_id' => $bookingInfo->tutor_id,
    //     //     'status' => 'B'
    //     // ]);
    //     // Send booking mail
    //     $this->sendBookingMail($bookingInfo->booking_no);
    //     return redirect()->route('student.booking.confirmation', $request->orderId);
    // }

    public function cancel()
    {
        return view('payment.cancel'); // A payment failed or cancelled page
    }




    public function viewPaymentPage(Request $request)
    {
        return view('payment.view_payment_page');
    }

    public function init(Request $request)
{
    try {

        Log::info("📝 [Init Request Received]", $request->all());

        if (!$request->track) {
            session()->flash("error", "Invalid booking reference!");
            return redirect()->route('search.result.j');
        }

        // -------------------------------
        // 1️⃣ DECRYPT BOOKING ID
        // -------------------------------
        try {
            $bookingId = decrypt($request->track);
        } catch (\Exception $e) {
            Log::error("❌ Track decrypt failed: " . $e->getMessage());
            session()->flash("error", "Invalid booking reference!");
            return redirect()->route('search.result.j');
        }

        Log::info("🔓 Decrypted Booking ID: " . $bookingId);

        // -------------------------------
        // 2️⃣ FETCH BOOKING BY ID
        // -------------------------------
        $booking = StudentClassBooking::with([
            'getStudent',
            'getTutor.languguageToTuor',
            'getTutor.getTutorAcademic',
            'getSubject',
            'getStudentGrade'
        ])
            ->where('id', $bookingId)
            ->whereIn('booking_status', ['IC', 'F']) // Allowed statuses
            ->first();

        if (!$booking) {
            Log::warning("⚠️ No booking found for ID: $bookingId");
            session()->flash("error", "Booking not found!");
            return redirect()->route('search.result.j');
        }

        // -------------------------------
        // 3️⃣ CHECK BOOKING OWNERSHIP
        // -------------------------------
        if ($booking->student_id != Auth::id()) {
            Log::warning("⚠️ Unauthorized access attempt", [
                'booking_student' => $booking->student_id,
                'logged_user' => Auth::id()
            ]);

            abort(403, "Unauthorized access");
        }

        // -------------------------------
        // 4️⃣ CONVERT TIMES TO STUDENT TZ
        // -------------------------------
        $timezone = Auth::user()->timezone_id ?? 'UTC';

        $booking->from_time_user = Carbon::parse("{$booking->booking_date} {$booking->from_time}", 'UTC')
            ->setTimezone($timezone)->format('H:i:s');

        $booking->to_time_user = Carbon::parse("{$booking->booking_date} {$booking->to_time}", 'UTC')
            ->setTimezone($timezone)->format('H:i:s');

        $booking->booking_date_user = Carbon::parse($booking->booking_date, 'UTC')
            ->setTimezone($timezone)->format('Y-m-d');

        // -------------------------------
        // 5️⃣ 15 MINUTE BOOKING WINDOW
        // -------------------------------
        $bookingCreatedUserTZ = Carbon::parse($booking->created_at)->setTimezone($timezone);
        $cutoff = $bookingCreatedUserTZ->clone()->addMinutes(15);
        $now = Carbon::now($timezone);

        if ($now->gt($cutoff)) {
            session()->flash("error", "Your 15-minute booking window expired. Please book again.");

            $tutor = $booking->getTutor;
            if ($tutor) {
                return Redirect::to(url('studentbook-class?search_tutor_nm_studentclass='
                    . $tutor->f_name . ' ' . $tutor->l_name
                    . '&search_tutor_id_studentclass=' . $tutor->id
                    . '&search_tutor_selected_name_studentclass=' . $tutor->f_name . ' ' . $tutor->l_name
                    . '&search_tutor_slug_studentclass=' . $tutor->slug
                    . '&book_subject=' . session('book_subject')));
            }
        }

        // -------------------------------
        // 6️⃣ SEND TO PAYMENT PAGE
        // -------------------------------
        $data['orderEncryptId'] = $request->track;
        $data['bookingDataInformation'] = $booking;

        Log::info("✅ Init completed successfully");

        return view('payment.init_payment')->with($data);

    } catch (\Exception $e) {
        Log::error("❌ [Init Error] " . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        session()->flash("error", "An unexpected error occurred: " . $e->getMessage());
        return redirect()->route('search.result.j');
    }
}


    public function checkPromocode(Request $request)
{
    try {
        if (!$request->promo_code) {
            return response()->json(['status' => 0, 'msg_code' => 4, 'discount' => 0]);
        }

        $promoCode = trim($request->promo_code);
        $promo = Promotion::where('discount_code', $promoCode)
                          ->where('status', 1)
                          ->first();

        if (!$promo) {
            return response()->json(['status' => 0, 'msg_code' => 3, 'discount' => 0]);
        }

        // DATE CHECK (CORRECTED)
        $today = Carbon::now()->format('Y-m-d');
        $start = Carbon::parse($promo->start_date)->format('Y-m-d');
        $end   = Carbon::parse($promo->end_date)->format('Y-m-d');

        if ($today < $start || $today > $end) {
            return response()->json(['status' => 0, 'msg_code' => 2, 'discount' => 0]);
        }

        if (!$request->booking_id || !$request->tot) {
            return response()->json(['status' => 0, 'msg_code' => 5, 'discount' => 0]);
        }

        $booking = StudentClassBooking::find($request->booking_id);
        if (!$booking) {
            return response()->json(['status' => 0, 'msg_code' => 5, 'discount' => 0]);
        }

        $tutor = User::find($booking->tutor_id);

        if (!$tutor || $tutor->free_trial != 1) {
        return response()->json([
        'status' => 0,
        'msg_code' => 8, // tutor not eligible
        'discount' => 0
        ]);
        }

        // One tutor → one promo use
      $alreadyUsed = PromoCodeUsage::where('promo_code_id', $promo->id)
    ->where('student_id', $booking->student_id)
    ->where('tutor_id', $booking->tutor_id)
    ->exists();

        if ($alreadyUsed) {
            return response()->json(['status' => 0, 'msg_code' => 7, 'discount' => 0]);
        }

        // APPLY DISCOUNT
        $tot = (float)$request->tot;
        $percent = (float)$promo->discount;
        $discountAmount = round($tot * ($percent / 100), 2);
        $netTotal = round($tot - $discountAmount, 2);

        $booking->discount_amount = $discountAmount;
        $booking->net_total = $netTotal;
        $booking->discount_percentage = $promo->discount;
        $booking->discount_code = $promo->discount_code;
        $booking->save();

        return response()->json([
            'status'   => 1,
            'msg_code' => 1,
            'discount' => $promo->discount
        ]);

    } catch (\Exception $e) {
        Log::error("Promo check error: ".$e->getMessage());
        return response()->json(['status' => 0, 'msg_code' => 6, 'discount' => 0]);
    }
}



// ---------------------------------------------------
// FREE BOOKING (100% PROMO)
// ---------------------------------------------------
public function freeBooking(Request $request)
{
    try {
        $bookingId = $request->booking_id;
        $promoCode = $request->promo_code;

        $booking = StudentClassBooking::find($bookingId);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        $tutor = User::find($booking->tutor_id);

if (!$tutor || $tutor->free_trial != 1) {
    return response()->json([
        'status' => 0,
        'msg_code' => 8,  // tutor not eligible
        'error' => 'Tutor is not eligible for free booking'
    ]);
}
        $promo = Promotion::where('discount_code', $promoCode)
                          ->where('status', 1)
                          ->first();

        if (!$promo) {
            return response()->json(['error' => 'Promo not found'], 404);
        }

        // Date validation
        $today = Carbon::now()->format('Y-m-d');
        $start = Carbon::parse($promo->start_date)->format('Y-m-d');
        $end   = Carbon::parse($promo->end_date)->format('Y-m-d');

        if ($today < $start || $today > $end) {
            return response()->json(['error' => 'Promo not active'], 400);
        }

        // Must be 100%
        if ((float)$promo->discount != 100) {
            return response()->json(['error' => 'Promo is not 100%'], 400);
        }

        // Check already used
       $alreadyUsed = PromoCodeUsage::where('promo_code_id', $promo->id)
    ->where('student_id', $booking->student_id)
    ->where('tutor_id', $booking->tutor_id)
    ->exists();

        if ($alreadyUsed) {
            return response()->json(['status' => 0, 'msg_code' => 7]);
        }

        // MARK BOOKING AS FREE
        $booking->booking_status = 'B';
        $booking->net_total = 0;
        $booking->discount_percentage = 100;
        $booking->discount_amount = $booking->booking_amount;
        $booking->discount_code = $promoCode;
        $booking->save();

        // SAVE PROMO USAGE
        PromoCodeUsage::create([
            'promo_code_id' => $promo->id,
            'booking_id'    => $booking->id,
            'student_id'    => $booking->student_id,
            'tutor_id'      => $booking->tutor_id,
            'used_at'       => now(),
            'status'        => 'booked'
        ]);

        // Run success flow (Zoom, email, availability update)
        $this->successActionsAfterPayment($booking->id);

        return response()->json([
            'redirect' => route('student.booking.confirmation', $booking->id)
        ]);

    } catch (\Exception $e) {
        Log::error("Free booking error: ".$e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

private function successActionsAfterPayment($orderId)
{
    // Copy EVERYTHING from success() AFTER booking is marked booked.
    // EXCLUDE stripe-specific code.
    // INCLUDE:
    // - update tutor availability
    // - insert tutor payment
    // - create Zoom meeting
    // - update booking with zoom links
    // - send email
}



    // public function init(Request $request)
    // {
    //     try {

    //         $data['orderEncryptId'] = $request->track;
    //         $bookingid = decrypt($request->track);
    //         // $bookingDataInformation = $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade'])->where(['id'=>$bookingid])->whereIn('booking_status',['IC','F'])->first();

    //         $timezone = Auth::user()->timezone_id ?? config('app.timezone');

    //         $bookingDataInformation = $data['bookingDataInformation'] = StudentClassBooking::with([
    //             'getStudent',
    //             'getTutor.languguageToTuor',
    //             'getTutor.getTutorAcademic',
    //             'getSubject',
    //             'getStudentGrade'
    //         ])
    //             ->whereIn('booking_status', ['IC', 'F'])
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if ($bookingDataInformation) {
    //             $bookingDataInformation->from_time_user = Carbon::parse($bookingDataInformation->from_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
    //             $bookingDataInformation->to_time_user = Carbon::parse($bookingDataInformation->to_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
    //         }

    //         //  Log::info("message", [$bookingDataInformation]);
    //         //exit;

    //         // dd($data['bookingDataInformation']);
    //         if (@$bookingDataInformation) {
    //             if (@$bookingDataInformation->booking_amount <= 0) {
    //                 session()->flash("error", "Booking amount cannot be zero!");
    //                 return redirect()->back();
    //             }
    //             $bookingInfo = StudentClassBooking::where(['id' => $bookingDataInformation->id])->first();

    //             $chkADtFrmTimeToTime = Tutor_calander_availability::where(['tutor_id' => $bookingInfo->tutor_id, 'booking_status' => 'NB', 'date' => $bookingInfo->booking_date_user])->where('start_time', '>=', $bookingInfo->from_time)->where('end_time', '<=', $bookingInfo->to_time)->count();

    //             if ($chkADtFrmTimeToTime <= 0) {

    //                 session()->flash("error", "3 Choose available time slot!Tutor is not available!");
    //                 return redirect()->back();
    //             }
    //             $chkBDtFrmTimeToTime = StudentClassBooking::where(['student_id' => @Auth::user()->id, 'booking_date' => $bookingInfo->booking_date_user])->whereIn('booking_status', ['B'])->where('from_time', '>=', $bookingInfo->from_time);
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function ($query) use ($bookingInfo) {
    //                 $query->whereBetween('to_time', [$bookingInfo->from_time, $bookingInfo->to_time]);
    //             });
    //             $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();

    //             if ($chkBDtFrmTimeToTime > 0) {
    //                 session()->flash("error", "You have already booked other tutor with same date and time!");
    //                 return redirect()->back();
    //             }
    //             $studentTimezone = Auth::user()->timezone_id ?? 'UTC';

    //             $data['t_my_av_show'] = MyAvailability::where(['teacher_id' => $data['bookingDataInformation']->tutor_id, 'status' => 'A'])->get()->map(function ($slot) use ($studentTimezone) {

    //                 // You must build full datetime in UTC first
    //                 $dayIndex = (int) $slot->day; // 1 = Monday
    //                 $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

    //                 $fromUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->from_time, 'UTC');
    //                 $toUtc = Carbon::createFromFormat('Y-m-d H:i:s', $baseDate->toDateString() . ' ' . $slot->to_time, 'UTC');

    //                 // Handle overnight times (e.g., 22:00 to 02:00 next day)
    //                 if ($toUtc->lessThanOrEqualTo($fromUtc)) {
    //                     $toUtc->addDay();
    //                 }

    //                 // Convert to student's timezone
    //                 $slot->from_time_student = $fromUtc->copy()->setTimezone($studentTimezone)->format('Y-m-d H:i');
    //                 $slot->to_time_student   = $toUtc->copy()->setTimezone($studentTimezone)->format('Y-m-d H:i');

    //                 return $slot;
    //             });



    //             $bookingTime = Carbon::parse($bookingDataInformation->created_at)->setTimezone($studentTimezone);
    //             $cutoffTime = $bookingTime->copy()->addMinutes(15);
    //             $currentTime = Carbon::now($studentTimezone);
    //             // Log::info("Booking Created At: " . $bookingTime);
    //             // Log::info("Cutoff Time (15 mins later): " . $cutoffTime);
    //             // Log::info("Current Time: " . $currentTime);
    //             // Log::info("Is Booking Valid? " . ($cutoffTime > $currentTime ? 'Yes' : 'No'));

    //             if ($cutoffTime > $currentTime) {
    //                 $textMessage = " Booking order " . $bookingDataInformation->booking_no . " received. Complete booking within the next 15 minutes to confirm";

    //                 session()->flash("success", $textMessage);
    //             } else {
    //                 session()->flash("error", "Your 15 minutes time is over!Please place a booking and complete booking within the next 15 minutes to confirm");
    //                 $getUser = User::where(['id' => $bookingDataInformation->tutor_id])->first();
    //                 $to_p = url('studentbook-class?search_tutor_nm_studentclass=' . $getUser->f_name . " " . $getUser->l_name . '&search_tutor_id_studentclass=' . $getUser->id . '&search_tutor_selected_name_studentclass=' . $getUser->f_name . " " . $getUser->l_name . '&search_tutor_slug_studentclass=' . $getUser->slug . '&book_subject=' . session('book_subject'));
    //                 return Redirect::to($to_p);
    //             }
    //             // dd($bookingDataInformation);
    //             // return view('payment.init_payment')->with(['bookingDataInformation'=>$bookingDataInformation]);
    //             return view('payment.init_payment')->with($data);
    //         } else {
    //             session()->flash("error", "No booking found!");
    //             return redirect()->route('search.result.j');
    //         }
    //     } catch (\Exception $e) {
    //         // abort('401');
    //         \Log::error($e->getMessage());
    //         session()->flash("error", $e->getMessage());
    //         return redirect()->route('search.result.j');
    //     }
    // }


    public function sendBookingMail($bookingNo)
    {
        try {
            $timezone = Auth::user()->timezone_id ?? 'UTC';
            $bookingDataInformation = $data1['bookingDataInformation'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->where(['booking_no' => $bookingNo])->first();
            if ($bookingDataInformation) {
                $bookingDataInformation->booking_date = Carbon::parse($bookingDataInformation->booking_date, 'UTC')->setTimezone($timezone)->format('Y-m-d');
                $bookingDataInformation->from_time_user = Carbon::parse($bookingDataInformation->from_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
                $bookingDataInformation->to_time_user = Carbon::parse($bookingDataInformation->to_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
                $bookingDataInformation->created_at_user = Carbon::parse($bookingDataInformation->created_at, 'UTC')->setTimezone($timezone)->format('H:i:s');
            }
            $data1['mail_send_to'] = 'S';
            $data1['email'] = $data1['bookingDataInformation']['getStudent']['email'];
            Mail::send(new StudentClassBookingMail($data1));

            $booking = $data2['bookingDataInformation'] = StudentClassBooking::with(['getStudent', 'getTutor.languguageToTuor', 'getTutor.getTutorAcademic', 'getSubject', 'getStudentGrade', 'getPaymentsInfo'])->where(['booking_no' => $bookingNo])->first();
            if ($booking && $booking->getTutor) {
                $tutorTimezone = $booking->getTutor->timezone_id ?? 'UTC';

                $booking->booking_date = Carbon::parse($booking->booking_date, 'UTC')->setTimezone($tutorTimezone)->format('Y-m-d');
                $booking->from_time_user = Carbon::parse($booking->from_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
                $booking->to_time_user = Carbon::parse($booking->to_time, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
                $booking->created_at_user = Carbon::parse($booking->created_at, 'UTC')->setTimezone($tutorTimezone)->format('H:i:s');
            }
            $data2['mail_send_to'] = 'T';
            $data2['email'] = $data2['bookingDataInformation']['getTutor']['email'];
            Mail::send(new TutorClassBookingMail($data2));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            // return redirect()->route('search.result.j');
        }
    }
}
