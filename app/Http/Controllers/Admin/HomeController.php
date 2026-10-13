<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use App\Models\StudentClassBooking;
use App\Models\Subject;
use App\Models\ClassEndAssesment;
use App\Models\TutorApplicationFormsModel;
use App\Models\Admin;
use Symfony\Component\HttpFoundation\Request;
use Auth;
use Storage;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function to_dashboard() {
        $to_p = url('/admin/dashboard');
        return Redirect::to($to_p);
    }
    public function index() {
        $data['grade_count'] = Grade::whereIn('status',['I','A'])->count();
        $data['subject_count'] = Subject::whereIn('status',['I','A'])->count();
        // $data['tutor_count'] = User::whereIn('status',['I','A','U','AA'])->where('user_type','T')->count();

        $tutor_application_count = TutorApplicationFormsModel::whereNotNull('id')->count();
        $data['tutor_application_count'] = $tutor_application_count;

        $total_approve = User::where('user_type','T')->whereIn('status',['A'])->Where('subscription', 'S')->Where('draft', 'N')->count();
        $all_active = User::where('user_type','T')->whereIn('status',['A'])->count();
        $total_active = $all_active - $total_approve;
        $total_reject = User::where('user_type','T')->whereIn('status',['R'])->count();
        $total_inactive = User::where('user_type','T')->whereIn('status',['I'])->count();

        $data['tutor_count'] = $total_approve + $total_active + $total_reject + $total_inactive;

        $data['student_count'] = User::whereIn('status',['I','A','U','AA'])->where('user_type','U')->count();
        $data['student_bookings_count'] = StudentClassBooking::whereIn('booking_status',['B','C','CM'])->count();
        $data['assessments_count'] = ClassEndAssesment::groupBy('user_id')->count();
        $data['todays_s_count'] = User::whereIn('status',['A','U','I','AA'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->whereDate('created_at', date('Y-m-d'))->count();
        $data['todays_booking_count'] = StudentClassBooking::whereIn('booking_status',['B','C','CM'])->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->whereDate('created_at', date('Y-m-d'))->count();
        return view('admin.modules.dashboard.dashboard')->with($data);
    }
    public function changePassword(Request $request)
    {
        if(@$request->all())
        {
            $request->validate([
                'opassword'    => 'required|string',
                'npassword'    => 'required|string',
                'cpassword'   =>'required|string|same:npassword',
            ]);
            $id = Auth::guard('admin')->user()->id;
            //dd($id);
            $password_check = Admin::where('id',$id)->first();

            //$password_check=Admin::where('id',auth()->user()->id)->first();
            //dd($password_check);
            $check = \Hash::check($request->opassword, $password_check->password);
            if(@$check)
            {
                $user = Admin::where('id',$id)->update([
                'password'      => \Hash::make($request->npassword),
                ]);
                return redirect()->back()->with('success','Password changed successfully.');
            }
            else
            {
                return redirect()->back()->with('error','Wrong current password');
            }
        }
        return view('admin.modules.change_password.change_password');
    }

    public function editProfile(Request $request){
        $id = Auth::guard('admin')->user()->id;
        $data['profile'] = Admin::where('id',$id)->first();
        if($request->all()){
            $update['name'] = $request->name;
            $update['mobile'] = $request->mobile;
            $update['email'] = $request->email;
            if(@$request->image){
                $image = $request->image;
                $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('admin/profileImage', $image, $filename);
                @unlink(storage_path('app/public/admin/profileImage/'.@$data['profile'] ->image));
                $update['image'] = $filename;
            }
            $updateProfile = Admin::where('id',$id)->update($update);
            if($updateProfile){
                return redirect()->back()->with('success','Profile updated Successfully.');
            }

        }
        return view('admin.modules.edit_profile.edit_profile')->with($data);
    }
    public function confirmAdminPassword(Request $request){
        if(@$request->all()){
            $request->validate([
                'edit_password'    => 'required|string'
            ]);
            $password_check = Auth::guard('admin')->user();
            $check = \Hash::check($request->edit_password, $password_check->password);
            if(@$check)
            {
                session(['is_authorized'=>1]);
                // session()->("flash",'You are authorize');
                if(@$request->nextHref){
                    session(['url'=>$request->nextHref]);
                    return redirect($request->nextHref);
                }else{
                    session(['is_admin'=>1]);
                    return redirect()->back();
                }
            }
            else
            {
                return redirect()->back()->with('error','Wrong password');
            }
        }
        return redirect()->back();
    }
    public function ajaxconfirmAdminPassword(Request $request){
        // $rules = ['verify_password' => 'required|email'];
        // $validator = Validator::make(@$request->data, $rules);
        // if(@$validator->fails()) {
        //     $data['result']['output'] = 0;
        //     $response['error']['message'] = 'Password field is required';
        //     return response()->json($response);
        // }



        $password_check = @Auth::guard('admin')->user();
        $check = \Hash::check($request->data['verify_password'], $password_check->password);
        if(@$check)
        {
            $data['result']['output'] = 1;
            $data['result']['message'] = 'Password is correct!';
            return response()->json($data,200);
        }else{
            $data['result']['output'] = 0;
            $data['result']['message'] = 'Password is wrong!Please try again!';
            return response()->json($data,200);
        }
    }
}
