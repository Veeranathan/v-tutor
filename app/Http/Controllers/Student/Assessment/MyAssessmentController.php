<?php

namespace App\Http\Controllers\Student\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MyAssessment;
use App\Models\LearningProgramAssessment;
use Illuminate\Support\Facades\Auth;

class MyAssessmentController extends Controller
{
    public function myAssessment()
    {
        return view('student.modules.my_assessment.assessment');
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'learning_program_assessment_id' => 'required|exists:learning_program_assessments,id',
            'qualitative_answers'  => 'required|array',
            'quantitative_answers' => 'required|array',
        ]);

        $studentId = Auth::id();

        $totalMarks = 0;
        $obtainedMarks = 0;

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUANTITATIVE QUESTIONS
    |--------------------------------------------------------------------------
    */
    $quantitativeProcessed = [];

    foreach ($request->quantitative_answers as $answer) {

        $question = \App\Models\LearningProgramAssessmentQuestion::find($answer['question_id']);

        if (!$question) {
            continue;
        }

        // Correct column names
        $correctAnswer = $question->answer;
        $questionMark  = (float) ($question->question_mark ?? 0);

        $selectedAnswer = $answer['selected_answer'] ?? null;
        $isCorrect = $selectedAnswer === $correctAnswer;

        // Calculate marks
        $totalMarks += $questionMark;
        if ($isCorrect) {
            $obtainedMarks += $questionMark;
        }

        $quantitativeProcessed[] = [
            'question_id'     => $question->id,
            'question'        => $question->question,
            'selected_answer' => $selectedAnswer,
            'correct_answer'  => $correctAnswer,
            'question_mark'   => $questionMark,
            'is_correct'      => $isCorrect,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUALITATIVE QUESTIONS
    |--------------------------------------------------------------------------
    */
    $qualitativeProcessed = [];

    foreach ($request->qualitative_answers as $answer) {
        $qualitativeProcessed[] = [
            'question_id' => $answer['question_id'],
            'question'    => $answer['question'],
            'answer'      => $answer['answer'] ?? null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE / UPDATE MY ASSESSMENT
    |--------------------------------------------------------------------------
    */
    \App\Models\MyAssessment::updateOrCreate(
        [
            'learning_program_assessment_id' => $request->learning_program_assessment_id,
            'student_id' => $studentId,
        ],
        [
            'qualitative_answers' => $qualitativeProcessed,
            'quantitative_answers' => [
                'answers'        => $quantitativeProcessed,
                'total_marks'    => $totalMarks,
                'obtained_marks' => $obtainedMarks,
            ],
            'qualitative_submitted'  => true,
            'quantitative_submitted' => true,
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | UPDATE ASSESSMENT STATUS
    |--------------------------------------------------------------------------
    */
    \App\Models\LearningProgramAssessment::where('id', $request->learning_program_assessment_id)
        ->where('student_id', $studentId)
        ->update([
            'status' => \App\Models\LearningProgramAssessment::STATUS_COMPLETED
        ]);

    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */
    return response()->json([
        'success' => true,
        'message' => 'Assessment submitted successfully',
        'result' => [
            'total_marks'    => $totalMarks,
            'obtained_marks' => $obtainedMarks,
        ]
    ]);
}

}
