<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\State;
use Illuminate\Support\Facades\Redirect;
use App\Models\UserToFavourite;
use App\Models\StudentClassBooking;
use App\Models\BookingToReviews;
use App\Models\ReviewModel;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(session()->all());
        // dd(date("H:i:s"));
        // booking page
        if(@session('save_on_click_value') == 'B'){
            session(['save_on_click_value' => 'NA']);
            $getUser = User::where(['id'=>session('save_search_on_click_tutor_id')])->first();
            // session(['save_on_click_value' => 'NA']);

            if(!@session('save_search_on_click_tutor_id') || @session('save_search_on_click_tutor_id') == 0){

                $get_s_grade = Grade::where(['id'=>session('book_grade')])->first();
                $myState = State::where(['id'=>@Auth::user()->state])->first();
                $to_p = url('tutor-search-result?grade='.@$get_s_grade->slug.'&subject_id%5B%5D='.session('book_subject'));

                return Redirect::to($to_p);
                // return redirect($to_p);
                    // return redirect()->url('tutor-search-result?grade='.session('book_grade').'&sort_type=sort_type&subject_id%5B%5D='.session('book_subject'));
            }
            if(@$getUser){
                session(['save_on_click_value' => 'NA']);
                if(@$getUser->state != @Auth::user()->state){
                    session()->flash("error","You cannot book a session outside your state");
                    return redirect()->route('student.book.class');
                }
                if(@$getUser->timezone_id != @Auth::user()->timezone_id){
                    session()->flash("error","Sorry, this tutor appear to be outside your time zone. You cannot book a class outside your time zone!");
                    return redirect()->route('student.book.class');
                }
                $to_p = url('studentbook-class?search_tutor_nm_studentclass='.$getUser->f_name." ".$getUser->l_name.'&search_tutor_id_studentclass='.$getUser->id.'&search_tutor_selected_name_studentclass='.$getUser->f_name." ".$getUser->l_name.'&search_tutor_slug_studentclass='.$getUser->slug.'&book_subject='.session('book_subject'));

                return Redirect::to($to_p);

            }else{
                session(['save_on_click_value' => 'NA']);
               return redirect()->route('student.book.class');
            }

            //
        }
        //pp  public profile page
        if(@session('save_on_click_value') == 'PP' && @session('save_search_on_click_tutor_id')){
            session(['save_on_click_value' => 'NA']);

            $user = User::where(['id'=>@session('save_search_on_click_tutor_id'),'status'=>'A'])->first();
            if(@$user){
                session(['save_search_on_click_tutor_id' => 0]);
                return redirect()->route('tutor.public.profile',$user->slug);
            }
        }
        // PR Post review page
        if(@session('save_on_click_value') == 'PR' && @session('save_search_on_click_tutor_id') && @session('save_search_on_click_tutor_id') != 0){
            $user = User::where(['id'=>@session('save_search_on_click_tutor_id'),'status'=>'A'])->first();
            if(@$user){
                session(['save_on_click_value' => 'NA']);
                session(['save_search_on_click_tutor_id' => 0]);
                return redirect()->route('student.my.review',$user->slug);
            }
            // post review page will be here
            session(['save_on_click_value' => 'NA']);
            session(['save_search_on_click_tutor_id' => 0]);
        }
        $data['total_classes'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->whereIn('booking_status',['B','C','CM'])->count();
        if(@$data['total_classes'] <=0){
            $data['booked_classes'] = ((StudentClassBooking::where(['booking_status'=>'B','student_id'=>@Auth::user()->id])->count()))*100;
            $data['completed_classes'] = ((StudentClassBooking::where(['booking_status'=>'CM','student_id'=>@Auth::user()->id])->count()))*100;
            $data['cancelled_classes'] = ((StudentClassBooking::where(['booking_status'=>'C','student_id'=>@Auth::user()->id])->count()))*100;
        }else{
            $data['booked_classes'] = ((StudentClassBooking::where(['booking_status'=>'B','student_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
            $data['completed_classes'] = ((StudentClassBooking::where(['booking_status'=>'CM','student_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
            $data['cancelled_classes'] = ((StudentClassBooking::where(['booking_status'=>'C','student_id'=>@Auth::user()->id])->count())/$data['total_classes'])*100;
        }
        $data['count_booked_classes'] = StudentClassBooking::where(['booking_status'=>'B','student_id'=>@Auth::user()->id])->count();
        $data['count_completed_classes'] = StudentClassBooking::where(['booking_status'=>'CM','student_id'=>@Auth::user()->id])->count();
        $data['count_cancelled_classes'] = StudentClassBooking::where(['booking_status'=>'C','student_id'=>@Auth::user()->id])->count();
        // dd($data);
        // Number of Classes per Tutor
        $data['top_tutors'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM','B'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id')->select(\DB::raw('DISTINCT tutor_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->take(5)->get();
        $data['top_tutor_ids'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM','B'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id')->select(\DB::raw('DISTINCT tutor_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->pluck('tutor_id')->toArray();

        $data['tot_count_booking'] = $data['top_tutors']->sum('count_booking');
        if(@$data['tot_count_booking'] <=0){
            $data['tot_count_booking'] = 1;
        }
        // dd($data['top_tutors']);
        // Number of Hours per Tutor
        $data['top_5_no_of_hours_per_tutor'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM','B'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id')->selectRaw('student_id,tutor_id,((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')->orderBy('shift_length')->take(5)->get();
        // dd($data['top_5_no_of_hours_per_tutor']);
        $data['tot_top_5_no_of_hours_per_tutor'] = $data['top_5_no_of_hours_per_tutor']->sum('shift_length');
        if(@$data['tot_top_5_no_of_hours_per_tutor'] <=0){
            $data['tot_top_5_no_of_hours_per_tutor'] = 1;
        }
        // dd($data['top_5_no_of_hours_per_tutor']);
        // Subjects learnt by sessions
        // $data['sub_learn_no_hrs'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','tutor_id','subject_id')->selectRaw('subject_id,(SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))) as shift_length')->orderBy('shift_length')->take(5)->get();
        $data['sub_learn_sessions'] = StudentClassBooking::with('getSubject')->whereIn('booking_status',['CM','B'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','subject_id')->select(\DB::raw('DISTINCT subject_id, COUNT(*) AS count_booking'))->orderBy('count_booking')->take(5)->get();
        $data['tot_sub_learn_sessions'] = $data['sub_learn_sessions']->sum('count_booking');
        // dd($data['sub_learn_sessions']);
        if(@$data['tot_sub_learn_sessions'] <=0){
            $data['tot_sub_learn_sessions'] = 1;
        }

        $data['tot_hr_by_sub'] = StudentClassBooking::with('getTutor')->whereIn('booking_status',['CM','B'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','subject_id')->selectRaw('subject_id,((SUM(TIME_TO_SEC(TIMEDIFF(to_time, from_time)))/60)/60) as shift_length')->orderBy('shift_length')->take(5)->get();
        $data['tot_tot_hr_by_sub'] = $data['tot_hr_by_sub']->sum('shift_length');
        if(@$data['tot_tot_hr_by_sub'] <=0){
            $data['tot_tot_hr_by_sub'] = 1;
        }

        // payments
        $data['payments_by_subjects'] = StudentClassBooking::with('getSubject')->whereIn('booking_status',['B','CM','C'])->where(['student_id'=>@Auth::user()->id])->groupBy('student_id','subject_id')->select(\DB::raw('DISTINCT subject_id, COUNT(*) AS count_booking,SUM(booking_amount) AS total_payments_by_subjects'))->orderBy('total_payments_by_subjects','desc')->take(5)->get();
        $data['total_payments_by_subjects']= StudentClassBooking::whereIn('booking_status',['B','CM'])->where(['student_id'=>@Auth::user()->id])->sum('booking_amount');
        if(@$data['total_payments_by_subjects'] <=0){
            $data['total_payments_by_subjects'] = 1;
        }
        // rev_pe_tot_cls

        $data['total_classes'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->whereIn('booking_status',['B','C','CM'])->count();
        // if(@$data['total_classes'] <=0){

        //     $data['total_reviews_given'] = ((BookingToReviews::where('user_id',@Auth::user()->id)->count())/(1)*100);
        // }else{
        //     $data['total_reviews_given'] = ((BookingToReviews::where('user_id',@Auth::user()->id)->count())/($data['total_classes'])*100);
        // }
        $data['total_reviews_given'] = (BookingToReviews::where('user_id',@Auth::user()->id)->count());
        // dd($data['payments_by_subjects']);
        // dd($data['sub_learn_no_hrs']);
        // dd($data['top_tutors_no_hrs']);
        // $data['count_fav_tutors'] = UserToFavourite::where(['user_id'=>@Auth::user()->id])->count();
        // $data['count_frequent_tutors'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->groupBy('tutor_id')->count();
        // $data['count_todays_session'] = StudentClassBooking::where(['student_id'=>@Auth()->user()->id,'booking_date'=>date('Y-m-d')])->count();
        // $data['count_upcoming_session'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->where('booking_date','>',date('Y-m-d'))->count();
        // $data['count_past_session'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->where('booking_date','<',date('Y-m-d'))->count();
        // $data['count_total_session'] = StudentClassBooking::where(['student_id'=>@Auth::user()->id])->count();
        // $data['count_reviewed_tutors'] = ReviewModel::where(['student_id'=>@Auth::user()->id])->count();
        // $data['total_tutors'] = User::with(['getTutorShipPlan.getGrade'])->where(['user_type'=>'T','status'=>'A']);

        // $grade = Grade::where(['id'=>@Auth::user()->grade])->first();
        // if(@$grade){
        //     $data['total_tutors'] = $data['total_tutors']->whereHas('getTutorShipPlan.getGrade',function($q) use($grade){
        //         $q->where('slug',$grade->slug);
        //     });
        // }
        // $data['total_tutors'] = $data['total_tutors']->count();
        return view('home')->with($data);
    }
}
