<?php

namespace App\Http\Controllers\Teacher\RescheduleBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Subject;
use App\Models\StudentClassBooking;
use App\Models\MyAvailability;
use App\Models\TutorshipPlan;
use App\Models\UserToFavourite;
use App\Models\Tutor_calander_availability;
use App\Models\Grade;
use App\Models\User;
use Validator;
use Mail;
use App\Mail\RescheduleBookingMail;

class RescheduleBookingController extends Controller
{
    public function sendRescheduleBookingMail($bookingNo){
        try{
            $data['bookingDataInformation'] = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade'])->where(['booking_no'=>$bookingNo])->first();
            Mail::send(new RescheduleBookingMail($data));
        }catch(\Exception $e){
            \Log::error($e->getMessage());
        }
    }
    /*
    * Method        :
    * Description   : This method is used to view reschedule booking details and get tutor details and booking details and date from time to time and subjects
    * Author        : Jayatri
    * Date          : 25-10-2021
    */
    public function viewRescheduleBooking($bookingNo)
    {
        $data['nextMaxDate'] = date('Y-m-d', strtotime("+30 days"));

        $data['getBookingInfo'] = $getBookingInfo = StudentClassBooking::with(['getStudent','getTutor.languguageToTuor','getTutor.getTutorAcademic','getSubject','getStudentGrade'])->where(['booking_no'=>$bookingNo,'tutor_id'=>@Auth::user()->id,'booking_rescheduled'=>'0'])->whereIn('booking_status',['B'])->first();


        if(@$getBookingInfo){

            $data['currentDiff'] = (strtotime($getBookingInfo->to_time) - strtotime($getBookingInfo->from_time))/60;

            $data['grade'] = Grade::where(['id'=>@$getBookingInfo->student_grade_id,'status'=>'A'])->first();
            $data['vtutor'] = User::with(['getTutorShipPlan.getSubject','getTutorAcademic','languguageToTuor'])->where(['id'=>@$getBookingInfo->tutor_id])->first();
            if(@$data['vtutor']){
                $data['subjects'] = TutorshipPlan::with(['getSubject'])->where(['teacher_id'=>$data['vtutor']->id])->get();
                $data['t_my_av_show'] = MyAvailability::where(['teacher_id'=>$data['vtutor']->id,'status'=>'A'])->get();
                $allbook=Tutor_calander_availability::where('booking_status','B')->where('date','<=',$data['nextMaxDate'])->where('date','>=',date('Y-m-d'))->where('tutor_id',(int)$data['vtutor']->id)->get();
                $data['get_available_dates'] = Tutor_calander_availability::where(['tutor_id'=>$data['vtutor']->id,'booking_status'=>'NB'])->where('date','>=',date('Y-m-d'))->where('date','<=',$data['nextMaxDate'])->pluck('date')->toArray();
                $data['get_available_start_times'] = Tutor_calander_availability::where(['tutor_id'=>$data['vtutor']->id,'booking_status'=>'NB'])->groupBy('start_time')->pluck('start_time')->toArray();
                $data['get_available_end_times'] = Tutor_calander_availability::where(['tutor_id'=>$data['vtutor']->id,'booking_status'=>'NB'])->groupBy('end_time')->pluck('end_time')->toArray();

                //dd($allbook);
                $bookedd2=[];
                if(@$allbook){
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
                }

                $data['booked']=$bookedd2;
                /*for availabale booking*/
                $notbook=Tutor_calander_availability::where('booking_status','NB')->where('date','<=',$data['nextMaxDate'])->where('date','>=',date('Y-m-d'))->where('tutor_id',(int)$data['vtutor']->id)->get();

                $nb=[];
                if(@$notbook){
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
                }
                $data['notbook']=$nb;
                return view('teacher.modules.reschedule_booking.reschedule_booking')->with($data);
            }else{
                session()->flash("error","You cannot reschedule this booking because you are not associated with this booking or booking status is changed!");
                return redirect()->route('tutor.myclass.upcoming');
            }
        }else{
            session()->flash("error","You cannot reschedule this booking because you are not associated with this booking or booking status is changed or booking already rescheduled!");
            return redirect()->route('tutor.myclass.upcoming');
        }

        // code...
    }
    public function updateRescheduleBooking($bookingNo,Request $request){
        try{
            if(@$request->all()){
                $getBookingInfo = StudentClassBooking::where(['booking_no'=>$bookingNo,'tutor_id'=>@Auth::user()->id,'booking_rescheduled'=>'0'])->whereIn('booking_status',['B'])->first();
                if(@$getBookingInfo){

                    // fetch date time day from request
                    $bookingDate = date("Y-m-d", strtotime($request->selected_booked_date));
                    $from_time = date("H:i:s", strtotime($request->from_time));
                    $to_time = date("H:i:s", strtotime($request->to_time));
                    $day = date("D", strtotime($request->selected_booked_date));
                    $tutor_id = $request->tutor_id;
                    //get day value
                    if($day == "Mon"){
                        $dValue = 1;
                    }
                    if($day == "Tue"){
                        $dValue = 2;
                    }
                    if($day == "Wed"){
                        $dValue = 3;
                    }
                    if($day == "Thu"){
                        $dValue = 4;
                    }
                    if($day == "Fri"){
                        $dValue = 5;
                    }
                    if($day == "Sat"){
                        $dValue = 6;
                    }
                    if($day == "Sun"){
                        $dValue = 7;
                    }
                    if($bookingDate < date('Y-m-d')){

                        session()->flash("error","Choose available time slot!Tutor is not available!Today from time to time should be greater than current time!");
                        return redirect()->route('tutor.myclass.upcoming');
                    }
                    if($bookingDate == date('Y-m-d')){
                        if($from_time <= date('H:i:s') || $to_time <= date('H:i:s')){
                            session()->flash("error","Choose available time slot!Tutor is not available!Today from time to time should be greater than current time!");
                            return redirect()->route('tutor.myclass.upcoming');
                        }
                    }
                    // get booking details
                    $prevBookingDetails = StudentClassBooking::where(['booking_no'=>$bookingNo])->first();


                    $getStudentHerselfBooked = array();

                    if(@$prevBookingDetails){
                        // reschedule duration should be same as per booking duration
                        $prevDiff = (strtotime($prevBookingDetails->to_time) - strtotime($prevBookingDetails->from_time))/60;
                        $currentDiff = (strtotime($to_time) - strtotime($from_time))/60;
                        if($currentDiff != $prevDiff){
                            session()->flash("error","Duration should be same!");
                            return redirect()->route('tutor.myclass.upcoming');
                        }
                        // if in between time if a student booked a slot and when request for reschedule provide a time which time is in between of previous booking time
                        // example student a 29-10-2021 7am -8am  a tutor want to reschedule 29-10-2021 to 7:30am to 8:30am
                        $getStudentHerselfBooked = Tutor_calander_availability::where(['tutor_id'=>$prevBookingDetails->tutor_id,'booking_status'=>'B','date'=>$prevBookingDetails->booking_date])->where('end_time','<=',$prevBookingDetails->to_time)->where('end_time','<=',$to_time);
                        $getStudentHerselfBooked = $getStudentHerselfBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                            $query->whereBetween('start_time',[$prevBookingDetails->from_time,$prevBookingDetails->to_time]);
                        });
                        $getStudentHerselfBooked = $getStudentHerselfBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                            $query->whereBetween('start_time',[$from_time,$to_time]);
                        });
                        $getStudentHerselfBooked = $getStudentHerselfBooked->pluck('id')->toArray();
                    }

