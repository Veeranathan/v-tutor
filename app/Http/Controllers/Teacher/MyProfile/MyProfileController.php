<?php

namespace App\Http\Controllers\Teacher\MyProfile;

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
use App\Models\TutorAcademic;
use App\Models\University;
use App\Models\FieldOfStudy;
use App\Models\ExpToSubject;
use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\TutorToRef;
use App\Models\TimezoneLists;
use App\Models\Branch;
use App\Models\TutorApplicationFormsModel;
use App\Models\TutorWWCCModel;
use Illuminate\Support\Str;
use App\Models\AcademicProgram;

class MyProfileController extends Controller
{


 //--------------PROFILE--------------------------//


    public function my_profile(){
     //   dd("hi");
      $data['teacher']=User::where('id',Auth()->user()->id)->first();
      $data['tutor_to_ref']=TutorToRef::where('tutor_id',Auth()->user()->id)->first();
      $data['state']=State::orderBy('id','asc')->get();
      $data['lan']=Language::orderBy('id')->get();
      $data['tutor_to_lan']=LangToTutor::where('tutor_id',Auth()->user()->id)->get();
      $data['timezonesLists']=TimezoneLists::get();
      //dd( $data['tutor_to_lan']);
      //update is_login to 1
      if(Auth()->user()->is_login=="0"){
      $upd=User::where('id',Auth()->user()->id)->update(['is_login'=>"1"]);
       }
      
      $approved = 2;
      if(@$data['teacher']->status == 'A' && @$data['teacher']->subscription == 'S' && @$data['teacher']->draft == 'N'){
        $approved = 1;        
      }
      $data['approved'] = $approved;
      
      return view('teacher.modules.my_profile.my_profile')->with($data);
    }



