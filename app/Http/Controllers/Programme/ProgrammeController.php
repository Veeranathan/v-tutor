<?php

namespace App\Http\Controllers\Programme;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programme;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\ProgrammeSignupMail;
use App\Models\LearningProgramAssessment;
use App\Models\LearningProgramAssessmentQuestion;
use App\Models\LearningProgramAssessmentForm;
use App\Mail\AssessmentMail;
use App\Mail\BookFreeAssessmentMail;
use App\Mail\AssessmentOtpMail;
use App\Models\MyAssessment;
use App\Models\Branch;
use Illuminate\Support\Str;
use App\Jobs\SendAssessmentReportJob;


class ProgrammeController extends Controller
{
    public function store(Request $request)
    {
          $request->validate([
                'parent_name'   => 'required|string|max:255',
                'email'         => 'required|email|unique:programmes,email',
                'student_name'  => 'required|string|max:255',
                'student_grade' => 'required|string',
                'ref_source'    => 'required|string',
                'programs'      => 'required|array|min:1',
                'terms'         => 'required',
                ], [
                    'email.unique' => 'The user email is already registered.',
            ]);

        Programme::create([
            'parent_name'   => $request->parent_name,
            'email'         => $request->email,
            'student_name'  => $request->student_name,
            'student_grade' => $request->student_grade,
            'ref_source'    => $request->ref_source,
            'subscribe'     => $request->subscribe ? 1 : 0,
            'programs'      => $request->programs,
            'terms_agreed'  => 1,
        ]);

        // Send Email Confirmation
        $data = [
            'parent_name' => $request->parent_name,
            'email'       => $request->email,
            'programs'    => $request->programs,
        ];

        try {
            Mail::send(new ProgrammeSignupMail($data));
        } catch (\Exception $e) {
            Log::error("Programme Signup Mail Error: ".$e->getMessage());
        }

            return response()->json(['success' => true]);
    }

    public function holidayProgramme()
    {
        return view('programme.holiday_programme');
    }

    public function programmeSignup()
    {
        return view('programme.programme_signup');
    }

    public function assessmentAvailability()
    {
        return view('programme.assessment_availability');
    }

    public function learningProgramAssessment()
    {
       $branches = Branch::where('status', 'A')
        ->select('id', 'branch_name', 'slug','capture_code')
        ->orderBy('branch_name')
        ->get();

    return view('programme.learning_programme_assessment', compact('branches'));
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $exists = \App\Models\Programme::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json(['exists' => true, 'message' => 'This email is already registered.']);
        }

