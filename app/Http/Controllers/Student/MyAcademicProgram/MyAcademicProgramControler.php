<?php

namespace App\Http\Controllers\Student\MyAcademicProgram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcademicProgram;
use App\Models\AcademicProgramPurchase;
use App\Models\StudentClassBooking;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class MyAcademicProgramControler extends Controller
{
    public function myMyAcademicProgram()
    {
        $branches = Branch::where('status', 'A')
        ->orderBy('branch_name', 'asc')
        ->get();

        return view(
        'student.modules.my_academic_program.my_academic_program',
        compact('branches')
        );
    }


    public function student_academic_program_list(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        $studentId = auth()->id();

        $query = AcademicProgramPurchase::with([
            'academicProgram.grade',
            'academicProgram.branch',
            'assignedTutor'
        ])
        ->where('user_id', $studentId)
        ->where('payment_status', 'paid');

        if (!empty($request->branch_id)) {
        $query->whereHas('academicProgram.branch', function ($q) use ($request) {
            $q->where('slug', $request->branch_id);
        });
        }

        $recordsTotal = $query->count();
        $recordsFiltered = $recordsTotal;

        $purchases = $query
            ->orderBy('created_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $data = [];

        foreach ($purchases as $purchase) {

            $remainingSessions = $purchase->sessions()
                ->where('status', 'pending')
                ->count();
            
            $assignedTutor = $purchase->assignedTutor;   
                
            $data[] = [
                'purchase_id' => $purchase->id,
                'name'        => $purchase->academicProgram->name ?? '-',
                'subject'     => optional($purchase->academicProgram->branch)->branch_name ?? '-',
                'year'        => optional($purchase->academicProgram->grade)->grade_name ?? '-',
                'validity'    => optional($purchase->expires_at)->format('d-m-Y') ?? '-',
                'remaining'   => $remainingSessions,
                'tutor_id'    => $purchase->assigned_tutor_id,
                'tutor_slug'  => optional($assignedTutor)->slug,
                'student_id'  => $studentId,
                'tutor_name'  => optional($assignedTutor)->full_name ?? '-',
            ];
        }

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }
    
    public function myMyAcademicProgramView($purchaseId)
    {
        $purchase = AcademicProgramPurchase::with([
            'academicProgram.branch',
            'academicProgram.grade',
            'user',
            'assignedTutor',
            'sessions.tutor',
        ])
        ->where('id', $purchaseId)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        return view('student.modules.my_academic_program.my_academic_program_view', compact('purchase'));
    }

}