    public function teacher_profile_update(Request $request){
      /* if(@Auth::user()->platform_type == NULL){
        if(\Hash::check(@$request->check_password,@Auth()->user()->password)) {

        }else{
          session()->flash("error","Password is not correct. Try again or reset the password");
          return redirect()->back();
        }
      } */
      $request->validate([
        'f_name' => 'required|min:3',
        'm_name' => 'nullable',
        'l_name' => 'required|min:3',
        'ph' => 'required|min:10',
        // 'mother_tongue' => 'required',
        // 'primary_communication_language' => 'required',
        'nationality' => 'required',
        //'hours' => 'required',
        //'teacher_emp_status' => 'required',
        // 'why_tutor' => 'required',
        // 'work_with_child' => 'required',
        // 'about_me' => 'required|min:10'
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'address' => 'required',
        'zip' => 'required',
        'timezone_id' => 'required',
      ], [
        'mother_tongue.required' => 'This field is required.',
        'primary_communication_language.required' => 'This field is required.',
        'nationality.required' => 'This field is required.',
      ]);
      //cheking
      $chk2=User::where('phone',$request->ph)->where('status','!=','D')->where('id','!=',Auth()->user()->id)->first();
      if($chk2){
        return back()->with('error','This mobile number already exists');
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
      $upd=array(
      "f_name" => $request->f_name,
      "m_name" => $request->m_name,
      "l_name" => $request->l_name,
      "slug" => Str::slug($request->f_name." ".$request->l_name." ".Auth()->user()->id),
      "phone" => $request->ph,
      // "mother_tongue" => $request->mother_tongue,
      // "primary_communication_lang" => $request->primary_communication_language,
      "nationality" => $request->nationality,
      //"teacher_emp_status" => $request->teacher_emp_status,
      //"hours" => $request->hours,
      "why_tutor" => $request->why_tutor,
      "work_with_child" => $request->work_with_child,
      "wwc_number" => @$request->wwc_number,
      "criminal_case" => $request->criminal_case,
      "criminal_details" => @$request->criminal_details,
      "video_short_url" => @$youtube_vdo_link,
      // "profile_video"=>@$request->youtube_link,
      "about_me" => $request->about_me,
      "country" => @$request->country,
      "state" => @$request->state,
      "timezone_id" => @$request->timezone_id,
      "city" => @$request->city,
      "zip" => @$request->zip,
      "address" => @$request->address,
      "street" => @$request->address,
      );

      $user_update=User::where('id',Auth()->user()->id)->update($upd);
      if(@$request->language){
        //first delete all data
        @$srchLan=LangToTutor::where('tutor_id',Auth()->user()->id)->get();

        foreach($srchLan as $del){
          @$del=LangToTutor::where('tutor_id',Auth()->user()->id)->where('language_id',$del->language_id)->delete();
        }

        //Now insert new data
        foreach($request->language as $val){
          $lan_obj=new LangToTutor();
          $lan_obj->tutor_id=Auth()->user()->id;
          $lan_obj->language_id=$val;
          $lan_obj->save();
        }
      }


      if($request->img){
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
      if(@Auth::user()->nationality_id && @Auth::user()->draft == 'Y'){
        User::where(['id'=>@Auth::user()->id])->update(['draft'=>'N']);
        try{
          $data['user'] = User::where('id',@Auth::user()->id)->first();
          $data['subject'] = "";
          Mail::send(new SendApprovalMail($data));
          return back()->with('success','Your profile is updated and application has been submitted');
        }catch(\Exception $e){
          return back()->with('success','Your profile is updated and application has been submitted'.$e->getMessage());
        }
      }
      return back()->with('success','Your profile is updated');
    }



















  //---------------TUTORSHIP PLAN--------------------------//


    public function tutorship_plan_view(Request $request){
      $data['tutorship_plan']=TutorshipPlan::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
      $data['grade']=Grade::orderBy('grade_name','asc')->where('status','A')->get();
      $data['subject']=Subject::where('status','A')->orderBy('subject','asc')->get();
      $s = Subject::where('status','A');
      $s1 = $s->orderBy('subject','asc')->get();
      $s2 = $s1->sortBy('subject', SORT_NATURAL);
      $s2 = $s2->values()->all();
      $data['subject'] = $s2;
      // $data['subject']=Subject::where('status','A')->orderBy(\DB::raw('LENGTH(subject), subject'),'asc')->get();
      $data['branches']=Branch::orderBy('branch_name','asc')->where('status','A')->get();
      return view('teacher.modules.my_profile.tutorship_plan')->with($data);
    }




    public function tutorship_plan_ins(Request $request){
      //dd($request->all());
      $request->validate([
        'grade' => 'required',
        'branch' => 'required',
        'subject' => 'required',
        'hourly_rate' => 'required|numeric',

      ]);
      if($request->subject){
        // foreach($request->subject as $key=> $val){
               //already subject added or not
          $chk=TutorshipPlan::where('subject_id',$request->subject)->where('grade_id',$request->grade)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->first();
          if(!@$chk){
            $ins_plan=new TutorshipPlan();
            $ins_plan->grade_id=$request->grade;
            $ins_plan->branch_id=$request->branch;
            $ins_plan->subject_id=$request->subject;
            $ins_plan->hourly_rate=$request->hourly_rate;
            $ins_plan->status='A';
            $ins_plan->teacher_id=Auth()->user()->id;

            $ins_plan->save();
            }
        // }
        $min_plan=TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate')?TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate'):0;
        $update_min_plan=User::where('id',Auth()->user()->id)->update(['min_hourly_rate'=>$min_plan]);
        return back()->with('success','Tutoring Plan successfully added');
      }
    }




    public function tutorship_plan_dlt($id){
      //dd($id);
      $delete_plan=TutorshipPlan::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
      if($delete_plan){
        TutorshipPlan::where('id',$id)->where('teacher_id',Auth()->user()->id)->update(['status'=>'D']);
        $min_plan=TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate')?TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate'):0;
        $update_min_plan=User::where('id',Auth()->user()->id)->update(['min_hourly_rate'=>$min_plan]);
        return back()->with('success','Tutorship plan removed.');

      }else{
        return back()->with('error','Unauthorized access.!');
      }
    }




