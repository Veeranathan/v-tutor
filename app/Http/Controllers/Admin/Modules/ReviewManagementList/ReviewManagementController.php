<?php

namespace App\Http\Controllers\Admin\Modules\ReviewManagementList;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReviewModel;
use App\Models\User;
use DB;

class ReviewManagementController extends Controller
{
    //
    public function index(Request $request){
        return view('admin.modules.review_list.review_list');
    }
    public function getAjaxReviewManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $reviews = ReviewModel::with(['tutor','student'])->whereNotIn('id',[0]);
        $ps =  $reviews->count();
        $pp = $reviews;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $reviews = $reviews;
        $p =  $p->count();
        if(@$request->columns['1']['search']['value']){
            $reviews = $reviews->whereHas('tutor',function($query) use($request) {
                $query->Where('f_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('l_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('unique_id','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('email','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                ->orWhere('phone','like','%'.$request->columns['1']['search']['value'].'%');
            })->orwhereHas('student',function($query) use($request) {
                $query->Where('f_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('l_name','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('unique_id','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere('email','like','%'.$request->columns['1']['search']['value'].'%')
                ->orWhere(\DB::raw("CONCAT(`f_name`, ' ', `l_name`)"), 'like', '%' . $request->columns['1']['search']['value'] . '%')
                ->orWhere('phone','like','%'.$request->columns['1']['search']['value'].'%');
            });
        }
        if(@$request->columns['2']['search']['value']){
            $reviews = $reviews->where(function($query) use($request) {
                $query->Where('ratting',$request->columns['2']['search']['value']);
            });
        }
        if(@$request->columns['3']['search']['value']){
            $reviews = $reviews->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if(@$request->columns['4']['search']['value']){
            $reviews = $reviews->where(function($query) use($request) {
                $query->whereBetween('created_at',[@$request->columns['3']['search']['value']." 00:00:00", @$request->columns['4']['search']['value']." 23:59:59"]);
            });
        }
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('id','asc');
            } else {
                $reviews = $reviews->orderBy('id','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('id','asc');
            } else {
                $reviews = $reviews->orderBy('id','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('created_at','asc');
            } else {
                $reviews = $reviews->orderBy('created_at','desc');
            }
        }
        if($columnIndex == 3) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('ratting','asc');
            } else {
                $reviews = $reviews->orderBy('ratting','desc');
            }
        }
        if($columnIndex == 4) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('id','asc');
            } else {
                $reviews = $reviews->orderBy('id','desc');
            }
        }
        if($columnIndex == 5) {
            if($columnSortOrder == 'asc') {
                $reviews = $reviews->orderBy('message','asc');
            } else {
                $reviews = $reviews->orderBy('message','desc');
            }
        }
        $reviews = $reviews->orderBy('id','desc')->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $reviews;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
}
