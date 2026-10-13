<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPassword;

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
        $this->middleware('guest');
    }



    public function forget_pass_view(){
        return view('static.modules.forget_password.forget_pass');
    }





    public function sendMail(Request $request)
    {
        //dd($request->all());
        $user = User::where('email', $request->email)->whereIn('status',['AA','A','I'])->where('password','!=','')->first();
        // checking if the user is valid or not
        if (!$user) {
            // $a=array(
            //     'errorr'=> 'This email is not registered yet',
            //     'msg'=>'msg',
            // );
            $data['error']='This email is not registered yet';
            $data['msg']='msg';

           return back()->with($data);
        }else{
            $updated = User::where('email',$request->email)->update(['email_vcode'=>time()]);
            $getdata = User::where('email',$request->email)->whereIn('status',['AA','A','I'])->first(); 
            if(@$getdata->user_type == 'S'){
                $data = [
                'email'=>$request->email,
                'name'=>$getdata->parent_f_name." ".$getdata->parent_l_name,
                'email_vcode'=>$getdata->email_vcode
            ];
            }else{
                $data = [
                'email'=>$request->email,
                'name'=>$getdata->f_name." ".$getdata->l_name,
                'email_vcode'=>$getdata->email_vcode
            ];    
            }
            
            Mail::send(new ResetPassword($data));
            return redirect()->route('login')->with('success','A reset password link has been sent to your email. You need to click the link to be redirected to a page where you can change your password.');
        }
    }





     public function resetpassword($email_vcode)
    {     
       $data = User::where('email_vcode',$email_vcode)->whereIn('status',['AA','A','I'])->first();
       if (!$data) {
           return redirect()->route('login')->with('error','link expire.!');
       }
        return view('static.modules.forget_password.new_password',compact('data'));
    }





    public function newPassword(Request $request)
    {
        $password = $request->input('password'); 
        $updatepassword = User::where('id',$request->id)->update([
            'password'=>Hash::make($password),
            'email_vcode'=>''
        ]); 

        return redirect()->route('login')->with('success','Password has been reset.');
             
    }
}