    public function tutorship_edit_page($id){
      $data['tutorship_plan']=TutorshipPlan::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
      $data['grade']=Grade::orderBy('grade_name','asc')->where('status','A')->get();
      $data['branches']=Branch::orderBy('branch_name','asc')->where('status','A')->get();
      //$data['subject']=Subject::where('status','A')->orderBy('id','asc')->get();
      $srch=TutorshipPlan::with(['getGrade','getSubject'])->where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
      $hourly_rate=$srch->hourly_rate;
      $grade=$srch->grade_id;
      $subject_idd=$srch->subject_id;
      $branch_id=$srch->getSubject->branch_id;
      $t_id=$srch->id;

   //Fetch the only subjects that is not added under this grade and remove those subjects which is added under this grade with different rate...

    $data['find']=TutorshipPlan::where('grade_id',$grade)->where('teacher_id',Auth()->user()->id)/*->where('hourly_rate','!=',$hourly_rate)*/->where('id','!=',$id)->where('status','!=','D')->get();
    $ar1=array();
    foreach($data['find'] as $val1){
      $subject_id=$val1->subject_id;
      array_push($ar1,$subject_id);
    }
    //dd($ar1);
     $ar2=array();
    $sub=Subject::where('status','A')->orderBy('subject','asc')->get();
     foreach($sub as $val2){
      $subject_id=$val2->id;
      array_push($ar2,$subject_id);
    }
    $output= array_merge(array_diff($ar1, $ar2), array_diff($ar2, $ar1));
    $abc=array();
    foreach($output as $val3){
      $ids=$val3;
      array_push($abc, $ids);
    }
    // $data['subject']=Subject::whereIn('id',$abc)->orderBy('subject','asc')->get();
    // $data['subject']=Subject::where(['status'=>'A','branch_id'=>$branch_id])->orderBy('subject','asc')->get();
      $s = Subject::where(['status'=>'A','branch_id'=>$branch_id]);
      $s1 = $s->orderBy('subject','asc')->get();
      $s2 = $s1->sortBy('subject', SORT_NATURAL);
      $s2 = $s2->values()->all();
      $data['subject'] = $s2;
    //dd($output, $unique_sub['unq_sub']);
    $data['edit_plan']=TutorshipPlan::where('hourly_rate',$hourly_rate)->where('grade_id',$grade)->where('teacher_id',Auth()->user()->id)->get();
    $data['hourly_rate']=$hourly_rate;
    $data['grade_id']=$grade;
    $data['subject_idd']=$subject_idd;
    $data['branch_id']=$branch_id;
    $data['t_id']=$t_id;

      //dd( $hourly_rate, $grade,$data['edit_plan'] );

       return view('teacher.modules.my_profile.tutorship_plan_edit')->with($data);
    }



    public function tutorship_update(Request $request){
      //dd($request->all());
      // if($request->t_id){

          //checking if this subject is already inserted or not
        $check=TutorshipPlan::where('subject_id',$request->subject)->where('branch_id',$request->branch)->where('grade_id',$request->grade)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->where('id','!=',$request->t_id)->first();
        if(!@$check){
          $up=array(
            'grade_id'=>$request->grade,
            'branch_id'=>$request->branch,
            'subject_id'=>$request->subject,
            'hourly_rate'=>$request->hourly_rate,
          );

          $updt=TutorshipPlan::where('id',$request->t_id)->where('teacher_id',Auth()->user()->id)->update($up);

          $min_plan=TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate');
         $update_min_plan=User::where('id',Auth()->user()->id)->update(['min_hourly_rate'=>$min_plan]);
                return back()->with('success','Tutoring Plan successfully updated');
        }else{
          return back()->with('error','This tutorship plan already exists');
        }
     // 1,2,3 4        2,3    1

     //    }



      // //first delete previous data
      // $dltBefUpd=TutorshipPlan::where('grade_id',$request->prv_grade)->where('hourly_rate',$request->prv_rt)->where('teacher_id',Auth()->user()->id)->get();
      // //dd( $dltBefUpd,$request->all());

      // foreach($dltBefUpd as $val){
      //   $dlt=TutorshipPlan::where('id',$val->id)->where('teacher_id',Auth()->user()->id)->delete();
      // }

      // //newly insert data
      // if($request->subject){
      //   foreach($request->subject as $key=> $val){
      //          //already subject added or not
      //     $chk=TutorshipPlan::where('subject_id',$val)->where('grade_id',$request->grade)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->first();
      //     if(!@$chk){
      //       $ins_plan=new TutorshipPlan();
      //       $ins_plan->grade_id=$request->grade;
      //       $ins_plan->subject_id=$val;
      //       $ins_plan->hourly_rate=$request->hourly_rate;
      //       $ins_plan->status='A';
      //       $ins_plan->teacher_id=Auth()->user()->id;

      //       $ins_plan->save();
      //       }
      //   }
      //    $min_plan=TutorshipPlan::where('teacher_id',Auth()->user()->id)->where('status','!=','D')->min('hourly_rate');
      //   $update_avg_plan=User::where('id',Auth()->user()->id)->update(['min_hourly_rate'=>$min_plan]);
      //   return redirect()->route('tutorship.plan')->with('success','Tutorship plan Updated successfully');
      // }
    }




