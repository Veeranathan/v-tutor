<?php

namespace App\Http\Controllers\Admin\Modules\AdminDisableBookingSettings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminDisableBookings;

class AdminDisableBookingsSettingsController extends Controller
{
    /*
    * Method        :adminDisableBookingsSettings
    * Description   :This method is used to disable booked (Block Booking >> Block Booking / Block Booking on this date / None)
    * Author        : Jayatri
    * Date          : 28-10-2021
    */
    public function adminDisableBookingsSettings(Request $request){
        $data['admin_disable_booking_settings'] = AdminDisableBookings::first();
        if(@$request->all()){
            $upd['disable_booking'] = $request->disable_booking;
            AdminDisableBookings::where('id',$data['admin_disable_booking_settings']->id)->update($upd);
            if(@$request->disable_booking == 'Y'){
                session()->flash("success","All bookings blocked on site!");
            }else{
                session()->flash("success","All bookings allowed on site!");
            }
            $data['admin_disable_booking_settings'] = AdminDisableBookings::first();
            return redirect()->back();
        }
        return view('admin.modules.admin_disable_bookings_settings.admin_disable_bookings_settings',$data);
    }
}
