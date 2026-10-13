<?php

namespace App\Http\Controllers\LandingPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Grade;
use App\Models\TutorshipPlan;
use App\Models\TestimonialModel;
use App\Models\StudentClassBooking;
use App\Models\Banners;
use App\Models\Subject;
use App\Models\Branch;
use App\User;
class LandingPageController extends Controller
{
    public function viewLandingPage(){
        //dd("test");
        $data['states'] = State::orderBy('state_name','asc')->get();
        $data['grades'] = Grade::where(['status'=>'A'])->get();
        $data['tutors'] = User::with(['getTutorShipPlan.getSubject','getTutorShipPlan.getGrade'])->where(['status'=>'A','user_type'=>'T'])->orderBy('avg_review','desc')->take(5)->get();

        $data['featuredtutors'] = User::with(['getTutorShipPlan.getBranches'])->where(['status'=>'A','user_type'=>'T','featured'=>1])->get();
        $data['testimonials'] = TestimonialModel::where(['status'=>'A'])->get();
        $data['banners'] = Banners::orderBy('display_order')->get();
        $data['total_classes'] = StudentClassBooking::whereIn('booking_status',['CM'])->count();
        $data['total_hours'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM'])->selectRaw('booking_status,((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')->orderBy('shift_length')->get();

        $data['total_hours'] = $data['total_hours']->sum('shift_length');
        $data['total_subjects'] = Subject::whereIn('status',['A'])->count();
        $data['number_of_active_tutors'] = User::where(['user_type'=>'T'])->whereIn('status',['A'])->count();
        
        $branches = Branch::where('status', 'A')
            ->select('id', 'slug', 'branch_name', 'capture_code')
            ->get();
         $data['branches'] =  $branches;

        return view('welcome')->with($data);
    }
}