    public function get_sub(Request $request){
        if(@$request->grade_id != 0){
            $data['find']=TutorshipPlan::where('grade_id',$request->grade_id)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->get();
            $ar1=array();
            foreach($data['find'] as $val1){
            $subject_id=$val1->subject_id;
            array_push($ar1,$subject_id);
            }
            // $s3=Subject::where('status','A')->whereNotIn('id',$ar1)->where(['branch_id'=>$request->branch_id]);
            // $s3 = $s3->orderBy('subject','asc')->get();
            // $s2 = $s3->sortBy('id', SORT_NATURAL);
            // $s2 = $s2->values()->all();
            // $unique_sub['unq_sub'] = $s2;
            $data['subjects'] = Subject::where(['status'=>'A'])->where('branch_id',$request->branch_id)->where('grade_id',$request->grade_id)->orderBy('display_order','asc')->get();

            $data['count'] = $data['subjects']->count();

            //$s2 = $data['subjects'];
            //$s2 = $s2->values()->all();
            //$data['subjects'] = $s2;
            $unique_sub['unq_sub'] = $data['subjects'];

            return view('teacher.modules.my_profile.get_sub')->with($unique_sub);
        }else{
            $data['find']=TutorshipPlan::where('grade_id',$request->grade_id)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->get();

            $ar1=array();
            foreach($data['find'] as $val1){
            $subject_id=$val1->subject_id;
            array_push($ar1,$subject_id);
            }
            // $s3=Subject::where('status','A')->whereNotIn('id',$ar1)->where(['branch_id'=>$request->branch_id]);
            // $s3 = $s3->orderBy('subject','asc')->get();
            // $s2 = $s3->sortBy('subject', SORT_NATURAL);
            // $s2 = $s2->values()->all();
            // $unique_sub['unq_sub'] = $s2;
            $data['subjects'] = Subject::where(['status'=>'A'])->where('branch_id',$request->branch_id)->orderBy('display_order','asc')->get();

            $data['count'] = $data['subjects']->count();

            //$s2 = $data['subjects'];
            //$s2 = $s2->values()->all();
            //$data['subjects'] = $s2;
            $unique_sub['unq_sub'] = $data['subjects'];

            return view('teacher.modules.my_profile.get_sub')->with($unique_sub);
        }

    // $ar2=array();
    // $data['subjects']=Subject::where('status','A')->where(['branch_id'=>$request->branch_id])->orderBy('subject','asc')->get();
    //  foreach($data['subjects'] as $val2){
    //   $subject_id=$val2->id;
    //   array_push($ar2,$subject_id);
    // }

    // $output= array_merge(array_diff($ar1, $ar2), array_diff($ar2, $ar1));

    // $abc=array();
    // foreach($output as $val3){
    //   $ids=$val3;
    //   array_push($abc, $ids);
    // }

    // $unique_sub['unq_sub']=Subject::whereIn('id',$abc)->where('status','A')->where(['branch_id'=>$request->branch_id])->orderBy('subject','asc')->get();



    //$output['subjects']=Subject::where('status','A')->orderBy('id','asc')->get();

      // $data['find']=TutorshipPlan::where(['grade_id'=>$request->grade_id,'teacher_id',Auth()->user()->id,'status'=>'A'])->pluck('subject_id')->get();

      // $ar1=array();
      // foreach($data['find'] as $val1){
      //   $subject_id=$val1->subject_id;
      //   array_push($ar1,$subject_id);
      // }
      // $ar2=array();
      // $data['subjects']=Subject::where('status','A')->where(['branch_id'=>$request->branch_id])->orderBy('subject','asc')->get();
      //  foreach($data['subjects'] as $val2){
      //   $subject_id=$val2->id;
      //   array_push($ar2,$subject_id);
      // }
      // $unique_sub['unq_sub']=Subject::where(['branch_id'=>$request->branch_id,'status'=>'A'])->whereNotIn('id',$data['find'])->orderBy('subject','asc')->get();

      //return response()->json(['ids'=>@$unique_sub['unq_sub']]);
   }

















    //---------------------TEACHER EXPERIENCE---------------------------------//



