<?php

namespace App\Http\Controllers\Student\CloseMyAccount;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;
use App\Mail\CloseAccountMail;

class CloseMyAccountController extends Controller
{
    //
    public function studentCloseMyAccount(Request $request){
        // if(@$request->all()){
            if(@Auth::user()->platform_type != NULL){
                
                User::where(['id'=>@Auth::user()->id])->update(['status'=>'C']);
                session(['t'=>'S']);
                session()->flash("success","Your V-Tutor account is closed!");
                $this->sendCloseAccountMail(@Auth::user()->id);
                Auth::logout();
                
                return redirect()->route('login');
            }else{
                
                $request->validate([
                    'mypassword'        => 'required'
                ]);
                $password = @$request->mypassword;
                if (\Hash::check($password,@Auth()->user()->password)) {
                    User::where(['id'=>@Auth::user()->id])->update(['status'=>'C']);
                    session(['t'=>'S']);
                    session()->flash("success","Your V-Tutor account is closed!");
                    $this->sendCloseAccountMail(@Auth::user()->id);
                    Auth::logout();
                    
                    return redirect()->route('login');
                }else{
                    session()->flash("error","Wrong Password !");
                    return redirect()->back();
                }    
            }
            
        // }
        
    }
    public function sendCloseAccountMail($id){
        try{
            $data['user'] = User::where('id',@Auth::user()->id)->first();

            if(@$data['user']){
                $data['subject'] = "Account Closed";
                Mail::send(new CloseAccountMail($data));
            }
            
        }catch(\Exception $e){
            \Log::error($e->getMessage());
        }
    }
}
