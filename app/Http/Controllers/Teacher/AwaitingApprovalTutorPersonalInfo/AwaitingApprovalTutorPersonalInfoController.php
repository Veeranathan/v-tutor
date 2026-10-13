<?php

namespace App\Http\Controllers\Teacher\AwaitingApprovalTutorPersonalInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\State;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\TutorshipPlan;
use App\Models\TutorExperience;
use App\Models\TutorRecognision;
use Illuminate\Support\Str;
use App\Models\TutorAcademic;
use App\Models\University;
use App\Models\FieldOfStudy;
use App\Models\ExpToSubject;
use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\TutorToRef;
use App\Models\TimezoneLists;
use App\Models\Commissions;

class AwaitingApprovalTutorPersonalInfoController extends Controller
{
    public function my_profile(){
        return redirect()->route('teacher.profile');
        if(@Auth::user()){
            if(@Auth::user()->status == 'AA' && @Auth::user()->user_type == 'T'){
                $data['teacher']=User::where('id',Auth()->user()->id)->first();
                $data['tutor_to_ref']=TutorToRef::where('tutor_id',Auth()->user()->id)->first();
                $data['state']=State::orderBy('id','asc')->get();
                $data['lan']=Language::orderBy('id')->get();
                $data['tutor_to_lan']=LangToTutor::where('tutor_id',Auth()->user()->id)->get();
                $data['timezonesLists']=TimezoneLists::get();
                @$data['total_lan']=LangToTutor::where('tutor_id',Auth()->user()->id)->count();

                if(@Auth::user()->draft == 'N'){
                    // if(@Auth::user()->f_name && @Auth::user()->l_name && @Auth::user()->email && @Auth::user()->phone && @Auth::user()->teacher_emp_status && @Auth::user()->hours && @Auth::user()->why_tutor && @Auth::user()->about_me && @Auth::user()->city && @Auth::user()->address && @Auth::user()->zip){

                        session()->flash('success','<h6>Thank you for the application.</h6>
                             <p>Kindly allow 2-3 days for our backend team to process. </p>
                                 <p>We will run background checks as part of the onboarding process.</p>
                                 <p>You will be contacted over phone or email for an interview. Please ensure to monitor messages and spam folders over the next few days.</p>
                                 <p class="academic_team_bold">Academics Team.</p>');
                        session(['m'=>"Thank You!"]);
                        // return redirect()->back();
                        // return back()->with('success','<h6>Thank you for the application.</h6>
                        //         <p>Please fill-in this page and submit to apply as a tutor.</p>
                        //         <p>You will be contacted over email or phone on next steps.</p>
                        //         <p>Wishing you all the best!</p>
                        //         <p class="student_pro_p">Regards,</p>
                        //         <p>Academics Coordinator.</p>');
                        // session()->flash('success','Thank you for your application. Kindly allow 24-48 hrs for our backend team to process. You will receive an email when your application is approved.');

                    // }
                }else{
                    if(\Session::get('success') == "Your profile is updated"){

                    }else{
                        session()->flash('success','<h6>Welcome to V-Tutor! We are happy that you would like to join us!</h6>
                             <p>Please fill-in this page and submit to apply as a tutor.</p>
                                 <p>You will be contacted over email or phone on next steps.</p>
                                 <p>Wishing you all the best!</p>
                                 <p class="academic_team_bold">Academics Team.</p>');
                                 session(['m'=>"Welcome to V-Tutor!"]);
                    }


                }
                // return back()->with('success','<h6>Thank you for the application.</h6>
                //                 <p>Please fill-in this page and submit to apply as a tutor.</p>
                //                 <p>You will be contacted over email or phone on next steps.</p>
                //                 <p>Wishing you all the best!</p>
                //                 <p class="student_pro_p">Regards,</p>
                //                 <p>Academics Coordinator.</p>');

                return view('teacher.modules.awaiting_approval_tutor_profile.awaiting_approval_tutor_profile')->with($data);
            }else{
                return redirect()->route('teacher.profile');
            }
        }else{
            return redirect()->back();
        }
    }

    public function teacher_profile_update(Request $request){
        if(@$request->applyvtutor == 'Apply as V-Tutor '){
            $request->validate([
              'f_name' => 'required|min:3',
              'hours' => 'required',
              'ph' => 'required|min:10|max:10',
              'l_name' => 'required|min:3',
              'timezone_id' => 'required',
              'teacher_emp_status' => 'required',
              'why_tutor' => 'required',
              'work_with_child' => 'required',
              'country' => 'required',
              'state' => 'required',
              'city' => 'required',
              'zip' => 'required',
              'about_me' => 'required|min:10'
            ]);
        }
        if(@$request->ph){
            //cheking
            $chk2=User::where('phone',$request->ph)->where('status','!=','D')->where('id','!=',Auth()->user()->id)->first();
            if($chk2){
              return back()->with('error','This mobile number already exists');
            }
        }


        if(@$request->youtube_link) {
            if(in_array('www.youtube.com', explode('/', @$request->youtube_link))) {
                $explode = explode('=', @$request->youtube_link);
                $youtube_vdo_link = end($explode);
            }else{
              $explode = explode('/', @$request->youtube_link);
              $youtube_vdo_link = end($explode);
            }
        }
        $tutorGeneralCommission = Commissions::first();
        $upd=array(
          "f_name" => @$request->f_name,
          "l_name" => @$request->l_name,
          "timezone_id" => $request->timezone_id,
          "slug" => Str::slug(@$request->f_name." ".@$request->l_name." ".Auth()->user()->id),
          "phone" => @$request->ph,
          "teacher_emp_status" => @$request->teacher_emp_status,
          "hours" => @$request->hours,
          "why_tutor" => @$request->why_tutor,
          "work_with_child" => @$request->work_with_child,
          "wwc_number" => @$request->wwc_number,
          "criminal_case" => @$request->criminal_case,
          "criminal_details" => @$request->criminal_details,
          "video_short_url" => @$youtube_vdo_link,
          "profile_video"=>@$request->youtube_link,
          "country" => @$request->country,
          "state" => @$request->state,
          "city" => @$request->city,
          "address" => @$request->address,
          "zip" => @$request->zip,
          "about_me" => @$request->about_me,
          "commission_percentage" => @$tutorGeneralCommission->commission
           // "bank_name" => $request->bank_name,
           //  "account_no" => $request->account_no,
           //  "account_name" => $request->account_name,
           //  "bsb_code" => $request->bsb_code,
            //"language" => $request->language,
        );


        $user_update=User::where('id',Auth()->user()->id)->update($upd);
        if(@$request->language){
            //Insert language data
            foreach($request->language as $val){
              $lan_obj=new LangToTutor();
              $lan_obj->tutor_id=Auth()->user()->id;
              $lan_obj->language_id=$val;
              $lan_obj->save();
            }
        }
        if(@$request->img){
            $unlnk=User::where('id',auth()->user()->id)->first();
            @$prev_img = $unlnk->profile_pic;

            if(@$prev_img){
                @unlink('storage/profile/'.$prev_img);
            }
            //this is for upload image
            $image = $request->img;
            $profile = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move("storage/teacher_profile_pic",$profile);
            $user_pic_update=User::where('id',Auth()->user()->id)->update(['profile_pic'=>$profile]);
        }
        // jayatri reference feedback point
        // Add 'Reference 1' --> text boxes with Name, Phone, Email, Relationship
        // Add 'Reference 2' --> text boxes with Name, Phone, Email, Relationship
        // Relationship drop down --> Partner, Family, Friend, Colleague
        $isTutorToRef = TutorToRef::where(['tutor_id'=>Auth()->user()->id])->first();
        if(@$isTutorToRef){
            // $updTutorToRef['ref_1_name'] = @$request->ref_1_name;
            $updTutorToRef['ref_1_f_name'] = @$request->ref_1_f_name;
            $updTutorToRef['ref_1_l_name'] = @$request->ref_1_l_name;
            $updTutorToRef['ref_1_email'] = @$request->ref_1_email;
            $updTutorToRef['ref_1_phone'] = @$request->ref_1_phone;
            $updTutorToRef['ref_1_relation'] = @$request->ref_1_relation;
            // $updTutorToRef['ref_2_name'] = @$request->ref_2_name;
            $updTutorToRef['ref_2_f_name'] = @$request->ref_2_f_name;
            $updTutorToRef['ref_2_l_name'] = @$request->ref_2_l_name;
            $updTutorToRef['ref_2_email'] = @$request->ref_2_email;
            $updTutorToRef['ref_2_phone'] = @$request->ref_2_phone;
            $updTutorToRef['ref_2_relation'] = @$request->ref_2_relation;
            TutorToRef::where(['tutor_id'=>Auth()->user()->id])->update($updTutorToRef);
        }else{
            $updTutorToRef['tutor_id'] = Auth()->user()->id;
            // $updTutorToRef['ref_1_name'] = @$request->ref_1_name;
            $updTutorToRef['ref_1_f_name'] = @$request->ref_1_f_name;
            $updTutorToRef['ref_1_l_name'] = @$request->ref_1_l_name;
            $updTutorToRef['ref_1_email'] = @$request->ref_1_email;
            $updTutorToRef['ref_1_phone'] = @$request->ref_1_phone;
            $updTutorToRef['ref_1_relation'] = @$request->ref_1_relation;
            // $updTutorToRef['ref_2_name'] = @$request->ref_2_name;
            $updTutorToRef['ref_2_f_name'] = @$request->ref_2_f_name;
            $updTutorToRef['ref_2_l_name'] = @$request->ref_2_l_name;
            $updTutorToRef['ref_2_email'] = @$request->ref_2_email;
            $updTutorToRef['ref_2_phone'] = @$request->ref_2_phone;
            $updTutorToRef['ref_2_relation'] = @$request->ref_2_relation;
            $tutorCrt = TutorToRef::create($updTutorToRef);
        }
        if(@$request->applyvtutor == 'Apply as V-Tutor '){
            User::where(['id'=>@Auth::user()->id])->update(['draft'=>'N']);
        }
        if(@$request->saveAsDraft == 'Save as Draft'){
            User::where(['id'=>@Auth::user()->id])->update(['draft'=>'Y']);
        }
        // return back()->with('success','Thank you for your application. Kindly allow 24-48 hrs for our backend team to process. You will receive an email when your application is approved.');
        // return back()->with('success','<h6>Welcome to V-Tutor! We are happy that you would like to join us!</h6>
        //                         <p>Please fill-in this page and submit to apply as a tutor.</p>
        //                         <p>You will be contacted over email or phone on next steps.</p>
        //                         <p>Wishing you all the best!</p>
        //                         <p class="student_pro_p">Regards,</p>
        //                         <p>Academics Coordinator.</p>');
        return back()->with('success',"Your profile is updated");
    }
}
