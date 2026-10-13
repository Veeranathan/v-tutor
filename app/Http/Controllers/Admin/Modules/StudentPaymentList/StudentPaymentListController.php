<?php

namespace App\Http\Controllers\Admin\Modules\StudentPaymentList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\State;
use App\Models\School;
use App\Models\TimezoneLists;
use Mail;
use App\Mail\AdminApproveMail;
use App\Mail\DeleteAccountMail;
use App\Mail\AdminCloseAccountMail;

class StudentPaymentListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function index(){
        return view('admin.modules.student_payment_list.student_payment_list');   
    }
    public function studentManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $users = User::with(['getStudentTotOnlineHours','getStudentTotPaid'])->withCount(['getStudentTotCount'])->where(['user_type'=>'U'])->whereNotIn('status',['U','D'])->has('getStudentTotCount','>',0);
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
        if(@$request->columns['2']['search']['value']){
            $users = $users->where(function($query) use($request) {
                $query->Where('status',$request->columns['2']['search']['value']);
            });
        }
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
        // if(@$request->columns['5']['search']['value'] != 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->Where('platform_type',$request->columns['5']['search']['value']);
        //     });
        // }
        // if(@$request->columns['5']['search']['value'] == 'N'){
        //     $users = $users->where(function($query) use($request) {
        //         $query->WhereIn('platform_type',['google','facebook',NULL,'',null]);
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
                $users = $users->orderBy('get_student_tot_count_count','asc');
            } else {
                $users = $users->orderBy('get_student_tot_count_count','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('get_student_tot_count_count','asc');
            } else {
                $users = $users->orderBy('get_student_tot_count_count','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $users = $users->orderBy('get_student_tot_count_count','asc');
            } else {
                $users = $users->orderBy('get_student_tot_count_count','desc');
            }
        }
        // if($columnIndex == 4) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('created_at','asc');
        //     } else {
        //         $users = $users->orderBy('created_at','desc');
        //     }
        // }
        // if($columnIndex == 5) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('status','asc');
        //     } else {
        //         $users = $users->orderBy('status','desc');
        //     }
        // }
        // if($columnIndex == 6) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('platform_type','asc');
        //     } else {
        //         $users = $users->orderBy('platform_type','desc');
        //     }
        // }
        // if($columnIndex == 7) {
        //     if($columnSortOrder == 'asc') {
        //         $users = $users->orderBy('id','asc');
        //     } else {
        //         $users = $users->orderBy('id','desc');
        //     }
        // }
        // if($columnIndex == 8) {
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
}