                    if(!@$getStudentHerselfBooked){
                        $getStudentHerselfBooked = array();
                    }

                    // check whether tutor is available or not
                    // get all time slots and count

                    $starttime = $from_time;  // your start time
                    $endtime = $to_time;  // End time
                    $duration = '30';  // split by 30 mins

                    $array_of_time = array ();
                    $start_time    = strtotime ($starttime); //change to strtotime
                    $end_time      = strtotime ($endtime); //change to strtotime

                    $add_mins  = $duration * 60;
                    while ($start_time <= $end_time) // loop between time
                    {
                       $array_of_time[] = date ("h:i:s", $start_time);
                       $start_time += $add_mins; // to check endtime
                    }
                    $length=count($array_of_time);
                    $from_to_times=[];
                    $get_all_from_times=[];
                    $get_all_to_times=[];

                    for($k=0;$k<$length;$k++){
                        $data=[];
                        if($k+1<$length){
                            $data['from_time']=$array_of_time[$k];
                            $data['to_time']=$array_of_time[$k+1];
                            $frmT = "'".$data['from_time']."'";
                            $toT = "'".$data['to_time']."'";
                            array_push($from_to_times,$data);
                            array_push($get_all_from_times,$frmT);
                            array_push($get_all_to_times,$toT);
                        }
                    }
                    // count the time slots
                    $timeSlotCount = count($from_to_times);


