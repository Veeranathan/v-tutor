<?php

namespace App\Http\Controllers\Admin\Modules\AcademicProgram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicProgramPurchase;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\AcademicProgram;
use App\Models\AcademicProgramInvoice;
use App\Models\AcademicProgramSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ManualProgramAssignedMail;
use Carbon\Carbon;

class AcademicProgramAssignmentController extends Controller
{
    /* ===========================
       LIST PAGE
    ============================ */
    public function index()
    {
        return view('admin.modules.academic_program.assignment_list');
    }

    /* ===========================
       DATATABLE LIST
    ============================ */
    public function assignment_list(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        $query = AcademicProgramPurchase::with([
            'academicProgram',
            'user'
        ]);

        // Filter by status
        if ($request->filled('status')) {

            switch ($request->status) {

                case 'expired':
                $query->whereNotNull('expires_at')
                  ->whereDate('expires_at', '<', now());
                break;

                case 'assigned':
                    $query->whereNotNull('assigned_tutor_id')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhereDate('expires_at', '>=', now());
                        });
                break;

                case 'unassigned':
                    $query->whereNull('assigned_tutor_id')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhereDate('expires_at', '>=', now());
                        });
                    break;

                case 'active':
                    $query->where(function ($q) {
                        $q->whereNull('expires_at')
                        ->orWhereDate('expires_at', '>=', now());
                    });
                    break;
             }
        }

        // Search
        if ($request->filled('search_txt')) {
            $search = $request->search_txt;

            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('academicProgram', function ($p) use ($search) {
                      $p->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('code', 'LIKE', "%{$search}%");
                  });
            });
        }

        $recordsTotal    = AcademicProgramPurchase::count();
        $recordsFiltered = $query->count();

        $purchases = $query
            ->orderBy('updated_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $data = [];

        foreach ($purchases as $purchase) {

            $user = $purchase->user;

            $data[] = [
                'id'              => $purchase->id,
                'order_id'        => $purchase->order_id,
                'f_name'          => optional($user)->f_name,
                'l_name'          => optional($user)->l_name,
                'email'          => optional($user)->email,
                'name'    => trim(optional($user)->f_name . ' ' . optional($user)->l_name),
                'program_name'    => optional($purchase->academicProgram)->name,
                'program_code'    => optional($purchase->academicProgram)->code,
                'payment_status'  => $purchase->payment_status,
                'start_date'      => $purchase->start_date 
                                        ? $purchase->start_date->format('d-m-Y') 
                                        : '',
                'expires_at'      => $purchase->expires_at 
                                        ? $purchase->expires_at->format('d-m-Y') 
                                        : '',
                'status'          => $purchase->assignment_status,

                'assign_url'      => route('view.academic.assignment', $purchase->id),
            ];
        }

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    public function assignment_view($id)
    {
        $purchase = AcademicProgramPurchase::with([
            'academicProgram.grade',
            'academicProgram.branch',
            'user.getState',
            'sessions.tutor',
            'assignedTutor'
        ])->findOrFail($id);

        $gradeId  = $purchase->academicProgram->grade_id ?? null;
        $branchId = $purchase->academicProgram->branch_id ?? null;

        $student = $purchase->user;
        $studentStateId = $student->state ?? null;
        $studentTimezone = $student->getState->time_zone ?? null;

        $tutors = User::where('status', 'A')
            ->whereIn('id', function ($query) use ($gradeId, $branchId) {
                $query->select('teacher_id')
                    ->from('tutorship_plan')
                    ->where('status', 'A')
                    ->where('grade_id', $gradeId)
                    ->where('branch_id', $branchId);
            })
            ->whereIn('id', function ($query) use ($studentStateId) {
                $query->select('tutor_id')
                    ->from('tutor_wwcc')
                    ->where('states', $studentStateId)
                    ->where('is_valid', 1)
                    ->whereDate('expiry_date', '>=', Carbon::today());
            })

            ->orderBy('f_name', 'asc')
            ->get();

        return view(
            'admin.modules.academic_program.assignment_view',
            compact(
                'purchase',
                'tutors',
                'studentTimezone',
                'studentStateId'
            )
        );
    }

    /* ===========================
       ASSIGN TUTOR
    ============================ */
    public function assignTutorStore(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:academic_program_purchases,id',
            'tutor_id'    => 'required|exists:users,id',
        ]);

        $purchase = AcademicProgramPurchase::findOrFail($request->purchase_id);

        if ($purchase->expires_at && now()->gt($purchase->expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot assign tutor. Purchase has expired.'
            ]);
        }

        $purchase->assigned_tutor_id = $request->tutor_id;
        $purchase->save();

        return response()->json([
            'success' => true,
            'message' => 'Tutor assigned successfully.'
        ]);
    }
    public function manualAssignmentCreate()
    {
        $students = User::where('user_type', 'U')
            ->whereIn('student_type', ['G', 'P', 'S'])
            ->where('status', '!=', 'D')
            ->orderBy('f_name')
            ->get();

        $programs = AcademicProgram::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
        'admin.modules.academic_program.manual_assignment',
        compact('students', 'programs')
        );
    }

    public function manualAssignmentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:academic_programs,id',
        ]);

        // VALIDATION ERROR
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $student = User::findOrFail($request->student_id);

            $program = AcademicProgram::findOrFail($request->program_id);

            $orderId = 'SPLPGM' . rand(100, 999);

            $startDate = now();

            $expiresAt = now()->addDays($program->validity);

            // CREATE INVOICE
            $invoice = AcademicProgramInvoice::create([
                'user_id'        => $student->id,
                'order_id'       => $orderId,
                'invoice_number' => 'SPL-INV-' . time(),
                'sub_total'      => $program->price ?? 0,
                'gst_percent'    => 0,
                'gst_amount'     => 0,
                'total_amount'   => $program->price ?? 0,
                'payment_status' => 'paid',
            ]);

            // CREATE PURCHASE
            $purchase = AcademicProgramPurchase::create([
                'user_id'             => $student->id,
                'academic_program_id' => $program->id,
                'invoice_id'          => $invoice->id,
                'stripe_session_id'   => 'MANUAL-' . time(),
                'order_id'            => $orderId,
                'quantity'            => 1,
                'amount'              => $program->price ?? 0,
                'payment_status'      => 'paid',
                'start_date'          => $startDate,
                'expires_at'          => $expiresAt,
                'status'              => 'active',
            ]);

            // CREATE SESSIONS
            for ($i = 1; $i <= $program->number_of_sessions; $i++) {

            AcademicProgramSession::create([
                'purchase_id'    => $purchase->id,
                'session_number' => $i,
                'status'         => 'pending',
                'tutor_id'       => null,
            ]);
            }

        DB::commit();

        try {

            Mail::send(new ManualProgramAssignedMail(
                $student,
                $program,
                $orderId,
                $expiresAt
            ));

        } catch (\Exception $e) {

        Log::error(
            "Manual Program Assignment Mail Error: " . $e->getMessage()
        );
        }

        return response()->json([
            'success' => true,
            'message' => 'Academic program assigned successfully.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function sessionHistory($id)
{
    $adminTimezone = 'Australia/Sydney';

    $session = AcademicProgramSession::with([
        'purchase.academicProgram.grade',
        'purchase.academicProgram.branch',
        'purchase.user',
        'tutor',
        'logs.tutor',
        'logs.actionBy',
        'booking',
    ])->findOrFail($id);

    $booking = $session->booking;

    $studentLoginTime = null;
    $tutorLoginTime = null;

    if ($booking) {
        $studentLoginAt = $booking->getRawOriginal('student_login_at');
        $tutorLoginAt = $booking->getRawOriginal('tutor_login_at');

        if ($studentLoginAt) {
            $studentLoginTime = Carbon::parse(
                $studentLoginAt,
                'UTC'
            )->setTimezone($adminTimezone);
        }

        if ($tutorLoginAt) {
            $tutorLoginTime = Carbon::parse(
                $tutorLoginAt,
                'UTC'
            )->setTimezone($adminTimezone);
        }
    }

    return view(
        'admin.modules.academic_program.session_history',
        compact(
            'session',
            'studentLoginTime',
            'tutorLoginTime',
            'adminTimezone'
        )
    );
}

}