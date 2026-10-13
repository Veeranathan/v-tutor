<?php

namespace App\Http\Controllers\Admin\Modules\ModifyCommission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;

class ModifyCommissionController extends Controller
{
    //
    public function updateModifyCommission($id,Request $request){
        $tutorId = $id;
        $tutor = User::where(['id'=>$id])->first();
        if(@$tutor){
            $request->validate([
                'commission_percentage'=>'required|min:0|max:100'
            ]);
            User::where(['id'=>$id])->update(['commission_percentage'=>$request->commission_percentage]);
            session()->flash("success",$tutor->unique_id."'s commission percentage ".$request->commission_percentage."% updated successfully!");
        }else{
            session()->flash("success","No tutor found associated with this id!");
        }
        return redirect()->back();   
    }
}
