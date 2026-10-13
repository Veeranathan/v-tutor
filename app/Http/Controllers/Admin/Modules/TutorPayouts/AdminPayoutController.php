<?php

namespace App\Http\Controllers\Admin\Modules\TutorPayouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TutorPayment;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPayoutController extends Controller
{
    /**
     * Tutor Payout List
     */
    public function index(Request $request)
    {
        $from    = $request->input('from_date');
        $to      = $request->input('to_date');
        $tutorId = $request->input('tutor_id');

        /*
         * Date validation
         */
        if (($from && !$to) || (!$from && $to)) {
            return redirect()
                ->route('admin.payouts')
                ->with('error', 'Please select both From Date and To Date.');
        }

        if ($from && $to && $from > $to) {
            return redirect()
                ->route('admin.payouts')
                ->with('error', 'From Date cannot be greater than To Date.');
        }

        /*
         * Get tutors who have TutorPayment records.
         */
        $tutorIdsQuery = TutorPayment::query()
            ->select('tutor_id')
            ->whereNotNull('tutor_id')
            ->distinct();

        if (!empty($tutorId)) {
            $tutorIdsQuery->where('tutor_id', $tutorId);
        }

        $tutorIds = $tutorIdsQuery->pluck('tutor_id');

        /*
         * Tutor dropdown.
         */
        $tutors = User::where('user_type', 'T')
            ->whereIn('id', $tutorIds)
            ->select(
                'id',
                'unique_id',
                'f_name',
                'l_name'
            )
            ->orderBy('unique_id')
            ->get();

        $paymentQuery = TutorPayment::with([
            'get_tutor',
            'booking.academicProgramSession'
        ])->whereIn('tutor_id', $tutorIds);

        if ($from && $to) {
            $paymentQuery->whereHas('booking', function ($q) use ($from, $to) {
                $q->whereBetween('booking_date', [$from, $to]);
            });
        }

        $payments = $paymentQuery
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('tutor_id');
        $results = $tutors->map(function ($tutor) use ($payments) {

            $rows = $payments->get($tutor->id, collect());

            /*
             * ONLY eligible bookings are used for payout calculation.
             */
            $eligibleRows = $rows->filter(function ($payment) {
                return $this->isEligibleForPayout($payment);
            });

            $grossTutorAmount = (float) $eligibleRows->sum('tutor_amount');

            $grossCommission = (float) $eligibleRows->sum(
                'commission_amount'
            );

            $grossRevenue = $grossTutorAmount + $grossCommission;

            $deduction = $grossCommission;

            $paidRows = $eligibleRows->filter(function ($payment) {
                return (int) $payment->payment_status === 1;
            });

            $paidAmount = (float) $paidRows->sum('tutor_amount');

            $netPayout = $paidAmount;

            $pendingRows = $eligibleRows->filter(function ($payment) {
                return (int) $payment->payment_status === 0;
            });

            $payoutPending = (float) $pendingRows->sum('tutor_amount');

            $pendingCount = $pendingRows->count();
            $pendingCount = $pendingRows->count();

            if ($eligibleRows->isEmpty()) {

                $paymentStatus = 'No Payment';

            } elseif ($payoutPending > 0) {

                $paymentStatus = 'Pending';

            } elseif ($netPayout > 0) {

                $paymentStatus = 'Paid';

            } else {

                $paymentStatus = 'No Payment';
            }

            return (object) [
                'tutor_id' => $tutor->id,

                'get_tutor' => $tutor,

                'gross' => round($grossRevenue, 2),

                'deduction' => round($deduction, 2),

                'net' => round($netPayout, 2),

                'payout_pending' => round($payoutPending, 2),

                'paid_amount' => round($paidAmount, 2),

                'commission' => round($grossCommission, 2),

                'pending_count' => $pendingCount,

                'total_count' => $eligibleRows->count(),

                'payment_status' => $paymentStatus,
            ];
        })->values();

        return view(
            'admin.modules.tutorpayouts.index',
            compact(
                'tutors',
                'results',
                'from',
                'to',
                'tutorId'
            )
        );
    }


