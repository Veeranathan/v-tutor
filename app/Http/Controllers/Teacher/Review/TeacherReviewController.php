<?php

namespace App\Http\Controllers\Teacher\Review;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReviewModel;
use App\Models\User;
use Auth;

class TeacherReviewController extends Controller
{
    public function review_page(){
    	$data['reviews']=ReviewModel::where('tutor_id',Auth()->user()->id)->get();
    	//dd(Auth()->user()->id);
    	return view('teacher.modules.review.tutor_review')->with($data);
    }




    public function review_details($id){
    	//dd($id);
    	$data['reviews']=ReviewModel::where('id',$id)->first();
        return view('teacher.modules.review.review_details')->with($data);
    }
}
