<?php

namespace App\Http\Controllers\Student\GetAllVTutors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;

class GetAllVTutorsController extends Controller
{
    public function getAllTutors(Request $request){
        try{
            $userId = @Auth::user()->id;
            $data['tutors'] = User::with(['getuserToFavourite'])->where(['user_type'=>'T','status'=>'A'])->orderBy('f_name')->select('id','f_name','l_name','user_type','status');
            if(@$request->search_u_name){
                $data['tutors'] = $data['tutors']->where(function($query) use($request) {
                    $query->Where('f_name','like','%'.$request->search_u_name.'%')
                    ->orWhere('l_name','like','%'.$request->search_u_name.'%')
                    ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->search_u_name. '%');
                });    
            }
            if(@$request->get_fav == 'Y'){
                $data['tutors'] = $data['tutors']->whereHas('getuserToFavourite',function($q) use($userId){
                    $q->where('user_id',$userId);
                });
            }
            $data['tutors'] = $data['tutors']->get();
            return response()->json($data,200);
        }catch(\Exception $e){
            $data['message'] = $e->getMessage();
            $data['tutors_count'] = 0;
            \Log::error($e->getMessage());
            return response()->json($data,200);
        }
        
    }
}
