<?php

namespace App\Http\Controllers\ResendVerifyLink;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mail;
use App\Mail\TeacherVerify;

class ResendVerifyLinkController extends Controller
{
    //
    public function resendVerifyLink($id){
        $getuser = User::where(['id'=>$id,'status'=>'U'])->first();           
        $data['name'] = $getuser->f_name.' '. $getuser->l_name;
        $data['email'] = $getuser->email;
        $data['vcode'] = $getuser->email_vcode;
        $data['id'] = $getuser->id;
        $data['email_subject'] = "Verify your email address on V-Tutor";
        Mail::to($getuser->email)->send(new TeacherVerify($data));
    }
}
