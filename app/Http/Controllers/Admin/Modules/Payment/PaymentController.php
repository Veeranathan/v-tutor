<?php

namespace App\Http\Controllers\Admin\Modules\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tutor_transaction;
use App\Models\Payments;
use App\Models\StudentClassBooking;
use App\Models\Commissions;
use DB;


class PaymentController extends Controller
{


//----------------------------------------------ALL TUTOR PAYMENTS-------------------------------//

	public function due_payments(Request $request){
    $data['admin_commission_management'] = Commissions::first();
     $data['due_payment']=User::orderBy('id')->where(['user_type'=>'T'])->whereIn('status',['A','I','C']);

       if(@$request->keyword ){
        @$keyword=$request->keyword;       
       if($keyword){

             $data['due_payment']=$data['due_payment']->where(DB::raw('CONCAT(f_name, " ", l_name)'),'LIKE', "%".$keyword."%");
               }

         $data['res']=$request->all();

        }
        if(@$request->show_only == 'Y'){
          $data['due_payment']=$data['due_payment']->where('total_due','>',0);
        }

         // $data['due_payment']=$data['due_payment']->where('total_due','>',0)->get();
         $data['due_payment']=$data['due_payment']->orderBy('total_due','desc')->get();
         //dd($data['due_payment']);
     return view('admin.modules.tutor_due_payment.tutor_due_payment_list')->with($data);
    }


    public function due_payments_all(){
      $data['due_payment']=User::orderBy('id')->where('user_type','T')->where('total_due','>',0)->get();
      return view('admin.modules.tutor_due_payment.tutor_due_payment_ajax')->with($data);
    }




    public function tutor_payment(Request $request){
    	// dd($request->all());
      if(@$request->incentive){
        $obj=new Tutor_transaction();
        $obj->tutor_id=$request->tutor_id;
        $obj->amount=$request->incentive;
        $obj->type='IN';
        $obj->note=@$request->notes;
        $obj->purpose="I";
        $obj->save();

        //update User table..
        $GetTutorDetails=User::where('id',$request->tutor_id)->first();
        
        $up=array(
          'total_due'=>$GetTutorDetails->total_due+$request->incentive,
          'total_incentive'=> $GetTutorDetails->total_incentive+$request->incentive,
          'total_earning'=>$GetTutorDetails->total_earning+$request->incentive,
        );

        $u=User::where('id',$request->tutor_id)->update($up);  
      }  
      
         
         // return back()->with('success',$request->incentive.' $ incentive done to tutor.');


    	//insert to user_transaction table..
    	$obj=new Tutor_transaction();
    	$obj->tutor_id=$request->tutor_id;
      $obj->amount=$request->total_due;

      // if(@$request->incentive){
    	 // $obj->amount=$request->payment+$request->incentive;
      // }else{
      //   $obj->amount=$request->payment;
      // }
    	$obj->type='OUT';
    	$obj->note=@$request->notes;
    	$obj->purpose="W";
    	$obj->save();

    	//update User table..
    	$GetTutorDetails=User::where('id',$request->tutor_id)->first();
    	
    	$up=array(
    		'total_due'=>$GetTutorDetails->total_due-$obj->amount,
    		'total_paid'=>$GetTutorDetails->total_paid+$obj->amount
    	);

    	$u=User::where('id',$request->tutor_id)->update($up);
      $tutor=User::where('id',$request->tutor_id)->first();
      session()->flash("success","Payment of $".($obj->amount)." has been made to Tutor ".$tutor->f_name." ".$tutor->l_name);
         return redirect()->back();
         // return back()->with('success',$request->payment.' $ Payment done to tutor.');

    }




    public function payment_his($id){
    	//dd($id);
    	 $data['payment_history']=Tutor_transaction::orderBy('id')->where('tutor_id',$id)->get();

       // if(@$request->keyword || $request->from_date || $request->to_date ){
       //  @$keyword=$request->keyword;   
       //   @$from_date = date('Y-m-d', strtotime($request->from_date));
       //  @$to_prev= $request->to_date;
       //  @$to=date('Y-m-d', strtotime($to_prev. ' + 1 days'));
       //  // dd($request->all(),$from_date,$to);

       //  if($from_date && $to){
       //      $data['payment_history']=$data['payment_history']->whereBetween('created_at',[$from_date, $to]); 
       //    }    
       

       //    if($keyword){
       //        $data['payment_history']->where(function($q) use ($keyword) {
       //            $q->whereHas('tutor', function( $query ) use ( $keyword ){
       //                  $query->where(DB::raw('CONCAT(f_name, " ", l_name)'),'LIKE', "%".$keyword."%");
       //              });
       //        });
       //         }
       //   $data['res']=$request->all();

       //  }
    

        // $data['payment_history']=$data['payment_history']->with('tutor')->get();
        // dd($data['payment_history']);
    	 $data['tutor_id']=$id;
    	  $userDetails=User::where('id',$id)->first();
    	  $data['tutor_name']=@$userDetails->f_name." ".@$userDetails->l_name;
     return view('admin.modules.tutor_due_payment.payment_history')->with($data);
      
    }





