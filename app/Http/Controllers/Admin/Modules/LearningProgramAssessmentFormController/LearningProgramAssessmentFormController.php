<?php

namespace App\Http\Controllers\Admin\Modules\LearningProgramAssessmentFormController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningProgramAssessmentForm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LearningProgramAssessmentFormController extends Controller
{
    /* LIST PAGE */
    public function index()
    {
        return view(
            'admin.modules.assessment_forms_management.learning_program_assessment_forms_list'
        );
    }

    /*  AJAX LIST */
    public function list(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        $query = LearningProgramAssessmentForm::query();

        /* FILTERS */

        if ($request->filled('assessment_type')) {
            $query->where(
                'assessment_type',
                $request->assessment_type
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $recordsTotal =
            LearningProgramAssessmentForm::count();

        $recordsFiltered =
            $query->count();

        $forms = $query
            ->latest()
            ->offset($start)
            ->limit($length)
            ->get();

        $data = [];

        foreach ($forms as $form) {

            $data[] = [

    'id' => $form->id,

    'form_name' =>
        $form->form_name,

    'assessment_type' =>
        ucfirst($form->assessment_type),

    'form_url' =>
        'https://v-tutor.com.au/assessment/' . $form->form_slug,

    'category' =>
        ucwords(str_replace('_', ' ', $form->category)),

    'sections' =>
        !empty($form->sections)
            ? implode(', ', $form->sections)
            : '-',

    'passage_count' =>
        $form->passage_count ?? 0,


    'status' =>
        $form->status,

    /* ACTION URLS */

    'view_url' => route(
        'learning.assessment.forms.view',
        $form->id
    ),

    'delete_url' => route(
        'learning.assessment.forms.delete',
        $form->id
    ),

    'status_toggle_url' => $form->status
        ? route(
            'learning.assessment.forms.inactive',
            $form->id
        )
        : route(
            'learning.assessment.forms.active',
            $form->id
        ),
    ];
        }

        return response()->json([

            'draw' => $draw,

            'recordsTotal' => $recordsTotal,

            'recordsFiltered' => $recordsFiltered,

            'data' => $data,
        ]);
    }

    /* CREATE PAGE */
    public function create()
    {
        return view(
            'admin.modules.assessment_forms_management.learning_program_assessment_forms_add'
        );
    }

    /* STORE */
    public function store(Request $request)
    {
    $validator = Validator::make(

        $request->all(),

        [

            'form_name' =>
                'required|string|max:255|unique:learning_program_assessment_forms,form_name',

            'form_slug' =>
                'nullable|string|max:255|unique:learning_program_assessment_forms,form_slug',

            'assessment_type' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'category' => [
                Rule::requiredIf($request->assessment_type !== 'general'),
                'nullable',
                'in:full_length,sectional'
            ],

            'sections' => [
                Rule::requiredIf($request->assessment_type !== 'general'),
                'array',
                'min:1'
            ],

            'sections.*' =>
                'in:reading,thinking,reasoning,writing,logic',

            'status' =>
                'required|boolean',

            'passages' =>
                'nullable|array',
            'diagnostic_assessment' => 'required',
        ]
    );

    /* GENERATE SLUG */

    $formSlug = !empty($request->form_slug)

        ? Str::slug($request->form_slug)

        : Str::slug($request->form_name);

    /* CHECK GENERATED SLUG UNIQUE */

    $slugExists =
        LearningProgramAssessmentForm::where(
            'form_slug',
            $formSlug
        )->exists();

    if ($slugExists) {

        return response()->json([

            'success' => false,

            'errors' => [

                'form_name' => [
                    'Form name already exists'
                ],

                'form_slug' => [
                    'Generated slug already exists'
                ]
            ]

        ], 422);
    }

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'errors' => $validator->errors(),

        ], 422);
    }

    /* PASSAGES */

    $passages = [];

    if (
        $request->assessment_type !== 'general' &&
        in_array('reading', $request->sections ?? [])
    ) {

        if (!empty($request->passages)) {

            foreach ($request->passages as $passage) {

                if (
                    empty($passage['passage_text'])
                ) {
                    continue;
                }

                $passages[] = [

                    'passage_no' =>
                        $passage['passage_no'] ?? null,

                    'question_count' =>
                        $passage['question_count'] ?? 0,

                    'passage_text' =>
                        $passage['passage_text'] ?? '',
                ];
            }
        }
    }

    /* SAVE */

    LearningProgramAssessmentForm::create([

        'form_name' =>
            $request->form_name,

        'assessment_type' =>
            $request->assessment_type,

        'diagnostic_assessment' => $request->diagnostic_assessment,

        'form_slug' =>
            $formSlug,

        'description' =>
            $request->description,

        'category' =>
            $request->assessment_type === 'general'
                ? null
                : $request->category,

        'sections' =>
                $request->assessment_type === 'general'
                ? null
                : $request->sections,

        'passage_count' =>
            count($passages),

        'passages' =>
            !empty($passages)
                ? $passages
                : null,

        'status' =>
            $request->status,
    ]);

