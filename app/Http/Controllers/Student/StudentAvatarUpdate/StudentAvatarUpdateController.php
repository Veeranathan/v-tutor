<?php

namespace App\Http\Controllers\Student\StudentAvatarUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class StudentAvatarUpdateController extends Controller
{
    /*
    *   Method          : updateStudentAvatar
    *   Description     : This method is used to update studentAvatar
    *   Author          : Jayatri
    */ 
    public function updateStudentAvatar(Request $request){
        try{
            $profile_pic = @$request->data['profile_pic'];
            User::where(['id'=>@Auth::user()->id])->update(['profile_pic'=>$profile_pic]);
            $data['message'] = 'Your avatar is uploaded successfully!';
            $data['s'] = '1';
            
            return response()->json($data,200);    
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['message'] = 'Avatar is not uploaded!'.$e->getMessage();
            $data['s'] = '0';
            return response()->json($data,200);    
        }
    }
}
