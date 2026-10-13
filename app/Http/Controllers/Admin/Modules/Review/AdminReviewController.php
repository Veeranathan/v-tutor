<?php

namespace App\Http\Controllers\Admin\Modules\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReviewModel;
use App\Models\User;
use DB;

class AdminReviewController extends Controller
{
    public function review_list(Request $request){

     $data['reviews']=ReviewModel::orderBy('id');

       if(@$request->from_date || @$request->to_date || $request->keyword || $request->ratting ){
        

        @$keyword=$request->keyword;
        @$from_date = date('Y-m-d', strtotime($request->from_date));
        @$to_prev= $request->to_date;
        @$to=date('Y-m-d', strtotime($to_prev. ' + 1 days'));
        // dd($request->all(),$from_date,$to);

        if($from_date && $to){
            $data['reviews']=$data['reviews']->whereBetween('created_at',[$from_date, $to]); 
          }

        if($request->ratting){
            $data['reviews']=$data['reviews']->where('ratting',$request->ratting); 
        }


        
           
      
        if($keyword){

              $data['reviews']->where(function($q) use ($keyword) {
                  $q->whereHas('tutor', function( $query ) use ( $keyword ){
                        $query->where(DB::raw('CONCAT(f_name, " ", l_name)'),'LIKE', "%".$keyword."%");
                    })->orWhereHas('student', function( $query ) use ( $keyword ){
                        $query->where(DB::raw('CONCAT(f_name, " ", l_name)'),'LIKE',"%".$keyword."%");
                    });
              });
               }

         $data['res']=$request->all();

        }

         $data['reviews']=$data['reviews']->get();

          //$data['allreviews']=ReviewModel::orderBy('id')->get();
     return view('admin.modules.review.review_list')->with($data);
    }




    public function review_list_all(){
      $data['allreviews']=ReviewModel::orderBy('id')->get();
      //return response()->json(['time'=>$data['allreviews']]);
      return view('admin.modules.review.review_ajax')->with($data);
    }



    public function review_del(Request $request){
    	$ReviewDetails=ReviewModel::where('id',$request->id)->first();
    	$tutor_id=$ReviewDetails->tutor_id;
    	$del=ReviewModel::where('id',$request->id)->delete();
    	
    	//update to User table
		$totalReview=ReviewModel::where('tutor_id',$tutor_id)->count();
        $totalAvg=ReviewModel::where('tutor_id',$tutor_id)->count();
            if($totalAvg>0){
                $avgReview=ReviewModel::where('tutor_id',$tutor_id)->avg('ratting');
            }
            else{
                $avgReview=0;
            }
		//$avgReview=ReviewModel::where('tutor_id',$tutor_id)->avg('ratting');
		//dd($totalReview,$avgReview);
		$up=array(
			'total_no_of_reviews'=>$totalReview,
			'avg_review'=>$avgReview
		);
		$updateTutorReview=User::where('id',$tutor_id)->update($up);

     return response()->json(['id'=>$tutor_id]);
    }
}
