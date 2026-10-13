<?php

namespace App\Http\Controllers\Student\ClassEndAssesment;

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
    /*
    * Method        :viewStudentClassEndAssesment
    * Description   : This method is used to show student class assesment questions
    * Author        :Jayatri
    */
    public function viewStudentClassEndAssesment(Request $request,$bookingNo){
        try{
            $data['questions'] = AssesmentQuestions::with(['getAnswerOptions'])->where(['type'=>'student'])->orderBy('display_order','asc')->get();
            $data['badwords'] = \DB::table('bad_words')->pluck('words')->toArray();
            $data['id'] = $bookingNo;
            $data['bookingInfo'] = StudentClassBooking::where(['booking_no'=>$bookingNo,'class_assessment_student'=>'N'])->whereIn('booking_status',['B','CM'])->first();
            if(!@$data['bookingInfo']){
                session()->flash("error","Already assesment submited!");
                return redirect()->route('student.my.classes.past');
            }
            return view('student.modules.student_class_end_assesment.student_class_end_assesment')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->route('student.my.classes.past');
        }
    }
    /*
    * Method        :saveStudentClassEndAssesment
    * Description   : This method is used to save student class assesment questions answer
    * Author        :Jayatri
    */
    public function saveStudentClassEndAssesment(Request $request,$bookingNo){
        try{
            $data['bookingInfo'] = StudentClassBooking::where(['booking_no'=>$bookingNo,'class_assessment_student'=>'N'])->whereIn('booking_status',['B','CM'])->first();
            if(!@$data['bookingInfo']){
                session()->flash("error","Already assesment submited!");
                return redirect()->route('student.my.classes.past');
            }
            if(@$request->questions){
                foreach(@$request->questions as $key=>$qId){
                    $crClassEndAssesment['booking_id'] = $data['bookingInfo']->id;
                    $crClassEndAssesment['user_id'] = @Auth::user()->id;
                    $crClassEndAssesment['question_id'] =$qId;
                    $assesmentQuestion = AssesmentQuestions::with(['getAnswerOptions'])->where(['type'=>'student','id'=>$qId])->first();
                    $assesmentAnswer = AssesmentAnswers::where(['id'=>(int)@$request->answers[$qId]])->first();
                    if(@$assesmentQuestion->answer_type == 'textbox'){
                        $crClassEndAssesment['answer'] = @$request->answers[$qId];
                        $crClassEndAssesment['answer_id'] = 0;
                    }
                    if(@$assesmentQuestion->answer_type == 'radio'){
                        $crClassEndAssesment['answer_id'] = (int)@$request->answers[$qId];
                        $crClassEndAssesment['answer'] = NULL;
                        if(@$assesmentQuestion->id == 19 || @$assesmentQuestion->id == 10){
                            StudentClassBooking::where(['booking_no'=>$bookingNo])->update(['student_class_end_review'=>@$assesmentAnswer->answer]);
                            $bookingReviews['booking_id'] = $data['bookingInfo']->id;
                            $bookingReviews['user_id'] = @Auth::user()->id;
                            $bookingReviews['rating'] = @$assesmentAnswer->answer;
                            $bReviews = BookingToReviews::create($bookingReviews);
                        }
                    }
                    $ClassEndAssesment = ClassEndAssesment::create($crClassEndAssesment);
                }
            }
            StudentClassBooking::where(['booking_no'=>$bookingNo])->update(['class_assessment_student'=>'Y']);
            session()->flash("success","Thank you for the review. Your response has been submitted");
            return redirect()->route('student.my.classes.past');
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->route('student.my.classes.past');
        }
    }
}
