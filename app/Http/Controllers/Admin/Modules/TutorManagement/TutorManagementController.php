<?php

namespace App\Http\Controllers\Admin\Modules\TutorManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TutorApplicationFormsModel;
use App\Models\TutorWWCCModel;
use App\Models\TutorshipPlan;
use App\Models\ExpToSubject;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\FieldOfStudy;
use App\Models\MyAvailability;
use Carbon\Carbon;
use App\Models\TutorRecognision;
use App\Models\University;
use App\Models\TutorExperience;
use App\Models\TutorAcademic;
use App\Models\State;

use App\Models\LangToTutor;
use App\Models\Language;
use App\Models\TutorToRef;
use App\Models\TimezoneLists;
use App\Models\Branch;
use App\Models\Nationality;
// use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\AdminApproveMail;
use Validator;

class TutorManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function updateTutorAvatar(Request $request){
        try{
            $profile_pic = @$request->data['profile_pic'];
            $id = @$request->data['id'];
            User::where(['id'=>$id])->update(['profile_pic'=>$profile_pic]);
            $data['message'] = 'Your avatar is uploaded successfully!';
            return response()->json($data,200);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            $data['message'] = 'avatar is not uploaded!'.$e->getMessage();
            return response()->json($data,200);
        }
    }
    public function viewTutorPersonalInfo($id,Request $request){
        try{
            $data['user'] = User::with(['getTimezone','getState'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutor_to_ref']=TutorToRef::where('tutor_id',$id)->first();
            $data['state']=State::orderBy('id','asc')->get();
            $data['lan']=Language::orderBy('id')->get();
            $data['tutor_to_lan']=LangToTutor::with('languageName')->where('tutor_id',$id)->get();
            $data['total_lan']=LangToTutor::where('tutor_id',$id)->count();
            $data['states'] = State::get();

                if(@$data['user']){
                    return view('admin.modules.tutor_management.view_tutor_personal_info')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutorAdvancePage($id,Request $request){
        try{
            $data['user'] = User::with(['getTimezone','getState','getNationality'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutor_to_ref']=TutorToRef::where('tutor_id',$id)->first();
            $data['state']=State::orderBy('id','asc')->get();
            $data['lan']=Language::orderBy('id')->get();
            $data['tutor_to_lan']=LangToTutor::with('languageName')->where('tutor_id',$id)->get();
            $data['total_lan']=LangToTutor::where('tutor_id',$id)->count();
            $data['states'] = State::get();

                if(@$data['user']){
                    return view('admin.modules.tutor_management.view_advance_page')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function updateFreeTrailStatus(Request $request)
{
    $request->validate([
        'tutor_id' => 'required|integer',
        'status'   => 'required|integer|in:0,1',
    ]);

    $user = User::find($request->tutor_id);
    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Tutor not found']);
    }

    $user->free_trial = $request->status;
    $user->save();

    return response()->json(['status' => true, 'message' => 'Free Trial status updated successfully']);
}

    public function updateFeaturedStatus(Request $request)
{
   $request->validate([
        'tutor_id' => 'required|integer|exists:users,id',
        'status'   => 'required|in:0,1',
    ]);

    \App\Models\User::where('id', $request->tutor_id)
        ->update(['featured' => $request->status]);

    return response()->json(['status' => true, 'message' => 'Featured status updated successfully.']);
}
    public function viewTutorshipPlans($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['states'] = State::get();
            if(@$data['user']){
                return view('admin.modules.tutor_management.view_tutorship_plans')->with($data);
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutorExperience($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['states'] = State::get();
            if(@$data['user']){
                return view('admin.modules.tutor_management.view_tutor_experience')->with($data);
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutorRecognitions($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['states'] = State::get();
            if(@$data['user']){
                return view('admin.modules.tutor_management.view_tutor_recognitions')->with($data);
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutorRighttoWork($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');

            if(@$data['user']){
                $data['tutor_wwcc'] = [];
                $exist_taf = TutorApplicationFormsModel::selectRaw('MIN(id) as id')
                    ->Where('status', '!=', 2)
                    ->groupBy('tutor_id')
                    ->pluck('id')
                    ->toArray();
                if(count($exist_taf) != 0){
                    $data['tutor_wwcc'] = TutorWWCCModel::where('tutor_id',$id)->WhereIn('tutor_app_id', $exist_taf)->orderby('id','asc')->get();
                }
                
                return view('admin.modules.tutor_management.view_tutor_right_to_work')->with($data);
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutorAcademic($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['states'] = State::get();
            if(@$data['user']){
                return view('admin.modules.tutor_management.view_tutor_academic')->with($data);
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function sendAdminApproveMail($id){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['subject'] = "";
            if($data['user']->user_type == 'T'){
                $data['subject'] = "Admin approved your vtutor tutor account!Please login!";
            }
            if($data['user']->user_type == 'U'){
                if($data['user']->student_type == 'G'){
                    $data['subject'] = "Admin approved your vtutor gurdain account!Please login!";
                }
                if($data['user']->student_type == 'P'){
                    $data['subject'] = "Admin approved your vtutor parent account!Please login!";
                }
                if($data['user']->student_type == 'S'){
                    $data['subject'] = "Admin approved your vtutor student account!Please login!";
                }
            }
            Mail::send(new AdminApproveMail($data));
        }catch(\Exception $e){
            \Log::error($e->getMessage());
        }
    }
    public function ajaxTutorDuplicateEmailCheck(Request $request){
        try{
            $email = trim($request->email);
            $isExistEmail = User::where(['email'=>@$request->email])->whereNotIn('id',[@$request->id])->whereIn('status',['A','I','AA','U'])->first();
            if(@$isExistEmail){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function ajaxTutorDuplicatePhoneCheck(Request $request){
        try{
            $phone = trim($request->phone);
            $isExistPhone = User::where(['phone'=>@$request->phone])->whereNotIn('id',[@$request->id])->whereIn('status',['A','I','AA','U'])->first();
            if(@$isExistPhone){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'true';
        }
    }
    public function tutorManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        // $users = User::where(['user_type'=>'T'])->whereNotIn('status',['D']);
        $users = User::where(['user_type'=>'T'])->whereIn('status',['A', 'I', 'R']);
        if(@$request->columns['1']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->Where('f_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('l_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('unique_id','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('email','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                ->orWhere('phone','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        if(@$request->columns['2']['search']['value'] == 'A'){

            $users = $users->where(function($query) use($request) {
                // $query->Where('status',$request->columns['2']['search']['value']);
                $query->where('status', 'A')
                    ->where(function ($q) {
                        $q->where('subscription', '!=', 'S')
                            ->orWhere('draft', '!=', 'N');
                    });
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'R'){

            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'C'){

            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'AA'){

            $users = $users->where(function($query) use($request) {
                $query->Where(['status'=>$request->columns['2']['search']['value'],'draft'=>'Y']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'I'){

            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'U'){

            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'draft'){

            $users = $users->where(function($query) use($request) {
                $query->Where(['status'=>'AA','draft'=>'N']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        if(@$request->columns['2']['search']['value'] == 'AP'){

            $users = $users->where(function($query) use($request) {
                $query->Where(['status'=>'A','subscription'=>'S','draft'=>'N']);
            });
            $data["re"] = @$request->columns['2']['search']['value'];

        }
        // if(@$request->columns['6']['search']['value']){
        //     $users = $users->where(function($query) use($request) {
        //         $query->where(['draft'=>$request->columns['6']['search']['value'],'status'=>'AA']);
        //     });

        // }
        // if(@$request->columns['5']['search']['value'] != 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type',$request->columns['5']['search']['value']);
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'google'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type','google');
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'facebook'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type','facebook');
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'web'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type',NULL);
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_id',NULL);
        //     });
        // }
        if(@$request->columns['3']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if(@$request->columns['4']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if (@$request->columns[5]['search']['value'] == 'Y') {
    $users = $users->whereHas('getMyAvailability', function ($q) {
        $q->where('status', 'A');
    });
}

if (@$request->columns[5]['search']['value'] == 'N') {
    $users = $users->whereDoesntHave('getMyAvailability', function ($q) {
        $q->where('status', 'A');
    });
}

// 6 → Featured filter
if ($request->columns[6]['search']['value'] !== null && $request->columns[6]['search']['value'] !== '') {
    $users = $users->where('featured', $request->columns[6]['search']['value']);
}

// 7 → Free Trial filter
if ($request->columns[7]['search']['value'] !== null && $request->columns[7]['search']['value'] !== '') {
    $users = $users->where('free_trial', $request->columns[7]['search']['value']);
}
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
         if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('unique_id','asc');
            } else {
                $users = $users->orderBy('unique_id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('f_name','asc');
            } else {
                $users = $users->orderBy('f_name','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('email','asc');
            } else {
                $users = $users->orderBy('email','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('phone','asc');
            } else {
                $users = $users->orderBy('phone','desc');
            }
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('created_at','asc');
            } else {
                $users = $users->orderBy('created_at','desc');
            }
        }
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('platform_type','asc');
            } else {
                $users = $users->orderBy('platform_type','desc');
            }
        }
        if($columnIndex == 6) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('status','asc');
            } else {
                $users = $users->orderBy('status','desc');
            }
        }
        if($columnIndex == 7) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('updated_at','asc');
            } else {
                $users = $users->orderBy('updated_at','desc');
            }
        }
        if($columnIndex == 8) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        $users = $users->with('status_change_user')->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
       $users->transform(function ($value) {

    // Availability: YES if any availability row exists (status = 'A')
    $value->availability = $value->getMyAvailability()
                                ->where('status', 'A')
                                ->exists() ? 'Y' : 'N';

    // Featured toggle HTML already exists
    $value->featured_button = '<label class="switch">
        <input type="checkbox" class="featuredToggle" data-id="'.$value->id.'" '.($value->featured == 1 ? 'checked' : '').'>
        <span class="slider round"></span>
    </label>';
    $value->free_trial_button = '<label class="switch">
    <input type="checkbox" class="freeTrailToggle" data-id="'.$value->id.'" '.($value->free_trial == 1 ? 'checked' : '').'>
    <span class="slider"></span>
</label>';

    return $value;
});
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        $data['total_approve'] = User::where('user_type','T')->whereIn('status',['A'])->Where('subscription', 'S')->Where('draft', 'N')->count();
        $total_active = User::where('user_type','T')->whereIn('status',['A'])->count();
        $data['total_active'] = $total_active - $data['total_approve'];
        $data['total_reject'] = User::where('user_type','T')->whereIn('status',['R'])->count();
        $data['total_inactive'] = User::where('user_type','T')->whereIn('status',['I'])->count();
        $data['total_in_progress'] = User::where(['user_type'=>'T','draft'=>'Y'])->whereIn('status',['AA'])->count();
        $data['total_unverified'] = User::where('user_type','T')->whereIn('status',['U'])->count();
        $data['total_submitted'] = User::where(['user_type'=>'T','draft'=>'N'])->whereIn('status',['AA'])->count();
        $data['total_closed'] = User::where(['user_type'=>'T'])->whereIn('status',['C'])->count();
        // $data['total_submitted'] = User::where('user_type'=>'T','draft'=>'N')->whereIn('status',['AA'])->count();
        // $data['total_closed'] = User::where('user_type','T')->whereIn('status',['C'])->count();
        return response()->json($data);
    }
    public function getDuetutorManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = User::where(['user_type'=>'T'])->whereNotIn('status',['D','U']);
        if(@$request->columns['1']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->Where('f_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('l_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('email','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                ->orWhere('phone','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        if(@$request->columns['2']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
        }
        // if(@$request->columns['5']['search']['value'] != 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type',$request->columns['5']['search']['value']);
        //     });
        // }
        if(@$request->columns['5']['search']['value'] == 'google'){
            $users = $users->where(function($query) use($request) {
                $query->Where('platform_type','google');
            });
        }
        if(@$request->columns['5']['search']['value'] == 'facebook'){
            $users = $users->where(function($query) use($request) {
                $query->Where('platform_type','facebook');
            });
        }
        if(@$request->columns['5']['search']['value'] == 'web'){
            $users = $users->where(function($query) use($request) {
                $query->Where('platform_type',NULL);
            });
        }
        // if(@$request->columns['5']['search']['value'] == 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_id',NULL);
        //     });
        // }
        if(@$request->columns['3']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if(@$request->columns['4']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
         if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('f_name','asc');
            } else {
                $users = $users->orderBy('f_name','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('email','asc');
            } else {
                $users = $users->orderBy('email','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('phone','asc');
            } else {
                $users = $users->orderBy('phone','desc');
            }
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('created_at','asc');
            } else {
                $users = $users->orderBy('created_at','desc');
            }
        }
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('status','asc');
            } else {
                $users = $users->orderBy('status','desc');
            }
        }
        if($columnIndex == 6) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('platform_type','asc');
            } else {
                $users = $users->orderBy('platform_type','desc');
            }
        }
        if($columnIndex == 7) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 8) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function academicManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorAcademic::where('status','!=','D');
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        // if($columnIndex == 3) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('status','asc');
        //     } else {
        //         $users = $users->orderBy('status','desc');
        //     }
        // }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('id','asc');
        //     } else {
        //         $users = $users->orderBy('id','desc');
        //     }
        // }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function expManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorExperience::where('status','!=','D');
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        // if($columnIndex == 3) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('status','asc');
        //     } else {
        //         $users = $users->orderBy('status','desc');
        //     }
        // }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('id','asc');
        //     } else {
        //         $users = $users->orderBy('id','desc');
        //     }
        // }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    public function recManagement($id,Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = TutorRecognision::where('teacher_id',$id)->where('status','!=','D');
        $ps =  $users->count();
        $pp = $users;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $users = $users;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('id','asc');
            } else {
                $users = $users->orderBy('id','desc');
            }
        }
        // if($columnIndex == 3) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('status','asc');
        //     } else {
        //         $users = $users->orderBy('status','desc');
        //     }
        // }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('id','asc');
        //     } else {
        //         $users = $users->orderBy('id','desc');
        //     }
        // }
        $users = $users->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $users;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage tutors!
    * Author        : Jayatri
    */
    public function index(Request $request){
        try{
            $data['total_approve'] = User::where('user_type','T')->whereIn('status',['A'])->Where('subscription', 'S')->Where('draft', 'N')->count();
            $total_active = User::where('user_type','T')->whereIn('status',['A'])->count();
            $data['total_active'] = $total_active - $data['total_approve'];
            $data['total_reject'] = User::where('user_type','T')->whereIn('status',['R'])->count();
            $data['total_inactive'] = User::where('user_type','T')->whereIn('status',['I'])->count();
            $data['tot_submitted'] = User::where(['user_type'=>'T','status'=>'AA','draft'=>'N'])->count();
            $data['tot_in_progress'] = User::where(['user_type'=>'T','status'=>'AA'])->count();
            $data['tot_unverified'] = User::where(['user_type'=>'T','status'=>'U'])->count();
            $data['tot_closed'] = User::where(['user_type'=>'T','status'=>'C'])->count();
            // $data['users'] = User::where(['user_type'=>'T'])->whereNotIn('status',['D']);
            // if(@$request->all()) {
            //     if(@$request->keyword) {
            //         $data['users'] = $data['users']->where(function($q) use($request){
            //             $q->where(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->keyword . '%')
            //             ->orwhere('l_name', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('f_name', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('email', 'like', '%' . $request->keyword . '%')
            //             ->orwhere('phone', 'like', '%' . $request->keyword . '%');
            //         });
            //     }
            //     if(@$request->status) {
            //         $data['users'] = $data['users']->where('status', $request->status);
            //     }
            //     if(@$request->created_at || @$request->to_date) {
            //         $data['users'] = $data['users']->where(function($q8) use($request) {
            //             $q8 = $q8->whereBetween('created_at',[@$request->created_at." 00:00:00", @$request->to_date." 23:59:59"]);
            //         });
            //     }
            //     if(@$request->platform_type) {
            //         $data['users'] = $data['users']->where('platform_type', $request->platform_type);
            //     }
            //     if(@$request->gender) {
            //         $data['users'] = $data['users']->where('platform_type', $request->gender);
            //     }

            // }
            // $data['users']= $data['users']->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.tutor_management.manage_tutors')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function manageTutorShipPlans($id,Request $request){
        try{
            $data['user'] = User::with(['getState'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutorshipplans'] = TutorshipPlan::with(['getGrade','getSubject'])->where(['teacher_id'=>$id,'status'=>'A'])->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.tutor_management.manage_tutorship_plans')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function manageTutorAcademic($id,Request $request){
        try{
            $data['user'] = User::with(['getState'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutoracademic'] = TutorAcademic::with(['getFieldStudy','getUniversity'])->where(['teacher_id'=>$id])->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.tutor_management.manage_tutoracademic')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function manageTutorRecognization($id,Request $request){
        try{
            $data['user'] = User::with(['getState'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutor_recognitions'] = TutorRecognision::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.tutor_management.manage_tutor_recognition')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function manageTutorExperience($id,Request $request){
        try{
            $data['user'] = User::with(['getState'])->where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutorexps'] = TutorExperience::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            // $data['key'] = @$request->all();
            return view('admin.modules.tutor_management.manage_tutor_exp')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function viewTutor($id,Request $request){
    try{
        
        $data['user'] = $user = User::with(['getState'])->where('id',$id)->first();
        $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
        $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');

        if (@$data['user']) {

            // ⭐ Get tutor timezone from users table
            $tutorTimezone = $user->timezone_id ?? 'UTC';

            // ⭐ Convert tutor timezone string to valid format (optional)
            // If your timezone_id stores like 'Australia/Sydney', no change needed.

            $data['availablity'] = MyAvailability::where([
                'teacher_id' => $id,
                'status'     => 'A'
            ])->get()->map(function ($slot) use ($tutorTimezone) {

                // Build a date based on day index
                $dayIndex = (int) $slot->day; // 1 = Monday
                $baseDate = Carbon::now()->startOfWeek()->addDays($dayIndex);

                // Create UTC datetime (your DB likely stores UTC times)
                $fromUtc = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $baseDate->toDateString() . ' ' . $slot->from_time,
                    'UTC'
                );

                $toUtc = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $baseDate->toDateString() . ' ' . $slot->to_time,
                    'UTC'
                );

                // Handle overnight times
                if ($toUtc->lessThanOrEqualTo($fromUtc)) {
                    $toUtc->addDay();
                }

                // ⭐ Convert from UTC → tutor's timezone
                $slot->from_time_student = $fromUtc->copy()->setTimezone($tutorTimezone)->format('Y-m-d H:i');
                $slot->to_time_student   = $toUtc->copy()->setTimezone($tutorTimezone)->format('Y-m-d H:i');

                return $slot;
            });

            return view('admin.modules.tutor_management.view_tutor_info_availability')->with($data);
        
        } else {
            session()->flash("error","Tutor is not found associated with id : ".$id);
            return redirect()->back();
        }

    } catch(\Exception $e){
        \Log::error($e->getMessage());
        session()->flash("error",$e->getMessage());
        return redirect()->back();
    }
}
   public function deleteTutorshipPlan($id){
        TutorshipPlan::where('id',$id)->update(['status'=>'D']);
        $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
        session()->flash("success"," Tutorship plan deleted successfully!");
        return redirect()->back();
    }
    public function editTutorAddPlan($id,Request $request){
        try{
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            if(@$request->all()){
                $isCountExist = 0;
                // $request->validate([
                //     'grade_id'=>'required'
                // ],[

                //     'grade_id.required'=>'Please select grade!Grade is required!'
                // ]);
                if(@$request->subject_id){
                    foreach(@$request->subject_id  as $subject){
                        $isExist = TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subject,'status'=>'A'])->first();
                        if(!@$isExist){
                            $addTutorshipPlan['teacher_id'] = $id;
                            $addTutorshipPlan['grade_id'] = $request->grade_id;
                            $addTutorshipPlan['subject_id'] = $subject;
                            $addTutorshipPlan['hourly_rate'] = $request->hourly_rate;
                            $addTutorshipPlan['status'] = "A";
                            $tutorshipplans = TutorshipPlan::create($addTutorshipPlan);
                            $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                            session()->flash("success"," Tutorship plans added successfully!");
                        }else{
                            $isCountExist = 1;
                            session()->flash("success"," Tutorship plans added successfully!But few combinations are already exist!");
                        }

                    }
                }
                if($isCountExist == 1){
                    session()->flash("error"," Some Tutorship plans added successfully!But few combinations are already exist!");
                }else{
                    session()->flash("success","Tutorship plans added successfully!");
                }

                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function addTutorAcademics($id,Request $request){
        try{
            if(@$request->all()){
                if(!@$request->qualification || !@$request->qualification_status || !@$request->field_of_study || !@$request->university || !@$request->effective_date){
                    session()->flash("error","Please provide all required fields !");
                    return redirect()->back();
                }
                // $request->validate([
                //     'qualification'=>'required',
                //     'qualification_status'=>'required',
                //     'field_of_study'=>'required',
                //     'university'=>'required',
                //     'effective_date'=>'required',
                // ]
                // ,[

                //     'qualification.required'=>'Please select qualification!'
                // ]
                // );
                $isExist = TutorAcademic::where(['teacher_id'=>$id,'qualification'=>$request->qualification,'qualification_status'=>$request->qualification_status,'field_of_study'=>$request->field_of_study,'university'=>$request->university,'effective_date'=>$request->effective_date])->first();
                if(!@$isExist){
                    $addTutorAcademic['teacher_id'] = $id;
                    $addTutorAcademic['qualification'] = $request->qualification;
                    $addTutorAcademic['qualification_status'] = $request->qualification_status;
                    $addTutorAcademic['field_of_study'] = $request->field_of_study;
                    $addTutorAcademic['university'] = $request->university;
                    $addTutorAcademic['effective_date'] = $request->effective_date;
                    $addTutorAcademic['status'] = 'A';
                    $tutorAcademic = TutorAcademic::create($addTutorAcademic);
                    session()->flash("success","Academic information added successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("error","Academic information already exist!");
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function updateTutorAcademic($tutorExperienceid,Request $request){
        try{
            $tutorAcademicDtls = TutorAcademic::where('id',$tutorExperienceid)->first();
            if(@$tutorAcademicDtls){
                $id = $tutorAcademicDtls->teacher_id;
                $user = User::where('id',$id)->first();
                $field_studies = FieldOfStudy::get();
                $universities = University::get();
                $tutoracademics = TutorAcademic::with(['getFieldStudy','getUniversity'])->where(['teacher_id'=>$id])->paginate(10);
                if(@$request->all()){
                    if(!@$request->qualification || !@$request->qualification_status || !@$request->field_of_study || !@$request->university || !@$request->effective_date){
                        session()->flash("error","Please provide all required fields !");
                        return redirect()->back();
                    }
                    // $request->validate([
                    //     'qualification'=>'required',
                    //     'qualification_status'=>'required',
                    //     'field_of_study'=>'required',
                    //     'university'=>'required',
                    //     'effective_date'=>'required'
                    // ]);
                    // $isExist = TutorAcademic::where(['teacher_id'=>$id,'qualification'=>$request->qualification,'qualification_status'=>$request->qualification_status,'field_of_study'=>$request->field_of_study,'university'=>$request->university,'effective_date'=>$request->effective_date])->whereNotIn('id',$tutorExperienceid)->first();
                    // if(!@$isExist){
                        $addTutorAcademic['qualification'] = $request->qualification;
                        $addTutorAcademic['qualification_status'] = $request->qualification_status;
                        $addTutorAcademic['field_of_study'] = $request->field_of_study;
                        $addTutorAcademic['university'] = $request->university;
                        $addTutorAcademic['effective_date'] = $request->effective_date;
                        TutorAcademic::where('id',$tutorExperienceid)->update($addTutorAcademic);
                        session()->flash("success","Academic information added successfully!");
                        return redirect()->route('edit.tutor.academics',$id);
                    // }else{
                        // session()->flash("error","Academic information already exist!");
                        // return redirect()->back();
                    // }
                }else{
                    if(@$user){
                        return view('admin.modules.tutor_management.edit_tutor_academic')->with(['user'=>$user,'universities'=>$universities,'field_studies'=>$field_studies,'tutoracademics'=>$tutoracademics,'tutorAcademicDtls'=>$tutorAcademicDtls]);
                    }else{
                        session()->flash("error","Tutor is not found associated with id : ".$id);
                        return redirect()->back();
                    }
                }
            }else{
                session()->flash("error","Tutor academic is not associated with id!");
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function addTutorExp($id,Request $request){
        try{
            if(@$request->all()){
                // $request->validate([
                //     'grade_id'=>'required'
                // ],[

                //     'grade_id.required'=>'Please select grade!Grade is required!'
                // ]);
                $isExist = TutorExperience::where(['teacher_id'=>$id,'organization'=>$request->organization,'job_title'=>$request->job_title,'year_of_exp'=>$request->year_of_exp])->first();
                if(!@$isExist){
                    if(@$request->to_year < @$request->from_year){
                        session()->flash("error","From year cannot be greater than to year !");
                        return redirect()->back();
                    }
                    $addTutorExp['teacher_id'] = $id;
                    $addTutorExp['organization'] = $request->organization;
                    $addTutorExp['job_title'] = $request->job_title;
                    $addTutorExp['year_of_exp'] = $request->year_of_exp;
                    $addTutorExp['from_year'] = @$request->from_year;
                    $addTutorExp['to_year'] = @$request->to_year;
                    if(@$request->description){
                        $addTutorExp['description'] = nl2br(@$request->description);
                    }

                    $addTutorExp['status'] = "A";
                    $tutorExp = TutorExperience::create($addTutorExp);
                    $tutorExpId = $tutorExp->id;
                    $get_exp_to_sub = ExpToSubject::where('exp_id',$tutorExpId)->get();
                    if(@$request->subject_id){
                        foreach(@$request->subject_id as $subject){
                            $isExistExpToSubject = ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$subject,'teacher_id'=>$id])->first();

                            if(!@$isExistExpToSubject){
                                $crTutprExpSubject['teacher_id'] = $id;
                                $crTutprExpSubject['exp_id'] = $tutorExpId;
                                $crTutprExpSubject['subject_id'] = $subject;
                                $expToSubject = ExpToSubject::create($crTutprExpSubject);
                                // dd($expToSubject);
                            }
                        }
                    }
                    if(@$get_exp_to_sub){
                        foreach(@$get_exp_to_sub as $s){
                          if(!in_array($s->subject_id,@$request->subject_id)){
                            $expToSubject = ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$s->subject_id,'teacher_id'=>$id])->first();
                            if(@$expToSubject){
                                ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$s->subject_id,'teacher_id'=>$id])->delete();
                            }
                          }
                        }
                    }
                    $tutor = User::where(['user_type'=>'T','status'=>'A','id'=>$id])->first();
                    if(@$tutor){
                        $updateTotalExp['total_experience'] = TutorExperience::where(['status'=>'A','teacher_id'=>$id])->sum('year_of_exp');
                        User::where(['user_type'=>'T','status'=>'A','id'=>$id])->update($updateTotalExp);
                    }
                    session()->flash("success","Experience information added successfully!");
                    return redirect()->back();
                }else{
                    session()->flash("error","Experience information already exist!");
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function addTutorRec($id,Request $request){
        try{
            if(@$request->all()){
                // $request->validate([
                //     'grade_id'=>'required'
                // ],[
                //     'grade_id.required'=>'Please select grade!Grade is required!'
                // ]);
                // $isExist = TutorRecognision::where(['teacher_id'=>$id,'organization'=>$request->organization])->first();
                // if(!@$isExist){
                    $addTutorRec['teacher_id'] = $id;
                    $addTutorRec['organization'] = @$request->organization;
                    $addTutorRec['recg_title'] = @$request->recg_title;
                    $addTutorRec['year_of_recg'] = @$request->year_of_recg;
                    if(@$request->description){
                        $addTutorRec['description'] = nl2br(@$request->description);
                    }

                    $addTutorRec['status'] = "A";
                    $tutorAcademic = TutorRecognision::create($addTutorRec);
                    session()->flash("success","Recognization information added successfully!");
                    return redirect()->back();
                // }else{
                    // session()->flash("error","Experience information already exist!");
                    // return redirect()->back();
                // }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function editTutorAcademics($id,Request $request){
        try{
            $data['user'] = $user = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['field_studies']=$field_studies = FieldOfStudy::get();
            $data['universities']=$universities = University::get();
            $data['tutoracademics']=$tutoracademics = TutorAcademic::with(['getFieldStudy','getUniversity'])->where(['teacher_id'=>$id])->paginate(10);
            if(@$request->all()){
            }else{
                if(@$user){
                    session(['is_authorized'=>0]);
                    // return view('admin.modules.tutor_management.edit_tutor_academic')->with(['user'=>$user,'universisties'=>$universities,'field_studies'=>$field_studies,'tutoracademics'=>$tutoracademics]);
                    return view('admin.modules.tutor_management.edit_tutor_academic')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function updateTutorExp($tutorExpId,Request $request){

        try{
            $tutorExpDtls = TutorExperience::where(['id'=>$tutorExpId])->first();
            $subjects = Subject::where(['status'=>'A'])->orderBy('subject','asc')->get();
            $get_subject_id = ExpToSubject::where('exp_id',$tutorExpId)->pluck('subject_id')->toArray();
            $id = $tutorExpDtls->teacher_id;
            $user = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $tutorexp = TutorExperience::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            $branches = Branch::where(['status'=>'A'])->get();
            if(@$request->all()){
                // $request->validate([
                //    'grade_id'=>'required'
                // ],[
                //    'grade_id.required'=>'Please select grade!Grade is required!'
                // ]);
                $isExist = TutorExperience::where(['teacher_id'=>$id,'organization'=>$request->organization,'job_title'=>$request->job_title,'year_of_exp'=>$request->year_of_exp,'from_year'=>$request->from_year,'to_year'=>@$request->to_year])->whereNotIn('id',[$tutorExpId])->first();
                if(!@$isExist){
                    if(@$request->to_year < @$request->from_year){
                        session()->flash("error","From year cannot be greater than to year !");
                        return redirect()->back();
                    }
                    $addTutorAcademic['teacher_id'] = $id;
                    $addTutorAcademic['organization'] = $request->organization;
                    $addTutorAcademic['job_title'] = $request->job_title;
                    $addTutorAcademic['year_of_exp'] = $request->year_of_exp;
                    $addTutorAcademic['from_year'] = @$request->from_year;
                    $addTutorAcademic['to_year'] = @$request->to_year;
                    if(@$request->description){
                        $addTutorAcademic['description'] = nl2br($request->description);
                    }
                    TutorExperience::where('id',$tutorExpId)->update($addTutorAcademic);
                    $get_exp_to_sub = ExpToSubject::where('exp_id',$tutorExpId)->get();
                    if(@$request->subject_id){
                        foreach(@$request->subject_id as $subject){
                            $isExistExpToSubject = ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$subject,'teacher_id'=>$id])->first();

                            if(!@$isExistExpToSubject){
                                $crTutprExpSubject['teacher_id'] = $id;
                                $crTutprExpSubject['exp_id'] = $tutorExpId;
                                $crTutprExpSubject['subject_id'] = $subject;
                                $expToSubject = ExpToSubject::create($crTutprExpSubject);

                            }
                        }
                    }
                    if(@$get_exp_to_sub){
                        foreach(@$get_exp_to_sub as $s){
                          if(!in_array($s->subject_id,@$request->subject_id)){
                            $expToSubject = ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$s->subject_id,'teacher_id'=>$id])->first();
                            if(@$expToSubject){
                                ExpToSubject::where(['exp_id'=>$tutorExpId,'subject_id'=>$s->subject_id,'teacher_id'=>$id])->delete();
                            }
                          }
                        }
                    }
                    session()->flash("success","Tutor Experience information updated successfully!");
                    return redirect()->route('edit.tutor.experience',$id);
                }else{
                    session()->flash("error","Tutor Experience information with same combination of organization,job title,from year,to year already exist!");
                    return redirect()->back();
                }
            }else{
                if(@$user){
                    session(['is_authorized'=>0]);
                    $branches = Branch::where(['status'=>'A'])->get();
                    return view('admin.modules.tutor_management.edit_tutor_experience')->with(['user'=>$user,'tutorexp'=>$tutorexp,'tutorExpDtls'=>$tutorExpDtls,'subjects'=>$subjects,'get_subject_id'=>$get_subject_id,'branches'=>@$branches]);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function editTutorExp($id,Request $request){

        try{
            $user = User::where('id',$id)->first();
            $tutorexp = TutorExperience::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            $subjects = Subject::where(['status'=>'A'])->orderBy('subject','asc')->get();
            $s2 = $subjects->sortBy('subject', SORT_NATURAL);
        $s2 = $s2->values()->all();
        $subjects = $s2;
            $get_subject_id = ExpToSubject::where('exp_id',$id)->pluck('subject_id')->toArray();
            $branches = Branch::where(['status'=>'A'])->get();
            if(@$request->all()){
            }else{
                if(@$user){

                    return view('admin.modules.tutor_management.edit_tutor_experience')->with(['user'=>$user,'tutorexp'=>$tutorexp,'subjects'=>$subjects,'get_subject_id'=>$get_subject_id,'branches'=>@$branches]);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function editTutorRec($id,Request $request){
        try{
            $data['user'] = $user = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            // $field_studies = FieldOfStudy::get();
            // $universities = University::get();
            $data['tutorRec']=$tutorRec = TutorRecognision::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            if(@$request->all()){
            }else{
                if(@$user){
                    session(['is_authorized'=>0]);
                    // return view('admin.modules.tutor_management.edit_tutor_recognization')->with(['user'=>$user,'tutorRec'=>$tutorRec]);
                    return view('admin.modules.tutor_management.edit_tutor_recognization')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function updateTutorRec($recId,Request $request){
        try{

            $tutorRecDtls = TutorRecognision::where(['id'=>$recId])->first();
            $id = $tutorRecDtls->teacher_id;
            $user = User::where('id',$id)->first();
            $tutorRec = TutorRecognision::where(['teacher_id'=>$id])->whereNotIn('status',['D'])->paginate(10);
            if(@$request->all()){
                $isExist = TutorRecognision::where(['organization'=>@$request->organization,'recg_title'=>@$request->recg_title,'year_of_recg'=>@$request->year_of_recg,'status'=>'A'])->whereNotIn('id',[$recId])->first();
                if(!@$isExist){
                    $updateTutorRec['organization'] = @$request->organization;
                $updateTutorRec['recg_title'] = @$request->recg_title;
                $updateTutorRec['year_of_recg'] = @$request->year_of_recg;
                if(@$request->description){

                    $updateTutorRec['description'] = nl2br($request->description);
                }
                TutorRecognision::where('id',$recId)->update($updateTutorRec);
                session()->flash("success","Recognization information updated successfully!");
                }else{
                    session()->flash("error","Combinations already exist!");
                }

                return redirect()->route('edit.tutor.rec',$id);
            }else{
                if(@$user){
                    return view('admin.modules.tutor_management.edit_tutor_recognization')->with(['user'=>$user,'tutorRec'=>$tutorRec,'tutorRecDtls'=>$tutorRecDtls]);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteTutorAcademic($id){
        TutorAcademic::where('id',$id)->delete();
        session()->flash("success","Academic information deleted successfully!");
        return redirect()->back();
    }
    public function deleteTutorExp($id){
        TutorExperience::where('id',$id)->delete();
        session()->flash("success","Tutor Experience information deleted successfully!");
        return redirect()->back();
    }
    public function deleteTutorRec($id){
        TutorRecognision::where('id',$id)->update(['status'=>'D']);
        session()->flash("success","Tutor Recognization information deleted successfully!");
        return redirect()->back();
    }
    public function editTutorShipPlans($id,Request $request){
        try{
            $data['user'] = $user =  User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['subjects'] = Subject::where('status','A')->orderBy('subject','asc')->get();
            $data['grades'] = Grade::where(['status'=>'A'])->get();
            $data['branches'] = Branch::where(['status'=>'A'])->get();
            $data['tutorshipplans'] = TutorshipPlan::with(['getGrade','getSubject'])->where(['teacher_id'=>$id,'status'=>'A'])->paginate(10);
            if(@$request->all()){
            }else{
                if(@$user){
                    session(['is_authorized'=>0]);
                    // return view('admin.modules.tutor_management.edit_tutor_tutorship_plans')->with(['user'=>$user,'grades'=>$grades,'subjects'=>$subjects,'tutorshipplans'=>$tutorshipplans,'branches'=>@$branches]);
                    return view('admin.modules.tutor_management.edit_tutor_tutorship_plans')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function updateTutorShipPlans($tutorshipplanid,Request $request){
        try{
            $tutorshipplandtls = TutorshipPlan::where('id',$tutorshipplanid)->first();
            $id = @$tutorshipplandtls->teacher_id;
            $data['user']=$user = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['subjects'] = $subjects = Subject::where('status','A')->orderBy('subject','asc')->get();
            $data['grades'] = $grades =  Grade::where('status','A')->get();
            $tutorshipplans = TutorshipPlan::with(['getGrade','getSubject'])->where(['teacher_id'=>$id,'status'=>'A'])->paginate(10);
            if(@$request->all()){
                if(@$request->subject_id){
                    $plan_data = TutorshipPlan::where(['teacher_id'=>$tutorshipplandtls->teacher_id,'grade_id'=>$tutorshipplandtls->grade_id,'hourly_rate'=>$tutorshipplandtls->hourly_rate,'status'=>'A'])->pluck('subject_id')->toArray();
                    foreach(@$plan_data as $subjectId){
                        $isSubjectDel = in_array($subjectId,@$request->subject_id);
                        if(!$isSubjectDel){
                            $isRowExist = TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subjectId,'status'=>'A'])->first();
                            if(@$isRowExist){
                                TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subjectId])->update(['status'=>'D']);
                                $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                            }else{
                                $crTutorshipPlan['teacher_id'] = $id;
                                $crTutorshipPlan['grade_id'] = $request->grade_id;
                                $crTutorshipPlan['subject_id'] = $subjectId;
                                $crTutorshipPlan['hourly_rate'] = $request->hourly_rate;
                                $crTutorshipPlan['status'] = 'A';
                                $t = TutorshipPlan::create($crTutorshipPlan);
                                $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                                session()->flash("success"," Tutorship plans updated successfully!");
                            }
                        }else{
                            $isRowExist = TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subjectId,'status'=>'A'])->first();
                            if(@$isRowExist){
                                $updTutorshipPlan['grade_id'] = $request->grade_id;
                                $updTutorshipPlan['subject_id'] = $subjectId;
                                $updTutorshipPlan['hourly_rate'] = $request->hourly_rate;
                                TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subjectId,'status'=>'A'])->update($updTutorshipPlan);
                                $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                                session()->flash("success"," Tutorship plans updated successfully!");
                            }else{
                                $updTutorshipPlan['grade_id'] = $request->grade_id;
                                $updTutorshipPlan['teacher_id'] = $id;
                                $updTutorshipPlan['subject_id'] = $subjectId;
                                $updTutorshipPlan['hourly_rate'] = $request->hourly_rate;
                                TutorshipPlan::create($updTutorshipPlan);
                                $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                                session()->flash("success"," Tutorship plans updated successfully!");
                            }

                        }
                    }
                    foreach(@$request->subject_id  as $subject){
                        $isRowExist = TutorshipPlan::where(['teacher_id'=>$id,'grade_id'=>$request->grade_id,'subject_id'=>$subject,'status'=>'A'])->first();

                        if(!@$isRowExist){

                            $crtTutorshipPlan['teacher_id'] = $id;
                            $crtTutorshipPlan['grade_id'] = $request->grade_id;
                            $crtTutorshipPlan['subject_id'] = $subject;
                            $crtTutorshipPlan['hourly_rate'] = $request->hourly_rate;
                            $crtTutorshipPlan['status'] = 'A';
                            $t = TutorshipPlan::create($crtTutorshipPlan);
                            $updateAvg['min_hourly_rate'] = TutorshipPlan::where(['status'=>'A','teacher_id'=>$id])->min('hourly_rate');
                            User::where('id',$id)->update($updateAvg);
                        }
                    }
                }
                return redirect()->route('edit.tutor.tutorship.plans',$id);
            }else{
                if(@$user){
                    $plan_data = TutorshipPlan::where(['teacher_id'=>$tutorshipplandtls->teacher_id,'grade_id'=>$tutorshipplandtls->grade_id,'hourly_rate'=>$tutorshipplandtls->hourly_rate,'status'=>'A'])->pluck('subject_id')->toArray();
                    // dd($plan_data);
                    // return view('admin.modules.tutor_management.edit_tutor_tutorship_plans')->with(['user'=>$user,'grades'=>$grades,'subjects'=>$subjects,'tutorshipplandtls'=>$tutorshipplandtls,'tutorshipplans'=>$tutorshipplans,'plan_data'=>$plan_data]);
                    return view('admin.modules.tutor_management.edit_tutor_tutorship_plans')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }

    public function editTutorPersonalInfo($id,Request $request){
        try{
            $data['user'] = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutor_to_ref']=TutorToRef::where('tutor_id',$id)->first();
            $data['state']=State::orderBy('state_name','asc')->get();
            $data['lan']=Language::orderBy('id')->get();
            $data['tutor_to_lan']=LangToTutor::where('tutor_id',$id)->get();
            $data['total_lan']=LangToTutor::where('tutor_id',$id)->count();
            $data['states'] = State::orderBy('state_name','asc')->get();
            $data['timezonesLists']=TimezoneLists::orderBy('time_zone_name','asc')->get();
            if(@$request->all()){
                if(@$request->email){
                    $isExistEmail = User::where(['email'=>@$request->email])->whereNotIn('id',[$id])->whereIn('status',['A','I','AA','U'])->first();
                    if(@$isExistEmail){
                        session()->flash("error","Email-id already exist!");
                        return redirect()->back();
                    }
                }
                if(@$request->phone){
                    $isExistPhone = User::where(['phone'=>@$request->phone])->whereNotIn('id',[$id])->whereIn('status',['A','I','AA','U'])->first();
                    if(@$isExistPhone){
                        session()->flash("error","Phone no already exist!");
                        return redirect()->back();
                    }
                }


                // $updateTutor['f_name'] = @$request->f_name;
                // $updateTutor['l_name'] = @$request->l_name;
                if(@$request->email){
                    $updateTutor['email'] = @$request->email;
                }
                if(@$request->phone){
                    $updateTutor['phone'] = @$request->phone;
                }
                if(@$request->teacher_emp_status){
                    $updateTutor['teacher_emp_status'] = @$request->teacher_emp_status;
                }
                if(@$request->hours){
                    $updateTutor['hours'] = @$request->hours;
                }
                if(@$request->why_tutor){
                    $updateTutor['why_tutor'] = @$request->why_tutor;
                }
                if(@$request->work_with_child){
                    $updateTutor['work_with_child'] = @$request->work_with_child;
                }
                if(@$request->wwc_number){
                    $updateTutor['wwc_number'] = @$request->wwc_number;
                }
                if(@$request->criminal_case){
                    $updateTutor['criminal_case'] = @$request->criminal_case;
                }

                if(@$request->criminal_case == 'Y'){
                    $updateTutor['criminal_details'] = @$request->criminal_details;
                }else{
                    $updateTutor['criminal_details'] = NULL;
                }
                if(@$request->about_me){
                    $updateTutor['about_me'] = @$request->about_me;
                }

                if(@$request->img){
                    $image = $request->img;
                    $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
                    $image->move('storage/teacher_profile_pic/', $filename);
                    $updateTutor['profile_pic'] = $filename;
                }

                $youtubesplit = explode("=",@$request->profile_video);
                if(@$request->address){
                    $updateTutor['address'] = @$request->address;
                }
                if(@$youtubesplit[1]){
                    $updateTutor['video_short_url'] = @$youtubesplit[1];
                }
                if(@$request->profile_video){
                    $updateTutor['profile_video'] = @$request->profile_video;
                }

                User::where('id',$id)->update($updateTutor);
                if(@$request->img){
                if(@$data['user']->profile_pic){
                    $image_path = 'storage/teacher_profile_pic/'.@$data['user']->profile_pic;
                    if(file_exists(@$image_path)){
                       unlink(@$image_path);
                    }
                }
                }
                $l = LangToTutor::where(['tutor_id'=>$id])->pluck('language_id')->toArray();
                $tl = $request->language;
                $archk = array_diff($l,$tl);
                foreach($archk as $aa){
                    LangToTutor::where(['tutor_id'=>$id,'language_id'=>$aa])->delete();
                }
                if($request->language){
                    //Insert language data
                    foreach($request->language as $val){
                        $isCheckL =LangToTutor::where(['tutor_id'=>$id,'language_id'=>$val])->first();
                        if(!@$isCheckL){
                            $nL['tutor_id'] = $id;
                            $nL['language_id'] = $val;
                            $nnn = LangToTutor::create($nL);
                        }

                    }
                }

                // $isTutorToRef = TutorToRef::where(['tutor_id'=>$id])->first();
                // if(@$isTutorToRef){
                //     $updTutorToRef['ref_1_f_name'] = @$request->ref_1_f_name;
                //     $updTutorToRef['ref_1_l_name'] = @$request->ref_1_l_name;
                //     $updTutorToRef['ref_1_email'] = @$request->ref_1_email;
                //     $updTutorToRef['ref_1_phone'] = @$request->ref_1_phone;
                //     $updTutorToRef['ref_1_relation'] = @$request->ref_1_relation;
                //     // $updTutorToRef['ref_2_name'] = @$request->ref_2_name;
                //     $updTutorToRef['ref_2_f_name'] = @$request->ref_2_f_name;
                //     $updTutorToRef['ref_2_l_name'] = @$request->ref_2_l_name;
                //     $updTutorToRef['ref_2_email'] = @$request->ref_2_email;
                //     $updTutorToRef['ref_2_phone'] = @$request->ref_2_phone;
                //     $updTutorToRef['ref_2_relation'] = @$request->ref_2_relation;
                //     TutorToRef::where(['tutor_id'=>$id])->update($updTutorToRef);
                // }else{
                //     $updTutorToRef['tutor_id'] = $id;
                //     $updTutorToRef['ref_1_f_name'] = @$request->ref_1_f_name;
                //     $updTutorToRef['ref_1_l_name'] = @$request->ref_1_l_name;
                //     $updTutorToRef['ref_1_email'] = @$request->ref_1_email;
                //     $updTutorToRef['ref_1_phone'] = @$request->ref_1_phone;
                //     $updTutorToRef['ref_1_relation'] = @$request->ref_1_relation;
                //     // $updTutorToRef['ref_2_name'] = @$request->ref_2_name;
                //     $updTutorToRef['ref_2_f_name'] = @$request->ref_2_f_name;
                //     $updTutorToRef['ref_2_l_name'] = @$request->ref_2_l_name;
                //     $updTutorToRef['ref_2_email'] = @$request->ref_2_email;
                //     $updTutorToRef['ref_2_phone'] = @$request->ref_2_phone;
                //     $updTutorToRef['ref_2_relation'] = @$request->ref_2_relation;
                //     $tutorCrt = TutorToRef::create($updTutorToRef);
                // }
                $data['user'] = User::where('id',$id)->first();
                session()->flash("success","Tutor personal information updated successfully! ");
                return redirect()->back();
            }else{
                if(@$data['user']){
                    return view('admin.modules.tutor_management.edit_tutor_personal_info')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function editTutorAdvancePage($id,Request $request){
        try{
            $data['user'] = $user   = User::where('id',$id)->first();
            $data['next_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','>',$id)->min('id');
            $data['previous_id'] = User::whereIn('status',['I','A','U','AA'])->where('id','<',$id)->max('id');
            $data['tutor_to_ref']=TutorToRef::where('tutor_id',$id)->first();
            $data['state']=State::orderBy('state_name','asc')->get();
            $data['lan']=Language::orderBy('id')->get();
            $data['tutor_to_lan']=LangToTutor::where('tutor_id',$id)->get();
            $data['total_lan']=LangToTutor::where('tutor_id',$id)->count();
            $data['states'] = State::orderBy('state_name','asc')->get();
            $data['timezonesLists']=TimezoneLists::orderBy('time_zone_name','asc')->get();
            $data['nationalities']=Nationality::orderBy('name','asc')->get();

            if(@$request->all()){

                if(@$request->id_proof){
                    $unlnk=User::where('id',auth()->user()->id)->first();
                    @$prev_img = $unlnk->id_proof;
                    if(@$prev_img){
                        @unlink('storage/id_proof/'.$prev_img);
                    }
                    //this is for upload
                    $image = $request->id_proof;
                    $profile = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move("storage/id_proof",$profile);
                    $user_pic_update=User::where('id',$user->id)->update(['id_proof'=>encrypt($profile)]);
                }
                if(@$request->residence_proof){
                    $unlnk=User::where('id',$user->id)->first();
                    @$prev_img = $unlnk->residence_proof;
                    if(@$prev_img){
                        @unlink('storage/residence_proof/'.$prev_img);
                    }
                    //this is for upload
                    $image = $request->residence_proof;
                    $profile = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move("storage/residence_proof",$profile);
                    $user_pic_update=User::where('id',$user->id)->update(['residence_proof'=>encrypt($profile)]);


                }
                $curentUser = User::where(['id'=>$user->id])->first();
                if(@$curentUser){
                    if(@$curentUser->residence_proof && @$curentUser->id_proof){
                        $updPoints['document_score'] = 100;
                        User::where(['id'=>$user->id])->update($updPoints);
                    }
                    if(@$curentUser->residence_proof && !@$curentUser->id_proof){
                        $updPoints['document_score'] = 40;
                        User::where(['id'=>$user->id])->update($updPoints);
                    }
                    if(!@$curentUser->residence_proof && @$curentUser->id_proof){
                        $updPoints['document_score'] = 60;
                        User::where(['id'=>$user->id])->update($updPoints);
                    }


                }

                $upd['nationality_id'] = @$request->nationality_id;
        $upd['visa_type'] = @$request->visa_type;
        if(@$request->id_proof_type){
            $upd['id_proof_type'] = @$request->id_proof_type;
        }

        $upd['residence_id_proof_type'] = @$request->residence_id_proof_type;
        if(@$request->visa_expiry){
            $upd['visa_expiry'] = $request->visa_expiry;
        }

                // $upd['bank_name'] = @$request->bank_name;
                // $upd['bsb_code'] = @$request->bsb_code;
                // $upd['account_no'] = @$request->account_no;
                $upd['other_visa_type'] = @$request->other_visa_type;

                if(@$request->visa_expiry){
                    $upd['visa_expiry'] = @$request->visa_expiry;
                }else{
                    $upd['visa_expiry'] = NULL;
                }

                if(@$request->country){
                    $upd['country'] = @$request->country;
                }
                if(@$request->city){
                    $upd['city'] = @$request->city;
                }
                if(@$request->state){
                    $upd['state'] = @$request->state;
                }
                if(@$request->zip){
                    $upd['zip'] = @$request->zip;
                }
                if(@$request->address){
                    $upd['address'] = @$request->address;
                }
                if(@$request->phone){
                    $upd['phone'] = @$request->phone;
                }
                if(@$request->timezone_id){
                    $upd['timezone_id'] = @$request->timezone_id;
                }

                // $upd['bank_name'] = @$request->bank_name;
                // $upd['account_no'] = @$request->account_no;
                // $upd['account_name'] = @$request->account_name;

                // $upd['bsb_code'] = @$request->bsb_code;
                User::where(['id'=>$user->id])->update($upd);

                $data['user'] = User::where('id',$id)->first();
                session()->flash("success","Tutor advance page updated successfully! ");
                return redirect()->back();
            }else{
                if(@$data['user']){
                    return view('admin.modules.tutor_management.edit_advance_page')->with($data);
                }else{
                    session()->flash("error","Tutor is not found associated with id : ".$id);
                    return redirect()->back();
                }
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function changeStatus($id,Request $request){
        try{
            $user = User::where('id',$id)->first();
            if(@$user){
                if($user->status == 'AA'){
                  $updateStatus['status'] = 'A';
                  $status = "active";
                  User::where('id',$id)->update($updateStatus);
                  $this->sendAdminApproveMail($id,'approve');
                }elseif($user->status == 'A'){
                    $updateStatus['status'] = 'I';
                    $status = "inctive";
                    User::where('id',$id)->update($updateStatus);
                }elseif($user->status == 'I'){
                    $updateStatus['status'] = 'A';
                    $status = "active";
                    User::where('id',$id)->update($updateStatus);
                    $this->sendAdminApproveMail($id,'unblock');
                }elseif($user->status == 'U'){
                    if(@$user->user_type == 'T'){
                        $updateStatus['status'] = 'AA';
                        $status = "awaiting approval";
                    }else{
                        $updateStatus['status'] = 'A';
                        $status = "active";
                    }


                    User::where('id',$id)->update($updateStatus);
                    $this->sendAdminApproveMail($id,'verified');
                }
                session()->flash("success",$user->f_name." ".$user->l_name."'s status is ".$status);
                return redirect()->back();
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function deleteTutor($id,Request $request){
        try{
            $user = User::where('id',$id)->first();
            if(@$user){
                $updateStatus['status'] = 'D';
                $status = "Deleted";
                User::where('id',$id)->update($updateStatus);
                session()->flash("success","Tutor deleted successfully!");
                return redirect()->back();
            }else{
                session()->flash("error","Tutor is not found associated with id : ".$id);
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function getTutorManagementList(Request $request)
{
    $data['students'] = User::where(['user_type' => 'T'])
        ->whereNotIn('status', ['D']);

    // FILTER 1: Name / Email / Phone
    if ($request->col1_filter) {
        $data['students'] = $data['students']->where(function($query) use ($request) {
            $query->where('f_name', 'like', '%' . $request->col1_filter . '%')
                ->orWhere('l_name', 'like', '%' . $request->col1_filter . '%')
                ->orWhere('email', 'like', '%' . $request->col1_filter . '%')
                ->orWhere(DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->col1_filter . '%')
                ->orWhere('phone', 'like', '%' . $request->col1_filter . '%');
        });
    }

    // FILTER 2: Status
    if ($request->col2_filter) {
        $data['students'] = $data['students']->where('status', $request->col2_filter);
    }

    // FILTER 3: From Date
    if ($request->col3_filter) {
        $from = $request->col3_filter . " 00:00:00";
        $to = $request->col3_filter . " 23:59:59";
        $data['students'] = $data['students']->whereBetween('created_at', [$from, $to]);
    }

    // FILTER 4: To Date
    if ($request->col4_filter) {
        $from = $request->col4_filter . " 00:00:00";
        $to = $request->col4_filter . " 23:59:59";
        $data['students'] = $data['students']->whereBetween('created_at', [$from, $to]);
    }

    // 🔥 FILTER 5: Availability (Yes / No)
    // Your Blade uses col7_filter for Availability
    if ($request->col5_filter == 'Y') {
        $data['students'] = $data['students']->whereHas('getMyAvailability', function ($q) {
            $q->where('status', 'A');
        });
    }
    if ($request->col5_filter == 'N') {
        $data['students'] = $data['students']->whereDoesntHave('getMyAvailability', function ($q) {
            $q->where('status', 'A');
        });
    }
if ($request->featured_filter !== null && $request->featured_filter !== '') {
    $data['students'] = $data['students']->where('featured', $request->featured_filter);
}

// FILTER: Free Trail
if ($request->free_trial_filter !== null && $request->free_trial_filter !== '') {
    $data['students'] = $data['students']->where('free_trial', $request->free_trial_filter);
}
    // GET DATA
    $data['students'] = $data['students']->orderBy('id', 'desc')->get();

    // EXPORT BUILD
    $t = '';
    $t .= '<table>
            <tr>
                <th style="border:1px solid black;background-color:lime">Name</th>
                <th style="border:1px solid black;background-color:lime">Email</th>
                <th style="border:1px solid black;background-color:lime">Phone</th>
                <th style="border:1px solid black;background-color:lime">Date Joined</th>
                <th style="border:1px solid black;background-color:lime">Availability</th>
                <th style="border:1px solid black;background-color:lime">Status</th>
                 <th style="border:1px solid black;background-color:lime">Featured</th>
            <th style="border:1px solid black;background-color:lime">Free Trial</th>
            </tr>';

    foreach ($data['students'] as $value) {

        // 🔥 Correct availability
        $availability = $value->getMyAvailability()->where('status', 'A')->exists()
            ? 'Yes'
            : 'No';

        // Status text
        if ($value->status == "U") $status = "Unverified";
        elseif ($value->status == "A") $status = "Active";
        elseif ($value->status == "I") $status = "Inactive";
        else $status = "";

        $t .= '
        <tr>
            <td style="border:1px solid black;">' . $value->f_name . ' ' . $value->l_name . '</td>
            <td style="border:1px solid black;">' . $value->email . '</td>
            <td style="border:1px solid black;">' . $value->phone . '</td>
            <td style="border:1px solid black;">' . $value->created_at . '</td>

            <!-- FIXED: Availability column -->
            <td style="border:1px solid black;">' . $availability . '</td>

            <td style="border:1px solid black;">' . $status . '</td>
               <td style="border:1px solid black;">' . ($value->featured ? 'Yes' : 'No') . '</td>

    <!-- NEW: FREE TRIAL -->
    <td style="border:1px solid black;">' . ($value->free_trial ? 'Yes' : 'No') . '</td>
        </tr>';
    }

    $t .= '</table>';

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=TutorManagement.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo $t;
}
}