   public function experience_list(Request $request){
    $data['tutor_exp']=TutorExperience::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->with('getExpToSub')->get();
    $data['subject']=Subject::where('status','A')->orderBy('subject','asc')->get();
    $data['branches']=Branch::orderBy('branch_name','asc')->where('status','A')->get();
    $s2 = $data['subject']->sortBy('subject', SORT_NATURAL);
        $s2 = $s2->values()->all();
        $data['subject'] = $s2;
        return view('teacher.modules.teacher_exp.teacher_exp_list')->with($data);

   }








   public function exp_ins(Request $request){
    //dd($request->all());
    $request->validate([
        'organization' => 'required',
        'is_educational_institution' => 'required',
        // 'institution_name' => 'required_if:is_educational_institution,1',
        'institution_type' => 'required_if:is_educational_institution,1',
        'job_title' => 'required',
        // 'year_of_exp' => 'required',
        // 'description'  => 'required',
        'from_year'=>      'required',
        'to_year'=>      'required',
      ]);

    $ins_exp=new TutorExperience();
    $ins_exp->organization=$request->organization;
    $ins_exp->is_educational_institution=$request->is_educational_institution;
    $ins_exp->institution_name = (isset($request->institution_name) && $request->institution_name) ? $request->institution_name : NULL;
    $ins_exp->institution_type = (isset($request->institution_type) && $request->institution_type) ? $request->institution_type : NULL;
    $ins_exp->job_title=$request->job_title;
    // $ins_exp->year_of_exp=$request->year_of_exp;
    $ins_exp->status='A';
    // $ins_exp->description=@$request->description;
    $ins_exp->from_year=$request->from_year;
    $ins_exp->to_year=$request->to_year;
    $ins_exp->teacher_id=Auth()->user()->id;

    $ins_exp->save();

    //update the exp in master table
    $getExp=TutorExperience::where('status','A')->where('teacher_id',Auth()->user()->id)->sum('year_of_exp');
    $upd=User::where('id',Auth()->user()->id)->update(['total_experience'=>$getExp]);


    //ADD the subjects to exp_to_sub table
    if(@$request->subject){
      // foreach($request->subject as $key=> $val){
        $ins_sub=new ExpToSubject();
        $ins_sub->teacher_id=Auth()->user()->id;
        $ins_sub->exp_id=$ins_exp->id;
        $ins_sub->subject_id=$request->subject;

        $ins_sub->save();
      // }
    }
    return back()->with('success','The experience has been added.');
   }







   public function exp_dlt($id){
    //dd($id);
      $delete_exp=TutorExperience::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
      if($delete_exp){
        $tdlt=TutorExperience::where('id',$id)->where('teacher_id',Auth()->user()->id)->update(['status'=>'D']);

        //update the exp in master table
      $getExp=TutorExperience::where('status','A')->where('teacher_id',Auth()->user()->id)->sum('year_of_exp');
      $upd=User::where('id',Auth()->user()->id)->update(['total_experience'=>$getExp]);

      //delete from exp_to_sub table
      $findForDel=ExpToSubject::where('exp_id',$id)->where('teacher_id',Auth()->user()->id)->get();
      if(count($findForDel)>0){
        foreach($findForDel as $del){
          $dlt=ExpToSubject::where('exp_id',$del->exp_id)->delete();
        }
      }

        return back()->with('success','Experience removed.');
      }else{
        return back()->with('error','Unauthorized access.!');
      }
   }








   public function exp_edit_page($id){
    $data['tutor_exp']=TutorExperience::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
    $data['subject']=Subject::where('status','A')->orderBy(\DB::raw('LENGTH(subject), subject'))->get();
    $s2 = $data['subject']->sortBy('subject', SORT_NATURAL);
        $s2 = $s2->values()->all();
        $data['subject'] = $s2;
    $data['already_sub']=ExpToSubject::where('exp_id',$id)->where('teacher_id',Auth()->user()->id)->get();
     $data['edit_exp']=TutorExperience::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
     $data['sinfo']=Subject::where(['id'=>@$data['already_sub'][0]->subject_id])->first();

     $data['branches']=Branch::orderBy('branch_name','asc')->where('status','A')->get();
       return view('teacher.modules.teacher_exp.teacher_exp_edit')->with($data);
   }