    public function payment_his_search_ajax($id){
       $data['payment_history']=Tutor_transaction::orderBy('id')->where('tutor_id',$id)->get();
        return view('admin.modules.tutor_due_payment.payment_his_ajax')->with($data);
    }







    public function payment_his_search(Request $request){
    //	dd($request->all());
    	$data['payment_history']=Tutor_transaction::orderBy('id')->where('tutor_id',$request->tutor_id);
    	if( $request->from_date || $request->to_date || $request->perpous){
       
         @$from_date = date('Y-m-d', strtotime($request->from_date));
        @$to_prev= $request->to_date;
        @$to=date('Y-m-d', strtotime($to_prev. ' + 1 days'));
        // dd($request->all(),$from_date,$to);

        if($from_date && $to){
            $data['payment_history']=$data['payment_history']->whereBetween('created_at',[$from_date, $to]); 
          }   
           if($request->perpous){
            $data['payment_history']=$data['payment_history']->where('purpose',$request->perpous); 
          }     
       

         $data['res']=$request->all();

        }
        $data['payment_history']=$data['payment_history']->with('tutor')->get();
        $userDetails=User::where('id',$request->tutor_id)->first();

         $data['tutor_id']=$request->tutor_id;
         $data['tutor_name']=$userDetails->f_name." ".$userDetails->l_name;
         //dd( $data['tutor_name']);
         return view('admin.modules.tutor_due_payment.payment_history')->with($data);
    }



    public function tutor_incentive(Request $request){
      //dd($request->all());

      //insert to user_transaction table the incentive..
      $obj=new Tutor_transaction();
      $obj->tutor_id=$request->tutor_id;
      $obj->amount=$request->inc;
      $obj->type='IN';
      $obj->note=@$request->notes;
      $obj->purpose="I";
      $obj->save();

      //update User table..
      $GetTutorDetails=User::where('id',$request->tutor_id)->first();
      
      $up=array(
        'total_due'=>$GetTutorDetails->total_due+$request->inc,
        //'total_paid'=>$GetTutorDetails->total_paid+$request->payment,
        'total_incentive'=> $GetTutorDetails->total_incentive+$request->inc,
        'total_earning'=>$GetTutorDetails->total_earning+$request->inc,
      );

      $u=User::where('id',$request->tutor_id)->update($up);
         
         return back()->with('success',$request->inc.' $ incentive done to tutor.');

    }


    //----------------------TUTOR PAYMENT END------------------------------------------------------------//













    //---------------------------------------STUDENT PAYMENT START-----------------------------------------//

    public function student_pay_list(Request $request){
      
     //  $payments=Payments::where('status','S')->get();
     //  $uniqueBookingIds=[];
     //  foreach($payments as $val){
     //    array_push($uniqueBookingIds, $val->booking_id);
     //  }
     //  //dd($uniqueBookingIds); all the unique booking ids..
     //  $BookingDetsils=StudentClassBooking::whereIn('id',$uniqueBookingIds)->with('getStudent')->get();
     // dd($BookingDetsils);

      $BookingDetsils=StudentClassBooking::whereIn('booking_status',['CM','B'])->with('getStudent')->get();
     // dd($BookingDetsils);

      //now take all unique student ids
       $a=[];
      foreach($BookingDetsils as $val){
        if(!in_array($val->student_id, $a)){
        array_push($a, $val->student_id);
      } 
      }
      //dd($a);
      
     $data['users']=User::whereIn('id',$a);
     if($request->keyword){
      $data['users']=$data['users']->where(DB::raw('CONCAT(f_name, " ", l_name)'),'LIKE', "%".$request->keyword."%");

     }
      $data['users']=$data['users']->get();
     return view('admin.modules.student_pay.student_pay')->with($data);

     // // $a[1]=[];

     //  foreach($a[0] as $v){
     //    $s=StudentClassBooking::where('student_id',$v)->get();
      
     //  }
     //  dd($s);

      // $z=StudentClassBooking::whereIn('student_id',$a)->get();
      // //dd($z);
      //  $b=[];
      // foreach($z as $val2){
      //   $srchSuccessBookingPay=Payments::where('booking_id',$val2->id)->where('status','S')->first();
      //   if($srchSuccessBookingPay){
      //  array_push($b, $val->id);

      //   }
      // }

      
      // // $a=[];
      // // foreach($BookingDetsils as $val){
      // //   $srchSuccessBookingPay=Payments::where('booking_id',$val->id)->where('status','S')->first();
      // //   if($srchSuccessBookingPay){
      // //   array_push($a, $val->id);
      // //   }
      // // }
      // dd($a);

    }

    public function student_pay_list_ajax(){
      $BookingDetsils=StudentClassBooking::whereIn('booking_status',['CM','B'])->with('getStudent')->get();
   
       $a=[];
      foreach($BookingDetsils as $val){
        if(!in_array($val->student_id, $a)){
        array_push($a, $val->student_id);
      } 
      }
      //dd($a);
      
     $data['users']=User::whereIn('id',$a)->get();
     return view('admin.modules.student_pay.student_pay_ajax_list')->with($data);
    }


}
