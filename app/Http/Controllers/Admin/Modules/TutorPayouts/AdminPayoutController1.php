<?php

namespace App\Http\Controllers\Admin\Modules\TutorPayouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TutorPayment;
use App\Models\StudentClassBooking;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminPayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    // ========= Helpers =========

    /**
     * Returns a base query for payable tutor_payment rows in a date window.
     * - Date column: COALESCE(tutor_payment.booking_date, tutor_payment.created_at)
     * - Only completed classes based on student_class_bookings.booking_status = 'CM'
     * - Excludes already settled: payment_status != 3
     */
    protected function payableBaseQuery(string $from, string $to)
    {
        $fromTs = $from . ' 00:00:00';
        $toTs   = $to   . ' 23:59:59';

        return TutorPayment::query()
            ->from('tutor_payment as tp')
            ->join('student_class_bookings as scb', 'scb.id', '=', 'tp.booking_id')
            ->join('users as u', 'u.id', '=', 'tp.tutor_id')
            ->whereBetween(DB::raw('COALESCE(tp.booking_date, tp.created_at)'), [$fromTs, $toTs])
            ->whereIn('scb.booking_status', ['CM','B'])     // completed
            ->where('tp.payment_status', '!=', 3);  // not settled
    }

    /**
     * Build summary per tutor in range (not settled).
     */
    protected function rangeSummary(string $from, string $to)
    {
        $q = $this->payableBaseQuery($from, $to);

        return $q->selectRaw("
                tp.tutor_id,
                u.unique_id,
                u.f_name,
                u.l_name,
                SUM(tp.tutor_amount + tp.commission_amount) as gross_pay,
                SUM(tp.commission_amount)                   as commission,
                0.00                                        as deductions,
                SUM(tp.tutor_amount)                        as net_pay
            ")
            ->groupBy('tp.tutor_id', 'u.unique_id', 'u.f_name', 'u.l_name')
            ->orderBy('u.f_name')
            ->get();
    }

    // ========= Pages =========

    public function index(Request $request)
    {
        // default this week if not provided
        $from = $request->query('from_date', Carbon::now()->startOfWeek()->toDateString());
        $to   = $request->query('to_date',   Carbon::now()->endOfWeek()->toDateString());

        // Summary table (all tutors with payable rows)
        $summary = $this->rangeSummary($from, $to);

        // For initial page load, if a tutor is preselected we’ll show auto-fill via AJAX,
        // so here we just pass the list of currently eligible tutors (optional)
        $eligibleTutors = $this->eligibleTutors($request, true); // returns collection in internal call

        return view('admin.modules.tutorpayouts.index', compact('from', 'to', 'summary', 'eligibleTutors'));
    }

    // ========= AJAX ==========

    /**
     * Eligible tutors for a date range (payable > 0 and not settled).
     * If $internal is true, returns collection; else returns JSON.
     */
    public function eligibleTutors(Request $request, bool $internal = false)
    {
        $from = $request->query('from_date');
        $to   = $request->query('to_date');

        if (!$from || !$to) {
            return $internal ? collect([]) : response()->json([]);
        }

        $rows = $this->rangeSummary($from, $to)
            ->filter(function ($row) {
                return (float)$row->net_pay > 0;
            })
            ->values();

        if ($internal) {
            return $rows;
        }

        return response()->json($rows);
    }

    /**
     * Totals for a specific tutor in the date range (auto-fill the top form).
     */
    public function tutorTotals(Request $request)
    {
        $from    = $request->query('from_date');
        $to      = $request->query('to_date');
        $tutorId = $request->query('tutor_id');

        if (!$from || !$to || !$tutorId) {
            return response()->json(['ok' => false, 'msg' => 'Missing parameters'], 422);
        }

        $q = $this->payableBaseQuery($from, $to)
            ->where('tp.tutor_id', $tutorId);

        $totals = $q->selectRaw('
                    SUM(tp.tutor_amount + tp.commission_amount) as gross_pay,
                    SUM(tp.commission_amount)                   as commission,
                    0.00                                        as deductions,
                    SUM(tp.tutor_amount)                        as net_pay
                ')
                ->first();

        // fetch tutor basic info
        $tutor = User::select('id', 'unique_id', 'f_name', 'l_name')->find($tutorId);

        return response()->json([
            'ok'         => true,
            'tutor'      => $tutor,
            'from_date'  => $from,
            'to_date'    => $to,
            'gross_pay'  => (float) ($totals->gross_pay ?? 0),
            'commission' => (float) ($totals->commission ?? 0),
            'deductions' => 0.0,
            'net_pay'    => (float) ($totals->net_pay ?? 0),
        ]);
    }

    /**
     * Booking details modal (completed + cancelled) for one tutor within the window.
     * NOTE: Right now, deductions=0. We'll extend later with cancellation policy.
     */
    public function details(Request $request, $tutorId)
    {
        $from = $request->query('from_date');
        $to   = $request->query('to_date');

        if (!$from || !$to) {
            return '<div class="p-3 text-danger">Invalid date range.</div>';
        }

        $fromTs = $from . ' 00:00:00';
        $toTs   = $to   . ' 23:59:59';

        $rows = TutorPayment::query()
            ->from('tutor_payment as tp')
            ->leftJoin('student_class_bookings as scb', 'scb.id', '=', 'tp.booking_id')
            ->leftJoin('users as s', 's.id', '=', 'scb.student_id')
            ->where('tp.tutor_id', $tutorId)
            ->whereBetween(DB::raw('COALESCE(tp.booking_date, tp.created_at)'), [$fromTs, $toTs])
            ->whereIn('scb.booking_status', ['CM', 'C']) // completed + cancelled
            ->select([
                'tp.id',
                'tp.booking_id',
                'tp.tutor_amount',
                'tp.commission_amount',
                'tp.payment_status',
                DB::raw("COALESCE(tp.booking_date, tp.created_at) as when_at"),
                'scb.booking_status',
                'scb.cancelled_by',
                'scb.cancelled_on',
                DB::raw("CONCAT(s.f_name,' ',s.l_name) as student_name"),
            ])
            ->orderBy('when_at', 'asc')
            ->get();

        $tutor = User::select('id','unique_id','f_name','l_name')->find($tutorId);

        return view('admin.modules.tutorpayouts.partials.details_table', compact('rows', 'tutor', 'from', 'to'));
    }

    // ========= Actions =========

    /**
     * Pay a tutor for the current date window:
     * - Insert payout row
     * - Mark matching tutor_payment rows as settled (payment_status = 3)
     */
    public function pay(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date',
            'tutor_id'  => 'required|integer|exists:users,id',
            'gross_pay' => 'required|numeric',
            'commission'=> 'required|numeric',
            'deductions'=> 'nullable|numeric',
            'net_pay'   => 'required|numeric',
        ]);

        $from    = $request->from_date;
        $to      = $request->to_date;
        $tutorId = (int) $request->tutor_id;

        DB::transaction(function () use ($from, $to, $tutorId, $request) {
            $tutor = User::select('id','unique_id','f_name','l_name')->findOrFail($tutorId);

            // Create payout
            Payout::create([
                'tutor_id'       => $tutor->id,
                'tutor_unique_id'=> $tutor->unique_id,
                'pay_from'       => $from,
                'pay_to'         => $to,
                'gross_pay'      => $request->gross_pay,
                'commission'     => $request->commission,
                'deductions'     => $request->deductions ?? 0,
                'net_pay'        => $request->net_pay,
                'payment_date'   => Carbon::now()->toDateString(),
                'payment_status' => 'Disbursed',
            ]);

            // Settle tutor_payment rows in this range (completed only)
            $fromTs = $from . ' 00:00:00';
            $toTs   = $to   . ' 23:59:59';

            TutorPayment::query()
                ->from('tutor_payment as tp')
                ->join('student_class_bookings as scb', 'scb.id', '=', 'tp.booking_id')
                ->where('tp.tutor_id', $tutorId)
                ->whereBetween(DB::raw('COALESCE(tp.booking_date, tp.created_at)'), [$fromTs, $toTs])
                ->where('scb.booking_status', 'CM')
                ->where('tp.payment_status', '!=', 3)
                ->update(['tp.payment_status' => 3]);
        });

        return redirect()
            ->route('admin.payouts', ['from_date' => $from, 'to_date' => $to])
            ->with('success', 'Payout disbursed and payments settled successfully.');
    }
}
   