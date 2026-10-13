<?php

namespace App\Http\Controllers\Admin\Modules\FollowUsDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FollowUsDetails;

class FollowUsDetailsController extends Controller
{
    //
    public function updateFollowUsDetails(Request $request){
        $data['contentDetails'] = FollowUsDetails::first();
        if(@$request->all()){
            $upd['email'] = @$request->email;
            $upd['facebook_link'] = @$request->facebook_link;
            $upd['twitter_link'] = @$request->twitter_link;
            $upd['instagram_link'] = @$request->instagram_link;
            $upd['youtube_link'] = @$request->youtube_link;
            $upd['p_interest_link'] = @$request->p_interest_link;
            FollowUsDetails::where('id','!=',0)->update($upd);
            session()->flash("success","Follow us updated successfully!");
            return redirect()->back();
        }
        return view('admin.modules.follow_us_details.follow_us_details')->with($data);
    }
}
