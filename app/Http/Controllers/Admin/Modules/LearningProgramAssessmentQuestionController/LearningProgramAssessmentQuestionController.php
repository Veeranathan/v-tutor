<?php

namespace App\Http\Controllers\Admin\Modules\LearningProgramAssessmentQuestionController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LearningProgramAssessmentQuestion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\LearningProgramAssessmentForm;

class LearningProgramAssessmentQuestionController extends Controller
{
    /* ===========================
       LIST PAGE
    ============================ */
    public function index()
    {
       $forms = LearningProgramAssessmentForm::where('status', 1)
        ->orderBy('form_name')
        ->get();

        return view(
            'admin.modules.assessment_questions_management.learning_program_assessment_questions_list',
            compact('forms')
        );
    }

    /* DATATABLES AJAX LIST */
    public function list(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);

        $query = LearningProgramAssessmentQuestion::with('form');

        // Filters
        if ($request->filled('form_id')) {
            $query->where('form_id', $request->form_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('assessment_type')) {
            $query->where('assessment_type',$request->assessment_type);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }


        $recordsTotal    = LearningProgramAssessmentQuestion::count();
        $recordsFiltered = $query->count();

        $questions = $query
            ->orderBy('id', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $data = [];

        foreach ($questions as $q) {
            $data[] = [
                'id'           => $q->id,
                'form_name' => optional($q->form)->form_name ?? '-',
                'assessment_type' => optional($q->form)->assessment_type ?? '-',
                'type'         => ucfirst($q->type),
                'section'      => $q->section,
                'question'     => Str::limit($q->question, 120),
                'question_type'=> $q->question_type,
                'options'      => $q->options ? implode(', ', $q->options) : '',
                'order'        => $q->order,
                'status'       => $q->status,

                // Action URLs
                'view_url'          => route('learning.assessment.questions.view', $q->id),
                'delete_url'        => route('learning.assessment.questions.delete', $q->id),
                'status_toggle_url' => $q->status
                    ? route('learning.assessment.questions.inactive', $q->id)
                    : route('learning.assessment.questions.active', $q->id),
            ];
        }

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ]);
    }

    /* CREATE PAGE  */
    public function create()
    {
        $forms = LearningProgramAssessmentForm::where('status', 1)
        ->orderBy('form_name')
        ->get();

        return view(
            'admin.modules.assessment_questions_management.learning_program_assessment_questions_add',
            compact('forms')
        );
       }

    /* STORE NEW QUESTION */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

        /* BASIC */
        'form_id' => 'required|exists:learning_program_assessment_forms,id',
        'type'            => 'required|in:qualitative,quantitative,primary',
        'question'        => 'required|string',
        'question_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'question_type'   => 'required|in:choose_best,text',
        'status'          => 'required|boolean',
        'diagnostic_assessment' => 'required|boolean',
        'section' => 'required|string',
        'passage_no' => [
            'nullable',
            'integer',
            'min:1',
            Rule::requiredIf(
            $request->section === 'reading'
        )
        ],
        'grade' => [
            Rule::requiredIf(function () use ($request) {
                return $request->boolean('diagnostic_assessment');
            }),
            'nullable',
            'string'
        ],

        /* OPTIONS */
        'options' => 'nullable|array|max:5',

        /* MARKS */
        'marks' => [
            'nullable',
            'numeric',
            'min:0',
            Rule::requiredIf(
                $request->type === 'quantitative'
            )
        ],

    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    /* PREPARE OPTIONS */
    $options = array_values(array_filter($request->options ?? []));

    /* VALIDATE MIN OPTIONS (MCQ) */
    if (
        $request->question_type === 'choose_best' &&
        count($options) < 2
    ) {
        return response()->json([
            'success' => false,
            'message' => 'At least 2 options required'
        ], 422);
    }

    /* RESOLVE CORRECT ANSWER TEXT */
    $correctAnswerText = null;

    if (
        $request->type === 'quantitative' &&
        $request->question_type === 'choose_best' &&
        $request->correct_answer !== null
    ) {
        $index = (int) $request->correct_answer - 1;

        if (isset($options[$index])) {
            $correctAnswerText = $options[$index];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid correct answer selection'
            ], 422);
        }
    }

    $imageName = null;

    if ($request->hasFile('question_image')) {
        $image = $request->file('question_image');
        $imageName =
        time() . '-' . Str::random(6) . '.'
        . $image->getClientOriginalExtension();
        $image->move(
        'storage/assessment_question_images/',
        $imageName
     );
    }

    $form = LearningProgramAssessmentForm::find($request->form_id);

    /* SAVE  */
    $question = new LearningProgramAssessmentQuestion();

    $question->form_id         = $request->form_id;
    $question->assessment_type = $form->assessment_type;
    $question->type            = $request->type;
    $question->diagnostic_assessment = $request->boolean('diagnostic_assessment');
    $question->grade = $request->boolean('diagnostic_assessment')
        ? $request->grade
        : null;
    $question->subject = null;
    $question->question        = $request->question;
    $question->question_image = $imageName;
    $question->question_type   = $request->question_type;
    $question->options         = !empty($options) ? $options : null;
    $question->order           = $request->order ?? 0;
    $question->status          = $request->status;
    $question->answer          = $correctAnswerText;
    $question->question_mark   = $request->marks;
    $question->section = $request->section;
    $question->passage_no = $request->section === 'reading'
        ? $request->passage_no
        : null;

    $question->save();

    return response()->json([
        'success' => true,
        'message' => 'Question added successfully'
    ]);
}

    /* ===========================
       VIEW QUESTION
    ============================ */
    public function show($id)
    {
        $question = LearningProgramAssessmentQuestion::find($id);

       
        $forms = LearningProgramAssessmentForm::where('status', 1)
        ->orderBy('form_name')
        ->get();

        return view(
            'admin.modules.assessment_questions_management.learning_program_assessment_questions_view',
            compact('question', 'forms')
        );
    }

    /* UPDATE QUESTION */
    public function update(Request $request)
    {
       $form = LearningProgramAssessmentForm::findOrFail(
        $request->form_id
        );

        $rules = [

            'question_id' => 'required|exists:learning_program_assessment_questions,id',
            'form_id' => 'required|exists:learning_program_assessment_forms,id',
            'type' => 'required|in:qualitative,quantitative',
            'question' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'question_type' => 'required|in:choose_best,text',
            'status' => 'required|boolean',
            'diagnostic_assessment' => 'required|boolean',
            'section' => 'required|string',
            'passage_no' => [
                'nullable',
                'integer',
                'min:1',
                Rule::requiredIf($request->section === 'reading')
            ],
            'grade' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->boolean('diagnostic_assessment');
                }),
                'nullable',
                'string'
            ],
            'marks' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf($request->type === 'quantitative')
            ],
        ];

    if ($form->assessment_type === 'general') {

        $rules['grade'] = 'required|string';
        $rules['subject'] = 'required|string';

    } else {

        $rules['section'] = 'required|string';
    }

    $validator = Validator::make(
        $request->all(),
        $rules
    );

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    $question = LearningProgramAssessmentQuestion::findOrFail($request->question_id);

    /* PREPARE OPTIONS */
    $options = array_values(array_filter($request->options ?? []));

    /* VALIDATE MIN OPTIONS (MCQ) */
    if (
        $request->question_type === 'choose_best' &&
        count($options) < 2
    ) {
        return response()->json([
            'success' => false,
            'message' => 'At least 2 options required'
        ], 422);
    }

    /* RESOLVE CORRECT ANSWER TEXT*/
    $correctAnswerText = null;

    if (
        $request->type === 'quantitative' &&
        $request->question_type === 'choose_best' &&
        $request->correct_answer !== null
    ) {
        $index = (int) $request->correct_answer - 1;

        if (isset($options[$index])) {
            $correctAnswerText = $options[$index];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid correct answer selection'
            ], 422);
        }
    }

    $imageName = $question->question_image;

    // Remove image
    if ($request->remove_question_image == 1 && $question->question_image) {

        $oldImage = public_path(
            'storage/assessment_question_images/' . $question->question_image
        );

    if (file_exists($oldImage)) {
        unlink($oldImage);
    }

        $imageName = null;
    }

    // Upload new image
    if ($request->hasFile('question_image')) {

        if ($question->question_image) {

            $oldImage = public_path(
                'storage/assessment_question_images/' . $question->question_image
            );

            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }

        $image = $request->file('question_image');

        $imageName = time() . '-' . Str::random(6) . '.' .
                 $image->getClientOriginalExtension();

        $image->move(
            public_path('storage/assessment_question_images'),
            $imageName
        );
    }

    $form = LearningProgramAssessmentForm::find($request->form_id);

    /* UPDATE */
    $question->update([

        'form_id'         => $request->form_id,
        'assessment_type' => $form->assessment_type,
        'type'            => $request->type,
        'question'        => $request->question,
        'question_image'  => $imageName,
        'question_type'   => $request->question_type,
        'options'         => !empty($options) ? $options : null,
        'order'           => $request->order ?? 0,
        'status'          => $request->status,
        'answer'          => $correctAnswerText,
        'question_mark'   => $request->marks,
        'diagnostic_assessment' => $request->boolean('diagnostic_assessment'),
        'grade' => $request->boolean('diagnostic_assessment')
            ? $request->grade
            : null,
        'subject' => null,
        'section' => $request->section,
        'passage_no' => $request->section === 'reading'
            ? $request->passage_no
            : null,
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Question updated successfully'
    ]);
}   

    /* DELETE QUESTION */
    public function destroy($id)
    {
        $question = LearningProgramAssessmentQuestion::find($id);

        if (!$question) {
            return back()->with('error', 'Question not found');
        }

        $imagePath = 'storage/assessment_question_images/' .$question->question_image;

        if ($question->question_image && file_exists($imagePath)) 
            {
                unlink($imagePath);
            }

        $question->delete();

        return back()->with('success', 'Question deleted successfully');
    }

    /* ACTIVATE QUESTION */
    public function active($id)
    {
        $question = LearningProgramAssessmentQuestion::find($id);

        if (!$question) {
            return back()->with('error', 'Question not found');
        }

        $question->update(['status' => true]);

        return back()->with('success', 'Question activated successfully');
    }

    /* DEACTIVATE QUESTION */
    public function inactive($id)
    {
        $question = LearningProgramAssessmentQuestion::find($id);

        if (!$question) {
            return back()->with('error', 'Question not found');
        }

        $question->update(['status' => false]);

        return back()->with('success', 'Question deactivated successfully');
    }
}

