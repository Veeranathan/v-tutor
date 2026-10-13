<?php

namespace App\Http\Controllers\Admin\Modules\AdminDisableBookingDates;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminDisableBookingDates;
use App\Models\AdminDisableBookings;

class AdminDisableBookingDatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    
    public function adminDisableDatesManagement(Request $request){
        $columnIndex = $request->order[0]['column'];
        $columnSortOrder = $request->order[0]['dir'];
        $adminDisableBookingDates = AdminDisableBookingDates::whereIn('status',['I','A']);
        if(@$request->columns['1']['search']['value'] && @$request->columns['2']['search']['value']){
            $adminDisableBookingDates = $adminDisableBookingDates->where(function($query) use($request) {
                $query->whereBetween('disable_booking_date',[$request->columns['1']['search']['value'],$request->columns['2']['search']['value']]);
            });
        }
        $ps =  $adminDisableBookingDates->count();
        $pp = $adminDisableBookingDates;
        $pp = $pp->count();
        $limit = $request->length;
        $p = $adminDisableBookingDates = $adminDisableBookingDates;
        $p =  $p->count();
        if($columnIndex == 0) {
            if($columnSortOrder == 'asc') {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('disable_booking_date','asc');
            } else {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('disable_booking_date','desc');
            }
        }
        if($columnIndex == 1) {
            if($columnSortOrder == 'asc') {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('status','asc');
            } else {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('status','desc');
            }
        }
        if($columnIndex == 2) {
            if($columnSortOrder == 'asc') {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('id','asc');
            } else {
                $adminDisableBookingDates = $adminDisableBookingDates->orderBy('id','desc');
            }
        }
        $adminDisableBookingDates = $adminDisableBookingDates->skip($request->start)->take($request->length)->get();
        $data['aaData'] = $adminDisableBookingDates;
        $data["draw"] = intval($request->draw);
        $data['iTotalRecords'] = $ps;
        $data["iTotalDisplayRecords"] = $pp;
        return response()->json($data);
    }
    /*
    * Method        : index
    * Description   : This method is used to manage admin disable booking dates!
    * Author        : Jayatri
    */ 

    public function index(Request $request){
        try{
            
            $data['key'] = @$request->all();
            return view('admin.modules.admin_manage_disable_booking_dates.list_admin_manage_disable_booking_dates')->with($data);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function ediAdminDisableBookingDates($id,Request $request){
        try{
            $data['admin_disable_booking_settings'] = AdminDisableBookings::first();
            $data['gt_admin_disablse_booking_dates'] = AdminDisableBookingDates::where('id',$id)->first();

            if(@$request->all()){
                $request->validate(['disable_booking_date' => 'required']);
                $adminDisableBookingDates = AdminDisableBookingDates::where('disable_booking_date',@$request->disable_booking_date)->whereNotIn('id',[$id])->first();

                if(!@$adminDisableBookingDates){
                    $addDisable_booking['disable_booking_date'] = @$request->disable_booking_date;
                    $addDisable_booking = AdminDisableBookingDates::where('id',$id)->update($addDisable_booking);
                    session()->flash("success","You have successfully updated a date to lock booking dates list!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Date is already exists in lock Booking dates list!");
                    return redirect()->back();
                }    
            }else{
                return view('admin.modules.admin_manage_disable_booking_dates.edit_admin_manage_disable_booking_dates')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    /*
    * Method        : addAdminDisableBookingDates
    * Description   : This method is used to add disable booking on this date!
    * Author        : Jayatri
    */
    public function addAdminDisableBookingDates(Request $request){
        try{
            $data['admin_disable_booking_settings'] = AdminDisableBookings::first();
            // dd($data);
            if(@$request->all()){
                $request->validate(['disable_booking_date' => 'required']);
                $adminDisableBookingDates = AdminDisableBookingDates::where('disable_booking_date',@$request->disable_booking_date)->first();

                if(!@$adminDisableBookingDates){
                    $addDisable_booking['disable_booking_date'] = @$request->disable_booking_date;
                    $addDisable_booking['status'] = 'A';
                    $addDisable_booking = AdminDisableBookingDates::create($addDisable_booking);
                    session()->flash("success","You have successfully added a date!");
                    return redirect()->back();
                }else{
                    session()->flash("success","Date is already exists in lock Booking dates list!");
                    return redirect()->back();
                }
                
            }else{
                return view('admin.modules.admin_manage_disable_booking_dates.add_admin_manage_disable_booking_dates')->with($data);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            return redirect()->back();
        }
    }
    public function ajaxDuplicateDateCheck(Request $request){
        try{
            
            $disable_booking_date = trim($request->disable_booking_date);
            $id = @$request->id;
            $list_disable_booking_date = AdminDisableBookingDates::where('disable_booking_date',@$request->disable_booking_date)->whereNotIn('id',[$id])->whereIn('status',['I','A'])->first();    

            if(@$list_disable_booking_date){
                return 'false';
            }else{
                return 'true';
            }

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return 'false';
        }
    }
    public function ajaxDeleteDisableBookingDates(Request $request){
        try{
            $id = @$request->data['id'];
            $adminDisable_booking = AdminDisableBookingDates::where('id',$id)->first();
            if(@$adminDisable_booking){
                AdminDisableBookingDates::where('id',$id)->delete();
                $data['status'] = 1;
                $data['message'] = "You have successfully deleted the date from list!";
                return response()->json($data,200);
            }else{
                $data['status'] = 0;
                $data['message'] = "This date is not deleted or already deleted!";
                return response()->json($data,200);
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            session()->flash("error",$e->getMessage());
            $data['status'] = 0;
            $data['message'] = $e->getMessage();
            return response()->json($data,200);
        }
    }
    
    
}
