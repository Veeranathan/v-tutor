<?php

namespace App\Http\Controllers\Student\UserToFavourite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserToFavourite;
use App\Models\User;
use Auth;
use App\Models\AdminDisableBookings;
use App\Models\AdminDisableBookingDates;
use App\Models\StudentClassBooking;

class UserToFavouriteController extends Controller
{
    public function saveUserTofavourite(Request $request){
        try{
            if(@Auth::check()){
                if(@Auth::user()->user_type == 'U'){
                    $favourite_user_id = $request->data['favourite_user_id'];
                    $isFav = UserToFavourite::where(['favourite_user_id'=>$request->data['favourite_user_id'],'user_id'=>@Auth::user()->id])->first();
                    if(@$isFav){
                        UserToFavourite::where(['favourite_user_id'=>$request->data['favourite_user_id'],'user_id'=>@Auth::user()->id])->delete();
                        $response['result']['status'] = 'Removed';
                        $response['result']['message'] = 'Removed from your Wishlist';
                    }else{
                        $addUserToFav['favourite_user_id'] =$request->data['favourite_user_id']; 
                        $addUserToFav['user_id'] = @Auth::user()->id; 
                        $fav = UserToFavourite::create($addUserToFav);
                        $response['result']['status'] = 'Added';
                        $response['result']['message'] = 'Added to your Wishlist';
                    }
                }else{
                    $response['result']['status'] = '2';
                    $response['result']['message'] = 'You are a tutor so you cannot add other favourite tutor in your list!Only a student can add favorite tutors! ';   
                }
            }else{
                $response['result']['status'] = '2';
                $response['result']['message'] = 'Please login!';
            }
            return response()->json($response,200);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    public function getAllUserToFavourites(Request $request){
        try{  
            $userId = @Auth::user()->id;
            $data['getBookedTutors']=StudentClassBooking::where(['student_id'=>@Auth::user()->id])->whereIn('booking_status',['B','CM'])->pluck('tutor_id')->groupBy('tutor_id')->toArray();
            $data['admin_disable_bookings_values'] = AdminDisableBookings::first();
            $data['all_disabled_booking_dates'] = AdminDisableBookingDates::where('status','A')->pluck('disable_booking_date')->toArray();
            $data['tutors'] = User::with(['getState','getTimezone','getuserToFavourite','getTutorAcademic','languguageToTuor:id,tutor_id,language_id','languguageToTuor.languageName:id,language','getState:id,slug,state_name','getTutorShipPlan.getSubject:id,slug,subject,capture_code,status','getTutorShipPlan.getGrade:id,slug,grade_name,capture_code,status','getTutorShipPlan:id,teacher_id,grade_id,subject_id,hourly_rate,status'])->where(['user_type'=>'T','status'=>'A']);

            $data['tutors'] = $data['tutors']->whereHas('getuserToFavourite',function($q) use($userId){
                $q->where('user_id',$userId);
            });
            if(@$request->search_tutor_nm_studentclass){
                $data['tutors'] = $data['tutors']->where(function($query) use($request) {
                    $query->Where('f_name','like','%'.$request->search_tutor_nm_studentclass.'%')
                    ->orWhere('l_name','like','%'.$request->search_tutor_nm_studentclass.'%')
                    ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->search_tutor_nm_studentclass . '%');
                });
            }
            // if(@$request->search_tutor_id_studentclass){
            //     $search_tutor_id_studentclass = $request->search_tutor_id_studentclass;
            //     $data['tutors'] = $data['tutors']->where(function($q) use($search_tutor_id_studentclass){
            //         $q->where('id',$search_tutor_id_studentclass);
            //     });    
            // }
            
            $data['tutors'] = $data['tutors']->select('id','f_name','l_name','slug','user_type','student_type','status','avatar','profile_pic','about_me','profile_video','video_short_url','total_experience','total_no_of_reviews','avg_review','min_hourly_rate','created_at','state','timezone_id');
            // $data['favourites'] = UserToFavourite::with(['getFavouriteUserInfo','getFavouriteUserInfo.getTutorAcademic','getFavouriteUserInfo.languguageToTuor:id,tutor_id,language_id','getFavouriteUserInfo.languguageToTuor.languageName:id,language','getFavouriteUserInfo.getState:id,slug,state_name','getFavouriteUserInfo.getTutorShipPlan.getSubject:id,slug,subject,capture_code,status','getFavouriteUserInfo.getTutorShipPlan.getGrade:id,slug,grade_name,capture_code,status','getFavouriteUserInfo.getTutorShipPlan:id,teacher_id,grade_id,subject_id,hourly_rate,status'])->where(['user_id'=>@Auth::user()->id]);
            $data['tutors'] = $data['tutors']->orderBy('id','desc')->paginate(3)->appends(request()->query());     
            $data['search_tutor_nm'] = @$request->search_tutor_nm;
            $data['search_tutor_id'] = @$request->search_tutor_id;
            $data['search_tutor_slug'] = @$request->search_tutor_slug;
            $data['key'] = @$request->all();
            // dd($data['search_tutor_nm']);
            return view('student.modules.user_to_favoruites.user_to_favoruites')->with($data);
        }catch(\Exception $e){
            dd($e->getMessage());
        } 
    }

    public function getAllTutors(Request $request){
        try{
            $data['tutors'] = User::where(['user_type'=>'T','status'=>'A'])->orderBy('f_name')->select('id','f_name','l_name','user_type','status')->get();
            return response()->json($data,200);
        }catch(\Exception $e){
            $data['message'] = $e->getMessage();
            $data['tutors_count'] = 0;
            \Log::error($e->getMessage());
            return response()->json($data,200);
        }
        
    }
}
