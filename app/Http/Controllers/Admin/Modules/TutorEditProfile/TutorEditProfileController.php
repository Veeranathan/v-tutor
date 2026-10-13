<?php

namespace App\Http\Controllers\Admin\Modules\TutorEditProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorEditProfileController extends Controller
{
    public function tutorshipManagement(Request $request){
        try
        {
            $columnIndex = $request->order[0]['column'];
            $columnSortOrder = $request->order[0]['dir'];
            $users = TutorShipPlan::whereNotIn('status',['D']);
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
            if($columnIndex == 3) {
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
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            
        }
    }
}