   public function exp_update(Request $request){
     if(@$request->exp_id){
        $check=TutorExperience::where('year_of_exp',@$request->year_of_exp)->where('organization',@$request->organization)->where('job_title',@$request->job_title)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->where('id','!=',$request->exp_id)->first();
        if(!@$check){
          $up=array(
            'organization'=>@$request->organization,
            'is_educational_institution'=>$request->is_educational_institution,
            'institution_name' => (isset($request->institution_name) && $request->institution_name) ? $request->institution_name : NULL,
            'institution_type' => (isset($request->institution_type) && $request->institution_type) ? $request->institution_type : NULL,
            'job_title'=>@$request->job_title,
            // 'year_of_exp'=>@$request->year_of_exp,
            // 'description'=>@$request->description,
            'from_year'=>$request->from_year,
            'to_year'=>$request->to_year,
          );

          $updt=TutorExperience::where('id',$request->exp_id)->where('teacher_id',Auth()->user()->id)->update($up);

          //update the exp in master table
          $getExp=TutorExperience::where('status','A')->where('teacher_id',Auth()->user()->id)->sum('year_of_exp');
          $upd=User::where('id',Auth()->user()->id)->update(['total_experience'=>$getExp]);

            //Delete and newly insert the exp_to_sub table (update)
            if($request->subject){
                $findForDel=ExpToSubject::where('exp_id',$request->exp_id)->where('teacher_id',Auth()->user()->id)->get();
                if(count($findForDel)>0){
                    foreach($findForDel as $del){
                      $dlt=ExpToSubject::where('exp_id',$del->exp_id)->delete();
                    }
                }
                if(@$request->subject){


                // foreach(@$request->subject as $key=> $val){
                    $ins_sub=new ExpToSubject();
                    $ins_sub->teacher_id=@Auth()->user()->id;
                    $ins_sub->exp_id=$request->exp_id;
                    $ins_sub->subject_id=@$request->subject;

                    $ins_sub->save();
                // }
                }

            }
            return redirect()->route('tutor.exp')->with('success','Experience updated successfully.');
        }else{
          return back()->with('error','This experience already added');
        }

        }
   }


















//---------------------------RECOGINATION--------------------------------//

  public function rightToWork(Request $request){
    $data['tutor_wwcc'] = [];
    $exist_taf = TutorApplicationFormsModel::selectRaw('MIN(id) as id')
        ->Where('status', '!=', 2)
        ->groupBy('tutor_id')
        ->pluck('id')
        ->toArray();
    if(count($exist_taf) != 0){
        $data['tutor_wwcc'] = TutorWWCCModel::where('tutor_id',Auth()->user()->id)->WhereIn('tutor_app_id', $exist_taf)->orderby('id','asc')->get();
    }

    return view('teacher.modules.teacher_right_to_work.teacher_right_to_work_list')->with($data);
  }

  public function recognization_list(Request $request){
    $data['tutor_rec']=TutorRecognision::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
        return view('teacher.modules.teacher_recognization.teacher_rec_list')->with($data);
  }




   public function rec_ins(Request $request){
     $request->validate([
        'organization' => 'required',
        'location' => 'required',
        'recg_title' => 'required',
        'year_of_recg' => 'required',
        // 'description'  => 'required',
      ]);

        $ins_recog=new TutorRecognision();
    $ins_recog->organization=@$request->organization;
    $ins_recog->location=@$request->location;
    $ins_recog->recg_title=@$request->recg_title;
    $ins_recog->year_of_recg=@$request->year_of_recg;
    $ins_recog->status='A';
    $ins_recog->description=@$request->description;
    $ins_recog->teacher_id=Auth()->user()->id;

    $ins_recog->save();
    return back()->with('success','The recognition has been added.');
   }





   public function rec_dlt($id){
    $delete_rec=TutorRecognision::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
      if($delete_rec){
        TutorRecognision::where('id',$id)->where('teacher_id',Auth()->user()->id)->update(['status'=>'D']);
        return back()->with('success','Recognization removed.');
      }else{
        return back()->with('error','Unauthorized access.!');
      }
   }





   public function rec_edit_page($id){
      $data['tutor_rec']=TutorRecognision::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
     $data['edit_rec']=TutorRecognision::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
       return view('teacher.modules.teacher_recognization.teacher_rec_edit')->with($data);
   }




