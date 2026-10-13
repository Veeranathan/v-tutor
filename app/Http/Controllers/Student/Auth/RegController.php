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

class RegController extends Controller
{


/*This is for student registration
*name:Jeet
*method:student_custom_reg
date:26/7/2021
*/

  public function student_custom_reg(Request $request){
  //dd($request->all());
    $request->validate([
      'f_name' => 'required|min:3',
      'email' => 'required|min:3|email',
      'password' => 'required|min:3',
      'l_name' => 'required|min:3',
      'parent_dob' => 'required|date',
      'parent_state' => 'required',
      'ph' => 'required',
      'student_f_name' => 'required|min:3',
      'student_l_name' => 'required|min:3',
      'student_dob' => 'required|date',
      'student_grade' => 'required',
      'student_grade' => 'required',
    ], [
        'f_name.min' => 'Please ensure the parent first name is at least 3 characters or more.',
        'l_name.min' => 'Please ensure the parent last name is at least 3 characters or more.',
        'student_f_name.min' => 'Please ensure the student first name is at least 3 characters or more.',
        'student_l_name.min' => 'Please ensure the student last name is at least 3 characters or more.',
    ]);

    //cheking
    $chk=User::where('email',$request->email)->where('status','!=','D')->first();
    if($chk){
      return back()->with('error','This email address is used by some one else. Please use another email address');
    }

     //cheking
    $chk2=User::where('phone',$request->ph)->where('status','!=','D')->first();
    if($chk2){
      return back()->with('error','This mobile number already exists');
    }

       $student=new User();
       /***********/
         //update parent fname and lname depend on the type
        if(@$request->radios == 'P'){
          $student->parent_f_name=$request->f_name;
          $student->parent_l_name=$request->l_name;
        }
        elseif(@$request->radios == 'G'){
          $student->parent_f_name=$request->f_name;
          $student->parent_l_name=$request->l_name;
        }
        /************/
       // $student->f_name=$request->f_name;
       // $student->l_name=$request->l_name;
       $student->parent_dob=$request->parent_dob;
       $student->state=$request->parent_state;
       $student->timezone_id=$request->timezone_id;
       $student->email=$request->email;
       $student->password=Hash::make($request->password);
       $student->user_type='U';
       $student->slug=Str::slug($request->f_name." ".$request->l_name);
       $student->phone=$request->ph;
       $student->student_type=$request->radios;
       $student->email_vcode=Str::random(60);
       
       $student->student_f_name=$request->student_f_name;
       $student->f_name=$request->student_f_name;
       $student->student_l_name=$request->student_l_name;
       $student->l_name=$request->student_l_name;
       $student->student_dob=$request->student_dob;
       $student->dob=$request->student_dob;
       $student->student_grade=$request->student_grade;
       $student->grade=$request->student_grade;
       $student->operate_accept=$request->operate_accept_val;
       $student->collect_data_accept=$request->collect_data_accept_val;
       $student->rules_accept=$request->rules_accept_val;
       $student->signature_full_name=$request->signature_full_name_val;
       $student->signature_date=$request->signature_date_val;

       $student->save();
       $updateSlug['slug'] = Str::slug($request->f_name." ".$request->l_name." ".$student->id);
       $updateSlug['unique_id'] = "STU000".$student->id;

       if ($request->filled('assessment_id')) {

      LearningProgramAssessment::where('id', $request->assessment_id)
          ->whereNull('student_id') 
          ->update([
            'student_id' => $student->id,
            'status'     => LearningProgramAssessment::STATUS_PROGRESS,
          ]);   
      }   

       User::where('id',$student->id)->update($updateSlug);
        $getuser = User::where('id',$student->id)->first();
        $data['name'] = $getuser->parent_f_name.' '. $getuser->parent_l_name;
        $data['email'] = $getuser->email;
        $data['vcode'] = $getuser->email_vcode;
        $data['id'] = $getuser->id;
        $data['email_subject'] = "Verify your email address on V-Tutor";

        Mail::to($getuser->email)->send(new TeacherVerify($data));
       return back()->with('success','A verification link has been sent to your email address. Please check and click on the link to complete the sign up.');
       // return redirect()->route('login')->with('success','A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
       // return redirect()->route('msg')->with('success','A verification link has been sent to your email address, please check your email and click on the verification link to complete sign up. You will be able to login after your email address is verified');
  }






/*This is for student socail registration part 2 page load
*name:Jeet
*method:step_two_view
date:26/7/2021
*/

  public function step_two_view($id){
      //dd($id);
      $data['user_details']=User::where('id',$id)->first();
      return view('student.modules.reg.reg_two')->with($data);
  }






/*This is for student socail registration part 2 insert
*name:Jeet
*method:student_custom_reg_two
date:26/7/2021
*/
  public function student_custom_reg_two(Request $request){
    // dd($request->all());
    if($request->email){
    $updateStudent=array(
      'email'=>@$request->email,
      'student_type'=>$request->radios,
      'phone'=>$request->ph,

    );
    }else{
       $updateStudent=array(
      //'email'=>@$request->email,
      'student_type'=>$request->radios,
      'phone'=>$request->ph,

    );

    }

    $up=User::where('id',(int)$request->student_id)->update($updateStudent);


    /****************************/

    //jayatri
    // parent fname and lname and slug
    $newUserData=User::where('id',$request->student_id)->first();
    if(@$request->radios == 'P'){
        if(@$newUserData->f_name){
            $updateStudentUser['parent_f_name'] = $newUserData->f_name;
            $updateStudentUser['f_name'] = NULL;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        if(@$newUserData->l_name){
            $updateStudentUser['parent_l_name'] = $newUserData->l_name;
            $updateStudentUser['l_name'] = NULL;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        $newUserData=User::where('id',$request->student_id)->first();
        //slug update
        if(@$newUserData->f_name && @$newUserData->l_name){
            $updateStudentUser['slug'] = Str::slug($newUserData->parent_f_name." ".$newUserData->parent_l_name." ".$newUserData->id);
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
    }
    if(@$request->radios == 'G'){
        if(@$newUserData->f_name){
            $updateStudentUser['parent_f_name'] = $newUserData->f_name;
            $updateStudentUser['f_name'] = NULL;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        if(@$newUserData->l_name){
            $updateStudentUser['parent_l_name'] = $newUserData->l_name;
            $updateStudentUser['l_name'] = NULL;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        $newUserData=User::where('id',$request->student_id)->first();
        // slug update
        if(@$newUserData->parent_f_name && @$newUserData->parent_l_name){
            $updateStudentUser['slug'] = Str::slug($newUserData->parent_f_name." ".$newUserData->parent_l_name." ".$newUserData->id);
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
    }
    if(@$request->radios == 'S'){
        if(@$newUserData->f_name){
            $updateStudentUser['f_name'] = $newUserData->f_name;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        if(@$newUserData->l_name){
            $updateStudentUser['l_name'] = $newUserData->l_name;
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
        $newUserData=User::where('id',$request->student_id)->first();
        // slug update
        if(@$newUserData->f_name && @$newUserData->l_name){
            $updateStudentUser['slug'] = Str::slug($newUserData->f_name." ".$newUserData->l_name." ".$newUserData->id);
            User::where('id',$request->student_id)->update($updateStudentUser);
        }
    }
    $up=User::where('id',(int)$request->student_id)->first();
    // dd($up);
    /**************************/
    $UpdateUser=User::where('id',$request->student_id)->first();

    Auth::login($UpdateUser);
    if(Auth::check()) {
        $expiresAt = Carbon::now()->addMinutes(720);
        Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
    }
    return redirect()->route('my.profile');
  }



}