                    // check booked or not
                    $chkBDtFrmTimeToTime = Tutor_calander_availability::whereNotIn('id',$getStudentHerselfBooked)->where(['tutor_id'=>$tutor_id,'booking_status'=>'B','date'=>$bookingDate])->where('end_time','<=',$to_time);

                    $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function($query) use($request,$from_time,$to_time) {
                        $query->whereBetween('start_time',[$from_time,$to_time]);
                    });

                    $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
                    if($chkBDtFrmTimeToTime > 0){
                        session()->flash("error","5 Choose available time slot!Tutor is not available!");
                        return redirect()->route('tutor.myclass.upcoming');
                    }
                    // check available if
                    $chkADtFrmTimeToTime = Tutor_calander_availability::whereNotIn('id',$getStudentHerselfBooked)->where(['tutor_id'=>$tutor_id,'booking_status'=>'NB','date'=>$bookingDate])->where('end_time','<=',$to_time);

                    $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function($query) use($request,$from_time,$to_time) {
                        $query->whereBetween('start_time',[$from_time,$to_time]);
                    });

                    $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();

                    if($chkADtFrmTimeToTime == 0){
                        session()->flash("error","6 Choose available time slot!Tutor is not available!");
                        return redirect()->route('tutor.myclass.upcoming');
                    }
                    // checking searching that 4 rows depend on date from time to time all are avilable  if
                    if($timeSlotCount == $chkADtFrmTimeToTime){
                        // true
                    }else{
                        // check available or not
                        $totalAvailCountforthisStudent =count($getStudentHerselfBooked)+$chkADtFrmTimeToTime;

                        if($timeSlotCount == $totalAvailCountforthisStudent){
                            // true
                        }else{
                            session()->flash("error","7 Choose available time slot!Tutor is not available!");
                            return redirect()->route('tutor.myclass.upcoming');
                        }

                    }



                    Tutor_calander_availability::where(['tutor_id'=>$getBookingInfo->tutor_id,'date'=>$getBookingInfo->booking_date])->where('start_time','>=',$getBookingInfo->from_time)->where('end_time','<=',$getBookingInfo->to_time)->update(['booking_status'=>'NB']);


                    StudentClassBooking::where(['id'=>$getBookingInfo->id])->update(['booking_date'=>$bookingDate,'booking_rescheduled'=>'1','from_time'=>$from_time,'to_time'=>$to_time]);
                    $updatedBookingInfo = StudentClassBooking::where(['booking_no'=>$bookingNo])->first();

                    Tutor_calander_availability::where(['tutor_id'=>$updatedBookingInfo->tutor_id,'date'=>$updatedBookingInfo->booking_date])->where('start_time','>=',$updatedBookingInfo->from_time)->where('end_time','<=',$updatedBookingInfo->to_time)->update(['booking_status'=>'B']);

                    try{
                        $this->sendRescheduleBookingMail($updatedBookingInfo->booking_no);
                    }catch(\Exception $e){
                        \Log::error($e->getMessage());
                    }

                    session()->flash("success","Your session".$updatedBookingInfo->booking_no." rescheduled on ".$updatedBookingInfo->booking_date." ".date('h:i a',strtotime($updatedBookingInfo->from_time))." - ".date('h:i a',strtotime($updatedBookingInfo->to_time)));

                    return redirect()->route('tutor.myclass.upcoming');

                }else{
                    session()->flash("error","This booking is already rescheduled!");
                    return redirect()->route('tutor.myclass.upcoming');
                }
            }else{
                session()->flash("error","This booking is already rescheduled!");
                return redirect()->route('tutor.myclass.upcoming');
            }
        }catch(\Exception $e){
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : ajaxCheckingTeacherRescheduleBooking
    * Description   : This method is used to check reschedule the date time is available or not depend on booking no  by tutor who is associated with this booking no.
    * Author        : Jayatri
    * Date          : 25-10-2021
    */
    public function ajaxCheckingTeacherRescheduleBooking(Request $request){
        try{
            // validation
            // $request->validate([
            //     'tutor_id'=>'required',
            //     'booking_no'=>'required',
            //     'get_booking_date'=>'required',
            //     'from_time'=>'required',
            //     'to_time'=>'required'
            // ]);
            $tutor_id = trim($request->data['tutor_id']);
            $bookingNo = trim($request->data['booking_no']);
            $bookingDate = date("Y-m-d", strtotime($request->data['get_booking_date']));
            $from_time = date("H:i:s", strtotime($request->data['from_time']));
            $to_time = date("H:i:s", strtotime($request->data['to_time']));
            $day = date("D", strtotime($request->data['get_booking_date']));

            //if previous day
            if(@$bookingDate < date('Y-m-d')){
                $data['output'] = 'false';
                $data['show_message'] = 'Choose available time slot!';
                return response()->json($data,200);
            }
            // if today if time is lesser than current time
            if(@$bookingDate == date('Y-m-d')){
                if($from_time <= date('H:i:s') || $to_time <= date('H:i:s')){
                    $data['output'] = 'false';
                    $data['show_message'] = 'Choose available time slot!';
                    return response()->json($data,200);
                }
            }

            // fetch day
            if($day == "Mon"){
                $dValue = 1;
            }
            if($day == "Tue"){
                $dValue = 2;
            }
            if($day == "Wed"){
                $dValue = 3;
            }
            if($day == "Thu"){
                $dValue = 4;
            }
            if($day == "Fri"){
                $dValue = 5;
            }
            if($day == "Sat"){
                $dValue = 6;
            }
            if($day == "Sun"){
                $dValue = 7;
            }
            // get booking details
            $prevBookingDetails = StudentClassBooking::where(['booking_no'=>$bookingNo])->first();


            $getStudentHerselfBooked = array();

            if(@$prevBookingDetails){

                // reschedule duration should be same as per booking duration
                $prevDiff = (strtotime($prevBookingDetails->to_time) - strtotime($prevBookingDetails->from_time))/60;
                $currentDiff = (strtotime($to_time) - strtotime($from_time))/60;
                if($currentDiff != $prevDiff){
                    $data['output'] = 'false';
                    $data['condition_no'] = '9';
                    $data['show_message'] = 'Duration should be '.$prevDiff." minutes !";
                    return response()->json($data,200);
                }
                // same date and same from time to time is not allowed
                if($bookingDate == $prevBookingDetails->booking_date && $from_time == $prevBookingDetails->from_time && $to_time == $prevBookingDetails->to_time){
                    $data['output'] = 'false';
                    $data['condition_no'] = '10';
                    $data['show_message'] = 'Same booking date and same from time and same to time is not allowed!Choose available time slot';
                    return response()->json($data,200);
                }
                // if in between time if a student booked a slot and when request for reschedule provide a time which time is in between of previous booking time
                // example student a 29-10-2021 7am -8am  a tutor want to reschedule 29-10-2021 to 7:30am to 8:30am
                // 1st step
                $getTutorStudentBooked = StudentClassBooking::where(['student_id'=>$prevBookingDetails->student_id,'tutor_id'=>$prevBookingDetails->tutor_id,'booking_status'=>'B','booking_date'=>$prevBookingDetails->booking_date])->where('to_time','<=',$prevBookingDetails->to_time)->where('from_time','<',$to_time);
                $getTutorStudentBooked = $getTutorStudentBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                    $query->whereBetween('from_time',[$prevBookingDetails->from_time,$prevBookingDetails->to_time]);
                });
                $getTutorStudentBooked = $getTutorStudentBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                    $query->whereBetween('from_time',[$from_time,$to_time]);
                });
                $getTutorStudentBooked = $getTutorStudentBooked->first();
                if(@$getTutorStudentBooked){
                    // 2nd step
                    $getStudentHerselfBooked = Tutor_calander_availability::where(['tutor_id'=>$prevBookingDetails->tutor_id,'booking_status'=>'B','date'=>$prevBookingDetails->booking_date])->where('end_time','<=',$prevBookingDetails->to_time)->where('end_time','<=',$to_time);
                    $getStudentHerselfBooked = $getStudentHerselfBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                        $query->whereBetween('start_time',[$prevBookingDetails->from_time,$prevBookingDetails->to_time]);
                    });
                    $getStudentHerselfBooked = $getStudentHerselfBooked->where(function($query) use($request,$from_time,$to_time,$prevBookingDetails) {
                        $query->whereBetween('start_time',[$from_time,$to_time]);
                    });
                    $getStudentHerselfBooked = $getStudentHerselfBooked->pluck('id')->toArray();
                }else{
                    $getStudentHerselfBooked = array();
                }
            }
            if(!@$getStudentHerselfBooked){
                $getStudentHerselfBooked = array();
            }
            // check whether tutor is available or not
            // get all time slots and count

            $starttime = $from_time;  // your start time
            $endtime = $to_time;  // End time
            $duration = '30';  // split by 30 mins

            $array_of_time = array ();
            $start_time    = strtotime ($starttime); //change to strtotime
            $end_time      = strtotime ($endtime); //change to strtotime

            $add_mins  = $duration * 60;
            while ($start_time <= $end_time) // loop between time
            {
               $array_of_time[] = date ("h:i:s", $start_time);
               $start_time += $add_mins; // to check endtime
            }
            $length=count($array_of_time);
            $from_to_times=[];
            $get_all_from_times=[];
            $get_all_to_times=[];

            for($k=0;$k<$length;$k++){
                $data=[];
                if($k+1<$length){
                    $data['from_time']=$array_of_time[$k];
                    $data['to_time']=$array_of_time[$k+1];
                    $frmT = "'".$data['from_time']."'";
                    $toT = "'".$data['to_time']."'";
                    array_push($from_to_times,$data);
                    array_push($get_all_from_times,$frmT);
                    array_push($get_all_to_times,$toT);
                }
            }
            // count the time slots
            $timeSlotCount = count($from_to_times);


            // check booked or not
            $chkBDtFrmTimeToTime = Tutor_calander_availability::whereNotIn('id',$getStudentHerselfBooked)->where(['tutor_id'=>$tutor_id,'booking_status'=>'B','date'=>$bookingDate])->where('end_time','<=',$to_time);

            $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->where(function($query) use($request,$from_time,$to_time) {
                $query->whereBetween('start_time',[$from_time,$to_time]);
            });

            $chkBDtFrmTimeToTime = $chkBDtFrmTimeToTime->count();
            // if same booking date time will count 0 because already booked previously
            if($chkBDtFrmTimeToTime > 0){
                $data['output'] = 'false';
                $data['condition_no'] = '2';
                $data['show_message'] = 'Choose available time slot!';
                $data['message'] = 'In between some time slots are booked!'."chkBDtFrmTimeToTime : ".$chkBDtFrmTimeToTime." timeSlotCount : ".$timeSlotCount;
                return response()->json($data,200);
            }
            // check available if
            $chkADtFrmTimeToTime = Tutor_calander_availability::whereNotIn('id',$getStudentHerselfBooked)->where(['tutor_id'=>$tutor_id,'booking_status'=>'NB','date'=>$bookingDate])->where('end_time','<=',$to_time);

            $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->where(function($query) use($request,$from_time,$to_time) {
                $query->whereBetween('start_time',[$from_time,$to_time]);
            });

            $chkADtFrmTimeToTime = $chkADtFrmTimeToTime->count();

            if($chkADtFrmTimeToTime == 0){
                $data['output'] = 'false';
                $data['condition_no'] = '3';
                $data['show_message'] = 'Choose available time slot!';
                $data['message'] = 'Time slot is not available';
                $data['d'] = 'Time slot is not available'."chkADtFrmTimeToTime : ".$chkADtFrmTimeToTime." timeSlotCount : ".$timeSlotCount;
                return response()->json($data,200);
            }
            // checking searching that 4 rows depend on date from time to time all are avilable  if
            if($timeSlotCount == $chkADtFrmTimeToTime){
                $data['output'] = 'true';
                $data['condition_no'] = '4';
                $data['show_message'] = 'Time slot is available';
                $data['message'] = 'This time slot is available';
                return response()->json($data,200);
            }else{
                // check available or not
                $totalAvailCountforthisStudent =count($getStudentHerselfBooked)+$chkADtFrmTimeToTime;

                if($timeSlotCount == $totalAvailCountforthisStudent){
                    $data['output'] = 'true';
                    $data['condition_no'] = '6';
                    $data['show_message'] = 'Time slot is available!';
                    $data['message'] = 'This time slot is available';
                    return response()->json($data,200);
                }else{
                    $data['output'] = 'false';
                    $data['condition_no'] = '5';
                    $data['show_message'] = 'Choose available time slot!';
                    $data['message'] = 'Time slot is not available';
                    return response()->json($data,200);
                }

            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
            $data['output'] = 'false';
            $data['show_message'] = 'Choose available time slot!'.$e->getMessage();
            return response()->json($data,200);
        }
    }
}
