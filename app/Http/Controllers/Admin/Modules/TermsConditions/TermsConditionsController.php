<?php

namespace App\Http\Controllers\Admin\Modules\TermsConditions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentDetails;

class TermsConditionsController extends Controller
{
    //
    public function termsConditions(Request $request){
        $data['contentDetails'] = ContentDetails::where(['type'=>'T'])->first();
        if(@$request->all()){
            $upd['title'] = @$request->title;
            $upd['description'] = @$request->description;
            ContentDetails::where(['type'=>'T'])->update($upd);
            session()->flash("success","Terms and conditions updated!");
            return redirect()->back();
        }
        return view('admin.modules.terms_and_conditions.terms_and_conditions')->with($data);
    }
}
