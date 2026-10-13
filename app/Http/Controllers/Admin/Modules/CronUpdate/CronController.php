<?php

namespace App\Http\Controllers\Teacher\CronUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TutorAcademic;
use App\Models\StudentClassBooking;
use App\Models\Tutor_transaction;
use App\Models\Tutor_calander_availability;

class CronController extends Controller
{




//this function to make all Status "B" to "CM", if time is over..
	public function updateToCm(){
		//dd("up11");
		//take all status "B" from table StudentClassBooking for present date
		$allBooked=StudentClassBooking::where('booking_status','B')->where('booking_date',date('Y-m-d') )->get();
		foreach($allBooked as $val){
			if($val->to_time <=  date('H:i:s')){
				//update to cm
				$u1=array(
					'booking_status'=>'CM'
				);
				$up1=StudentClassBooking::where('id',$val->id )->update($u1);
        $UserDetails=User::where('id',$valPast->tutor_id)->first();

        $updateEar=array(
          'total_earning'=> $valPast->total_earning+$UserDetails->total_earning,
          'total_due'=> $valPast->total_earning+$UserDetails->total_due,
          'total_commission'=>$valPast->admin_commission+$UserDetails->admin_commission
        );
        $u=User::where('id',$valPast->tutor_id)->update($updateEar);
			}
		}

		//take all status "B" from table StudentClassBooking for past date
		$allBookedPast=StudentClassBooking::where('booking_status','B')->where('booking_date','<',date('Y-m-d') )->get();
		foreach($allBookedPast as $valPast){
			 //update to cm
				$u2=array(
					'booking_status'=>'CM'
				);
				$up2=StudentClassBooking::where('id',$valPast->id )->update($u2);
        $UserDetails=User::where('id',$valPast->tutor_id)->first();

        $updateEar=array(
          'total_earning'=> $valPast->total_earning+$UserDetails->total_earning,
          'total_due'=> $valPast->total_earning+$UserDetails->total_due,
          'total_commission'=>$valPast->admin_commission+$UserDetails->admin_commission
        );
        $u=User::where('id',$valPast->tutor_id)->update($updateEar);
        // Update academic session
        if ($valPast->academicProgramSession) {
          $valPast->academicProgramSession->update([
            'status' => 'completed'
          ]);
        }
		}
		//dd('up');
		//------------------UPDATE ALL RS/- IN USER TABLE ------------------
		 	// $allTutor=StudentClassBooking::where('booking_status','CM')->get();
    // 	$blank=[];
    // 	foreach($allTutor as $val){
    // 		if(!in_array($val->tutor_id, $blank)){
    //             array_push($blank, $val->tutor_id);
    //             }
    // 	}
    // 	//dd($blank);
    //     $blank2=[];
    // 	foreach($blank as $tutor){
    // 		$findTotalAmount=StudentClassBooking::whereIn('booking_status',['CM'])->where('tutor_id',$tutor)->sum('booking_amount');
    //     $admin_commission=StudentClassBooking::whereIn('booking_status',['CM','C'])->where('tutor_id',$tutor)->sum('admin_commission');
    // 		$findTotalEarning=StudentClassBooking::whereIn('booking_status',['CM','C'])->where('tutor_id',$tutor)->sum('tutor_earnings');
    // 		 array_push($blank2, $findTotalEarning);

    // 		 $UserDetails=User::where('id',$tutor)->first();
    // 		 $prevEarning=$UserDetails->total_earning;
    // 		 $prevDue=$UserDetails->total_due;
    // 		 $prevComm=$UserDetails->total_commission;

    // 		 $updateEar=array(
    // 		 	'total_earning'=> $prevEarning+($findTotalEarning-$prevEarning),
    // 		 	'total_due'=> $prevDue+($findTotalEarning-$prevEarning),
    // 		 	// 'total_commission'=>/*$prevComm+*/($findTotalAmount-$findTotalEarning)
    //       'total_commission'=>/*$prevComm+*/($admin_commission)
    // 		 );
    // 		 $u=User::where('id',$tutor)->update($updateEar);

    // 	}
    	dd('up');
	}













    public function update_earning(){
    	//dd("up22");
    	// $allTutor=StudentClassBooking::where('booking_status','CM')->get();
    	// $blank=[];
    	// foreach($allTutor as $val){
    	// 	if(!in_array($val->tutor_id, $blank)){
     //            array_push($blank, $val->tutor_id);
     //            }
    	// }
    	// //dd($blank);
     //    $blank2=[];
    	// foreach($blank as $tutor){
    	// 	$findTotalAmount=StudentClassBooking::where('booking_status','CM')->where('tutor_id',$tutor)->sum('booking_amount');
    	// 	$findTotalEarning=StudentClassBooking::where('booking_status','CM')->where('tutor_id',$tutor)->sum('tutor_earnings');
    	// 	 array_push($blank2, $findTotalEarning);

    	// 	 $UserDetails=User::where('id',$tutor)->first();
    	// 	 $prevEarning=$UserDetails->total_earning;
    	// 	 $prevDue=$UserDetails->total_due;
    	// 	 $prevComm=$UserDetails->total_commission;

    	// 	 $updateEar=array(
    	// 	 	'total_earning'=> $prevEarning+($findTotalEarning-$prevEarning),
    	// 	 	'total_due'=> $prevDue+($findTotalEarning-$prevEarning),
    	// 	 	'total_commission'=>/*$prevComm+*/($findTotalAmount-$findTotalEarning)
    	// 	 );
    	// 	 $u=User::where('id',$tutor)->update($updateEar);

    	// }
    	//dd($blank2);
    }




    public function no_add(){
    	// $obj=new Tutor_transaction();
    	// $obj->tutor_id="1";
    	// $obj->amount="10";
    	// $obj->type="IN";
    	// $obj->note="1hfjf";
    	// $obj->purpose="jjj";
    	// $obj->save();
    	// //dd("done");


    }



    public function update_availability(){
      
      $dlt=Tutor_calander_availability::where('date','<',date('Y-m-d'))->get();
      //dd($dlt);
      if(count($dlt)>0){
      foreach($dlt as $val){
        $d=Tutor_calander_availability::where('id',$val->id)->delete();
      }
      }
      $lastDate=Tutor_calander_availability::orderBy('date','DESC')->first();

      $sixdaybefore=date('Y-m-d', strtotime("-6 days".$lastDate->date));
      $nextDay=date('Y-m-d', strtotime("+1 days".$lastDate->date));

      $getSixDaysBeforeData=Tutor_calander_availability::where('date', $sixdaybefore)->get();
      if(count($getSixDaysBeforeData)>0){
        foreach($getSixDaysBeforeData as $val){
            $obj=new Tutor_calander_availability();

            $obj->available_id=$val->available_id;
            $obj->day=$val->day;
            $obj->tutor_id=$val->tutor_id;
            $obj->date=$nextDay;
            $obj->start_time=$val->start_time;
            $obj->end_time=$val->end_time;
            $obj->booking_status="NB";
            $obj->save();
        }
    // dd( $lastDate->date, $sixdaybefore,$nextDay,$getSixDaysBeforeData);
        }
    }
}