   public function rec_update(Request $request){
     if($request->rec_id){


        $check=TutorRecognision::where('year_of_recg',@$request->year_of_recg)->where('organization',@$request->organization)->where('recg_title',@$request->recg_title)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->where('id','!=',$request->rec_id)->first();
        if(!@$check){
          $up=array(
            'organization'=>@$request->organization,
            'location'=>@$request->location,
            'recg_title'=>@$request->recg_title,
            'year_of_recg'=>@$request->year_of_recg,
            'description'=>@$request->description,

          );

          $updt=TutorRecognision::where('id',$request->rec_id)->where('teacher_id',Auth()->user()->id)->update($up);
                return redirect()->route('tutor.recognization')->with('success','Recognization updated successfully.');
        }else{
          return back()->with('error','This recognization already added');
        }

        }
   }



















//-------------------------------TEACHER ACADAMIC-------------------------------//


    public function acadamic_list(Request $request){
    $data['tutor_acd']=TutorAcademic::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
    $data['university']=University::orderBy('university_name','asc')->get();
    $data['study_field']=FieldOfStudy::orderBy('field_of_study','asc')->get();
        return view('teacher.modules.teacher_academic.academic_list')->with($data);
   }




   public function academic_ins(Request $request){
    $request->validate([
        'qualification' => 'required',
        'field_of_study' => 'required',
        'university' => 'required',
        'qualification_status'  => 'required',
        'located_in'  => 'required',
        'effective_date'  => 'required',
    ]);

    // Already exists or not
    $check = TutorAcademic::where('qualification', $request->qualification)
        ->where('field_of_study', $request->field_of_study)
        ->where('teacher_id', Auth()->user()->id)
        ->where('status','!=','D')
        ->first();

    if($check){
        return back()->with('error','This qualification details already added.');
    }

    // Convert dd-mm-Y to Y-m-d for database
    $effectiveDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->effective_date)
                                   ->format('Y-m-d');

    $ins_aced = new TutorAcademic();
    $ins_aced->qualification = $request->qualification;
    $ins_aced->field_of_study = $request->field_of_study;

    if($request->university == 'O'){
        $cUniversity['university_name'] = $request->university_name;
        $cUniversity['slug'] = Str::slug($request->university_name, '-');
        $crUniversity = University::create($cUniversity);
        $ins_aced->university = $crUniversity->id;
    } else {
        $ins_aced->university = $request->university;
    }

    $ins_aced->status = 'A';
    $ins_aced->located_in = $request->located_in;
    $ins_aced->qualification_status = $request->qualification_status;

    // Use converted date
    $ins_aced->effective_date = $effectiveDate;

    $ins_aced->teacher_id = Auth()->user()->id;

    $ins_aced->save();

