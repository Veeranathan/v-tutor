<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;
use App\Mail\AdminVerifyMail;
use Illuminate\Http\Request;
Use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        if($request->all()){

            $request->validate([
                            'email' => ['required', 'string', 'email', 'max:255'],
                        ]);

            $data['email'] = $request->email;
            $user = Admin::where('email',$request->email)->first();


            if(!@$user){
                return redirect()->back()->with('error','No record found.');
            }

            $vcode = rand();
            Admin::where('email',$request->email)->update(['vcode'=>$vcode]);
            $data['link'] = route('admin.password.reset',[$vcode]);
            $data['name'] = $user->name;
            $data['mailBody'] = 'forgotpassword';
            Mail::send(new AdminVerifyMail($data));
            return redirect()->back()->with('success','Password reset link send to your email.');

        }
        else{

            return redirect()->back()->with('error','Something went wrong');
        }

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

}
