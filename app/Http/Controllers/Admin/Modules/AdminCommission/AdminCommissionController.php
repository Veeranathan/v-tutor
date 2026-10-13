<?php

namespace App\Http\Controllers\Admin\Modules\AdminCommission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissions;

class AdminCommissionController extends Controller
{
    /*
    * Method        :adminUpdateCommission
    * Description   :This method is used to update commission
    * Author        : Jayatri
    */
    public function adminUpdateCommission(Request $request){
        $data['admin_commission_management'] = Commissions::first();
        // dd($data);
        if(@$request->all()){
            $upd['commission'] = $request->commission;
            Commissions::where('id',$data['admin_commission_management']->id)->update($upd);
            session()->flash("success","Commission Updated. It will be reflected on future payments");
            $data['admin_commission_management'] = Commissions::first();
            return redirect()->back();
        }
        return view('admin.modules.admin_commission_managament.admin_commission_managament',$data);
    }
}