    return back()->with('success','Academic qualification has been added.');
}


 public function aced_dlt($id){

    $delete_aced=TutorAcademic::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();

      if($delete_aced){

        TutorAcademic::where('id',$id)->where('teacher_id',Auth()->user()->id)->update(['status'=>'D']);

        return back()->with('success','Qualification removed.');

      }else{

        return back()->with('error','Unauthorized access.!');

      }

   }

   public function aced_edit_page($id){
      $data['tutor_acd']=TutorAcademic::where('teacher_id',Auth()->user()->id)->orderby('id','desc')->where('status','A')->get();
     $data['edit_aced']=TutorAcademic::where('id',$id)->where('teacher_id',Auth()->user()->id)->first();
     $data['university']=University::orderBy('id','asc')->get();
     $data['study_field']=FieldOfStudy::orderBy('field_of_study','asc')->get();
       return view('teacher.modules.teacher_academic.academic_edit')->with($data);
   }





   public function aced_update(Request $request){
    if($request->aced_id){


        $check=TutorAcademic::where('qualification',@$request->qualification)->where('field_of_study',$request->field_of_study)->where('teacher_id',Auth()->user()->id)->where('status','!=','D')->where('id','!=',$request->aced_id)->first();
        if(!@$check){
          if(@$request->university == 'O'){
            $cUniversity['university_name'] = @$request->university_name;
            $cUniversity['slug'] = Str::slug(@$request->university_name, '-');
            $crUniversity = University::create($cUniversity);
            $up=array(
            'qualification'=>$request->qualification,
            'field_of_study'=>$request->field_of_study,
            'university'=>$crUniversity->id,
            'located_in'=>$request->located_in,
            'qualification_status'=>$request->qualification_status,
            'effective_date'=>$request->effective_date,

          );
          }else{
            $up=array(
            'qualification'=>$request->qualification,
            'field_of_study'=>$request->field_of_study,
            'university'=>$request->university,
            'qualification_status'=>$request->qualification_status,
            'located_in'=>$request->located_in,
            'effective_date'=>$request->effective_date,

          );
          }


          $updt=TutorAcademic::where('id',$request->aced_id)->where('teacher_id',Auth()->user()->id)->update($up);
                return redirect()->route('tutor.acadamic')->with('success','Qualification updated successfully.');
        }else{
          return back()->with('error','This qualification already added');
        }

        }
   }
   public function checkOldPassword(Request $request){
        // try{
            $old_password = trim(@$request->data['old_password']);

            if(!\Hash::check($old_password,@Auth()->user()->password)) {

                return "false";
            }else{

                return "true";
            }

        // }catch(\Exception $e){
        //     \Log::error($e->getMessage());
        //     return "false";

        // }
    }

 //---------------Academic Program--------------------------//

    public function tutorship_academic_program(Request $request){

        $teacherId = auth()->user()->id;

        $plans = TutorshipPlan::where('teacher_id', $teacherId)
                ->where('status', 'A')
                ->get();

        $grades = Grade::whereIn(
                    'id',
                    $plans->pluck('grade_id')->unique()
              )
              ->where('status', 'A')
              ->orderByRaw("CAST(SUBSTRING(grade_name, 6) AS UNSIGNED) ASC")
              ->get();

        $branches = Branch::whereIn(
                    'id',
                    $plans->pluck('branch_id')->unique()
                )
                ->where('status', 'A')
                ->orderBy('branch_name', 'asc')
                ->get();

        return view(
            'teacher.modules.academic_program.academic_program',
            compact('grades', 'branches')
        );
      }

    public function tutorship_academic_program_list(Request $request)
    {
      $draw   = intval($request->draw);
      $start  = intval($request->start);
      $length = intval($request->length);

      $teacherId = auth()->user()->id;

      $gradeIds = TutorshipPlan::where('teacher_id', $teacherId)
                    ->where('status', 'A')
                    ->pluck('grade_id')
                    ->unique();

      $branchIds = TutorshipPlan::where('teacher_id', $teacherId)
                    ->where('status', 'A')
                    ->pluck('branch_id')
                    ->unique();

      $tutorshipPlans = TutorshipPlan::where('teacher_id', $teacherId)
        ->where('status', 'A')
        ->get(['grade_id', 'branch_id']);

      $query = AcademicProgram::with(['grade', 'branch'])
        ->where('status', 1)
        ->where(function ($q) use ($tutorshipPlans) {
          foreach ($tutorshipPlans as $plan) {
            $q->orWhere(function ($q) use ($plan) {
                $q->where('grade_id', $plan->grade_id)
                  ->where('branch_id', $plan->branch_id);
            });
          }
      });


      if ($request->filled('grade_id')) {
        $query->where('grade_id', $request->grade_id);
      }

      if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
      }


      if ($request->filled('search_txt')) {
        $search = $request->search_txt;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('code', 'LIKE', "%{$search}%");
        });
      }

      $recordsTotal = AcademicProgram::where('status', 1)->count();

      $recordsFiltered = $query->count();

      $programs = $query
        ->orderBy('updated_at', 'desc')
        ->offset($start)
        ->limit($length)
        ->get();
      
      $stateMap = [
        'New South Wales' => 'NSW',
        'Victoria' => 'VIC',
        'Queensland' => 'QLD',
        'South Australia' => 'SA',
        'Western Australia' => 'WA',
        'Tasmania' => 'TAS',
        'Australian Capital Territory' => 'ACT',
        'Northern Territory' => 'NT',
      ];

      $data = [];

      foreach ($programs as $program) {

        $downloadLink = $program->tutor_session_plan
        ? '<a href="'.asset('storage/academic_program_docs/'.$program->tutor_session_plan).'" class="btn btn-sm btn-link" target="_blank" rel="noopener">View</a>'
        : '-';

        $data[] = [
            'name'       => $program->name,
            'subject'    => optional($program->branch)->branch_name ?? '-',
            'year'       => optional($program->grade)->grade_name ?? '-',
            'state'      => $stateMap[$program->state] ?? $program->state ?? '-',
            'curriculum' => explode(' ', trim($program->curriculum))[0] ?? '-',
            'document'   => $downloadLink,
        ];
      }

      return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data,
      ]);
  }
}   
