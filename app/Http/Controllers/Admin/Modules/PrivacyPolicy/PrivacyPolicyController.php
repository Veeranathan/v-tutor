<?php

namespace App\Http\Controllers\Admin\Modules\PrivacyPolicy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentDetails;

class PrivacyPolicyController extends Controller
{
    //
    public function privacyPolicy(Request $request){
        $data['contentDetails'] = ContentDetails::where(['type'=>'P'])->first();
        if(@$request->all()){
            $upd['title'] = @$request->title;
            $upd['description'] = @$request->description;
            ContentDetails::where(['type'=>'P'])->update($upd);
            session()->flash("success","Privacy policy updated!");
            return redirect()->back();
        }
        return view('admin.modules.privacy_policy.privacy_policy')->with($data);
    }
}