        return response()->json(['exists' => false]);
    }

    public function storeProgramLearningAssessment(Request $request)
    {
    /* -----------------------------
       VALIDATION
    ------------------------------*/
    $request->validate([
        'assessment_for' => 'required|in:me,child',
        'visit_reason'   => 'required|string|max:255',
        'school_year'    => 'required|string|max:100',
        'grade'          => 'required|string|max:100',
        'state'          => 'nullable|string|max:100',
        'subject'        => 'required|string|max:255',
        'free_time'      => 'nullable|string|max:255',
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'email'          => 'required|email',
    ]);

    /* -----------------------------
       TERMS / PRIVACY LOGIC 
    ------------------------------*/
    $termsAgreed = (
        $request->boolean('terms_agreed') ||
        $request->boolean('privacy_agreed')
    ) ? 1 : 0;

    /* -----------------------------
    NORMALIZE SUBJECT (FIX)
    ------------------------------*/
    $subjectMap = [
        'English' => 'english',
        'Mathematics' => 'maths',
        'Science' => 'science',
        'Languages' => 'languages',
        'Humanities and Social Sciences (HASS)' => 'humanities and social sciences (hass)',
        'Technologies' => 'technologies',
    ];

    // fallback safety
    $normalizedSubject = $subjectMap[$request->subject] ?? strtolower($request->subject);
    
    $assessmentToken = (string) Str::uuid();

    /* -----------------------------
       STORE DATA (FIX IS HERE )
    ------------------------------*/
    $assessment = LearningProgramAssessment::create([
        'assessment_for' => $request->assessment_for,
        'visit_reason'   => $request->visit_reason,
        'school_year'    => $request->school_year,
        'grade'          => $request->grade,
        'state'          => $request->state,
        'subject'        => $normalizedSubject,
        'learning_need'  => $request->learning_need,
        'free_time'      => $request->free_time,
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'email'          => $request->email,
        'phone'          => $request->phone,
        'terms_agreed'   => $termsAgreed, 
        'country_code'   => $request->country_code,
        'source'         => $request->source ?? 'direct',
        'ip_address'     => $request->ip(),
        'user_agent'     => $request->userAgent(),
        'token'          => $assessmentToken,
    ]);


    // Send email ONLY for free assessment
    if ($request->visit_reason === 'free_assessment') {
        try {
            Mail::send(new AssessmentMail($assessment));
        } catch (\Exception $e) {
            Log::error("Assessment register Mail Error: " . $e->getMessage());
        }
    }

    /* -----------------------------
       RESPONSE
    ------------------------------*/
    return response()->json([
        'success' => true,
        'assessment_id' => $assessment->id,
        'data' => [
            'first_name'  => $assessment->first_name,
            'school_year' => $assessment->school_year,
            'subject'     => $assessment->subject,
        ],
        'message' => 'Assessment submitted successfully'
    ]);
    }
    
    public function showOtpForm(string $token)
    {
        return view('programme.otp_student_my_assessment', compact('token'));
    }

   
    public function startMainAssessment(string $token)
    {
    // Middleware validated token + OTP
    $assessment = LearningProgramAssessment::where('token', $token)
        ->firstOrFail();

    // Fetch existing draft from DB
    $myAssessment = MyAssessment::where('learning_program_assessment_id', $assessment->id)->first();

    /*
    |--------------------------------------------------------------------------
    | PARSE SAVED QUALITATIVE ANSWERS
    |--------------------------------------------------------------------------
    */
    $rawQualitative = $myAssessment?->qualitative_answers;
    if (is_string($rawQualitative)) {
        $rawQualitative = json_decode($rawQualitative, true) ?? [];
    }

    // Map array index positions to expected Blade keys
    $savedQualitative = [
        'qualitative_answer_step2'  => $rawQualitative[0]['answer'] ?? '',
        'qualitative_comment_step2' => $rawQualitative[0]['comment'] ?? '',
        'qualitative_answer_step3'  => $rawQualitative[1]['answer'] ?? '',
        'qualitative_comment_step3' => $rawQualitative[1]['comment'] ?? '',
        'qualitative_answer_step4'  => $rawQualitative[2]['answer'] ?? '',
        'qualitative_comment_step4' => $rawQualitative[2]['comment'] ?? '',
        'strengths'                 => $rawQualitative[3]['answer'] ?? '',
        'challenges'                => $rawQualitative[4]['answer'] ?? '',
        'areas_to_improve'          => $rawQualitative[5]['answer'] ?? '',
    ];

    /*
    |--------------------------------------------------------------------------
    | PARSE SAVED QUANTITATIVE ANSWERS
    |--------------------------------------------------------------------------
    */
    $rawQuantitative = $myAssessment?->quantitative_answers;
    if (is_string($rawQuantitative)) {
        $rawQuantitative = json_decode($rawQuantitative, true) ?? [];
    } elseif (is_object($rawQuantitative)) {
        $rawQuantitative = json_decode(json_encode($rawQuantitative), true) ?? [];
    }

    $answersList = $rawQuantitative['answers'] ?? [];
    $savedQuantitative = [];

    // Map into key-value map: [ question_id => selected_answer ]
    foreach ($answersList as $item) {
        if (!empty($item['question_id'])) {
            $savedQuantitative[$item['question_id']] = $item['selected_answer'] ?? '';
        }
    }

    $subject = $assessment->subject;
    $grade = $assessment->grade;

    /* FETCH QUESTIONS & FORM */
    $form = null;

    if ($assessment->source === 'direct' && !empty($assessment->form_slug)) {
        $form = LearningProgramAssessmentForm::where('form_slug', $assessment->form_slug)
            ->where('status', 1)
            ->first();
    }

    if ($assessment->source === 'direct' && $form && !$form->diagnostic_assessment) {
        // Direct Non-Diagnostic Flow
        $questions = LearningProgramAssessmentQuestion::where('form_id', $form->id)
            ->where('diagnostic_assessment', false)
            ->where('status', 1)
            ->orderBy('order', 'asc')
            ->get();
    } else {
        // Standard Diagnostic Flow
        $questions = LearningProgramAssessmentQuestion::where('diagnostic_assessment', true)
            ->where('status', 1)
            ->where('grade', $grade)
            ->orderBy('order', 'asc')
            ->get();

        // Only assign form if $form was not already loaded
        if (!$form) {
            $formId = $questions->first()?->form_id;
            $form = LearningProgramAssessmentForm::find($formId);
        }
    }

    $formName = $form?->form_name ?? 'Assessment';

    /*
    |--------------------------------------------------------------------------
    | QUALITATIVE
    |--------------------------------------------------------------------------
    */

    $qualitativeQuestions = $questions
        ->where('type', 'qualitative')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | QUANTITATIVE SECTIONS
    |--------------------------------------------------------------------------
    */

    $reading = $questions
        ->where('type', 'quantitative')
        ->where('section', 'reading')
        ->values();

    $reasoning = $questions
        ->where('type', 'quantitative')
        ->where('section', 'reasoning')
        ->values();

    $thinking = $questions
        ->where('type', 'quantitative')
        ->where('section', 'thinking')
        ->values();

    $logic = $questions
        ->where('type', 'quantitative')
        ->where('section', 'logic')
        ->values();

    $writing = $questions
        ->where('type', 'quantitative')
        ->where('section', 'writing')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | QUANTITATIVE AVAILABILITY CHECK
    |--------------------------------------------------------------------------
    */

    $hasQuantitative = $reading->isNotEmpty() 
        || $reasoning->isNotEmpty() 
        || $thinking->isNotEmpty() 
        || $logic->isNotEmpty() 
        || $writing->isNotEmpty();

    if (!$hasQuantitative) {
        return redirect()->route('assessment.availability')->with('error', 'This assessment is not yet available.');
    }

    /*
    |--------------------------------------------------------------------------
    | READING PASSAGES
    |--------------------------------------------------------------------------
    */

    $readingPassages = [];
    $qNumber = 1;

    if ($form && !empty($form->passages)) {
        foreach ($form->passages as $index => $passage) {
            $passageQuestions = $reading
                ->where('passage_no', $index + 1)
                ->values();

            $readingPassages[] = [
                'text' => $passage['passage_text'] ?? '',
                'questions' => $passageQuestions,
                'start_q' => $qNumber,
                'end_q' => $qNumber + $passageQuestions->count() - 1,
            ];

            $qNumber += $passageQuestions->count();
        }
    } else {
        $readingPassages[] = [
            'text' => '',
            'questions' => $reading,
            'start_q' => 1,
            'end_q' => $reading->count(),
        ];
    }

    $termAgreed = (bool) ($myAssessment?->terms_agreed ?? false);

    return view('programme.student_my_assessment', [
        'termAgreed'         => $termAgreed,
        'savedQualitative'  => $savedQualitative,
        'savedQuantitative' => $savedQuantitative,
        'assessment'        => $assessment,
        'formName'          => $formName,
        'subject'           => $subject,
        'token'             => $token,
        'qualitativeQuestions' => $qualitativeQuestions,
        'readingPassages'   => $readingPassages,
        'reading'           => $reading,
        'reasoning'         => $reasoning,
        'thinking'          => $thinking,
        'logic'             => $logic,
        'writing'           => $writing,
        'hasReading'        => $reading->count() > 0,
        'hasReasoning'      => $reasoning->count() > 0,
        'hasThinking'       => $thinking->count() > 0,
        'hasLogic'          => $logic->count() > 0,
        'hasWriting'        => $writing->count() > 0,
    ]);
}
    public function assessmentEmailRedirect(string $token)
    {
        $assessment = LearningProgramAssessment::where('token', $token)->first();

        if (!$assessment) {
            abort(403, 'Invalid or expired assessment link');
        }

        /**
        * OTP already verified
        * Allow direct access only within 24 hours
        */
        if ($assessment->otp_verified_at) {

            if ($assessment->otp_verified_at->addHours(24)->gte(now())) {
                return redirect()->route('program.assessment.start', $token);
            }

            // 24 hours expired -> Force re-verification
            $assessment->update([
                'otp_verified_at' => null,
            ]);
        }

       
        // CHECK IF EXISTING OTP IS STILL VALID (15-MINUTE OTP WINDOW)
        if ($assessment->otp_expires && $assessment->otp_expires->isFuture()) {
            return redirect()->route('program.assessment.otp', $token);
        }

        /**
        * GENERATE NEW OTP (EXPIRES IN 15 MINUTES)
        */
        $otp = random_int(100000, 999999);

        $assessment->update([
            'otp' => $otp,
            'otp_expires' => now()->addMinutes(15),
        ]);

        // Send OTP email
        try {
            Mail::send(new AssessmentOtpMail($assessment));
        } catch (\Exception $e) {
            Log::error("Assessment OTP Mail Error: " . $e->getMessage());
        }

        return redirect()->route('program.assessment.otp', $token);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'otp'   => 'required|digits:6',
        ]);

        $assessment = LearningProgramAssessment::where('token', $request->token)->first();

        // Invalid or expired OTP
        if (
            !$assessment ||
            is_null($assessment->otp) ||
            is_null($assessment->otp_expires) ||
            now()->gt($assessment->otp_expires) ||
            (string) $assessment->otp !== (string) $request->otp
            ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ], 422);
        }

        // Mark verified & clear OTP
        $assessment->update([
            'otp_verified_at' => now(),
            'otp'             => null,
            'otp_expires'     => null,
        ]);

        return response()->json([
            'success'  => true,
            'redirect' => route('program.assessment.start', $assessment->token)
        ]);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $assessment = LearningProgramAssessment::where('token', $request->token)->first();

        if (!$assessment) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid assessment link.'
            ], 404);
        }

        // Generate new OTP (valid for 15 minutes)
        $otp = random_int(100000, 999999);

        $assessment->update([
            'otp'         => $otp,
            'otp_expires' => now()->addMinutes(15),
        ]);

        // Send OTP email
        try {
            Mail::send(new AssessmentOtpMail($assessment));
        } catch (\Exception $e) {
        Log::error("Assessment OTP Resend Mail Error: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to send OTP email. Please try again.'
        ], 500);
        }

        return response()->json([
        'success' => true,
        'message' => 'A new OTP has been sent to your email address.'
        ]);
    }
    
    public function saveAssessmentDraft(Request $request)
    {
    $request->validate([
        'learning_program_assessment_id' => 'required|exists:learning_program_assessments,id',
        'assessment_form_name'           => 'nullable|string',
        'terms_agreed'                   => 'nullable|boolean',
        'qualitative_answers'            => 'nullable|array',
        'quantitative_answers'           => 'nullable|array',
    ]);

    $totalMarks = 0;
    $obtainedMarks = 0;

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUANTITATIVE QUESTIONS (SAME AS SUBMIT)
    |--------------------------------------------------------------------------
    */
    $quantitativeProcessed = [];

    $sectionMarks = [
        'reading'   => ['total_marks' => 0, 'obtained_marks' => 0, 'answers' => []],
        'reasoning' => ['total_marks' => 0, 'obtained_marks' => 0, 'answers' => []],
        'thinking'  => ['total_marks' => 0, 'obtained_marks' => 0, 'answers' => []],
        'logic'     => ['total_marks' => 0, 'obtained_marks' => 0, 'answers' => []],
        'writing'   => ['total_marks' => 0, 'obtained_marks' => 0, 'answers' => []],
    ];

    $quantitativeAnswers = $request->quantitative_answers ?? [];

    foreach ($quantitativeAnswers as $answer) {

        if (empty($answer['question_id'])) {
            continue;
        }

        $question = \App\Models\LearningProgramAssessmentQuestion::find($answer['question_id']);

        if (!$question) {
            continue;
        }

        $correctAnswer  = $question->answer;
        $questionMark   = (int) ($question->question_mark ?? 0);
        $selectedAnswer = $answer['selected_answer'] ?? null;

        if ($question->question_type === 'text') {
            $answerData = [
                'question_id'     => $question->id,
                'question'        => $question->question,
                'question_type'   => 'text',
                'selected_answer' => $selectedAnswer,
                'section'         => $question->section,
            ];

            $quantitativeProcessed[] = $answerData;
            $section = strtolower($question->section);

            if (isset($sectionMarks[$section])) {
                $sectionMarks[$section]['answers'][] = $answerData;
            }

            continue;
        }

        $isCorrect   = ($selectedAnswer !== null && $selectedAnswer === $correctAnswer);
        $awardedMark = $isCorrect ? $questionMark : 0;
        
        $totalMarks    += $questionMark;
        $obtainedMarks += $awardedMark;

        $answerData = [
            'question_id'     => $question->id,
            'question'        => $question->question,
            'question_type'   => $question->question_type,
            'selected_answer' => $selectedAnswer,
            'correct_answer'  => $correctAnswer,
            'question_mark'   => $questionMark,
            'awarded_mark'    => $awardedMark,
            'is_correct'      => $isCorrect,
            'section'         => $question->section,
        ];

        $quantitativeProcessed[] = $answerData;
        $section = strtolower($question->section);

        if (isset($sectionMarks[$section])) {
            $sectionMarks[$section]['total_marks'] += $questionMark;

            if ($isCorrect) {
                $sectionMarks[$section]['obtained_marks'] += $questionMark;
            }

            $sectionMarks[$section]['answers'][] = $answerData;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUALITATIVE QUESTIONS
    |--------------------------------------------------------------------------
    */
    $qualitativeProcessed = [];
    $qualitativeAnswers   = $request->qualitative_answers ?? [];

    foreach ($qualitativeAnswers as $answer) {
        $qualitativeProcessed[] = [
            'step'     => $answer['step'] ?? null,
            'question' => $answer['question'] ?? null,
            'answer'   => $answer['answer'] ?? null,
            'comment'  => $answer['comment'] ?? null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE DRAFT TO MY ASSESSMENT
    |--------------------------------------------------------------------------
    */
    \App\Models\MyAssessment::updateOrCreate(
        [
            'learning_program_assessment_id' => $request->learning_program_assessment_id,
            // 'student_id'                  => Auth::id(), // or 55
        ],
        [
            'assessment_form_name' => $request->assessment_form_name,
            'terms_agreed'         => $request->boolean('terms_agreed'),
            'qualitative_answers'  => $qualitativeProcessed,
            'quantitative_answers' => [
                'answers'        => $quantitativeProcessed,
                'total_marks'    => $totalMarks,
                'obtained_marks' => $obtainedMarks,
                'sections'       => $sectionMarks,
            ],
            'qualitative_submitted'  => false,
            'quantitative_submitted' => false,
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'Draft saved successfully'
    ]);
}

public function submitMainAssessment(Request $request)
{
    $request->validate([
        'learning_program_assessment_id' => 'required|exists:learning_program_assessments,id',
        'terms_agreed'                   => 'nullable|boolean',
        'assessment_form_name' => 'nullable|string',
        'qualitative_answers'  => 'required|array',
        'quantitative_answers' => 'nullable|array',
    ]);

    //$studentId = Auth::id();

    $totalMarks = 0;
    $obtainedMarks = 0;

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUANTITATIVE QUESTIONS
    |--------------------------------------------------------------------------
    */

    $quantitativeProcessed = [];

    $sectionMarks = [
        'reading' => [
            'total_marks' => 0,
            'obtained_marks' => 0,
            'answers' => [],
        ],

        'reasoning' => [
            'total_marks' => 0,
            'obtained_marks' => 0,
            'answers' => [],
        ],

        'thinking' => [
            'total_marks' => 0,
            'obtained_marks' => 0,
            'answers' => [],
        ],

        'logic' => [
            'total_marks' => 0,
            'obtained_marks' => 0,
            'answers' => [],
        ],

        'writing' => [
            'total_marks' => 0,
            'obtained_marks' => 0,
            'answers' => [],
        ],
    ];

    $quantitativeAnswers = $request->quantitative_answers ?? [];
    $hasQuantitative = !empty($quantitativeAnswers);

    foreach ($quantitativeAnswers as $answer) {

        if (empty($answer['question_id'])) {
            continue;
        }

        $question = \App\Models\LearningProgramAssessmentQuestion::find($answer['question_id']);

        if (!$question) {
            continue;
        }

        $correctAnswer = $question->answer;
        $questionMark  = (int) ($question->question_mark ?? 0);

        $selectedAnswer = $answer['selected_answer'] ?? null;

        if ($question->question_type === 'text') {

        $answerData = [
            'question_id'     => $question->id,
            'question'        => $question->question,
            'question_type'   => 'text',
            'selected_answer' => $selectedAnswer,
            'section'         => $question->section,
        ];

        $quantitativeProcessed[] = $answerData;

        $section = strtolower($question->section);

        if (isset($sectionMarks[$section])) {
            $sectionMarks[$section]['answers'][] = $answerData;
        }

        continue;
    }

    $isCorrect = $selectedAnswer === $correctAnswer;
    $awardedMark = $isCorrect ? $questionMark : 0;
        $totalMarks += $questionMark;
        $obtainedMarks += $awardedMark;

        $answerData = [
            'question_id'     => $question->id,
            'question'        => $question->question,
            'question_type'   => $question->question_type,
            'selected_answer' => $selectedAnswer,
            'correct_answer'  => $correctAnswer,
            'question_mark'   => $questionMark,
            'awarded_mark'    => $awardedMark,
            'is_correct'      => $isCorrect,
            'section'         => $question->section,
        ];

        $quantitativeProcessed[] = $answerData;

        $section = strtolower($question->section);

        if (isset($sectionMarks[$section])) {

            $sectionMarks[$section]['total_marks'] += $questionMark;

            if ($isCorrect) {
                $sectionMarks[$section]['obtained_marks'] += $questionMark;
            }

            $sectionMarks[$section]['answers'][] = $answerData;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS QUALITATIVE QUESTIONS
    |--------------------------------------------------------------------------
    */

    $qualitativeProcessed = [];

    foreach ($request->qualitative_answers as $answer) {

        $qualitativeProcessed[] = [
            'step'     => $answer['step'] ?? null,
            'question' => $answer['question'] ?? null,
            'answer'   => $answer['answer'] ?? null,
            'comment'  => $answer['comment'] ?? null,
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
            //'student_id' => $studentId,
            'student_id' => 55,
        ],
        [
            'assessment_form_name' => $request->assessment_form_name,
            'terms_agreed'         => $request->boolean('terms_agreed'),
            'qualitative_answers' => $qualitativeProcessed,

            'quantitative_answers' => [
                'answers'        => $quantitativeProcessed,
                'total_marks'    => $totalMarks,
                'obtained_marks' => $obtainedMarks,
                'sections'       => $sectionMarks,
            ],

            'qualitative_submitted'  => true,
            'quantitative_submitted' => $hasQuantitative,
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | UPDATE ASSESSMENT STATUS
    |--------------------------------------------------------------------------
    */

    \App\Models\LearningProgramAssessment::where(
        'id',
        $request->learning_program_assessment_id
    )
    //->where('student_id', $studentId)
    ->update([
        'status' => \App\Models\LearningProgramAssessment::STATUS_COMPLETED,
        'token'  => null,
    ]);

    // Assessment Report
    SendAssessmentReportJob::dispatch($request->learning_program_assessment_id);

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
            'sections'       => $sectionMarks,
        ]
    ]);
}

public function startAssessment($slug)
{
    $form = LearningProgramAssessmentForm::where('form_slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    // Pass base form shell to blade view
    return view('programme.student_assessment', [
        'form' => $form,
        'type' => $form->form_slug,
    ]);
}
public function fetchDirectAssessmentDraft(Request $request, $type)
{
    $request->validate([
        'parent_name' => 'required|string|max:255',
        'child_name'  => 'required|string|max:255',
       // 'year_level'  => 'required|string',
        'state'       => 'required|string',
        'email'       => 'required|email|max:255',
    ]);

     // Get assessment form using the form slug
    $assessmentForm = LearningProgramAssessmentForm::where('form_slug', $type)
        ->where('status', true)
        ->firstOrFail();

    // Extract year from assessment type, e.g. "year-1" => "Grade 1"
    $grade = null;

    if (preg_match('/^year-(\d+)/', $assessmentForm->assessment_type, $matches)) {
        $grade = 'Grade ' . $matches[1];
    }

    $assessment = LearningProgramAssessment::where('email', $request->email)
        ->where('form_slug', $type)
        ->where('status', LearningProgramAssessment::STATUS_PENDING)
        ->first();

    $token = (string) Str::uuid();

    if ($assessment) {
        $assessment->update([
            'first_name' => $request->parent_name,
            'last_name'  => $request->child_name,
            'grade'      => $grade,
            'state'      => $request->state,
            'token'      => $assessment->token ?: $token,
        ]);
    } else {
        $assessment = LearningProgramAssessment::create([
            'first_name'     => $request->parent_name,
            'last_name'      => $request->child_name,
            'email'          => $request->email,
            'grade'          => $grade,
            'state'          => $request->state,
            'form_slug'      => $type,
            'assessment_for' => 'child',
            'visit_reason'   => $type . '_assessment',
            'status'         => LearningProgramAssessment::STATUS_PENDING,
            'token'          => $token,
            'source'         => 'direct',
            'ip_address'     => $request->ip(),
            'user_agent'     => $request->userAgent(),
        ]);
    }

    return response()->json([
        'success'      => true,
        'redirect_url' => route('program.assessment.email.link', $assessment->token),
    ]);
}
/**
 * Show the email lookup view for continuing an assessment.
 */
public function showResumeForm(string $slug)
{
    $form = LearningProgramAssessmentForm::where('form_slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    return view('programme.resume_assessment', [
        'form' => $form,
        'type' => $slug,
    ]);
}

/**
 * Verify if an existing pending assessment exists for given email + form_slug.
 */
public function checkExistingAssessment(Request $request)
{
    $request->validate([
        'email'     => 'required|email|max:255',
        'form_slug' => 'required|string',
    ]);

    $assessment = LearningProgramAssessment::where('email', $request->email)
        ->where('form_slug', $request->form_slug)
        ->where('status', LearningProgramAssessment::STATUS_PENDING)
        ->first();

    if ($assessment) {
        return response()->json([
            'success'      => true,
            'redirect_url' => route('program.assessment.email.link', $assessment->token),
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'No existing pending assessment found with this email. Please create a new assessment.'
    ], 404);
}
 public function bookassessment()
    {
        $branches = Branch::where('status', 'A')
        ->select('id', 'branch_name', 'slug','capture_code')
        ->orderBy('branch_name')
        ->get();

        return view('programme.book_assessment', compact('branches'));
    }

 public function submitBookFreeAssessment(Request $request)
{

    $request->validate([
        'parent_name' => 'required|string|max:255',
        'child_name'  => 'required|string|max:255',
        'email'      => 'required|email|max:255',
        'year_level' => 'required|string|max:50',
        'state'      => 'required|string|max:50',
        // 'subject'    => 'required|string|max:100',
    ]);

    $assessmentToken = (string) Str::uuid();

    $assessment = LearningProgramAssessment::create([
        'first_name'     => $request->parent_name,
        'last_name'      => $request->child_name,
        'email'          => $request->email,
        'assessment_for' => null,
        'visit_reason'   => 'book_free_assessment',
        'status'         => LearningProgramAssessment::STATUS_PENDING,
        'grade'          => $request->year_level,
        'subject'        => $request->subject,
        'state'          => $request->state,
        'token'          => $assessmentToken,
    ]);


    MyAssessment::create([
        'learning_program_assessment_id' => $assessment->id,
        'student_id' => 55,

        'oc_answers' => null,
        'qualitative_answers'   => null,
        'quantitative_answers'  => null,

        'oc_submitted'          => false,
        'qualitative_submitted' => false,
        'quantitative_submitted'=> false,
    ]);

    try {
      //  Mail::send(new BookFreeAssessmentMail($assessment));
        Mail::send(new AssessmentMail($assessment));
    } catch (\Exception $e) {
        Log::error("Book Free Assessment Mail Error: " . $e->getMessage());
    }

    return response()->json([
    'success' => true,
    'message' => 'Assessment booked successfully!'
]);
}
}
