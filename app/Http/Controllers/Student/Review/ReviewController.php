<?php

namespace App\Http\Controllers\Student\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReviewModel;
use App\Models\UserToFavourite;
use App\Models\TutorshipPlan;
use App\Models\Subject;
use App\Models\User;
use Auth;
use DB;

class ReviewController extends Controller
{  

	public function review_page_without_slug(){
		$data['reviews']=ReviewModel::where('student_id',Auth()->user()->id)->get();
		return view('student.modules.review.review_no_slug')->with($data);
	}





    public function review_page($slug){
    	$data['UserDetails']=User::where('slug',$slug)->first();
        // dd($data);
    	$data['reviews']=ReviewModel::where('student_id',Auth()->user()->id)->get();

    	//all the tutor those are in fevourite list but not given review..
    	$fev_tutor=UserToFavourite::where('user_id',Auth()->user()->id)->get();
    	//dd($fev_tutor);
    	$balnk=[];
    	foreach($fev_tutor as $val){
          $srch=ReviewModel::where('student_id',Auth()->user()->id)->where('tutor_id',$val->favourite_user_id)->first();
          if(!@$srch){
          	array_push($balnk, $val->favourite_user_id );
          }
    	}
        $data['tutors']=User::whereIn('id',$balnk)->get();


        

        //subjects get
        $subjects=TutorshipPlan::where('teacher_id',$data['UserDetails']->id)->where('status','A')->get();
        $unique=[];
        foreach($subjects as $val){
            if(!in_array($val->subject_id, $unique)){
                array_push($unique, $val->subject_id);
            }
        }
        $subjectss=Subject::whereIn('id',$unique)->get();
        $sub=[];
        foreach($subjectss as $v){
          array_push($sub,$v->subject);
        }
        $data['subjects']=implode(",",$sub);
         

         
         //badwords
        $badwords=DB::table('bad_words')->get();
         $balnkBad=[];
        foreach($badwords as $v){
          array_push($balnkBad, $v->words);
        }
       // dd($balnkBad);
      
        $data['bad']=$balnkBad;




    	
    	
    	//dd($balnk,$data['tutors'], $data['subjects']);
    	return view('student.modules.review.review')->with($data);
    }



    public function review_insert(Request $request){
    	//dd($request->all());

    	$srch=ReviewModel::where('student_id',Auth()->user()->id)->where('tutor_id',$request->tutor_id)->first();
    	if($srch){
    		return redirect()->route('student.my.review.no.slug')->with('error','Review already given.!');
    	}
    	else{
    		$obj=new ReviewModel();

    		$obj->student_id=Auth()->user()->id;
    		$obj->tutor_id=$request->tutor_id;
    		$obj->ratting=$request->ratting;
    		$obj->message=$request->message;

    		$obj->save();

            //update to User table
    		$totalReview=ReviewModel::where('tutor_id',$request->tutor_id)->count();
    		$avgReview=ReviewModel::where('tutor_id',$request->tutor_id)->avg('ratting');
    		//dd($totalReview,$avgReview);
    		$up=array(
    			'total_no_of_reviews'=>$totalReview,
    			'avg_review'=>$avgReview
    		);
    		$updateTutorReview=User::where('id',$request->tutor_id)->update($up);
    		return redirect()->route('list.of.favourite')->with('success','Thank you for the review. Comments are subject to moderation, might be taken down if inappropriate.');
            // return back()->with('success','Thank you for the review. Comments are subject to moderation, might be taken down if inappropriate.');
    	}
    }







    public function review_del($id){
      
      $tutorDetails=ReviewModel::where('id',$id)->first();
      $tutor_id=$tutorDetails->tutor_id;
      //dd($id,$tutor_id);

      $del=ReviewModel::where('id',$id)->delete();
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
    		//return redirect()->route('student.my.review.no.slug')->with('success','Review deleted.!');
            return back()->with('success','Review removed. You may review the tutor again in future.');
    
    }
}
