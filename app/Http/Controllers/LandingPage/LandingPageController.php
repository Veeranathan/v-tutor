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
use App\Models\User;
use App\Models\Promotion;
use App\Models\FaqModel;
class LandingPageController extends Controller
{
    public function viewLandingPage(){
        //return redirect()->route('coming_soon_page');

        $data['states'] = State::orderBy('state_name','asc')->get();
        $data['grades'] = Grade::where(['status'=>'A'])->get();
        $data['tutors'] = User::with(['getTutorShipPlan.getSubject','getTutorShipPlan.getGrade'])->where(['status'=>'A','user_type'=>'T'])->orderBy('avg_review','desc')->inRandomOrder()->take(10)->get();
        $data['featuredtutors'] = User::with(['getTutorShipPlan.getBranches'])->where(['status'=>'A','user_type'=>'T','featured'=>1])->get();
        $data['testimonials'] = TestimonialModel::where(['status'=>'A'])->get();
        $data['banners'] = Banners::orderBy('display_order')->get();
        $data['total_classes'] = StudentClassBooking::whereIn('booking_status',['CM'])->count();
        $data['total_hours'] = StudentClassBooking::with('getTutor')
    ->whereIn('booking_status', ['CM'])
    ->selectRaw('booking_status, ((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')
    ->groupBy('booking_status')  // <--- Add this!
    ->orderBy('shift_length')
    ->get();

        $data['total_hours'] = $data['total_hours']->sum('shift_length');
        $data['total_subjects'] = Subject::whereIn('status',['A'])->count();
        $data['number_of_active_tutors'] = User::where(['user_type'=>'T'])->whereIn('status',['A'])->count();
        $data['promotion'] = Promotion::WhereDate('start_date', '<=', date('y-m-d'))->WhereDate('end_date', '>=', date('y-m-d'))->Where('status', 1)->first();
         $data['StudentFaqModel'] = FaqModel::where(['user_type' => 'U', 'status' => 'A'])->orderBy('display_order', 'asc')->limit(7)->get();
        return view('welcome')->with($data);
    }
}