    return response()->json([

        'success' => true,

        'message' =>
            'Assessment form created successfully',
    ]);
}

    /*  VIEW*/
    public function show($id)
    {
        $form =
            LearningProgramAssessmentForm::with('questions')
                ->find($id);

        if (!$form) {

            return back()->with(
                'error',
                'Assessment form not found'
            );
        }

        return view(
            'admin.modules.assessment_forms_management.learning_program_assessment_forms_view',
            compact('form')
        );
    }

    /*  DELETE */
    public function destroy($id)
    {
        $form =
            LearningProgramAssessmentForm::find($id);

        if (!$form) {

            return back()->with(
                'error',
                'Assessment form not found'
            );
        }

        $form->delete();

        return back()->with(
            'success',
            'Assessment form deleted successfully'
        );
    }

    /* ACTIVE */
    public function active($id)
    {
        $form =
            LearningProgramAssessmentForm::find($id);

        if (!$form) {

            return back()->with(
                'error',
                'Assessment form not found'
            );
        }

        $form->update([
            'status' => true
        ]);

        return back()->with(
            'success',
            'Assessment form activated successfully'
        );
    }

    /* INACTIVE */
    public function inactive($id)
    {
        $form =
            LearningProgramAssessmentForm::find($id);

        if (!$form) {

            return back()->with(
                'error',
                'Assessment form not found'
            );
        }

        $form->update([
            'status' => false
        ]);

        return back()->with(
            'success',
            'Assessment form deactivated successfully'
        );
    }

    /* UPDATE  */
    public function update(Request $request)
    {

    $validator = Validator::make(

        $request->all(),

        [

            'form_id' =>
                'required|exists:learning_program_assessment_forms,id',

            'form_name' =>
                'required|string|max:255|unique:learning_program_assessment_forms,form_name,' . $request->form_id,
            
            'diagnostic_assessment' => 'required',

            'assessment_type' =>
                'required|string|max:255',

            'form_slug' =>
                'nullable|string|max:255|unique:learning_program_assessment_forms,form_slug,' . $request->form_id,

            'description' =>
                'nullable|string',

            'category' => [
                Rule::requiredIf($request->assessment_type !== 'general'),
                    'nullable',
                    'in:full_length,sectional'
                ],

            'sections' => [
                Rule::requiredIf($request->assessment_type !== 'general'),
                'array',
                'min:1'
            ],

            'sections.*' =>
                'in:reading,thinking,reasoning,writing,logic',

            'status' =>
                'required|boolean',

            'passages' =>
                'nullable|array',
            
            'diagnostic_assessment' => 'required',
        ]
    );

    if ($validator->fails()) {

        return response()->json([

            'success' => false,

            'errors' => $validator->errors(),

        ], 422);
    }


    $form =
        LearningProgramAssessmentForm::find(
            $request->form_id
        );

    if (!$form) {

        return response()->json([

            'success' => false,

            'message' =>
                'Assessment form not found'

        ], 404);
    }


    $formSlug = !empty($request->form_slug)

        ? Str::slug($request->form_slug)

        : Str::slug($request->form_name);

    $slugExists =
        LearningProgramAssessmentForm::where(
            'form_slug',
            $formSlug
        )
        ->where(
            'id',
            '!=',
            $request->form_id
        )
        ->exists();

    if ($slugExists) {

        return response()->json([

            'success' => false,

            'errors' => [

                'form_name' => [
                    'Form name already exists'
                ],

                'form_slug' => [
                    'Generated slug already exists'
                ]
            ]

        ], 422);
    }

    $passages = [];

    if (
        $request->assessment_type !== 'general' &&
        in_array('reading', $request->sections ?? [])
    ) {

        if (!empty($request->passages)) {

            foreach ($request->passages as $passage) {

                if (
                    empty($passage['passage_text'])
                ) {
                    continue;
                }

                $passages[] = [

                    'passage_no' =>
                        $passage['passage_no'] ?? null,

                    'question_count' =>
                        $passage['question_count'] ?? 0,

                    'passage_text' =>
                        $passage['passage_text'] ?? '',
                ];
            }
        }
    }

    $form->update([

        'form_name' =>
            $request->form_name,

        'assessment_type' =>
            $request->assessment_type,

        'form_slug' =>
            $formSlug,

        'description' =>
            $request->description,

        'category' =>
            $request->assessment_type === 'general'
                ? null
                : $request->category,

        'sections' =>
                $request->assessment_type === 'general'
                ? null
                : $request->sections,

        'passage_count' =>
            count($passages),

        'passages' =>
            !empty($passages)
                ? $passages
                : null,

        'status' =>
            $request->status,
            
        'diagnostic_assessment' => $request->diagnostic_assessment,
    ]);

    return response()->json([

        'success' => true,

        'message' =>
            'Assessment form updated successfully',
    ]);
}
}