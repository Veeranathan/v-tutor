<?php

namespace App\Http\Controllers\Teacher\Auth;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mail;
use App\Mail\TeacherWelcome;
use App\Mail\TeacherVerify;
use App\Mail\UserWelcome;
use Hash;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RegController extends Controller
{





    /*This is for teacher registration view page
*name:Jeet
*method:teacher_reg_view
date:26/7/2021
*/

    public function teacher_reg_view()
    {
        return view('teacher.modules.auth.reg');
    }









    /*This is for teacher registration
*name:Jeet
*method:teacher_custom_reg
date:26/7/2021
*/

    public function teacher_custom_reg(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'f_name' => 'required|min:3',
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
            'l_name' => 'required|min:3',
            'recaptcha_token' => 'required',
        ], [
            'f_name.required' => 'The first name field is required.',
            'f_name.min' => 'The first name must be at least 3 characters.',
            'l_name.required' => 'The last name field is required.',
            'l_name.min' => 'The last name must be at least 3 characters.',
            // 'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already registered.',
            'recaptcha_token.required' => 'Capcha token is required.',
        ]);

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('recaptcha_token'),
                'remoteip' => $request->ip(),
            ],
        ]);

        $res_body = json_decode($response->getBody());
        // dd($res_body);

        // Check the score (should be >= 0.5 for a good request)
        if ($res_body->success == true) {
            if (isset($res_body->score) && $res_body->score < 0.5) {
                return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
            }
        } else {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
        }

        //cheking
        $chk = User::where('email', $request->email)->where('status', '!=', 'D')->first();
        if ($chk) {
            return back()->with('error', 'This email is already registered. Please log in.');
        }

        $teacher = new User();
        $teacher->f_name = $request->f_name;
        $teacher->l_name = $request->l_name;
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->user_type = 'T';
        $teacher->slug = Str::slug($request->f_name . " " . $request->l_name);
        $teacher->email_vcode = Str::random(60);
        if (@$request->checkbox2) {
            $teacher->subscription = 'S';
        }
        $teacher->save();
        $updateSlug['slug'] = Str::slug($teacher->f_name . " " . $teacher->l_name . " " . $teacher->id);
        $updateSlug['unique_id'] = "TUT000" . $teacher->id;
        User::where('id', $teacher->id)->update($updateSlug);
        $getuser = User::where('id', $teacher->id)->first();
        $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
        $data['email'] = $getuser->email;
        $data['vcode'] = $getuser->email_vcode;
        $data['id'] = $getuser->id;
        $data['email_subject'] = "V-Tutor - Confirm your Registration";
        try {
            Mail::send(new TeacherVerify($data));
        } catch (\Exception $e) {
        }

        // Mail::to($getuser->email)->send(new TeacherVerify($data));
        // return  back()->with('success', 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.');
        return redirect()->route('login')->with('success', 'A verification link has been sent to your email address. Please check and click on the link to complete the sign up.');
        // return redirect()->route('msg')->with('success','A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
    }









    /*This is for teacher registration and user registration email verify
*name:Jeet
*method:verify
date:26/7/2021
*/

    public function verify($id, $vcode) {
        $verify = User::where('email_vcode', $vcode)->where('id', $id)->where('status', '!=', 'D')->first();
        // dd($verify);
        if (@$verify) {
            if (@$verify->user_type == 'T') {
                $update = User::where('id', $id)->update([
                    'status' => 'AA',
                    'email_vcode' => null,
                    'is_email_verify' => 'Y',
                ]);

                $getuser = User::where('id', $verify->id)->first();
                $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                $data['email'] = $getuser->email;
                $data['id'] = $getuser->id;
                $data['email_subject'] = "Welcome to V-Tutor";
                try {
                    Mail::send(new TeacherWelcome($data));
                } catch (\Exception $e) {
                }

                return redirect()->route('login')->with('success', 'Your email address has been successfully verified. You may now log in using your credentials.');  //redirect login
            } else {
                $update = User::where('id', $id)->update([
                    'status' => 'A',
                    'email_vcode' => null,
                    'is_email_verify' => 'Y',
                ]);

                // Parent/Gurdian Welcome Mail
                $getuser = User::where('id', $verify->id)->first();
                $data['name'] = $getuser->f_name . ' ' . $getuser->l_name;
                $data['p_g_name'] = $getuser->parent_f_name . ' ' . $getuser->parent_l_name;
                $data['email'] = $getuser->email;
                $data['id'] = $getuser->id;
                $data['email_subject'] = "Welcome to V-Tutor – Let’s Get Started!";
                try {
                    Mail::send(new UserWelcome($data));
                } catch (\Exception $e) {
                }
                
                return redirect()->route('login')->with('success', 'Your email address has been successfully verified. You may now log in using your credentials.');
            }
        } else {
            $checkinguser = User::where('id', $id)->first();
            if($checkinguser->user_type == 'T') {
                return redirect()->route('tutor_landing')->with('error', 'Already verfied, please login & continue');
            }

            if (@$checkinguser->status == 'D') {
                return redirect()->route('reg.home')->with('error', 'This email is not registered yet!Please register!');
            } elseif (@$checkinguser->status == 'A') {
                return redirect()->route('login')->with('error', 'Your email address has been successfully verified. You may now log in using your credentials.');
            } elseif (@$checkinguser->status == 'AA') {
                return redirect()->route('login')->with('error', 'Your email is awaiting approval. Login with your credentials');
            } elseif (@$checkinguser->status == 'I') {
                return redirect()->route('reg.home')->with('error', 'Your email is inactive. Contact admin');
            } else {
                return redirect()->route('reg.home')->with('error', 'link expire');
            }
        }
    }






    public function step_two_view($id)
    {
        //dd($id);
        $data['user_details'] = User::where('id', $id)->first();
        return view('teacher.modules.auth.reg_two')->with($data);
    }



    public function tutor_custom_reg_two(Request $request)
    {
        //dd($request->all());
        // $updateTutor=array(
        //   'email'=>@$request->email,
        // );
        $updateTutor['email'] = $request->email;
        if (@$request->checkbox2) {
            $updateTutor['subscription'] = 'S';
        }
        $up = User::where('id', $request->tutor_id)->update($updateTutor);
        $UpdateUser = User::where('id', $request->tutor_id)->first();

        Auth::login($UpdateUser);
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(720);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
        }
        // return redirect()->route('teacher.home');
        // return redirect()->route('tutor.awaiting.approval.profile');
        return redirect()->route('teacher.profile');
    }
}
