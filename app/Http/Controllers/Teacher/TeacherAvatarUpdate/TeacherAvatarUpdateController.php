<?php

namespace App\Http\Controllers\Teacher\TeacherAvatarUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class TeacherAvatarUpdateController extends Controller
{
    /*
    *   Method          : updateTutorAvatar
    *   Description     : This method is used to update teacher Avatar
    *   Author          : Jayatri
    */ 
    public function updateTutorAvatar(Request $request){
        try{
            $profile_pic = @$request->data['profile_pic'];
            User::where(['id'=>@Auth::user()->id])->update(['profile_pic'=>$profile_pic]);
            $data['message'] = 'Your avatar is uploaded successfully!';
            return response()->json($data,200);    
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['message'] = 'avatar is not uploaded!'.$e->getMessage();
            return response()->json($data,200);    
        }
    }
}
