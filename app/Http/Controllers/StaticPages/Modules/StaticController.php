<?php

namespace App\Http\Controllers\StaticPages\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use App\Models\Messages;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use App\Services\ZohoDeskClient;
use App\Models\TokenModel;
use App\Models\FaqModel;
use App\Models\HelpCategory;
use App\Models\StudentClassBooking;
use App\Models\ContentDetails;
use App\Models\TestTable;
use App\Models\Blog;
use App\Models\AcademicProgram;
use App\Models\Grade;
use App\Models\Branch;
use Illuminate\Support\Str;
use GuzzleHttp;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

class StaticController extends Controller
{

    // public function classSessionLink($userid, $id)
    // {
    //     $booking = StudentClassBooking::with(['getStudent', 'getTutor'])->where(['booking_no' => $id])->first();

    //     if (!$booking) {
    //         abort(404, 'Booking not found');
    //     }

    //     // Set timezone for user
    //     $timezone = $booking->getStudent->timezone_id ?? 'UTC';

    //     // Convert times to user's timezone
    //     $booking->from_time_user = Carbon::parse($booking->from_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
    //     $booking->to_time_user = Carbon::parse($booking->to_time, 'UTC')->setTimezone($timezone)->format('H:i:s');
    //     $booking->created_at_user = Carbon::parse($booking->created_at, 'UTC')->setTimezone($timezone)->format('H:i:s');
    //     if ($booking && $booking->getStudent) {
    //         $Timezone = $booking->getStudent->timezone_id ?? 'UTC';

    //         $booking->from_time_user = Carbon::parse($booking->from_time, 'UTC')->setTimezone($Timezone)->format('H:i:s');
    //         $booking->to_time_user = Carbon::parse($booking->to_time, 'UTC')->setTimezone($Timezone)->format('H:i:s');
    //         $booking->created_at_user = Carbon::parse($booking->created_at, 'UTC')->setTimezone($Timezone)->format('H:i:s');
    //     }
    //     if (@$booking->booking_status == 'B' && @$booking->from_time <= date('H:i:s') && @$booking->to_time >= date('H:i:s')) {
    //         return Redirect::to($booking->join_url);
    //     } elseif (@$booking->booking_status == 'B' && @$booking->from_time <= date('H:i:s', strtotime(date('H:i:s')) + (60 * 5)) && @$booking->to_time >= date('H:i:s')) {
    //         return Redirect::to($booking->join_url);
    //     }

    //     elseif (@$booking->booking_status == 'CM') {
    //         $title= "Session Completed";
    //         $msg = "Your session is completed";
    //         session()->flash("success", $msg);
    //         return view('static.modules.class_link.class_link')->with(['booking' => @$booking, 'msg' => @$msg]);
    //     } elseif (@$booking->booking_status == 'B' && @$booking->booking_date == date('Y-m-d') && @$booking->to_time <= date('H:i:s')) {
    //         $title= "Session Expired";
    //         $msg = "Your session has expired";
    //         session()->flash("success", $msg);
    //         return view('static.modules.class_link.class_link')->with(['booking' => @$booking, 'msg' => @$msg]);
    //     } elseif (@$booking->booking_status == 'B' && @$booking->booking_date != date('Y-m-d')) {
    //         $title= "Session Details";
    //         $msg = "Your session is booked for " . date('d-m-Y', strtotime(@$booking->booking_date)) . " at " . date('h:i A', strtotime(@$booking->from_time_user)) . " - " . date('h:i A', strtotime(@$booking->to_time_user)) . " " .  @$booking->getStudent->timezone_id;
    //         session()->flash("success", $msg);
    //         return view('static.modules.class_link.class_link')->with(['booking' => @$booking, 'msg' => @$msg]);
    //     } elseif (@$booking->booking_status == 'C') {
    //         $title= "Session Cancelled";
    //         $msg = "Your session was cancelled. Refer email for more details.";
    //         session()->flash("success", $msg);
    //         return view('static.modules.class_link.class_link')->with(['booking' => @$booking, 'msg' => @$msg, 'title' => @$title]);
    //     }
    //     else {
    //         $msg = "Your session is booked for " . date('d-m-Y', strtotime(@$booking->booking_date)) . " at " . date('h:i A', strtotime(@$booking->from_time_user)) . " - " . date('h:i A', strtotime(@$booking->to_time_user)) . " " .  @$booking->getStudent->timezone_id;

    //         session()->flash("success", $msg);
    //         return view('static.modules.class_link.class_link')->with(['booking' => @$booking, 'msg' => @$msg]);
    //     }
    // }

