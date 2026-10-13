<?php

namespace App\Http\Controllers\Teacher\Dashboard;

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
use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\MyAvailability;
use App\Models\StudentClassBooking;
use App\Models\Tutor_calander_availability;
use App\Models\ReviewModel;

use App\Models\BookingToReviews;

// jayatri get enable disable bookings
use App\Models\AdminDisableBookingDates;
use App\Models\AdminDisableBookings;
use App\Models\Payments;



class DashboardController extends Controller
{

    public function teacher_dashboard(){
        // author : jayatri description : feedback point 10.11.2021 and 12-11-2021 
        // $data['count_todays_session'] = StudentClassBooking::where(['tutor_id'=>@Auth()->user()->id,'booking_date'=>date('Y-m-d')])->count();
        // $data['count_upcoming_session'] = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->where('booking_date','>',date('Y-m-d'))->count();
        // $data['count_past_session'] = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->where('booking_date','<',date('Y-m-d'))->count();
        // $data['count_total_session'] = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->count();
        // $data['count_reviews'] = ReviewModel::where(['tutor_id'=>@Auth::user()->id])->count();
        // $data['count_positive_reviews'] = ReviewModel::where(['tutor_id'=>@Auth::user()->id])->where('ratting','>=',4)->count();

        // $data['count_negative_reviews'] = ReviewModel::where(['tutor_id'=>@Auth::user()->id])->where('ratting','<',4)->count();
        // $tutor_id = @Auth::user()->id;
        // $data['count_total_payments'] = Payments::with(['getBookingsInfo']);
        // $data['count_total_payments'] = $data['count_total_payments']->whereHas('getBookingsInfo',function($query) use($tutor_id) {
        //     $query->where('tutor_id',$tutor_id);
        // });
        // $data['count_total_payments'] = $data['count_total_payments']->count();
        if(@Auth::user()->is_login == 1){
            session(['is_first' => 1]);
        }
        if(@Auth::user()->is_login == 0){

            session(['is_first' => 0]);   
            User::where('id',@Auth()->user()->id)->update(['is_login'=>"1"]);
        }
        $data['total_classes'] = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->whereIn('booking_status',['B','C','CM'])->count();
        if(@$data['total_classes'] <=0){
            $data['booked_classes'] = ((StudentClassBooking::where(['booking_status'=>'B','tutor_id'=>@Auth::user()->id])->count()))*100;
        $data['completed_classes'] = ((StudentClassBooking::where(['booking_status'=>'CM','tutor_id'=>@Auth::user()->id])->count()))*100;
        $data['cancelled_classes'] = ((StudentClassBooking::where(['booking_status'=>'C','tutor_id'=>@Auth::user()->id])->count()))*100;

        }else{
            $data['booked_classes'] = ((StudentClassBooking::where(['booking_status'=>'B','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
        $data['completed_classes'] = ((StudentClassBooking::where(['booking_status'=>'CM','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
        $data['cancelled_classes'] = ((StudentClassBooking::where(['booking_status'=>'C','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;

        }
        // $data['booked_classes'] = ((StudentClassBooking::where(['booking_status'=>'B','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
        // $data['completed_classes'] = ((StudentClassBooking::where(['booking_status'=>'CM','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
        // $data['cancelled_classes'] = ((StudentClassBooking::where(['booking_status'=>'C','tutor_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;

        $data['count_booked_classes'] = StudentClassBooking::where(['booking_status'=>'B','tutor_id'=>@Auth::user()->id])->count();
        $data['count_completed_classes'] = StudentClassBooking::where(['booking_status'=>'CM','tutor_id'=>@Auth::user()->id])->count();
        $data['count_cancelled_classes'] = StudentClassBooking::where(['booking_status'=>'C','tutor_id'=>@Auth::user()->id])->count();
        // Number of Classes per Tutor
        $data['top_tutors'] = StudentClassBooking::with('getStudent')->whereIn('booking_status',['CM','B'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id')->select(\DB::raw('DISTINCT student_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->take(5)->get();
        $data['tot_count_booking'] = $data['top_tutors']->sum('count_booking');
        if(@$data['tot_count_booking'] <= 0){
            $data['tot_count_booking'] = 1;
        }
        // dd($data['top_tutors']);
        // Number of Hours per Tutor
        $data['top_5_no_of_hours_per_tutor'] = StudentClassBooking::with('getStudent')->whereIn('booking_status',['CM','B'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id')->selectRaw('student_id,tutor_id,((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')->orderBy('shift_length')->take(5)->get();
        $data['tot_top_5_no_of_hours_per_tutor'] = $data['top_5_no_of_hours_per_tutor']->sum('shift_length');
        if(@$data['tot_top_5_no_of_hours_per_tutor'] <= 0){
            $data['tot_top_5_no_of_hours_per_tutor'] = 1;
        }
        // dd($data['top_5_no_of_hours_per_tutor']);
        // Subjects learnt by sessions
        // $data['sub_learn_no_hrs'] = StudentClassBooking::with('getStudent')->whereIn('booking_status',['CM'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id','subject_id')->selectRaw('subject_id,(SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))) as shift_length')->orderBy('shift_length')->take(5)->get();
        $data['sub_learn_sessions'] = StudentClassBooking::with('getSubject')->whereIn('booking_status',['CM','B'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('subject_id')->select(\DB::raw('DISTINCT subject_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->take(5)->get();
        $data['tot_sub_learn_sessions'] = $data['sub_learn_sessions']->sum('count_booking');
        if(@$data['tot_sub_learn_sessions'] <= 0){
            $data['tot_sub_learn_sessions'] = 1;
        }
        // dd($data['sub_learn_sessions']);

        $data['tot_hr_by_sub'] = StudentClassBooking::with('getStudent')->whereIn('booking_status',['CM','B'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('subject_id')->selectRaw('subject_id,((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')->orderBy('shift_length')->take(5)->get();
        $data['tot_tot_hr_by_sub'] = $data['tot_hr_by_sub']->sum('shift_length');
        if(@$data['tot_tot_hr_by_sub'] <= 0){
            $data['tot_tot_hr_by_sub'] = 1;
        }
        // payments
        $data['payments_by_subjects'] = StudentClassBooking::with('getSubject')->whereIn('booking_status',['B','CM','C'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('subject_id')->select(\DB::raw('DISTINCT subject_id, COUNT(*) AS count_booking,SUM(tutor_earnings) AS total_payments_by_subjects'))->orderBy('total_payments_by_subjects','desc')->take(5)->get();
        $data['total_payments_by_subjects']= StudentClassBooking::with('getSubject')->whereIn('booking_status',['B','CM'])->where(['tutor_id'=>@Auth::user()->id])->groupBy('subject_id')->sum('tutor_earnings');
        if(@$data['total_payments_by_subjects'] <= 0){
            $data['total_payments_by_subjects'] = 1;
        }
        // reviews
        
        // ->groupBy('student_id','tutor_id','ratting')
        // ->groupBy('student_id','tutor_id')
        $allB = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->whereIn('booking_status',['B','CM'])->pluck('id')->toArray();

        $data['cc_rev_pe'] = BookingToReviews::whereIn('booking_id',$allB)->count();
        // dd($data['cc_rev_pe']);
        if(@$data['cc_rev_pe'] > 0){
            // ->select(\DB::raw('DISTINCT rating, COUNT(*) AS count_n'))
            $data['rev_pe'] = BookingToReviews::whereIn('booking_id',$allB)->select(\DB::raw('DISTINCT rating, COUNT(*) AS count_n'))->groupBy('rating')->orderBy('rating','desc')->get();
            // dd($data['rev_pe']);
            $data['tot_rev_pe'] = BookingToReviews::whereIn('booking_id',$allB)->count();    
            // $data['tot_rev_pe'] = ReviewModel::with(['tutor','student'])->where(['tutor_id'=>@Auth::user()->id])->count();    
        }else{
            $data['rev_pe'] = BookingToReviews::whereIn('booking_id',$allB)->get();
            // $data['tot_rev_pe'] = ReviewModel::with(['tutor','student'])->where(['tutor_id'=>@Auth::user()->id])->count();    
            $data['tot_rev_pe'] = BookingToReviews::whereIn('booking_id',$allB)->count(); 
        }
        
        // $data['rev_pe'] = ReviewModel::with(['tutor','student'])->where(['tutor_id'=>@Auth::user()->id])->select(\DB::raw('DISTINCT ratting, COUNT(*) AS count_n'))->orderBy('count_n','desc')->get();
        
        // dd($data['rev_pe']);
        // if(@$data['tot_rev_pe'] <= 0){
        //     $data['tot_rev_pe'] = 1;
        // }
        // dd($data['rev_pe']);
        // $data['rev_pe_tot_cls'] = BookingToReviews::whereNotIn('user_id',[@Auth::user()->id])->groupBy('student_id','subject_id')->select(\DB::raw('DISTINCT subject_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->take(5)->get();
        // rev_pe_tot_cls
        // $data['total_reviews_given'] = BookingToReviews::where('user_id',@Auth::user()->id)->count();
        // $data['total_classes'] = StudentClassBooking::where(['tutor_id'=>@Auth::user()->id])->whereIn('booking_status',['CM'])->count();

    	return view('teacher.modules.dashboard.dashboard')->with($data);
    }




    public function reset_password_view(){
    	return view('teacher.modules.dashboard.reset_pass');
    }



    public function update_password(Request $request){
    		//dd($request->all());
        $request->validate([
           'old_password'        => 'required|string|min:6',
           'newPassword'=> 'required|min:6|required_with:confirm|same:confirm',
           'confirm'=>'required|min:6', 
         ]);
    	//dd(Auth::guard('admin')->id());
		$oldpassword = $request->input('old_password');
		if (!\Hash::check($oldpassword,Auth()->user()->password)) {
			return redirect()->back()->with('error','You have entered wrong old password!');
		}else{
			$updatepassword = User::where('id',Auth()->user()->id)->update([
				'password'=>\Hash::make($request->input('newPassword'))
			]);
			return redirect()->back()->with('success','Password updated successfully!');
		}
    }











    



    public function public_profile($slug){
        // jayatri get date after 30 days
        $data['nextMaxDate'] = date('Y-m-d', strtotime("+30 days"));
        $data['userDetails']=User::where('slug',$slug)->with('getTimezone','getTutorShipPlan.getSubject','getTutorShipPlan.getGrade','getTutorAcademic.getUniversity','getTutorExperience','getTutorRecognision','getuserToFavourite')->first();
        $data['getBookedTutors']=StudentClassBooking::where(['student_id'=>@Auth::user()->id])->whereIn('booking_status',['B','CM'])->pluck('tutor_id')->groupBy('tutor_id')->toArray();
        // jayatri checking disable/enable booking 29-10-2021
        $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
        $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status','A')->pluck('disable_booking_date')->toArray();

        if($data['userDetails']){
           

           //language
            $lan=LangToTutor::where('tutor_id',$data['userDetails']->id)->get();
            $blankLan=[];
            foreach($lan as $val){
              $l=Language::where('id',$val->language_id)->first();
              array_push($blankLan,$l->language);
            }         
            $data['languages']=implode(",",$blankLan);
            //dd($blankLan,$data['a']);



            //qualification
            $qualification=TutorAcademic::where('teacher_id',$data['userDetails']->id)->where('status','A')->get();
            $blankQua=[];
            foreach($qualification as $val){
                if($val->qualification=="1"){
                     array_push($blankQua,"Doctoral Degree");
                }
                elseif($val->qualification=="2"){
                     array_push($blankQua,"Postgraduate");
                }
                elseif($val->qualification=="3"){
                     array_push($blankQua,"Master's Degree (Research)");
                }
                elseif($val->qualification=="4"){
                     array_push($blankQua,"Master's Degree");
                }
                elseif($val->qualification=="5"){
                     array_push($blankQua,"Bachelor Honours Degree");
                }
                elseif($val->qualification=="6"){
                     array_push($blankQua,"Bachelor’s Degree");
                }
                elseif($val->qualification=="7"){
                     array_push($blankQua,"Associate Degree");
                }
                elseif($val->qualification=="8"){
                     array_push($blankQua,"Advanced Diploma ");
                }
                else/*if($val->qualification=="9")*/{
                     array_push($blankQua,"Diploma");
                }
            }
            //dd($blankQua);
            $uniqueQua=[];
            foreach($blankQua as $val){
                if(!in_array($val, $uniqueQua)){
                array_push($uniqueQua, $val);
                }
            }
            $data['qualifications']=implode(",",$uniqueQua);
           // dd($blankQua,$uniqueQua, $data['qualifications']);





            // //availability
            // $av=MyAvailability::where('teacher_id',$data['userDetails']->id)->get();
            // $monday=[];
            // $tues=[];
            // $wed=[];
            // $thurs=[];
            // $fri=[];
            // $sat=[];
            // $sun=[];
            // foreach($av as $val){
            //     if($val->day=='1'){
            //          array_push($monday,$val);
            //     }elseif($val->day=='2'){
            //         array_push($tues,$val);
            //     }
            //     elseif($val->day=='3'){
            //         array_push($wed,$val);
            //     }
            //     elseif($val->day=='4'){
            //         array_push($thurs,$val);
            //     }
            //     elseif($val->day=='5'){
            //         array_push($fri,$val);
            //     }
            //     elseif($val->day=='6'){
            //         array_push($sat,$val);
            //     }else{
            //          array_push($sun,$val);
            //     }
            // }
            // //dd($monday,$tues,$wed,$thurs,$fri,$sat,$sun);
            // @$data['mon']= $monday;
            // @$data['tues']= $tues;
            // @$data['wed']= $wed;
            // @$data['thurs']= $thurs;
            // @$data['fri']= $fri;
            // @$data['sat']= $sat;
            // @$data['sun']= $sun;
            //  @$data['av']= $av;





       //subjects get
        $subjects=TutorshipPlan::where('teacher_id',$data['userDetails']->id)->where('status','A')->get();
        $unique=[];
        foreach($subjects as $val){
            if(!in_array($val->subject_id, $unique)){
                array_push($unique, $val->subject_id);
            }
        }

        $data['subject']=Subject::whereIn('id',$unique)->get();
        
        //taking lowest price
        $data['hourly_rate']=TutorshipPlan::where('teacher_id',(int)$data['userDetails']->id)->where('status','A')->orderBy('hourly_rate')->first();

        //dd($data['hourly_rate'],(int)$data['userDetails']->id);


        $data['id']=$data['userDetails']->id;
        //dd($data['userDetails']);










        // $allbook=StudentClassBooking::where('tutor_id',(int)$data['userDetails']->id)->get();
        // $bookedd=[];
        // foreach($allbook as $val){
        //     $date=explode("-",$val->booking_date);
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($date,$from,$to);

        //     $data1=[];
        //      //$data1['id']=$val->id;
        //     $data1['year']=$date[0];
        //     $data1['month']=$date[1];
        //     $data1['day']=$date[2];

        //     $data1['from_hour']=$from[0];
        //     $data1['from_min']=$from[1];

        //     $data1['to_hour']=$to[0];
        //     $data1['to_min']=$to[1];

        //      array_push($bookedd, $data1);

        // }
        // $data['booked']=$bookedd;


/*--------------------------------Avalability fetch START---------------------------------------*/
        $allbook=Tutor_calander_availability::where('booking_status','B')->where('tutor_id',(int)$data['userDetails']->id)->where('date','<=',$data['nextMaxDate'])->where('date','>=',date('Y-m-d'))->get();
       
       //dd($allbook);
        $bookedd2=[];
        foreach($allbook as $val){
            $date=explode("-",$val->date);
            $from=explode(":",$val->start_time);
            $to=explode(":",$val->end_time);
           // dd($date,$from,$to);

            $data12=[];
             //$data12['id']=$val->id;
            $data12['year']=$date[0];
            $data12['month']=$date[1];
            $data12['day']=$date[2];

            $data12['from_hour']=$from[0];
            $data12['from_min']=$from[1];

            $data12['to_hour']=$to[0];
            $data12['to_min']=$to[1];

             array_push($bookedd2, $data12);

        }
        $data['booked']=$bookedd2;








         /*for availabale booking*/
        $notbook=Tutor_calander_availability::where('booking_status','NB')->where('tutor_id',(int)$data['userDetails']->id)->where('date','<=',$data['nextMaxDate'])->where('date','>=',date('Y-m-d'))->get();
       
       //dd($notbook);
        $nb=[];
        foreach($notbook as $val){
            $date=explode("-",$val->date);
            $from=explode(":",$val->start_time);
            $to=explode(":",$val->end_time);
           // dd($date,$from,$to);

            $data12=[];
             //$data12['id']=$val->id;
            $data12['year']=$date[0];
            $data12['month']=$date[1];
            $data12['day']=$date[2];

            $data12['from_hour']=$from[0];
            $data12['from_min']=$from[1];

            $data12['to_hour']=$to[0];
            $data12['to_min']=$to[1];

             array_push($nb, $data12);

        }
        $data['notbook']=$nb;
/*----------------------------------Availibility fetch END--------------------------------------------*/





        // $today= date('Y-m-d');
        // $next_due_date = date('Y-m-d', strtotime("+90 days"));    

    // $monday=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',1)->get();
    //     $data['availability_mon']=$monday;


    //     $tues=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',2)->with('getBook')->get();
    //     $data['availability_tues']=$tues;



    //     $wed=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',3)->get();
    //     $data['availability_wed']=$wed;


    //     $thurs=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',4)->get();
    //      $data['availability_thurs']=$thurs;


    //     $fri=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',5)->get();
    //     $data['availability_fri']=$fri;


    //     $sat=MyAvailability::where('teacher_id',(int)$data['userDetails']->id)->where('day',6)->get();
    //     $data['availability_sat']=$sat;
      
          $data['t_my_av_show'] = MyAvailability::where(['teacher_id'=>$data['userDetails']->id,'status'=>'A'])->get();

           $data['reviews'] = ReviewModel::where('tutor_id',$data['userDetails']->id)->get();
           //dd($data['reviews']);

        return view('teacher.modules.public_profile.teacher_public_profile')->with($data);
    }else{
        return view('errors.404');
    }
    }




























    public function getdata(){
        // $data['getdata']=MyAvailability::where('teacher_id',34)->get();

        // $ab='[TaskID":5,"OwnerID":2,"Title":"Take the dog to the vet","Description":"","StartTimezone":null,"Start":"\/Date(1370847600000)\/","End":"\/Date(1370851200000)\/","EndTimezone":null,"RecurrenceRule":null,"RecurrenceID":null,"RecurrenceException":null,"IsAllDay":false';

        // return json_encode($ab);
        $allbook=StudentClassBooking::where('tutor_id',34)->get();

        $bookedd=[];
        foreach($allbook as $val){
            $date=explode("-",$val->booking_date);
            $from=explode(":",$val->from_time);
            $to=explode(":",$val->to_time);
            //dd($date,$from,$to);

            $data=[];
             //$data['id']=$val->id;
            $data['year']=$date[0];
            $data['month']=$date[1];
            $data['day']=$date[2];

            $data['from_hour']=$from[0];
            $data['from_min']=$from[1];

            $data['to_hour']=$to[0];
            $data['to_min']=$to[1];

             array_push($bookedd, $data);

        }
        $data['booked']=$bookedd;

        // if(in_array("2021",$bookedd)){
        //     dd("h",$bookedd);
        // }else{
        //     dd("n",$bookedd);
        // }
       // dd($bookedd);
        $today= date('Y-m-d');
        $next_due_date = date('Y-m-d', strtotime("+90 days"));
      
      // for($i=0;$i<93;$i++){

      //   echo date('Y-m-d', strtotime("+".$i." days")) .'<br>';
      //   echo date('d', strtotime("+".$i." days")) .'<br>';
      //   echo date('m', strtotime("+".$i." days")) .'<br>';
      //   echo date('D', strtotime("+".$i." days")) .'<br>';
      // }


      //    echo $next_due_date.'<br>';

      //    echo $today;

    $monday=MyAvailability::where('teacher_id',34)->where('day',1)->get();
        // $m=[];
        // foreach($monday as $val){
        //     $data_mon=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_mon['av_from_hour']=$from[0];
        //     $data_mon['av_from_min']=$from[1];

        //     $data_mon['av_to_hour']=$to[0];
        //     $data_mon['av_to_min']=$to[1];
        //     array_push($m, $data_mon);
        // }
        //dd($m);
        //$data['availability_mon']=$m;
        $data['availability_mon']=$monday;




        $tues=MyAvailability::where('teacher_id',34)->where('day',2)->with('getBook')->get();
        //dd($tues);
        // $t=[];
        // foreach($tues as $val){
        //     $data_tues=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_tues['av_from_hour']=$from[0];
        //     $data_tues['av_from_min']=$from[1];

        //     $data_tues['av_to_hour']=$to[0];
        //     $data_tues['av_to_min']=$to[1];
        //     array_push($t, $data_tues);
        // }
       // dd($t);
        $data['availability_tues']=$tues;
       // dd( $data['availability_tues']);





        $wed=MyAvailability::where('teacher_id',34)->where('day',3)->get();
        //dd($wed);
        // $w=[];
        // foreach($wed as $val){
        //     $data_wed=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_wed['av_from_hour']=$from[0];
        //     $data_wed['av_from_min']=$from[1];

        //     $data_wed['av_to_hour']=$to[0];
        //     $data_wed['av_to_min']=$to[1];
        //     array_push($w, $data_wed);
        // }
        // //dd($m);
        // $data['availability_wed']=$w;
        $data['availability_wed']=$wed;






        $thurs=MyAvailability::where('teacher_id',34)->where('day',4)->get();
        // //dd($thurs);
        // $th=[];
        // foreach($thurs as $val){
        //     $data_thurs=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_thurs['av_from_hour']=$from[0];
        //     $data_thurs['av_from_min']=$from[1];

        //     $data_thurs['av_to_hour']=$to[0];
        //     $data_thurs['av_to_min']=$to[1];
        //     array_push($th, $data_thurs);
        // }
        // //dd($m);
        // $data['availability_thurs']=$th;
         $data['availability_thurs']=$thurs;






        $fri=MyAvailability::where('teacher_id',34)->where('day',5)->get();
        // //dd($fri);
        // $fr=[];
        // foreach($fri as $val){
        //     $data_fri=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_fri['av_from_hour']=$from[0];
        //     $data_fri['av_from_min']=$from[1];

        //     $data_fri['av_to_hour']=$to[0];
        //     $data_fri['av_to_min']=$to[1];
        //     array_push($fr, $data_fri);
        // }
        // //dd($m);
        // $data['availability_fri']=$fr;
        //dd( $data['availability_fri']);
        $data['availability_fri']=$fri;





        $sat=MyAvailability::where('teacher_id',34)->where('day',6)->get();
        // //dd($sat);
        // $st=[];
        // foreach($sat as $val){
        //     $data_sat=[];
        //     $from=explode(":",$val->from_time);
        //     $to=explode(":",$val->to_time);
        //     //dd($from,$to);
        //     $data_sat['av_from_hour']=$from[0];
        //     $data_sat['av_from_min']=$from[1];

        //     $data_sat['av_to_hour']=$to[0];
        //     $data_sat['av_to_min']=$to[1];
        //     array_push($st, $data_sat);
        // }
        // //dd($m);
        // $data['availability_sat']=$st;
        $data['availability_sat']=$sat;
        //dd( $data['availability_fri']);
         return view('static.modules.message.abc')->with($data);

    }







}
