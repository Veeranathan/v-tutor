<?php

namespace App\Http\Controllers\Admin\Modules\TutorPaymentList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TutorPayment;
use App\Models\User;
use App\Models\Commissions;
use App\Models\StudentClassBooking;

class TutorPaymentListController extends Controller
{
    public function __construct()
{
    $this->middleware('admin.auth:admin')->except('tutorManagement');
}


    public function index()
    {
        $data['admin_commission_management'] = Commissions::first();
        return view('admin.modules.tutor_payment_list.tutor_payment_list', $data);
    }

  public function tutorManagement(Request $request)
{
    $search = $request->columns[1]['search']['value'] ?? null;

    $tutors = User::where('user_type', 'T')
        ->whereNotIn('status', ['D', 'U'])
        ->with(['tutorPayments.Booking'])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q2) use ($search) {
                $q2->where('f_name', 'like', "%$search%")
                   ->orWhere('l_name', 'like', "%$search%")
                   ->orWhere('unique_id', 'like', "%$search%")
                   ->orWhere(\DB::raw("CONCAT(f_name,' ',l_name)"), 'like', "%$search%");
            });
        })
        ->orderBy('id', 'DESC')
        ->get();

    $data = [];

    foreach ($tutors as $tutor) {

        $gross = 0;
        $commission = 0;

        foreach ($tutor->tutorPayments as $p) {

            $booked     = ($p->booking_status == 1);
            $cancelled  = ($p->booking_status == 2);
            $paid       = ($p->payment_status == 1);
            $notPaid    = ($p->payment_status == 0);
            $cancelledBy = $p->getBookingsInfo->cancelled_by ?? null;

            // ✅ Booking logic
            if ($booked) {
                $gross += $p->tutor_amount;
                $commission += $p->commission_amount;
            }
            elseif ($cancelled && $notPaid) {
                // Do nothing (ignore)
            }
            elseif ($cancelled && $paid && $cancelledBy == "T") {
                // Tutor cancelled → deduct money back
                $gross -= $p->tutor_amount;
                $commission -= $p->commission_amount;
            }
            elseif ($cancelled && $paid && $cancelledBy != "T") {
                // Student cancelled after payment → admin keeps commission, tutor keeps?
                $gross += $p->tutor_amount;
                $commission += $p->commission_amount;
            }
        }

        // ✅ Skip tutors with zero revenue
        if ($gross == 0 && $commission == 0) {
            continue;
        }

        $data[] = [
            'unique_id'        => $tutor->unique_id,
            'tutor_name'       => $tutor->f_name . ' ' . $tutor->l_name,
            'gross_revenue'    => number_format($gross, 2),
            'commission'       => number_format($commission, 2),
            'net_revenue'      => number_format($gross + $commission, 2),
            'total_paid_out'   => '',
            'remaining_payout' => '',
        ];
    }

   return response()->json([
    'draw' => intval($request->draw),
    'recordsTotal' => count($data),
    'recordsFiltered' => count($data),
    'data' => $data  // 🔥 change here
]);
}

}
