<?php

namespace App\Http\Controllers\Admin\Modules\ProgrammeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningProgramAssessment;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\AssessmentMail;
use App\Mail\AssessmentSuggestionReportMail;
use App\Models\AcademicProgram; 
use App\Models\MyAssessment;
use App\Models\Grade;
use App\Services\AssessmentPdfService;
use Illuminate\Support\Str;
use App\Models\AssessmentSuggestion;
use Illuminate\Support\Facades\Auth;
use App\Jobs\AssessmentSuggestionReportJob;

class LearningProgramAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /* ===========================
       PAGE
    ============================ */
    public function index()
    {
        return view('admin.modules.programme_management.manage_learning_assessment');
    }

    /* ===========================
       DATATABLE LIST
    ============================ */
    public function list(Request $request)
    {
        try {
            // DataTables params
            $draw   = intval($request->draw);
            $start  = intval($request->start);
            $length = intval($request->length);

            // Base query
            $query = LearningProgramAssessment::with('myAssessment');

            /* ---------- FILTERS ---------- */
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('visit_reason')) {
                $query->where('visit_reason', $request->visit_reason);
            }

            if ($request->filled('keyword')) {
                $k = $request->keyword;
                $query->where(function ($q) use ($k) {
                    $q->where('first_name', 'like', "%$k%")
                      ->orWhere('last_name', 'like', "%$k%")
                      ->orWhere('email', 'like', "%$k%")
                      ->orWhere('phone', 'like', "%$k%")
                      ->orWhere('subject', 'like', "%$k%");
                });
            }

            /* ---------- RECORD COUNTS ---------- */
            $recordsTotal    = LearningProgramAssessment::count();
            $recordsFiltered = $query->count();

            /* ---------- ORDERING ---------- */
            $columns = [
                0 => 'first_name',
                1 => 'last_name',
                2 => 'assessment_for',
                3 => 'visit_reason',
                4 => 'school_year',
                5 => 'grade',
                6 => 'status',
                7 => 'created_at',
            ];

            // Default ordering
            $orderColumn = 'created_at';
            $orderDir    = 'desc';

            // If DataTables sends order, override default
            if (!empty($request->order)) {
                $orderColumnIndex = $request->order[0]['column'] ?? 7;
                $orderDir         = $request->order[0]['dir'] ?? 'desc';
                $orderColumn      = $columns[$orderColumnIndex] ?? 'created_at';
            }

            /* ---------- FETCH DATA ---------- */
            $assessments = $query
                ->orderBy($orderColumn, $orderDir)
                ->offset($start)
                ->limit($length)
                ->get();

            /* ---------- FORMAT RESPONSE ---------- */
            $data = [];
            foreach ($assessments as $a) {
                $data[] = [
                    'id'             => $a->id,
                    'parent_name'    => $a->first_name,
                    'child_name'     => $a->last_name,
                    'email'          => $a->email,
                    'phone'          => $a->phone,
                    'assessment_for' => ucfirst($a->assessment_for),
                    'visit_reason'   => $a->program_mode_label,
                    'assessment_form_name' => $a->myAssessment?->assessment_form_name ?? '-',
                    'grade'          => $a->grade,
                    'state'          => $a->state,
                    'subject'        => $a->subject,
                    'learning_need'  => $a->learning_need,
                    'free_time'      => $a->free_time,
                    'terms_agreed'   => $a->terms_agreed ? 'Yes' : 'No',
                    'status'         => ucfirst($a->status),
                    'created_at' => $a->created_at
                        ? $a->created_at
                        ->timezone('Australia/Sydney')
                        ->format('d-m-Y')
                        : '',


                    // Action URLs
                    'view_url'    => route('view.learning.assessment', $a->id),
                    'action_url'    => route('action.learning.assessment', $a->id),
                    'delete_url'  => route('delete.learning.assessment', $a->id),
                ];
            }

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);

        } catch (\Exception $e) {
            Log::error('Learning Assessment List Error: ' . $e->getMessage());

            return response()->json([
                'draw'            => 0,
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }
    }

    /* ===========================
       VIEW
    ============================ */
    public function view($id)
    {
        $assessment = LearningProgramAssessment::find($id);

        if (!$assessment) {
            return back()->with('error', 'Assessment not found');
        }

        return view(
            'admin.modules.programme_management.view_learning_assessment',
            compact('assessment')
        );
    }

    /* ===========================
       DELETE
    ============================ */
    public function delete($id)
    {
        $assessment = LearningProgramAssessment::find($id);

        if (!$assessment) {
            return response()->json([
                'success' => false,
                'message' => 'Assessment not found'
            ]);
        }

        $assessment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assessment deleted successfully'
        ]);
    }

    /* ===========================
       DOWNLOAD (EXCEL)
    ============================ */
    public function download()
    {
        $assessments = LearningProgramAssessment::orderBy('id', 'desc')->get();

        $html = '<table border="1">
            <tr>
                <th>Assessment For</th>
                <th>Visit Reason</th>
                <th>School Year</th>
                <th>Grade</th>
                <th>State</th>
                <th>Subject</th>
                <th>Learning Need</th>
                <th>Free Time</th>
                <th>Parent Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Terms Agreed</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>';

        foreach ($assessments as $a) {
            $html .= '<tr>
                <td>'.ucfirst($a->assessment_for).'</td>
                <td>'.$a->visit_reason.'</td>
                <td>'.$a->school_year.'</td>
                <td>'.$a->grade.'</td>
                <td>'.$a->state.'</td>
                <td>'.$a->subject.'</td>
                <td>'.$a->learning_need.'</td>
                <td>'.$a->free_time.'</td>
                <td>'.$a->first_name.' '.$a->last_name.'</td>
                <td>'.$a->email.'</td>
                <td>'.$a->phone.'</td>
                <td>'.($a->terms_agreed ? 'Yes' : 'No').'</td>
                <td>'.ucfirst($a->status).'</td>
                <td>'.$a->created_at->format('d-m-Y').'</td>
            </tr>';
        }

        $html .= '</table>';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Learning_Program_Assessments.xls");

        echo $html;
        exit;
    }

    /* ===========================
       Action
    ============================ */
    public function action($id)
    {
        $assessment = LearningProgramAssessment::find($id);
        if (!$assessment) {
            return back()->with('error', 'Assessment not found');
        }

    // Extract grade number (e.g. "Grade 10" -> "10")
    $gradeNumber = preg_replace('/[^0-9]/', '', $assessment->grade);

    // Find grade record
    $gradeRecord = Grade::where('grade_name', "Year {$gradeNumber}")->first();

    $gradeId = $gradeRecord ? $gradeRecord->id : null;

    $state = $assessment->state;

    // Primary Programs
    $primaryPrograms = AcademicProgram::where('grade_id', $gradeId)
        ->where('state', $state)
        //->where('program_type', 'Core Training Program')
        ->where('status', 1)
        ->get();

    // Secondary Programs
    $secondaryPrograms = AcademicProgram::where('grade_id', $gradeId)
        ->where('state', $state)
        ->where('status', 1)
        ->get();

        // Fetch results
        $results = MyAssessment::where('learning_program_assessment_id', $id)->get();
        $suggestion = AssessmentSuggestion::where('learning_program_assessment_id', $id)->first();

        return view(
            'admin.modules.programme_management.action_learning_assessment',
            compact('assessment', 'results', 'suggestion', 'primaryPrograms', 'secondaryPrograms')
        );
    }

    public function sendEmail(Request $request)
    {
    $assessment = LearningProgramAssessment::find($request->assessment_id);

    if (!$assessment) {
        return response()->json([
            'success' => false,
            'message' => 'Assessment not found'
        ]);
    }

    // Allow only Student Assessment
    if ($assessment->visit_reason !== 'free_assessment') {
        return response()->json([
            'success' => false,
            'message' => 'Email can be sent only for Student Assessment'
        ]);
    }

     try {
            Mail::send(new AssessmentMail($assessment, true));
        } catch (\Exception $e) {
            Log::error("Programme Signup Mail Error: ".$e->getMessage());
        }
    
    return response()->json([
        'success' => true,
        'message' => 'Email sent successfully'
    ]);

    }
     /**
     * Download Assessment Result PDF.
     */
    public function downloadAssessmentResult($id)
    {
        $pdfService = app(AssessmentPdfService::class);

        $data = $pdfService->getAssessmentData($id);

    
        $pdfBinary = $pdfService->generateInline(
            $data['assessment'],
            $data['result'],
            $data['myAssessment']
        );

        $lastName = !empty($data['assessment']->last_name) 
            ? Str::slug($data['assessment']->last_name) 
            : '';

        $fileName = $lastName 
            ? "{$lastName}_diagnostic_assessment_report.pdf" 
            : 'diagnostic_assessment_report.pdf';

        return response($pdfBinary)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function saveSuggestion(Request $request)
    {
        $validated = $request->validate([
            'learning_program_assessment_id' => 'required|exists:learning_program_assessments,id',
            'student_id'                     => 'nullable|integer',
            'performance_comment'            => 'required|string',
            'advisor_summary_report'          => 'required|string',
            'key_strengths'                  => 'required|array',
            'additional_strength'            => 'nullable|string',
            'learning_opportunities'         => 'required|array',
            'additional_opportunity'         => 'nullable|string',
            'quantitative_status'            => 'required|string',
            'quantitative_statement'         => 'required|string',
            'qualitative_status'             => 'required|string',
            'qualitative_statement'          => 'required|string',
            'quantitative_assessment_summary' => 'required|string',
            'qualitative_responses_summary'  => 'required|string',
            'overall_alignment'              => 'required|string',
            'alignment_summary'              => 'required|string',
            'additional_notes'               => 'nullable|string',
            'reading'                        => 'required|string',
            'reasoning'                      => 'required|string',
            'thinking'                       => 'required|string',
            'logic'                          => 'required|string',
            'writing'                        => 'required|string',
            'recommended_learning_priorities' => 'required|array',
            'primary_learning_recommendation'   => 'required|array|min:1|max:2',
            'secondary_learning_recommendation' => 'nullable|array|max:4',
        ]);

        if (Auth::guard('admin')->check()) {

            $user = Auth::guard('admin')->user();
            $validated['report_prepared_by_id'] = $user->id;
            $validated['report_prepared_by'] = $user->name;

            } else {
                Log::warning('User is NOT authenticated under admin guard when saving suggestion.');
        }

        try {
            $suggestion = AssessmentSuggestion::updateOrCreate(
                ['learning_program_assessment_id' => $request->learning_program_assessment_id],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Assessment suggestion saved successfully.',
                'data'    => $suggestion,
            ]);
        } catch (\Exception $e) {
            Log::error('Save Assessment Suggestion Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save suggestion. Please try again.',
            ], 500);
        }
    }
    public function sendReport(Request $request)
    {
      $request->validate([
        'assessment_id' => 'required|exists:learning_program_assessments,id',
    ]);

    try {
        $assessment = LearningProgramAssessment::findOrFail($request->assessment_id);

        if (empty($assessment->email)) {
            return response()->json([
                'success' => false,
                'message' => 'No email address associated with this assessment.'
            ], 422);
        }

        // Dispatch the dedicated suggestion job
        AssessmentSuggestionReportJob::dispatch($assessment->id);

        return response()->json([
            'success' => true,
            'message' => 'Academic Feedback & Learning Recommendations Report has been sent successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while dispatching the suggestion report: ' . $e->getMessage()
        ], 500);
    }
    }
    public function viewReport($id, AssessmentPdfService $pdfService)
    {
    try {
        $data = $pdfService->getSuggestionData($id);

        $html = view('pdf.assessment_suggestion_report', [
            'assessment'   => $data['assessment'],
            'myAssessment' => $data['myAssessment'],
            'result'       => $data['result'],
            'suggestion'   => $data['suggestion'],
            'logoRed'      => public_path('assets/images/pdf/pdf-red-logo.png'),
            'starFilled'   => public_path('assets/images/pdf/star_filled.png'),
            'starEmpty'    => public_path('assets/images/pdf/star_empty.png'),
            'assessmentStep' => public_path('assets/images/pdf/assessment-suggestion-next-step.png'),
        ])->render();

        $mpdf = new \Mpdf\Mpdf([
            'margin_left'   => 20,
            'margin_right'  => 20,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'format'        => 'A4',
            'tempDir'       => storage_path('app')
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('suggestion-report-' . $id . '.pdf', \Mpdf\Output\Destination::INLINE), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Unable to view suggestion report: ' . $e->getMessage());
    }
    }
}
  