    private function isEligibleForPayout(TutorPayment $payment): bool
    {
        $booking = $payment->booking;

        if (!$booking) {
            return false;
        }

        if ($this->isBookingCancelled($booking)) {
            return false;
        }

        if (empty($booking->tutor_login_at)) {
            return false;
        }

        if ($booking->booking_status === 'CM') {
            return true;
        }

        $session = $booking->academicProgramSession;

        if (
            $session &&
            $session->status === 'unattended'
        ) {
            return true;
        }

        return false;
    }



    private function isBookingCancelled($booking): bool
    {
    
        if (
            isset($booking->booking_status) &&
            $booking->booking_status === 'C'
        ) {
            return true;
        }

        if (
            isset($booking->cancelled_by) &&
            in_array(
                $booking->cancelled_by,
                ['S', 'T', 'A'],
                true
            )
        ) {
            return true;
        }

        return false;
    }

public function detailsPage(Request $request)
{
    $tutorId = $request->input('tutor_id');
    $from    = $request->input('from_date');
    $to      = $request->input('to_date');

    if (!$tutorId) {
        abort(404);
    }

    $tutor = User::findOrFail($tutorId);

    $query = TutorPayment::with([
        'booking.academicProgramSession',
        'booking.academicProgramPurchase.academicProgram',
        'get_tutor'
    ])
        ->where('tutor_id', $tutorId);

    if ($from && $to) {
        $query->whereHas('booking', function ($q) use ($from, $to) {
            $q->whereBetween('booking_date', [$from, $to]);
        });
    }

    $payments = $query
        ->orderBy('created_at', 'desc')
        ->get();

    $payments = $payments->filter(function ($payment) {
        return $this->isEligibleForPayout($payment);
    })->values();

    foreach ($payments as $payment) {

        $tutorAmount = (float) $payment->tutor_amount;

        $adminCommission = (float) $payment->commission_amount;

        $payment->gross =
            $tutorAmount + $adminCommission;

        $payment->deduction = $adminCommission;

        if ((int) $payment->payment_status === 1) {

            $payment->net = $tutorAmount;

        } else {

            $payment->net = 0;
        }

        if ((int) $payment->payment_status === 1) {

            $payment->payment_status_label = 'Paid';

        } else {

            $payment->payment_status_label = 'Pending';
        }

        $booking = $payment->booking;

        $session =
            optional($booking)->academicProgramSession;
        if (
            $session &&
            $session->status === 'unattended'
        ) {

            $payment->booking_status_label =
                'Unattended';

        } elseif (
            optional($booking)->booking_status === 'CM'
        ) {

            $payment->booking_status_label =
                'Completed';

        } else {

            $payment->booking_status_label = 'Completed';
        }
    }

    return view(
        'admin.modules.tutorpayouts.details',
        compact(
            'tutor',
            'payments',
            'from',
            'to'
        )
    );
}

