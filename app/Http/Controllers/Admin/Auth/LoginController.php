<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        try {
            if(Cookie::get('email') != null && Cookie::get('password') != null && Cookie::get('remember_me') != null) {
                $data['email'] = Cookie::get('email');
                $data['password'] = Cookie::get('password');
                $data['remember'] = Cookie::get('remember_me');
            }
            return view('admin.auth.login')->with(@$data);
        } catch (Exception $e) {
            abort(404);
        }
        // return view('admin.auth.login');
    }
    protected function authenticated(Request $request, $admin)
    {
        if((@$admin) && @$request->remember == 'on') {
            // check remember me cookie have or not
            // set remember me cookie
            $email_cookie = Cookie::queue('email', $request->email, 10080);
            $pass_cookie = Cookie::queue('password', $request->password, 10080);
            $remember_coockie = Cookie::queue('remember_me', $request->remember, 10080);
        }
        else {
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
            Cookie::queue(Cookie::forget('remember_me'));
        }
    }
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }

}
