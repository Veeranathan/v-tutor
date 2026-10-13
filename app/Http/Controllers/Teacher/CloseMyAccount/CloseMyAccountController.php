<?php

namespace App\Http\Controllers\Teacher\CloseMyAccount;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;
use App\Mail\CloseAccountMail;

class CloseMyAccountController extends Controller
{
    //
    public function tutorCloseMyAccount(Request $request){
        // if(@$request->all()){
            if(@Auth::user()->platform_type != NULL){
                User::where(['id'=>@Auth::user()->id])->update(['status'=>'C']);
                session()->flash("success","Your V-Tutor account is closed!");
                session(['t'=>'T']);
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
                    session()->flash("success","Your V-Tutor account is closed!");
                    session(['t'=>'T']);
                    $this->sendCloseAccountMail(@Auth::user()->id);
                    Auth::logout();
                    
                    return redirect()->route('login');
                }else{
                    session()->flash("error","Wrong Password !");
                    return redirect()->back();
                }    
            }
            
        // }
        // User::where(['id'=>@Auth::user()->id])->update(['status'=>'D']);
        // session()->flash("success","You have successfully close your account!");
        // Auth::logout();
        // return redirect()->route('login');
    }
    public function sendCloseAccountMail($id){
        // try{
            $data['user'] = User::where('id',$id)->first();
            $data['subject'] = "Your account is closed!";
            Mail::send(new CloseAccountMail($data));
        // }catch(\Exception $e){
            // \Log::error($e->getMessage());
        // }
    }
}