    public function disburse(Request $request)
    {
        $tutorId = $request->input('tutor_id');

        $from = $request->input('from_date');

        $to = $request->input('to_date');

        $bulk = (bool) $request->input('bulk', false);

        if ($bulk && (!$from || !$to)) {
            return response()->json([
                'status' => false,
                'message' =>
                    'Bulk payment requires From Date and To Date.'
            ], 422);
        }

        if (($from && !$to) || (!$from && $to)) {
            return response()->json([
                'status' => false,
                'message' =>
                    'Please provide both From Date and To Date.'
            ], 422);
        }

        if ($from && $to && $from > $to) {
            return response()->json([
                'status' => false,
                'message' =>
                    'From Date cannot be greater than To Date.'
            ], 422);
        }

        if (!$bulk && !$tutorId) {
            return response()->json([
                'status' => false,
                'message' => 'Tutor is required.'
            ], 422);
        }

        try {

            DB::beginTransaction();

            $query = TutorPayment::with([
                'get_tutor',
                'booking.academicProgramSession'
            ])
                ->where('payment_status', 0);

            if (!$bulk) {
                $query->where('tutor_id', $tutorId);
            }

            if ($from && $to) {
                $query->whereHas('booking', function ($q) use ($from, $to) {
                    $q->whereBetween('booking_date', [$from, $to]);
                });
            }

            $payments = $query
                ->orderBy('tutor_id')
                ->orderBy('created_at')
                ->get();

            $eligiblePayments = $payments->filter(function ($payment) {
                return $this->isEligibleForPayout($payment);
            });

            if ($eligiblePayments->isEmpty()) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' =>
                        'No eligible pending tutor payments found.'
                ]);
            }

            $paymentsByTutor =
                $eligiblePayments->groupBy('tutor_id');

            $updatedPaymentIds = [];

            foreach (
                $paymentsByTutor
                as $currentTutorId => $tutorPayments
            ) {

                $payableRows = $tutorPayments;

                if ($payableRows->isEmpty()) {
                    continue;
                }

                $sumTutor = (float) $payableRows->sum('tutor_amount');

                $sumAdmin = (float) $payableRows->sum('commission_amount');

                $sumGross = $sumTutor + $sumAdmin;

                $sumDeduction = $sumAdmin;

                $net = max(0, $sumGross - $sumDeduction);

                $tutor = optional(
                    $payableRows->first()
                )->get_tutor;

                $payFrom = $from;

                $payTo = $to;

                if (!$payFrom || !$payTo) {

                    $paymentDates = $payableRows
                        ->map(function ($payment) {
                        return optional($payment->booking)->booking_date;
                        })
                        ->filter()
                        ->sort()
                        ->values();

                    $payFrom =
                        $paymentDates->first();

                    $payTo =
                        $paymentDates->last();
                }

                Payout::create([
                    'tutor_id' =>
                        $currentTutorId,

                    'tutor_unique_id' =>
                        optional($tutor)->unique_id,

                    'pay_from' =>
                        $payFrom,

                    'pay_to' =>
                        $payTo,

                    'gross_pay' =>
                        round($sumGross, 2),

                    'commission' =>
                        round($sumAdmin, 2),

                    'deductions' =>
                        round($sumDeduction, 2),

                    'net_pay' =>
                        round($net, 2),

                    'payment_date' =>
                        now()->toDateString(),

                    'payment_status' =>
                        'Disbursed',
                ]);

                foreach ($payableRows as $payment) {

                    $updatedPaymentIds[] =
                        $payment->id;
                }
            }

            if (empty($updatedPaymentIds)) {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' =>
                        'No payable tutor payments found.'
                ]);
            }

            TutorPayment::whereIn(
                'id',
                $updatedPaymentIds
            )
                ->where('payment_status', 0)
                ->update([
                    'payment_status' => 1
                ]);

            DB::commit();

            if ($bulk) {

                return response()->json([
                    'status' =>
                        true,

                    'message' =>
                        'All eligible pending tutor payments marked as paid successfully.',

                    'tutor_count' =>
                        $paymentsByTutor->count(),

                    'payment_count' =>
                        count($updatedPaymentIds),
                ]);
            }

            return response()->json([
                'status' =>
                    true,

                'message' =>
                    'Tutor payment marked as paid successfully.',

                'tutor_id' =>
                    $tutorId,
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Tutor Payout Error: ' .
                $e->getMessage(),
                [
                    'tutor_id' => $tutorId,
                    'from' => $from,
                    'to' => $to,
                    'bulk' => $bulk,
                ]
            );

            return response()->json([
                'status' => false,
                'message' => 'Server Error'
            ], 500);
        }
    }
}