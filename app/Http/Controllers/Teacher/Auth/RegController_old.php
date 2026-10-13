<?php

namespace App\Http\Controllers\Teacher\Auth;

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
class RegController extends Controller
{





/*This is for teacher registration view page
*name:Jeet
*method:teacher_reg_view
date:26/7/2021
*/

  public function teacher_reg_view(){
   return view('teacher.modules.auth.reg');
  }









/*This is for teacher registration
*name:Jeet
*method:teacher_custom_reg
date:26/7/2021
*/

  public function teacher_custom_reg(Request $request){
  //dd($request->all());
    $request->validate([
      'f_name' => 'required|min:3',
      'email' => 'required|min:3|email',
      'password' => 'required|min:3',
      'l_name' => 'required|min:3',
    ]);

     //cheking
    $chk=User::where('email',$request->email)->where('status','!=','D')->first();
    if($chk){
      return back()->with('error','This email already exists');
    }

       $teacher=new User();
       $teacher->f_name=$request->f_name;
       $teacher->l_name=$request->l_name;
       $teacher->email=$request->email;
       $teacher->password=Hash::make($request->password);
       $teacher->user_type='T';
       $teacher->slug=Str::slug($request->f_name." ".$request->l_name);
       $teacher->email_vcode=Str::random(60);
       $teacher->save();
       $updateSlug['slug'] = Str::slug($teacher->f_name." ".$teacher->l_name." ".$teacher->id);
         $updateSlug['unique_id'] = "TU000".$teacher->id;
       User::where('id',$teacher->id)->update($updateSlug);
        $getuser = User::where('id',$teacher->id)->first();
        $data['name'] = $getuser->f_name.' '. $getuser->l_name;
        $data['email'] = $getuser->email;
        $data['vcode'] = $getuser->email_vcode;
        $data['id'] = $getuser->id;
        $data['email_subject'] = "Verify your email address on V-Tutor";

        Mail::send(new TeacherVerify($data));
        if (count(Mail::failures()) == 0) {
             dd('hi');
         }
       return redirect()->route('login')->with('success','A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
       // return redirect()->route('msg')->with('success','A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
  }









/*This is for teacher registration and user registration email verify
*name:Jeet
*method:verify
date:26/7/2021
*/

   public function verify($id,$vcode){
        $verify = User::where('email_vcode',$vcode)->where('id',$id)->where('status','!=','D')->first();
         if (@$verify) {
          if(@$verify->user_type=='T'){
            $update = User::where('id',$id)->update([
                'status'=>'AA',
                'email_vcode'=>null,
                'is_email_verify'=>'Y',
            ]);
         return redirect()->route('login')->with('success','Your email is now active. Login with your credentials.');  //redirect login
       }else{
         $update = User::where('id',$id)->update([
                'status'=>'A',
                'email_vcode'=>null,
                'is_email_verify'=>'Y',
            ]);
         return redirect()->route('login')->with('success','Your email is now active. Login with your credentials.');

       }
      }else{
          $checkinguser = User::where('id',$id)->first();
          if(@$checkinguser->status == 'D'){
            return redirect()->route('reg.home')->with('error','This email is not registered yet!Please register!');
          }elseif(@$checkinguser->status == 'A'){
            return redirect()->route('login')->with('error','Your email is active. Login with your credentials!');
          }elseif(@$checkinguser->status == 'AA'){
            return redirect()->route('login')->with('error','Your email is awaiting approval. Login with your credentials');
          }elseif(@$checkinguser->status == 'I'){
            return redirect()->route('reg.home')->with('error','Your email is inactive. Contact admin');
          }else{
              return redirect()->route('reg.home')->with('error','link expire');
          }
        }
    }






    public function step_two_view($id){
      //dd($id);
       $data['user_details']=User::where('id',$id)->first();
      return view('teacher.modules.auth.reg_two')->with($data);
    }



    public function tutor_custom_reg_two(Request $request){
       //dd($request->all());
    $updateTutor=array(
      'email'=>@$request->email,
    );

    $up=User::where('id',$request->tutor_id)->update($updateTutor);
    $UpdateUser=User::where('id',$request->tutor_id)->first();

    Auth::login($UpdateUser);
    if(Auth::check()) {
        $expiresAt = Carbon::now()->addMinutes(720);
        Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
    }
    return redirect()->route('teacher.home');
    }



}
