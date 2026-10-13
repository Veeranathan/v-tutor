<?php

namespace App\Http\Controllers\Student\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mail;
use App\Mail\TeacherVerify;
use Hash;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\LearningProgramAssessment;


class GuestRegisterController extends Controller
{

    public function guestRegister(Request $request)
    {
        $request->validate([
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'email'  => 'required|email',
        ], [
            'f_name.min' => 'Please ensure the first name is at least 3 characters.',
            'l_name.min' => 'Please ensure the last name is at least 3 characters.',
        ]);

        // Check email
        if (User::where('email', $request->email)->where('status', '!=', 'D')->exists()) {
            return back()->with('error', 'This email address is already registered.');
        }

        // Auto-generate password
        $plainPassword = Str::random(8);

        $user = new User();
        $user->parent_f_name = $request->f_name;
        $user->parent_l_name = $request->l_name;

        $user->f_name   = $request->f_name;
        $user->l_name   = $request->l_name;
        $user->email    = $request->email;
        $user->password = Hash::make($plainPassword);

        $user->user_type    = 'U';
        $user->student_type = 'P';
        $user->email_vcode  = Str::random(60);

        $user->state       = $request->parent_state;    
        $user->timezone_id = $request->timezone_id;

        $user->save();


        // Update slug & unique id
        User::where('id', $user->id)->update([
        'slug'      => Str::slug($request->f_name . ' ' . $request->l_name . ' ' . $user->id),
        'unique_id' => 'STU000' . $user->id,
        ]);

        // Send verification email with auto password
        $mailData = [
            'name'          => $user->parent_f_name . ' ' . $user->parent_l_name,
            'email'         => $user->email,
            'password'      => $plainPassword,
            'vcode'         => $user->email_vcode,
            'id'            => $user->id,
            'email_subject' => 'Verify your email & login details – V-Tutor',
        ];

        Mail::to($user->email)->send(new TeacherVerify($mailData));

        Auth::login($user);

        return response()->json([
            'success' => true
        ]);
    }

    public function checkGuestExists(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $emailExists = User::where('email', $request->email)
            ->where('status', '!=', 'D')
            ->exists();

        if ($emailExists) {
            return response()->json([
                'exists' => true,
                'email'  => $emailExists,
            ]);
        }

        return response()->json([
            'exists' => false
        ]);
    }


}