    public function classSessionLink($userid, $id)
    {
        $booking = StudentClassBooking::with(['getStudent', 'getTutor'])
            ->where('booking_no', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        // Get student's timezone (default UTC)
        $studentTimezone = $booking->getStudent->timezone_id ?? 'UTC';

        // Combine booking date + from/to times before conversion
        $fromUTC = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
        $toUTC = Carbon::parse($booking->booking_date . ' ' . $booking->to_time, 'UTC');

        // Convert to student's timezone
        $fromTimeUser = $fromUTC->copy()->setTimezone($studentTimezone);
        $toTimeUser   = $toUTC->copy()->setTimezone($studentTimezone);
        $nowStudentTime = Carbon::now('UTC')->setTimezone($studentTimezone);

        // ---------------------------
        // 1️⃣ Ongoing session
        // ---------------------------
        if (
            $booking->booking_status === 'B' &&
            $nowStudentTime->between($fromTimeUser, $toTimeUser)
        ) {
            // Track that the student clicked the join link
            if (!$booking->student_joined) {
                $booking->update([
                'student_joined' => 1,
                'student_login_at' => Carbon::now('UTC'),
                ]);
             }
           // return Redirect::to($booking->join_url);
            return view('static.modules.class_link.daily_session_link', [
                'roomUrl' => $booking->join_url,
                'booking' => $booking
            ]);
        }

        // ---------------------------
        // 2️⃣ Allow joining 5 min early
        // ---------------------------
        if (
            $booking->booking_status === 'B' &&
            $nowStudentTime->greaterThanOrEqualTo($fromTimeUser->copy()->subMinutes(5)) &&
            $nowStudentTime->lessThanOrEqualTo($toTimeUser)
        ) {
            // Track that the student clicked the join link
            if (!$booking->student_joined) {
                $booking->update([
                'student_joined' => 1,
                'student_login_at' => Carbon::now('UTC'),
                ]);
            }
            //return Redirect::to($booking->join_url);
            return view('static.modules.class_link.daily_session_link', [
                'roomUrl' => $booking->join_url,
                'booking' => $booking
            ]);
        }

        // ---------------------------
        // 3️⃣ Completed session
        // ---------------------------
        if ($booking->booking_status === 'CM') {
            $title = "Session Completed";
            $msg = "Your session is completed.";
        }

        // ---------------------------
        // 4️⃣ Expired (same day, passed end time)
        // ---------------------------
        elseif (
            $booking->booking_status === 'B' &&
            $nowStudentTime->greaterThan($toTimeUser)
        ) {
            $title = "You are Late";
            $msg = "Your session has expired.";
        }

        // ---------------------------
        // 5️⃣ Upcoming (future)
        // ---------------------------
        elseif (
            $booking->booking_status === 'B' &&
            $nowStudentTime->lt($fromTimeUser)
        ) {
            $title = "You are Early";
            $msg = "Your session is booked for " .
                $fromTimeUser->format('d-m-Y') . " between " .
                $fromTimeUser->format('h:i A') . " - " .
                $toTimeUser->format('h:i A') . " " . $studentTimezone;
        }

        // ---------------------------
        // 6️⃣ Cancelled
        // ---------------------------
        elseif ($booking->booking_status === 'C') {
            $title = "Session Cancelled";
            $msg = "Your session was cancelled. Refer email for more details.";
        }

        // ---------------------------
        // 7️⃣ Default fallback
        // ---------------------------
        else {
            $title = "Session Details";
            $msg = "Your session is booked for " .
                $fromTimeUser->format('d-m-Y') . " between " .
                $fromTimeUser->format('h:i A') . " - " .
                $toTimeUser->format('h:i A') . " " . $studentTimezone;
        }

        session()->flash("success", $msg);
        return view('static.modules.class_link.class_link', compact('booking', 'msg', 'title'));
    }


    public function tutorclassSessionLink($userid, $id)
    {
        $booking = StudentClassBooking::with(['getStudent', 'getTutor'])
            ->where('booking_no', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Booking not found');
        }

        $tutorTimezone = $booking->getTutor->timezone_id ?? 'UTC';

        // Combine booking_date + from_time / to_time before conversion
        $fromUTC = Carbon::parse($booking->booking_date . ' ' . $booking->from_time, 'UTC');
        $toUTC = Carbon::parse($booking->booking_date . ' ' . $booking->to_time, 'UTC');

        // Convert both to tutor's timezone
        $fromTimeUser = $fromUTC->copy()->setTimezone($tutorTimezone);

        $toTimeUser = $toUTC->copy()->setTimezone($tutorTimezone);
        // Current tutor local time
        $nowTutorTime = Carbon::now('UTC')->setTimezone($tutorTimezone);

        // 1. Live session ongoing
        if (
            $booking->booking_status == 'B' &&
            $nowTutorTime->between($fromTimeUser, $toTimeUser)
        ) {
            if (!$booking->tutor_login_at) {
                $booking->update([
                    'tutor_login_at' => Carbon::now('UTC'),
                ]);
            }
           // return Redirect::to($booking->start_url);
            return view('static.modules.class_link.daily_session_link', [
                'roomUrl' => $booking->start_url,
                'booking' => $booking
            ]);
        }

        // 2. Allow joining 5 minutes before
        if (
            $booking->booking_status == 'B' &&
            $nowTutorTime->greaterThanOrEqualTo($fromTimeUser->copy()->subMinutes(5)) &&
            $nowTutorTime->lessThanOrEqualTo($toTimeUser)
        ) {
            if (!$booking->tutor_login_at) {
                $booking->update([
                    'tutor_login_at' => Carbon::now('UTC'),
                ]);
            }
            //return Redirect::to($booking->start_url);
            return view('static.modules.class_link.daily_session_link', [
                'roomUrl' => $booking->start_url,
                'booking' => $booking
            ]);
        }

        // 3. Completed session
        if ($booking->booking_status == 'CM') {
            $title = "Completed";
            $msg = "Your session is completed";
        }
        // 4. Expired session (same-day, after end time)
        elseif (
            $booking->booking_status == 'B' &&
            $nowTutorTime->greaterThan($toTimeUser)
        ) {
            $title = "You are late";
            $msg = "Your session has expired";
        }
        // 5. Upcoming session (future day)
        elseif (
            $booking->booking_status == 'B' &&
            $nowTutorTime->lt($fromTimeUser)
        ) {
            $title = "You are early";
            $msg = "Your session is booked for " .
                $fromTimeUser->format('d-m-Y') . " between " .
                $fromTimeUser->format('h:i A') . " - " .
                $toTimeUser->format('h:i A') . " " . $tutorTimezone;
        }
        // 6. Cancelled session
        elseif ($booking->booking_status == 'C') {
            $title = "Cancelled";
            $msg = "Your session was cancelled. Refer email for more details.";
        }
        // 7. Fallback
        else {
            $title = "You are early";
            $msg = "Your session is booked for " .
                $fromTimeUser->format('d-m-Y') . " between " .
                $fromTimeUser->format('h:i A') . " - " .
                $toTimeUser->format('h:i A') . " " . $tutorTimezone;
        }

        session()->flash("success", $msg);
        return view('static.modules.class_link.class_link', compact('booking', 'msg', 'title'));
    }


    public function facebookDataDeletion(Request $request)
    {
        $facebook_id = $request->query('id');
        $get_user = User::where('provider_id', $facebook_id)->first();
        if (@$get_user) {
            User::where('provider_id', $facebook_id)->Update(['status' => 'D', 'provider_id' => '', 'email' => '', 'phone_no' => '']);
            echo "Data Deleted";
        } else {
            echo "Data Deleted";
        }
    }
    public function fbDataDelete(Request $request)
    {
        $signed_request = $request->get('signed_request');
        // dd($signed_request);
        // $data = $this->parse_signed_request($signed_request);
        $user_id = $data['user_id'];

        // here will delete the user base on the user_id from facebook
        User::where([
            ['platform_type' => 'facebook'],
            ['platform_id' => $user_id]
        ])->update(['status' => 'D']);

        // here will check if the user is deleted
        // $isDeleted = User::withTrashed()->where([
        //     ['provider' => 'facebook'],
        //     ['platform_id' => $user_id]
        // ])->find();

        // if ($isDeleted ===null) {
        //     return response()->json([
        //         'url' => url(''), // <------ i dont know what to put on this or what should it do
        //         'code' => $user_id, // <------ i dont know what is the logic of this code
        //     ]);
        // }
        $status_url = url('/') . "deletion?id=" . $user_id; // URL to track the deletion
        $confirmation_code = $user_id; // unique code for the deletion request

        $data = array(
            'url' => $status_url,
            'confirmation_code' => $confirmation_code
        );
        return json_encode($data);
        // echo json_encode($data);
        // return response()->json([
        //     'message' => 'operation not successful'
        // ], 500);
    }
    private function parse_signed_request($signed_request)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        // $secret = config('service.facebook.client_secret'); // Use your app secret here
        $secret = env('FACEBOOK_CLIENT_SECRET'); // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    private function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function privacyPolicy()
    {
        $data['contentDetails'] = ContentDetails::where(['type' => 'P'])->first();

        return view('static.modules.privacy_policy.privacy_policy')->with($data);
    }
    public function termsConditions()
    {
        $data['contentDetails'] = ContentDetails::where(['type' => 'T'])->first();
        return view('static.modules.terms_conditions.terms_condition')->with($data);
    }

    public function termsservice()
    {
        $data['contentDetails'] = ContentDetails::where(['type' => 'T'])->first();
        return view('static.modules.terms_service.terms_service')->with($data);
    }
    public function faq()
    {
        $data['TutorFaqModel'] = FaqModel::where(['user_type' => 'T', 'status' => 'A'])->orderBy('display_order', 'asc')->get();
        $data['StudentFaqModel'] = FaqModel::where(['user_type' => 'U', 'status' => 'A'])->orderBy('display_order', 'asc')->get();
        // dd($data);
        // return view('static.modules.faq.faq', $data);
        return view('static.modules.faq.new_faq_page', $data);
    }
    public function sendcontact_us(Request $request, ZohoDeskClient $desk)
    {
        // 1️⃣ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'number' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $request->only(['name', 'email', 'number','role', 'category','contact_method','best_time', 'subject', 'message']);

        // 2️⃣ Save message locally
        $message = Messages::create($data);

        // 3️⃣ Send email
        try {
            Mail::send(new ContactUsMail($data));
        } catch (\Exception $e) {
            \Log::error("ContactUsMail failed: " . $e->getMessage());
        }

        // 4️⃣ Create Zoho Desk ticket
        try {
            $contact = $desk->findOrCreateContact($data['email'], $data['name']);

            $ticket = $desk->createTicket([
                'subject'      => $data['subject'],
                'description'  => "Message: {$data['message']}\nPhone: {$data['number']}",
                'contactId'    => $contact['id'],
                'email'        => $data['email'],
                'departmentId' => config('services.zoho.default_department_id'),
                'channel'      => 'Web',
            ]);

            $message->update(['zoho_ticket_id' => $ticket['id']]);
        } catch (\Exception $e) {
            \Log::error("Zoho Desk ticket creation failed: " . $e->getMessage());
        }

        session()->flash("success", "Thank you for reaching out! Our team will get back to you shortly.");
        return redirect()->back();
    }
    public function help()
    {
        $data['help'] = HelpCategory::with(['helpAllDetails' => function ($query) {
            $query->where(function ($q) {
                $q->where('status', 'A');
            });
        }])->orderBy('display_order', 'asc')->get();
        // dd($data);
        return view('static.modules.help.help')->with($data);
    }


    public function contact_us()
    {
        return view('static.modules.contact.contact_us');
    }


    public function about_us()
    {
        return view('static.modules.about_us.about_us');
    }

    /* BLOG LIST */
    public function blog()
    {
        // Paginate 6 blogs per page
        $blogs = Blog::where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->paginate(6);    

        return view('static.modules.blog.blog', compact('blogs'));
    }

    /* BLOG DETAIL */
    public function blog_detail($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

         return view('static.modules.blog.blog_detail', compact('blog'));
    }


    public function message()
    {
        return view('static.modules.message.message');
    }



    public function emailcheck(Request $request)
    {
        $check = User::where('email', $request->email)->where('status', '!=', 'D')->first();
        if (!empty($check)) {
            echo "false";
        } else {
            echo "true";
        }
    }


    public function emailmobile(Request $request)
    {
        $check = User::where('phone', $request->ph)->where('status', '!=', 'D')->first();
        if (!empty($check)) {
            echo "false";
        } else {
            echo "true";
        }
    }




    public function emailmobiletwo(Request $request)
    {
        $check = User::where('phone', $request->ph)->where('status', '!=', 'D')->where('id', '!=', Auth()->user()->id)->first();
        if (!empty($check)) {
            echo "false";
        } else {
            echo "true";
        }
    }












    public function callBack()
    {
        try {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic " . base64_encode(env('CLIENT_ID') . ':' . env('CLIENT_SECRET'))
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => route('call.back')
                ],
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            TokenModel::where('id', 1)->update(['access_token' => json_encode($token)]);
            return json_encode($token);
            // $db = new DB();

            // if($db->is_table_empty()) {
            //     $db->update_access_token(json_encode($token));
            //     echo "Access token inserted successfully.";
            // }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function subject()
    {
        return view('static.modules.subjects_list.subject');
    }

}
