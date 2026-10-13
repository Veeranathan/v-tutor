<?php

namespace App\Http\Controllers\Admin\Modules\TutorAvailability;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyAvailability;
use App\Models\Tutor_calander_availability;
use App\Models\User;
use Illuminate\Support\Carbon;
class TutorAvailabilityController extends Controller
{
    public function editTutorAvailability($id,Request $request){
        $data['user'] = User::where(['id'=>$id])->first();
        $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
        return view('admin.modules.tutor_management.edit_tutor_info')->with($data);
    }
    public function testingPurpose($id,Request $request){
        $data['user'] = User::where(['id'=>$id])->first();
        $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
        return view('admin.modules.tutor_management.manage_tutorship_plans')->with($data);
    }
    public function addTutorAvailability($id,$key,Request $request){
        try{
            $f_t = "from_time".strval($key);
            $t_t = "to_time".strval($key);
            $from_time = date("H:i:s", strtotime(@$request->$f_t));
            $to_time = date("H:i:s", strtotime(@$request->$t_t));
            
            $isCheckMyAvailability = MyAvailability::where(['teacher_id'=>$id,'day'=>$key]);
            $isCheckMyAvailability = $isCheckMyAvailability->where(function($where) use ($request,$from_time,$to_time) {
                $where->where(function($where1) use ($request,$from_time,$to_time) {
                    $where1->where('from_time', '<=', $from_time)
                    ->where('to_time', '>=', $from_time);
                })
                ->orWhere(function($where2) use ($request,$from_time,$to_time) {
                    $where2->where('from_time', '<=', $to_time)
                    ->where('to_time', '>=', $to_time);
                });
            });
            $isCheckMyAvailability = $isCheckMyAvailability->first();
            if(@$isCheckMyAvailability){
                session()->flash("error","Time slot already added. Choose a slot with no conflicts!");
                return redirect()->back();  
            }else{
                $addTutorAvailability['teacher_id'] = $id;
                $addTutorAvailability['day'] = $key;
                $addTutorAvailability['from_time'] = $from_time;
                $addTutorAvailability['to_time'] = $to_time;
                $addTutorAvailability['status'] = 'A';
                $availablity = MyAvailability::create($addTutorAvailability);

                //delete all previous days data.
                $allPrevDays=Tutor_calander_availability::where('date','<',date('Y-m-d'))->where('tutor_id',$id)->get();
                //dd($allPrevDays);
                if(count($allPrevDays)>0){
                    foreach($allPrevDays as $deletee){
                        Tutor_calander_availability::where('id',$deletee->id)->where('tutor_id',$id)->delete();
                    }
                }
                //now break time slot to 30 min and insert to user_cal_avail table
                $starttime = $from_time;  // your start time
                $endtime = $to_time;  // End time
                $duration = '60';  // split by 30 mins

                $array_of_time = array ();
                $start_time    = strtotime ($starttime); //change to strtotime
                $end_time      = strtotime ($endtime); //change to strtotime
                $add_mins  = $duration * 60;
                while ($start_time <= $end_time) // loop between time
                {
                   $array_of_time[] = date ("H:i", $start_time);
                   $start_time += $add_mins; // to check endtie=me
                } 
                
                $length=count($array_of_time);
                //echo $length;
                //dd($length);
                $from_to_times=[];

                for($k=0;$k<$length;$k++){
                    $data=[];
                    if($k+1<$length){
                        $data['from_time']=$array_of_time[$k];
                        $data['to_time']=$array_of_time[$k+1];
                        array_push($from_to_times,$data);
                    }
                }
                //  dd($from_to_times);
                //now it will have a loop for a perticular day for next 3 months         
                for($i=0;$i<60;$i++){
                    //if((int)$request->day+1==1){ 
                    if((int)$key+1==7){
                        $date=0;
                    }
                    else{
                        $date=(int)$key;
                    } 
                    if(date('w', strtotime("+".$i."days"))== $date){
                       echo date('Y-m-d', strtotime("+".$i." days")) .'<br>';
                       echo date('D', strtotime("+".$i." days")) .'<br>';
                        // $c=[];

                        foreach($from_to_times as $val){
                            // $bk=[];
                            // $bk['f']=$val['from_time'];
                            // $bk['t']=$val['to_time'];
                            // $bk['dt']=date('Y-m-d', strtotime("+".$i." days"));
                            // array_push($c, $bk);

                            $searchData=Tutor_calander_availability::where('start_time',$val['from_time'])->where('end_time',$val['to_time'])->where('tutor_id',Auth()->user()->id)->where('date',date('Y-m-d', strtotime("+".$i." days")) )->where('day',(int)$key)->where('booking_status','B')->first();
                            if(!@$searchData){
                                $obj=new Tutor_calander_availability();
                                $obj->start_time=$val['from_time'];
                                $obj->end_time=$val['to_time'];
                                $obj->date=date('Y-m-d', strtotime("+".$i." days"));
                                $obj->booking_status="NB";
                                $obj->available_id= $availablity->id;
                                $obj->tutor_id=$id;
                                $obj->day=(int)$key;
                                $obj->save();
                            }
                        }
                       // dd($c);
                    }
                    //}
                }//for loop end of 90 days
                session()->flash("success","Tutor slot added!");
                return redirect()->back();    
            }
        }catch(\Exception $e){
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteTutorAvailability($id,Request $request){
        try{
            $myavailability = MyAvailability::whereId($id)->first();
            if(@$myavailability){
                $srch_booking=Tutor_calander_availability::where('available_id',$id)->where('booking_status','B')->where('date','>=',date('Y-m-d'))->first();
                if($srch_booking){
                    $allBooked=Tutor_calander_availability::where('available_id',$id)->where('booking_status','B')->where('date','>=',date('Y-m-d'))->get();
                    $blank=[];
                    foreach( $allBooked as $val){

                        array_push($blank, date(' Y/m/d ', strtotime(@$val->date))."(".date('h:i A', strtotime(@$val->start_time))."-".date('h:i A', strtotime(@$val->end_time)).")");
                    }
                    $dates=implode(" , ",$blank);
                    session()->flash("error","You can not delete this slot as you have booking on this slot on .".$dates." So first you need to cancle that booking to delete this slot.!");
                    return redirect()->back();    
                    // return response()->json(['dates'=>@$dates,'msg'=>'data']);
                }
                else{

                    $allData=Tutor_calander_availability::where('available_id',$request->id)->get();

                    foreach($allData as $dl){
                        Tutor_calander_availability::where('id',$dl->id)->where('booking_status','NB')->delete();
                    }
                    $dlt=MyAvailability::where('teacher_id',Auth()->user()->id)->where('id',$request->id)->delete();

                  // return response()->json(['msg'=>'nodata']);
                    session()->flash("success","Tutor slot removed!");
                    return redirect()->back();    
                }
            }else{
                session()->flash("error","Tutor slot not found!");
                return redirect()->back();    
            }

            
            // $myavailability = MyAvailability::whereId($id)->first();
            // if(@$myavailability){
            //     $allData=Tutor_calander_availability::where('available_id',$id)->get();
            //     foreach($allData as $dl){
            //         Tutor_calander_availability::where('id',$dl->id)->where('booking_status','NB')->delete();
            //     }
            //     $dlt=MyAvailability::where('teacher_id',$myavailability->teacher_id)->where('id',$id)->delete();
                
            //     session()->flash("success","Tutor slot removed!");
            //     return redirect()->back();    
            // }else{
                
            //     session()->flash("error","Tutor slot not found!");
            //     return redirect()->back();    
            // }
        }catch(\Exception $e){
            session()->flash("success",$e->getMessage());
            return redirect()->back();
        }
        
    }
}
