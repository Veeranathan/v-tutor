<?php

namespace App\Http\Controllers\Teacher\TeacherPyment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherPaymentController extends Controller
{
    public function my_payment_list(Request $request){
    	return view('teacher.modules.payment.payment_list');
    }
}
