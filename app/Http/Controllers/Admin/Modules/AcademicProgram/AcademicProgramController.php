<?php

namespace App\Http\Controllers\Admin\Modules\AcademicProgram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicProgram; 
use App\Models\Branch;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AcademicProgramController extends Controller
{
      /* ===========================
       LIST PAGE
    ============================ */
    public function index()
    {
        $grades   = Grade::where('status', 'A')->orderBy('id')->get();
        $branches = Branch::where('status', 'A')->orderBy('display_order')->get();

        return view('admin.modules.academic_program.academic_program_list', compact('grades','branches'));
    }

    /* ===========================
       DATATABLE LIST
    ============================ */
    public function academic_program_list(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        $query = AcademicProgram::with(['grade', 'branch']);


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('curriculum')) {
            $query->where('curriculum', $request->curriculum);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }


        if ($request->filled('year')) {
            $query->where('grade_id', $request->year);
        }

        if ($request->filled('subject')) {
            $query->where('branch_id', $request->subject);
        }


        if ($request->filled('search_txt')) {
            $search = $request->search_txt;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                 ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        $recordsTotal    = AcademicProgram::count();
        $recordsFiltered = $query->count();

        $programs = $query
            ->orderBy('updated_at', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $stateMap = [
            'New South Wales' => 'NSW',
            'Victoria' => 'VIC',
            'Queensland' => 'QLD',
            'South Australia' => 'SA',
            'Western Australia' => 'WA',
            'Tasmania' => 'TAS',
            'Australian Capital Territory' => 'ACT',
            'Northern Territory' => 'NT',
        ];    

        $data = [];

        foreach ($programs as $program) {
            $data[] = [
                'id'           => $program->id,
                'code'         => $program->code,
                'name'         => $program->name,
                'subject'      => optional($program->branch)->branch_name,
                'year'         => optional($program->grade)->grade_name,
                'state'        => $stateMap[$program->state] ?? $program->state ?? '-',
                'curriculum'   => explode(' ', trim($program->curriculum))[0] ?? '-',
                'price'        => $program->price,
                'discount'     => $program->discount,
                'popular'      => $program->popular,
                'status'       => $program->status,

                'updated_at' => $program->updated_at
                    ? $program->updated_at->format('d-m-Y')
                    : '',

                'view_url'   => route('view.academic.program', $program->id),
                'delete_url' => route('del.academic.program', $program->id),

                'status_toggle_url' => $program->status
                    ? route('inactive.academic.program', $program->id)
                    : route('active.academic.program', $program->id),
            ];
        }

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    /* ===========================
       ADD PAGE
    ============================ */
    public function academic_program_add_page()
    {
        $grades   = Grade::where('status', 'A')->orderBy('id')->get();
        $branches = Branch::where('status', 'A')->orderBy('display_order')->get();

        return view('admin.modules.academic_program.academic_program_add', compact('grades','branches'));
    }

    /* ===========================
       INSERT
    ============================ */
    public function academic_program_ins(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'                => 'required|string',
                'code'                => 'required|string|unique:academic_programs,code',
                'branch_id'           => 'required|exists:branches,id',
                'grade_id'            => 'required|exists:grades,id',
                'price'               => 'required|numeric',
                'regular_price'       => 'required|numeric',
                'discount'            => 'required|numeric',
                'description'         => 'required|string|max:90',
                'validity'            => 'required|integer',
                'display_for'         => 'required|array|min:1',
                'status'              => 'required|boolean',
                'curriculum'          => 'required|string',
                'city'                => 'required|string',
                'state'               => 'required|string',
                'program_type'        => 'required|string',
                'outcome'             => 'required|string',
                'number_of_sessions'  => 'required|string',
                'session_interval'    => 'required|string',
                'mode_of_delivery'    => 'required|string',
                'program_tutor'       => 'required|string',
                'booking_method'      => 'required|string',
                'program_detail'      => 'required|string',
                'assessments'         => 'required|array|min:1',
                'parent_session_plan' => 'nullable|file|mimes:pdf|max:5120',
                'tutor_session_plan'  => 'nullable|file|mimes:pdf|max:5120',
            ],
            [
                'code.unique' => 'The program code is already in use',
                'parent_session_plan.mimes' => 'Only PDF files are allowed',
                'parent_session_plan.max'   => 'PDF file size must not exceed 5 MB',
                'tutor_session_plan.mimes' => 'Only PDF files are allowed',
                'tutor_session_plan.max'   => 'PDF file size must not exceed 5 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $parentSessionPlanName = null;

        if ($request->hasFile('parent_session_plan')) {
            $doc = $request->file('parent_session_plan');

            $parentSessionPlanName = time() . '-parent-' . $doc->getClientOriginalName();

            $doc->move(
                'storage/academic_program_docs/',
                $parentSessionPlanName
            );
        }

        $tutorSessionPlanName = null;

        if ($request->hasFile('tutor_session_plan')) {
            $doc = $request->file('tutor_session_plan');

            $tutorSessionPlanName = time() . '-tutor-' . $doc->getClientOriginalName();

            $doc->move(
                'storage/academic_program_docs/',
                $tutorSessionPlanName
            );
        }
        
        $slug = Str::slug($request->name);

        AcademicProgram::create([
            'name'                  => $request->name,
            'slug'                  => $slug,
            'code'                  => $request->code,
            'branch_id'             => $request->branch_id,
            'grade_id'              => $request->grade_id,
            'price'                 => $request->price,
            'regular_price'         => $request->regular_price,
            'discount'              => $request->discount,
            'description'           => $request->description,
            'program_detail'        => $request->program_detail,
            'outcome'               => $request->outcome,
            'validity'              => $request->validity,
            'display_for'           => $request->display_for,
            'popular'               => $request->popular ?? 0,
            'display_order'         => $request->display_order ?? 0,
            'status'                => $request->status,
            'curriculum'            => $request->curriculum,
            'city'                  => $request->city,
            'state'                 => $request->state,
            'program_type'          => $request->program_type,
            'number_of_sessions'    => $request->number_of_sessions,
            'session_interval'      => $request->session_interval,
            'mode_of_delivery'      => $request->mode_of_delivery,
            'program_tutor'         => $request->program_tutor,
            'booking_method'        => $request->booking_method,
            'assessments'           => $request->assessments,
            'parent_session_plan'   => $parentSessionPlanName,
            'tutor_session_plan'    => $tutorSessionPlanName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Academic Program added successfully'
        ]);
    }

    /* ===========================
       DELETE
    ============================ */
    public function academic_program_del($id)
    {
        $program = AcademicProgram::find($id);

        if (!$program) {
            return back()->with('error', 'Academic Program not found');
        }

        if ($program->document) {
            $path = 'storage/academic_program_docs/' . $program->document;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $program->delete();

        return back()->with('success', 'Academic Program removed successfully');
    }

    /* ===========================
       ACTIVATE
    ============================ */
    public function academic_program_active($id)
    {
        AcademicProgram::where('id', $id)->update(['status' => 1]);
        return back()->with('success', 'Academic Program activated');
    }

    /* ===========================
       INACTIVE
    ============================ */
    public function academic_program_inactive($id)
    {
        AcademicProgram::where('id', $id)->update(['status' => 0]);
        return back()->with('success', 'Academic Program deactivated');
    }

    /* ===========================
       VIEW
    ============================ */
    public function academic_program_view($id)
    {
        $program  = AcademicProgram::findOrFail($id);
        $grades   = Grade::where('status','A')->get();
        $branches = Branch::where('status','A')->get();

        return view(
            'admin.modules.academic_program.academic_program_view',
            compact('program','grades','branches')
        );
    }

    /* ===========================
       UPDATE
    ============================ */
    public function academic_program_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name'                => 'required|string',
        'branch_id'           => 'required|exists:branches,id',
        'grade_id'            => 'required|exists:grades,id',
        'price'               => 'required|numeric',
        'regular_price'       => 'required|numeric',
        'discount'            => 'required|numeric',
        'description'         => 'required|string|max:90',
        'validity'            => 'required|integer',
        'display_for'         => 'required|array|min:1',
        'status'              => 'required|boolean',
        'curriculum'          => 'required|string',
        'city'                => 'required|string',
        'outcome'             => 'required|string',
        'state'               => 'required|string',
        'program_type'        => 'required|string',
        'number_of_sessions'  => 'required|string',
        'session_interval'    => 'required|string',
        'mode_of_delivery'    => 'required|string',
        'program_tutor'       => 'required|string',
        'booking_method'      => 'required|string',
        'program_detail'      => 'required|string',
        'assessments'         => 'required|array|min:1',
        'parent_session_plan' => 'nullable|file|mimes:pdf|max:5120',
        'tutor_session_plan'  => 'nullable|file|mimes:pdf|max:5120',
        ], [
        'parent_session_plan.mimes' => 'Only PDF files are allowed',
        'parent_session_plan.max'   => 'PDF file size must not exceed 5 MB',

        'tutor_session_plan.mimes' => 'Only PDF files are allowed',
        'tutor_session_plan.max'   => 'PDF file size must not exceed 5 MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
            ], 422);
        }

        $program = AcademicProgram::find($request->program_id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'errors' => ['program_id' => ['Academic Program not found']]
            ], 404);
        }

        $parentSessionPlanName = $program->parent_session_plan;

        if ($request->remove_parent_session_plan == '1') {

            if (
                $parentSessionPlanName &&
                file_exists('storage/academic_program_docs/' . $parentSessionPlanName)
            ) {
                unlink('storage/academic_program_docs/' . $parentSessionPlanName);
            }
                $parentSessionPlanName = null;
        }

        if ($request->hasFile('parent_session_plan')) {

        if (
            $parentSessionPlanName &&
            file_exists('storage/academic_program_docs/' . $parentSessionPlanName)
        ) {
            unlink('storage/academic_program_docs/' . $parentSessionPlanName);
        }

        $doc = $request->file('parent_session_plan');

        $parentSessionPlanName =
            time() . '-parent-' . $doc->getClientOriginalName();

        $doc->move(
            'storage/academic_program_docs/',
            $parentSessionPlanName
        );
        }

        $tutorSessionPlanName = $program->tutor_session_plan;

        if ($request->remove_tutor_session_plan == '1') {

            if (
                $tutorSessionPlanName &&
                file_exists('storage/academic_program_docs/' . $tutorSessionPlanName)
            ) {
                unlink('storage/academic_program_docs/' . $tutorSessionPlanName);
            }

                $tutorSessionPlanName = null;
        }

        if ($request->hasFile('tutor_session_plan')) {

        if (
            $tutorSessionPlanName &&
            file_exists('storage/academic_program_docs/' . $tutorSessionPlanName)
        ) {
            unlink('storage/academic_program_docs/' . $tutorSessionPlanName);
        }

            $doc = $request->file('tutor_session_plan');

            $tutorSessionPlanName =
                time() . '-tutor-' . $doc->getClientOriginalName();

            $doc->move(
                'storage/academic_program_docs/',
                $tutorSessionPlanName
            );
        }


        $slug = Str::slug(trim($request->name));

        $program->update([
            'name'               => $request->name,
            'slug'               => $slug,
            'code'               => $request->code,
            'branch_id'          => $request->branch_id,
            'grade_id'           => $request->grade_id,
            'price'              => $request->price,
            'regular_price'      => $request->regular_price,
            'discount'           => $request->discount,
            'description'        => $request->description,
            'validity'           => $request->validity,
            'display_for'        => $request->display_for,
            'popular'            => $request->popular ?? 0,
            'display_order'      => $request->display_order ?? 0,
            'status'             => $request->status,
            'curriculum'         => $request->curriculum,
            'city'               => $request->city,
            'outcome'            => $request->outcome,
            'state'              => $request->state,
            'program_type'       => $request->program_type,
            'number_of_sessions' => $request->number_of_sessions,
            'session_interval'   => $request->session_interval,
            'mode_of_delivery'   => $request->mode_of_delivery,
            'program_tutor'      => $request->program_tutor,
            'booking_method'     => $request->booking_method,
            'assessments'        => $request->assessments,
            'program_detail'     => $request->program_detail,
            'parent_session_plan'   => $parentSessionPlanName,
            'tutor_session_plan'    => $tutorSessionPlanName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Academic Program updated successfully'
        ]);
    }
}
