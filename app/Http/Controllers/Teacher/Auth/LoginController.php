<?php

namespace App\Http\Controllers\Teacher\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

/*This is for teacher login page view
*name:Jeet
*method:teacher_login_view
*date:26/7/2021
*/

    public function teacher_login_view(){
    	 return view('teacher.modules.auth.login'); 
    }

    //  public function teacher_login(Request $request){
    // 	 dd($request->all());
    // }
}
