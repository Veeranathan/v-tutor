<?php

namespace App\Http\Controllers\Teacher\ClassEndAssesment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssesmentQuestions;
use App\Models\AssesmentAnswers;
use App\Models\ClassEndAssesment;
use App\Models\StudentClassBooking;
use App\Models\BookingToReviews;
use App\Models\User;
use Auth;

class ClassEndAssesmentController extends Controller
{
    //
    public function viewTutorClassEndAssesment(Request $request, $bookingNo){
        try{
            $data['questions'] = AssesmentQuestions::with(['getAnswerOptions'])->where(['type'=>'tutor'])->orderBy('display_order','asc')->get();
            $data['badwords'] = \DB::table('bad_words')->pluck('words')->toArray();
            $data['id'] = $bookingNo;
            $data['bookingInfo'] = StudentClassBooking::where(['booking_no'=>$bookingNo,'class_assessment_tutor'=>'N'])->whereIn('booking_status',['B','CM'])->first();
            if(!@$data['bookingInfo']){
                session()->flash("error","You have already submitted feedback for this session.");
                return redirect()->route('tutor.myclass.past');
            }
            return view('teacher.modules.tutor_class_end_assesment.tutor_class_end_assesment')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->route('tutor.myclass.past');
        }
    }
    public function saveTutorClassEndAssesment(Request $request, $bookingNo){
        try{
            $data['bookingInfo'] = StudentClassBooking::where(['booking_no'=>$bookingNo,'class_assessment_tutor'=>'N'])->whereIn('booking_status',['B','CM'])->first();
            if(!@$data['bookingInfo']){
                session()->flash("error","You have already submitted feedback for this session.");
                return redirect()->route('tutor.myclass.past');
            }
            // dd($request->all());

            if(@$request->questions){
                foreach(@$request->questions as $key=>$qId){
                    $crClassEndAssesment['booking_id'] = $data['bookingInfo']->id;
                    $crClassEndAssesment['user_id'] = @Auth::user()->id;
                    $crClassEndAssesment['question_id'] =$qId;
                    $assesmentQuestion = AssesmentQuestions::with(['getAnswerOptions'])->where(['type'=>'tutor','id'=>$qId])->first();

                    if(@$assesmentQuestion->answer_type == 'textbox'){
                        $crClassEndAssesment['answer'] = @$request->answers[$qId];
                        $crClassEndAssesment['answer_id'] = 0;

                    }
                    if(@$assesmentQuestion->answer_type == 'radio'){
                        $crClassEndAssesment['answer_id'] = (int)@$request->answers[$qId];
                        $crClassEndAssesment['answer'] = NULL;
                        if(@$assesmentQuestion->id == 19 || @$assesmentQuestion->id == 10){
                            $assesmentAnswer = AssesmentAnswers::where(['id'=>(int)@$request->answers[$qId]])->first();
                            StudentClassBooking::where(['booking_no'=>$bookingNo])->update(['tutor_class_end_review'=>$assesmentAnswer->answer]);
                            $bookingReviews['booking_id'] = $data['bookingInfo']->id;
                            $bookingReviews['user_id'] = @Auth::user()->id;
                            $bookingReviews['rating'] = @$assesmentAnswer->answer;
                            $bReviews = BookingToReviews::create($bookingReviews);

                        }
                    }

                    // if(@$assesmentQuestion->answer_type == 'textbox'){
                    //     $crClassEndAssesment['answer'] = @$request->answers[$qId];
                    // }else{
                    //     $crClassEndAssesment['answer_id'] = (int)@$request->answers[$qId];
                    // }
                    // $crClassEndAssesment['answer'] = @$request->answers[$qId];
                    $ClassEndAssesment = ClassEndAssesment::create($crClassEndAssesment);
                }
            }
            StudentClassBooking::where(['booking_no'=>$bookingNo])->update(['class_assessment_tutor'=>'Y']);
            session()->flash("success","Thank you for the review. Your response has been submitted");
            return redirect()->route('tutor.myclass.past');
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->route('tutor.myclass.past');
        }
    }
}
