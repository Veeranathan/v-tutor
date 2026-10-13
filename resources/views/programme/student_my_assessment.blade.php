@extends('layouts.app')

@section('page_title', 'V-Tutor | Learning Program Assessment')

@section('left_part')
    @include('include.header_menu_part')
@endsection

@section('content')

@php
$title = 'Student Diagnostic Assessment';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => false
])

<section class="makes_special_sec faq-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">
                <div class="assessment-box">
                    <form id="assessmentForm" novalidate>
                        @csrf
                        <input type="hidden" name="assessment_form_name" value="{{ $formName }}">
                        <input type="hidden" name="learning_program_assessment_id" value="{{ $assessment->id }}">
                        <input type="hidden" name="token" value="{{ $token }}">
<!-- STEP 1: CONSENT & PRIVACY NOTICE -->
<div id="step1">
    <h4 class="text-center mt-3 fw-bold">Before You Begin</h4>
    <h5 class="text-center mt-2 text-muted">Consent & Privacy Notice</h5>

    <p class="text-muted mt-3">
        To help us provide the most accurate academic feedback and personalised learning recommendations, this assessment collects information provided by you and your child, including qualitative responses and assessment results.
    </p>

    <p class="fw-bold mt-3">By continuing, you confirm that:</p>

    <div class="form-check mb-2">
    <input class="form-check-input consent-check" type="checkbox" id="consent_guardian" {{ !empty($termAgreed) ? 'checked' : '' }} required>
    <label class="form-check-label text-muted" for="consent_guardian">
        I am the parent, legal guardian, or authorised representative of the student.
    </label>
</div>

<div class="form-check mb-2">
    <input class="form-check-input consent-check" type="checkbox" id="consent_data_processing" {{ !empty($termAgreed) ? 'checked' : '' }} required>
    <label class="form-check-label text-muted" for="consent_data_processing">
        I consent to V-Tutor collecting, storing and processing the information provided for the purpose of preparing the Diagnostic Assessment Report and the Academic Feedback & Learning Recommendations Report.
    </label>
</div>

<div class="form-check mb-2">
    <input class="form-check-input consent-check" type="checkbox" id="consent_privacy_handling" {{ !empty($termAgreed) ? 'checked' : '' }} required>
    <label class="form-check-label text-muted" for="consent_privacy_handling">
        I understand that the information collected will be handled in accordance with V-Tutor's Privacy Policy and may be reviewed by authorised Academic Team members to prepare personalised learning recommendations.
    </label>
</div>

<div class="form-check mb-2">
    <input class="form-check-input consent-check" type="checkbox" id="consent_guidance_disclaimer" {{ !empty($termAgreed) ? 'checked' : '' }} required>
    <label class="form-check-label text-muted" for="consent_guidance_disclaimer">
        I acknowledge that this assessment is intended to provide educational guidance only and does not constitute psychological, medical or professional educational diagnosis.
    </label>
</div>

<div class="form-check mb-2">
    <input class="form-check-input consent-check" type="checkbox" id="consent_terms_agree" {{ !empty($termAgreed) ? 'checked' : '' }} required>
    <label class="form-check-label text-muted" for="consent_terms_agree">
        I have read and agree to the V-Tutor Privacy Policy and Terms & Conditions.
    </label>
</div>

    <div class="text-danger mt-2 d-none" id="consentValidationError">
        Please accept all terms and conditions to proceed.
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">Cancel</a>
        <button type="button" class="btn btn-danger btn-sm" onclick="showStep(2)">I Agree</button>
    </div>
</div>

<!-- STEP 2: OVERVIEW (Added style="display:none;" to prevent rendering with Step 1) -->
<div id="step2" style="display:none;">
    <h4 class="text-center mt-3">Student Diagnostic Assessment</h4>

    <p class="text-muted mt-3">
        <strong>Note:</strong> This assessment consists of <strong>three parts: a Qualitative section, a Quantitative section, and an Optional Behavioural Response section.</strong>
    </p>
    <p class="text-muted mt-3">
        <strong>Qualitative Section:</strong> Defines and outlines the general profile of the student, capturing strengths, interests, learning preferences and any relevant background information.
    </p>
    <p class="text-muted mt-3">
        <strong>Quantitative Section:</strong> Provides a numerical evaluation of the student’s academic skills. Common subject areas such as English, Maths, and Science form the basis of this section, with each subject including 5–10 questions or problems to solve.
    </p>
    <p class="text-muted mt-3">
        <strong>Behavioural Response Section* (Optional):</strong> Assesses key behavioural traits such as engagement, communication, self-regulation, and work habits. This section requires a short video call with the student, during which an educator observes and evaluates the student’s behavioural responses in real time.
    </p>
    
    <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(1)">Back</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="showStep(3)">Continue</button>
    </div>
</div>
                        <!-- STEP 3: INTRO -->
                        <div id="step3" style="display:none;">
                            <!-- <h3>Student Initial Assessment​</h3> -->
                            <h4 class="text-center mt-3">Student Initial Assessment​</h4>
                            <h5 class="text-center mt-3">Kindly read before you begin the assessment​​</h5>
                            <p class="text-muted mt-3">
                              The qualitative section of the assessment must be completed by the parent. Parents are encouraged to provide fair and accurate
                              responses, as this information is used to generate meaningful insights and support better outcomes for the student.
                            </p>
                             <p class="text-muted mt-3">
                                Once the qualitative section is completed, please hand the assessment over to your child to complete the quantitative section. 
                                The quantitative section includes both scored and non-scored questions, depending on the nature of each question. Parents are 
                                encouraged to supervise this section to minimise distractions and interruptions.
                            </p>
                            <p class="text-muted mt-3">
                                After the quantitative section is completed, ensure the assessment is submitted, as submission will end the session and allow
                                the results to be processed.
                            </p>
                             <p class="text-muted mt-3">Once submitted, an automated assessment report will be available immediately, providing a summary of your child's 
                                assessment results and performance scores. A comprehensive Academic Feedback & Learning Recommendations Report will then be 
                                prepared by our Academic Team following a detailed review of the assessment. Please allow 24–48 business hours for the final report to
                                 be issued.
                             </p>
                            <div class="d-flex justify-content-between mt-4">
                                 <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(2)">Back</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="showStep(4)">Continue</button>
                            </div>
                        </div>

<!-- STEP 4: QUALITATIVE -->
<div id="step4" style="display:none;position:relative;">
    <button type="button"
            class="btn btn-link btn-sm skip-qualitative-btn"
            onclick="skipQualitativeSection()">
        Skip Qualitative Assessment
    </button>
    <h3 class="text-center mb-4 fw-bold">Qualitative Section</h3>
    <h4 class="text-center mt-3">Managing a Challenging Task Under Pressure</h4>
    
    <div class="mb-4">
        <label class="fw-semibold mt-4">
            1. Your child has been given a school task (homework) that they find challenging, and it is due the next day. They are tired after school and would prefer to play or relax. What would your child most likely do in this situation?
        </label>
        <p class="text-muted">Please answer based on your child’s typical behaviour in everyday situations.</p>
        
        <div class="mt-3">
            @php
                // Extract saved value and comment for Step 3
                $step3Data = null;
                if (is_array($savedQualitative ?? null)) {
                    foreach ($savedQualitative as $item) {
                        if (($item['step'] ?? '') === 'Managing a Challenging Task Under Pressure') {
                            $step3Data = $item;
                            break;
                        }
                    }
                }
                $savedAnswer3 = $step3Data['answer'] ?? ($savedQualitative['qualitative_answer_step2'] ?? '');
                $savedComment3 = $step3Data['comment'] ?? ($savedQualitative['qualitative_comment_step2'] ?? '');
            @endphp

            <div class="check-box">
                <input type="radio" id="qualitative_a" name="qualitative_answer_step2" 
                       value="My child will start the task independently and continue working through it, even when it feels difficult." 
                       {{ $savedAnswer3 === 'My child will start the task independently and continue working through it, even when it feels difficult.' ? 'checked' : '' }} required>
                <label for="qualitative_a" class="checklabeel">My child will start the task independently and continue working through it, even when it feels difficult.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_b" name="qualitative_answer_step2" 
                       value="My child will start the task but would ask for help after trying for a while." 
                       {{ $savedAnswer3 === 'My child will start the task but would ask for help after trying for a while.' ? 'checked' : '' }}>
                <label for="qualitative_b" class="checklabeel">My child will start the task but would ask for help after trying for a while.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_c" name="qualitative_answer_step2" 
                       value="My child would delay starting and will need reminders before beginning, completing only part of the task." 
                       {{ $savedAnswer3 === 'My child would delay starting and will need reminders before beginning, completing only part of the task.' ? 'checked' : '' }}>
                <label for="qualitative_c" class="checklabeel">My child would delay starting and will need reminders before beginning, completing only part of the task.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_d" name="qualitative_answer_step2" 
                       value="My child would become frustrated or distracted when attempting the task." 
                       {{ $savedAnswer3 === 'My child would become frustrated or distracted when attempting the task.' ? 'checked' : '' }}>
                <label for="qualitative_d" class="checklabeel">My child would become frustrated or distracted when attempting the task.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_e" name="qualitative_answer_step2" 
                       value="My child would avoid or refuse to do the task altogether." 
                       {{ $savedAnswer3 === 'My child would avoid or refuse to do the task altogether.' ? 'checked' : '' }}>
                <label for="qualitative_e" class="checklabeel">My child would avoid or refuse to do the task altogether.</label>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <textarea class="form-control" rows="3" placeholder="Enter additional details if required." name="qualitative_comment_step2">{{ $savedComment3 }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(3)">Back</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="showStep(5)">Continue</button>
    </div>
    
    <div class="text-danger mt-2 d-none validation-error">
        Please answer all the questions above.
    </div>
</div>
<!-- STEP 5: QUALITATIVE -->
<div id="step5" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">Qualitative Section</h3>
    <h4 class="text-center mt-3">Managing Social Conflict or Disagreement</h4>
    
    <div class="mb-4">
        <label class="fw-semibold mt-4">
            1. Your child is involved in a group activity or playing with other children, and a disagreement arises (for example, over rules, turns, or sharing). What would your child most likely do in this situation?
        </label>
        <p class="text-muted">Please answer based on your child’s typical behaviour in everyday situations.</p>

        <div class="mt-2">
            @php
                // Extract saved value and comment for Step 4
                $step4Data = null;
                if (is_array($savedQualitative ?? null)) {
                    foreach ($savedQualitative as $item) {
                        if (($item['step'] ?? '') === 'Managing Social Conflict or Disagreement') {
                            $step4Data = $item;
                            break;
                        }
                    }
                }
                $savedAnswer4 = $step4Data['answer'] ?? ($savedQualitative['qualitative_answer_step3'] ?? '');
                $savedComment4 = $step4Data['comment'] ?? ($savedQualitative['qualitative_comment_step3'] ?? '');
            @endphp

            <div class="check-box">
                <input type="radio" id="qualitative_a_s3" name="qualitative_answer_step3" 
                       value="My child will try to resolve the issue calmly by talking or compromising." 
                       {{ $savedAnswer4 === 'My child will try to resolve the issue calmly by talking or compromising.' ? 'checked' : '' }} required>
                <label for="qualitative_a_s3" class="checklabeel">My child will try to resolve the issue calmly by talking or compromising.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_b_s3" name="qualitative_answer_step3" 
                       value="My child will express their feelings and seek help from an adult if needed." 
                       {{ $savedAnswer4 === 'My child will express their feelings and seek help from an adult if needed.' ? 'checked' : '' }}>
                <label for="qualitative_b_s3" class="checklabeel">My child will express their feelings and seek help from an adult if needed.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_c_s3" name="qualitative_answer_step3" 
                       value="My child would become upset or withdraw from the situation." 
                       {{ $savedAnswer4 === 'My child would become upset or withdraw from the situation.' ? 'checked' : '' }}>
                <label for="qualitative_c_s3" class="checklabeel">My child would become upset or withdraw from the situation.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_d_s3" name="qualitative_answer_step3" 
                       value="My child would react emotionally or argue when the disagreement occurs." 
                       {{ $savedAnswer4 === 'My child would react emotionally or argue when the disagreement occurs.' ? 'checked' : '' }}>
                <label for="qualitative_d_s3" class="checklabeel">My child would react emotionally or argue when the disagreement occurs.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_e_s3" name="qualitative_answer_step3" 
                       value="My child would avoid the situation or refuse to continue participating." 
                       {{ $savedAnswer4 === 'My child would avoid the situation or refuse to continue participating.' ? 'checked' : '' }}>
                <label for="qualitative_e_s3" class="checklabeel">My child would avoid the situation or refuse to continue participating.</label>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <textarea class="form-control" rows="3" placeholder="Enter additional details if required (optional)" name="qualitative_comment_step3">{{ $savedComment4 }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(4)">Back</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="showStep(6)">Continue</button>
    </div>
    
    <div class="text-danger mt-2 d-none validation-error">
        Please answer all the questions above.
    </div>
</div>
<!-- STEP 6: QUALITATIVE -->
<div id="step6" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">Qualitative Section</h3>
    <h4 class="text-center mt-3">Following Instructions & Managing Routine Changes</h4>
    
    <div class="mb-4">
        <label class="fw-semibold mt-4">
            Your child is given instructions to complete a routine task (for example, getting ready for school, packing their bag, or transitioning from playtime to another activity). What would your child most likely do in this situation?
        </label>
        <p class="text-muted">Please answer based on your child’s typical behaviour in everyday situations.</p>

        <div class="mt-2">
            @php
                // Extract saved value and comment for Step 5
                $step5Data = null;
                if (is_array($savedQualitative ?? null)) {
                    foreach ($savedQualitative as $item) {
                        if (($item['step'] ?? '') === 'Following Instructions & Managing Routine Changes') {
                            $step5Data = $item;
                            break;
                        }
                    }
                }
                $savedAnswer5 = $step5Data['answer'] ?? ($savedQualitative['qualitative_answer_step4'] ?? '');
                $savedComment5 = $step5Data['comment'] ?? ($savedQualitative['qualitative_comment_step4'] ?? '');
            @endphp

            <div class="check-box">
                <input type="radio" id="qualitative_a_s4" name="qualitative_answer_step4" 
                       value="My child will follow the instructions independently and complete the task as expected." 
                       {{ $savedAnswer5 === 'My child will follow the instructions independently and complete the task as expected.' ? 'checked' : '' }} required>
                <label for="qualitative_a_s4" class="checklabeel">My child will follow the instructions independently and complete the task as expected.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_b_s4" name="qualitative_answer_step4" 
                       value="My child will follow the instructions but may need one or two reminders." 
                       {{ $savedAnswer5 === 'My child will follow the instructions but may need one or two reminders.' ? 'checked' : '' }}>
                <label for="qualitative_b_s4" class="checklabeel">My child will follow the instructions but may need one or two reminders.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_c_s4" name="qualitative_answer_step4" 
                       value="My child would delay or resist initially but complete the task after repeated prompting." 
                       {{ $savedAnswer5 === 'My child would delay or resist initially but complete the task after repeated prompting.' ? 'checked' : '' }}>
                <label for="qualitative_c_s4" class="checklabeel">My child would delay or resist initially but complete the task after repeated prompting.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_d_s4" name="qualitative_answer_step4" 
                       value="My child would become frustrated, distracted, or argumentative when asked to follow instructions." 
                       {{ $savedAnswer5 === 'My child would become frustrated, distracted, or argumentative when asked to follow instructions.' ? 'checked' : '' }}>
                <label for="qualitative_d_s4" class="checklabeel">My child would become frustrated, distracted, or argumentative when asked to follow instructions.</label>
            </div>

            <div class="check-box">
                <input type="radio" id="qualitative_e_s4" name="qualitative_answer_step4" 
                       value="My child would refuse to follow the instructions or avoid the task altogether." 
                       {{ $savedAnswer5 === 'My child would refuse to follow the instructions or avoid the task altogether.' ? 'checked' : '' }}>
                <label for="qualitative_e_s4" class="checklabeel">My child would refuse to follow the instructions or avoid the task altogether.</label>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <textarea class="form-control" rows="3" placeholder="Enter additional details if required (optional)" name="qualitative_comment_step4">{{ $savedComment5 }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(5)">Back</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="showStep(7)">Continue</button>
    </div>
    
    <div class="text-danger mt-2 d-none validation-error">
        Please answer all the questions above.
    </div>
</div>
<!-- STEP 7: QUALITATIVE (TEXT QUESTIONS) -->
<div id="step7" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">Qualitative Section</h3>
    <h4 class="text-center mt-3">Strengths, Weaknesses, Areas of Improvement</h4>

    @php
        $step6Q1 = '';
        $step6Q2 = '';
        $step6Q3 = '';

        if (is_array($savedQualitative ?? null)) {
            // Check if it is an associative array
            $step6Q1 = $savedQualitative['strengths'] ?? '';
            $step6Q2 = $savedQualitative['challenges'] ?? '';
            $step6Q3 = $savedQualitative['areas_to_improve'] ?? '';

            // If it is a indexed list of draft objects (saved via saveDraft)
            foreach ($savedQualitative as $item) {
                if (is_array($item) && isset($item['question'])) {
                    if (str_contains($item['question'], 'strengths')) {
                        $step6Q1 = $item['answer'] ?? '';
                    } elseif (str_contains($item['question'], 'challenges')) {
                        $step6Q2 = $item['answer'] ?? '';
                    } elseif (str_contains($item['question'], 'Areas') || str_contains($item['question'], 'improve')) {
                        $step6Q3 = $item['answer'] ?? '';
                    }
                }
            }
        }
    @endphp

    <!-- Question 1 -->
    <div class="mb-4">
        <label class="fw-semibold mt-4">
            1. What do you think are your child’s key strengths?
        </label>
        <textarea class="form-control mt-2" rows="3" name="qualitative_step6_q1" required placeholder="for example, academic, behavioural, social, or personal. Restrict within 100 words.">{{ old('qualitative_step6_q1', $step6Q1) }}</textarea>
    </div>

    <!-- Question 2 -->
    <div class="mb-4">
        <label class="fw-semibold">
            2. What do you think are your child’s key challenges?
        </label>
        <textarea class="form-control mt-2" rows="3" name="qualitative_step6_q2" required placeholder="for example, learning, focus, confidence, behaviour, or motivation. Restrict within 100 words.">{{ old('qualitative_step6_q2', $step6Q2) }}</textarea>
    </div>

    <!-- Question 3 -->
    <div class="mb-4">
        <label class="fw-semibold">
            3. Are there any specific areas you would like your child to improve in?
        </label>
        <textarea class="form-control mt-2" rows="3" name="qualitative_step6_q3" required placeholder="for example, learning skills, focus, confidence, behaviour, or motivation. Restrict within 100 words.">{{ old('qualitative_step6_q3', $step6Q3) }}</textarea>
    </div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary btn-sm" onclick="showStep(5)">Back</button>
        
        @if($hasReading || $hasReasoning || $hasThinking || $hasLogic || $hasWriting)
            <button type="button" class="btn btn-danger btn-sm" onclick="showStep(8)">
                Continue
            </button>
        @else
            <button type="button" class="btn btn-danger btn-sm" onclick="submitAssessment()">
                Submit Assessment
            </button>
        @endif
    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please answer all the questions above.
    </div>
</div>
@php
    $step = 8;
@endphp



{{-- ========================================================= --}}
{{-- READING --}}
{{-- ========================================================= --}}
@if($hasReading)

@foreach($readingPassages as $index => $passage)

@php
    // Prepare answers map if passed as array or collection from controller
    $savedAnswers = $savedQuantitative ?? $quantitativeAnswers ?? [];
@endphp

<div id="step{{ $step }}" class="assessment-step" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">
        Quantitative Assessment
    </h3>

    <h4 class="section-title">
        Reading
    </h4>

    <p>
        <strong>
            Read the passage and answer Questions
            {{ $passage['start_q'] }}–{{ $passage['end_q'] }}
        </strong>
    </p>

    @if(!empty($passage['text']))
        <p class="passage-box">
            {{ $passage['text'] }}
        </p>
    @endif

    @foreach($passage['questions'] as $i => $q)

    @php
        // Find pre-saved answer for this specific question ID
        $savedVal = '';
        if (is_array($savedAnswers)) {
            // Handles both key-value pairs [$q->id => answer] AND list of objects/arrays
            if (isset($savedAnswers[$q->id])) {
                $savedVal = is_array($savedAnswers[$q->id]) 
                    ? ($savedAnswers[$q->id]['answer'] ?? '') 
                    : $savedAnswers[$q->id];
            } else {
                foreach ($savedAnswers as $item) {
                    if (is_array($item) && isset($item['question_id']) && $item['question_id'] == $q->id) {
                        $savedVal = $item['answer'] ?? '';
                        break;
                    }
                }
            }
        }
    @endphp

    <div class="mb-3 question-wrapper" data-question-id="{{ $q->id }}">

        <label class="fw-bold">
            {{ $passage['start_q'] + $i }}.
            {{ $q->question }}
        </label>

        @if($q->question_image)
        <div class="question-image my-2">
            <img
                src="{{ asset('storage/assessment_question_images/' . $q->question_image) }}"
                alt="Question Image"
                class="img-fluid rounded">
        </div>
        @endif

        @if($q->question_type == 'choose_best')

            @foreach(($q->options ?? []) as $optIndex => $opt)

                @php
                    $inputId = 'read_'.$q->id.'_'.$optIndex;
                    $isChecked = (string)$savedVal === (string)$opt || old('q_'.$q->id) == $opt;
                @endphp

                <div class="check-box my-1">
                    <input 
                        type="radio" 
                        id="{{ $inputId }}" 
                        name="q_{{ $q->id }}" 
                        value="{{ $opt }}" 
                        data-question-id="{{ $q->id }}"
                        {{ $isChecked ? 'checked' : '' }}
                        required>

                    <label for="{{ $inputId }}">
                        {{ $opt }}
                    </label>
                </div>

            @endforeach

        @else

            <textarea
                name="q_{{ $q->id }}"
                data-question-id="{{ $q->id }}"
                class="form-control mt-2"
                rows="3"
                required
            >{{ old('q_'.$q->id, $savedVal) }}</textarea>

        @endif

    </div>

    @endforeach

    <div class="d-flex justify-content-between mt-4">
        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm">
            Back
        </button>

        <button
            type="button"
            onclick="showStep({{ $step + 1 }})"
            class="btn btn-danger btn-sm">
            Next
        </button>
    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please fill in responses to all the questions to proceed
    </div>

</div>

@php
    $step++;
@endphp

@endforeach

@endif

{{-- ========================================================= --}}
{{-- REASONING --}}
{{-- ========================================================= --}}
@if($hasReasoning)

@php
    // Extract saved quantitative answers passed from controller
    $savedAnswers = $savedQuantitative ?? $quantitativeAnswers ?? [];
@endphp

<div id="step{{ $step }}" class="assessment-step" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">
        Quantitative Assessment
    </h3>

    <h4 class="section-title">
        Reasoning
    </h4>

    @foreach($reasoning as $q)

    @php
        // Find pre-saved answer for this specific question ID
        $savedVal = '';
        if (is_array($savedAnswers)) {
            if (isset($savedAnswers[$q->id])) {
                $savedVal = is_array($savedAnswers[$q->id]) 
                    ? ($savedAnswers[$q->id]['answer'] ?? '') 
                    : $savedAnswers[$q->id];
            } else {
                foreach ($savedAnswers as $item) {
                    if (is_array($item) && isset($item['question_id']) && $item['question_id'] == $q->id) {
                        $savedVal = $item['answer'] ?? '';
                        break;
                    }
                }
            }
        }
    @endphp

    <div class="mb-3 question-wrapper" data-question-id="{{ $q->id }}">

        <label class="fw-bold">
            {{ $loop->iteration }}.
            {{ $q->question }}
        </label>

        @if($q->question_image)
        <div class="question-image my-2">
            <img
                src="{{ asset('storage/assessment_question_images/' . $q->question_image) }}"
                alt="Question Image"
                class="img-fluid rounded">
        </div>
        @endif

        @if($q->question_type == 'choose_best')

            @foreach(($q->options ?? []) as $i => $opt)

            @php
                $id = 'reason_'.$q->id.'_'.$i;
                $isChecked = (string)$savedVal === (string)$opt || old('q_'.$q->id) == $opt;
            @endphp

            <div class="check-box my-1">

                <input
                    type="radio"
                    id="{{ $id }}"
                    name="q_{{ $q->id }}"
                    value="{{ $opt }}"
                    data-question-id="{{ $q->id }}"
                    {{ $isChecked ? 'checked' : '' }}
                    required
                >

                <label for="{{ $id }}">
                    {{ $opt }}
                </label>

            </div>

            @endforeach

        @else

            <textarea
                name="q_{{ $q->id }}"
                data-question-id="{{ $q->id }}"
                class="form-control mt-2"
                rows="3"
                required
            >{{ old('q_'.$q->id, $savedVal) }}</textarea>

        @endif

    </div>

    @endforeach

    <div class="d-flex justify-content-between mt-4">

        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm"
        >
            Back
        </button>

        <button
            type="button"
            onclick="showStep({{ $step + 1 }})"
            class="btn btn-danger btn-sm"
        >
            Next
        </button>

    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please fill in responses to all the questions to proceed
    </div>

</div>

@php
    $step++;
@endphp

@endif

{{-- ========================================================= --}}
{{-- THINKING --}}
{{-- ========================================================= --}}
@if($hasThinking)

@php
    // Extract saved quantitative answers passed from controller
    $savedAnswers = $savedQuantitative ?? $quantitativeAnswers ?? [];
@endphp

<div id="step{{ $step }}" class="assessment-step" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">
        Quantitative Assessment
    </h3>

    <h4 class="section-title">
        Thinking Skills
    </h4>

    @foreach($thinking as $q)

    @php
        // Find pre-saved answer for this specific question ID
        $savedVal = '';
        if (is_array($savedAnswers)) {
            if (isset($savedAnswers[$q->id])) {
                $savedVal = is_array($savedAnswers[$q->id]) 
                    ? ($savedAnswers[$q->id]['answer'] ?? '') 
                    : $savedAnswers[$q->id];
            } else {
                foreach ($savedAnswers as $item) {
                    if (is_array($item) && isset($item['question_id']) && $item['question_id'] == $q->id) {
                        $savedVal = $item['answer'] ?? '';
                        break;
                    }
                }
            }
        }
    @endphp

    <div class="mb-3 question-wrapper" data-question-id="{{ $q->id }}">

        <label class="fw-bold">
            {{ $loop->iteration }}.
            {{ $q->question }}
        </label>

        @if($q->question_image)
        <div class="question-image my-2">
            <img
                src="{{ asset('storage/assessment_question_images/' . $q->question_image) }}"
                alt="Question Image"
                class="img-fluid rounded">
        </div>
        @endif

        @if($q->question_type == 'choose_best')

            @foreach(($q->options ?? []) as $i => $opt)

            @php
                $id = 'think_'.$q->id.'_'.$i;
                $isChecked = (string)$savedVal === (string)$opt || old('q_'.$q->id) == $opt;
            @endphp

            <div class="check-box my-1">

                <input
                    type="radio"
                    id="{{ $id }}"
                    name="q_{{ $q->id }}"
                    value="{{ $opt }}"
                    data-question-id="{{ $q->id }}"
                    {{ $isChecked ? 'checked' : '' }}
                    required
                >

                <label for="{{ $id }}">
                    {{ $opt }}
                </label>

            </div>

            @endforeach

        @else

            <textarea
                name="q_{{ $q->id }}"
                data-question-id="{{ $q->id }}"
                class="form-control mt-2"
                rows="3"
                required
            >{{ old('q_'.$q->id, $savedVal) }}</textarea>

        @endif

    </div>

    @endforeach

    <div class="d-flex justify-content-between mt-4">

        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm"
        >
            Back
        </button>

        <button
            type="button"
            onclick="showStep({{ $step + 1 }})"
            class="btn btn-danger btn-sm"
        >
            Next
        </button>

    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please fill in responses to all the questions to proceed
    </div>

</div>

@php
    $step++;
@endphp

@endif

{{-- ========================================================= --}}
{{-- LOGIC --}}
{{-- ========================================================= --}}
@if($hasLogic)

@php
    // Extract saved quantitative answers passed from controller
    $savedAnswers = $savedQuantitative ?? $quantitativeAnswers ?? [];
@endphp

<div id="step{{ $step }}" class="assessment-step" style="display:none;">
    <h3 class="text-center mb-4 fw-bold">
        Quantitative Assessment
    </h3>

    <h4 class="section-title">
        Logic
    </h4>

    @foreach($logic as $q)

    @php
        // Find pre-saved answer for this specific question ID
        $savedVal = '';
        if (is_array($savedAnswers)) {
            if (isset($savedAnswers[$q->id])) {
                $savedVal = is_array($savedAnswers[$q->id]) 
                    ? ($savedAnswers[$q->id]['answer'] ?? '') 
                    : $savedAnswers[$q->id];
            } else {
                foreach ($savedAnswers as $item) {
                    if (is_array($item) && isset($item['question_id']) && $item['question_id'] == $q->id) {
                        $savedVal = $item['answer'] ?? '';
                        break;
                    }
                }
            }
        }
    @endphp

    <div class="mb-3 question-wrapper" data-question-id="{{ $q->id }}">

        <label class="fw-bold">
            {{ $loop->iteration }}.
            {{ $q->question }}
        </label>

        @if($q->question_image)
        <div class="question-image my-2">
            <img
                src="{{ asset('storage/assessment_question_images/' . $q->question_image) }}"
                alt="Question Image"
                class="img-fluid rounded">
        </div>
        @endif

        @if($q->question_type == 'choose_best')

            @foreach(($q->options ?? []) as $i => $opt)

            @php
                $id = 'logic_'.$q->id.'_'.$i;
                $isChecked = (string)$savedVal === (string)$opt || old('q_'.$q->id) == $opt;
            @endphp

            <div class="check-box my-1">

                <input
                    type="radio"
                    id="{{ $id }}"
                    name="q_{{ $q->id }}"
                    value="{{ $opt }}"
                    data-question-id="{{ $q->id }}"
                    {{ $isChecked ? 'checked' : '' }}
                    required
                >

                <label for="{{ $id }}">
                    {{ $opt }}
                </label>

            </div>

            @endforeach

        @else

            <textarea
                name="q_{{ $q->id }}"
                data-question-id="{{ $q->id }}"
                class="form-control mt-2"
                rows="3"
                required
            >{{ old('q_'.$q->id, $savedVal) }}</textarea>

        @endif

    </div>

    @endforeach

    <div class="d-flex justify-content-between mt-4">

        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm"
        >
            Back
        </button>

        <button
            type="button"
            onclick="showStep({{ $step + 1 }})"
            class="btn btn-danger btn-sm"
        >
            Next
        </button>

    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please fill in responses to all the questions to proceed
    </div>

</div>

@php
    $step++;
@endphp

@endif

{{-- ========================================================= --}}
{{-- WRITING --}}
{{-- ========================================================= --}}
@if($hasWriting)

<div id="step{{ $step }}" class="assessment-step"  style="display:none;">
    <h3 class="text-center mb-4 fw-bold">
        Quantitative Assessment
    </h3>

    <h4 class="section-title">
        Writing
    </h4>

    @foreach($writing as $q)

    <div class="mb-3">

        <label>
            {{ $loop->iteration }}.
            {{ $q->question }}
        </label>

        @if($q->question_type == 'choose_best')

            @foreach(($q->options ?? []) as $i => $opt)

                @php
                    $id = 'writing_'.$q->id.'_'.$i;
                @endphp

                <div class="check-box">

                    <input
                        type="radio"
                        id="{{ $id }}"
                        name="q_{{ $q->id }}"
                        value="{{ $opt }}"
                        required
                    >

                    <label for="{{ $id }}">
                        {{ $opt }}
                    </label>

                </div>

            @endforeach

        @else

            <textarea
                name="q_{{ $q->id }}"
                class="form-control"
                required
            ></textarea>

        @endif

    </div>

    @endforeach

    <div class="d-flex justify-content-between">

        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm"
        >
            Back
        </button>

        <button
            type="button"
            onclick="document.getElementById('assessmentForm').requestSubmit()"
            class="btn btn-danger btn-sm"
        >
            Submit
        </button>

    </div>

    <div class="text-danger mt-2 d-none validation-error">
        Please fill in responses to all the questions to proceed
    </div>

</div>

@php
    $step++;
@endphp

@else

{{-- ========================================================= --}}
{{-- FINAL SUBMIT STEP --}}
{{-- ========================================================= --}}

<div id="step{{ $step }}" style="display:none;">

    <h4 class="section-title">
        Review & Submit
    </h4>

    <p class="text-center">
        Please review your answers and submit the assessment.
    </p>

    <div class="d-flex justify-content-between">

        <button
            type="button"
            onclick="showStep({{ $step - 1 }})"
            class="btn btn-secondary btn-sm"
        >
            Back
        </button>

        <button
            type="button"
            onclick="document.getElementById('assessmentForm').requestSubmit()"
            class="btn btn-danger btn-sm"
        >
            Submit
        </button>

    </div>

</div>
@endif
                    </form>
                    <!-- SUCCESS SCREEN -->
                    <div id="successScreen" style="display:none;" class="text-center p-5">
                        <h3 class="text-success">Assessment Submitted Successfully 🎉</h3>
                        <p>Thank you. Our team will contact you shortly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
    @include('include.footer')
@endsection

@section('script')
@include('include.script')

<style>
.assessment-box{
    background:#fff;
    border-top:6px solid #b80f0a;
    border-radius:16px;
    padding:40px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
    margin-top:40px;
}

/* ===== Custom Checkbox/Radio Style ===== */

.check-box{
    margin-bottom:12px;
}

.check-box input[type="checkbox"],
.check-box input[type="radio"]{
    display:none;
}

.check-box input[type="checkbox"] + label,
.check-box input[type="radio"] + label{
    padding-left:35px;
    cursor:pointer;
    background:url({{ public_asset('assets/images/check.png') }}) no-repeat left center;
    display:inline-block;
    width:100%;
}

.check-box input[type="checkbox"]:checked + label,
.check-box input[type="radio"]:checked + label{
    background:url({{ public_asset('assets/images/checked.png') }}) no-repeat left center;
}

.check-box label.checklabeel{
    color:#3a4448;
    font-size:14.5px;
    font-style:italic;
}

/* ===== EXACT SAME AS REFERENCE ===== */

.section-title{
    font-weight:700;
    font-size:22px;
    margin:25px 0;
    text-align:center;
    width:100%;
    position:relative;
}

.section-title::after{
    content:"";
    display:block;
    width:60px;
    height:3px;
    background:#b80f0a;
    margin:10px auto 0;
    border-radius:2px;
}

.passage-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.question-image{
    margin:20px 0;
    text-align:left;
}

.question-image img{
    display:block;
    width:100%;
    max-width:500px;
    height:auto;
    border-radius:8px;
    border:1px solid #ddd;
}

@media(max-width:768px){
    .question-image img{
        max-width:100%;
    }
}
.skip-qualitative-btn {
    position: absolute;
    top: 0;
    right: 0;

    color: #b80f0a !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    font-style: italic !important;
    font-family: inherit !important;
    letter-spacing: normal !important;
    text-transform: none !important;

    text-decoration: none !important;
    padding: 0 !important;
    border: 0 !important;
    box-shadow: none !important;

    z-index: 10;
}

.skip-qualitative-btn:hover {
    color: #8f0b08 !important;
    text-decoration: underline !important;
}
</style>
<script>
/* ==========================================================================
 * 1. HELPER & DATA COLLECTION FUNCTIONS
 * ========================================================================== */

function getSelectedLabelText(inputName) {
    const selected = document.querySelector(`input[name="${inputName}"]:checked`);
    if (!selected) return null;
    const label = document.querySelector(`label[for="${selected.id}"]`);
    return label ? label.innerText.trim() : null;
}

function collectQuantitativeAnswers() {
    let answers = [];
    document.querySelectorAll('[name^="q_"]').forEach(el => {
        const qId = el.name.replace('q_', '');
        if (el.type === 'radio' && el.checked) {
            answers.push({ question_id: qId, selected_answer: el.value });
        } else if (el.tagName === 'TEXTAREA' || (el.tagName === 'INPUT' && el.type !== 'radio')) {
            answers.push({ question_id: qId, selected_answer: el.value });
        }
    });
    return answers;
}

function buildAssessmentPayload() {
    // Check DOM checkboxes first
    const consentChecks = document.querySelectorAll('.consent-check');
    const domTermsAgreed = consentChecks.length > 0 && Array.from(consentChecks).every(cb => cb.checked);
    
    // Fallback to initial server state ($termsAgreed) if checkboxes were pre-checked via PHP
    const termsAgreed = domTermsAgreed || Boolean(@json($termAgreed ?? false));

    const qualitativeRadio = [
        {
            step: 'Managing a Challenging Task Under Pressure',
            question: document.querySelector('#step4 label.fw-semibold')?.innerText.trim() || '',
            answer: getSelectedLabelText('qualitative_answer_step2'),
            comment: document.querySelector('[name="qualitative_comment_step2"]')?.value.trim() || ''
        },
        {
            step: 'Managing Social Conflict or Disagreement',
            question: document.querySelector('#step5 label.fw-semibold')?.innerText.trim() || '',
            answer: getSelectedLabelText('qualitative_answer_step3'),
            comment: document.querySelector('[name="qualitative_comment_step3"]')?.value.trim() || ''
        },
        {
            step: 'Following Instructions & Managing Routine Changes',
            question: document.querySelector('#step6 label.fw-semibold')?.innerText.trim() || '',
            answer: getSelectedLabelText('qualitative_answer_step4'),
            comment: document.querySelector('[name="qualitative_comment_step4"]')?.value.trim() || ''
        }
    ];

    const qualitativeText = [
        {
            step: 'Strengths, Weaknesses, Areas of Improvement',
            question: 'What are your child key strengths?',
            answer: document.querySelector('[name="qualitative_step6_q1"]')?.value.trim() || ''
        },
        {
            step: 'Strengths, Weaknesses, Areas of Improvement',
            question: 'What are your child key challenges?',
            answer: document.querySelector('[name="qualitative_step6_q2"]')?.value.trim() || ''
        },
        {
            step: 'Strengths, Weaknesses, Areas of Improvement',
            question: 'Areas to improve',
            answer: document.querySelector('[name="qualitative_step6_q3"]')?.value.trim() || ''
        }
    ];

    return {
        learning_program_assessment_id: {{ $assessment->id }},
        assessment_form_name: document.querySelector('[name="assessment_form_name"]')?.value || '',
        terms_agreed: termsAgreed, // Always sends true (1) or false (0)
        qualitative_answers: [...qualitativeRadio, ...qualitativeText],
        quantitative_answers: collectQuantitativeAnswers()
    };
}

function saveDraft() {
    fetch('{{ route("program.assessment.save_draft", ["token" => $token]) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(buildAssessmentPayload())
    })
    .then(res => res.json())
    .then(data => console.log('Draft saved successfully:', data))
    .catch(err => console.error('Auto-save draft failed:', err));
}

function validateStep(stepEl) {
    let valid = true;
    const errorBox = stepEl.querySelector('.validation-error, #consentValidationError');
    if (errorBox) errorBox.classList.add('d-none');

    stepEl.querySelectorAll('input[type="checkbox"][required]').forEach(checkbox => {
        if (!checkbox.checked) valid = false;
    });

    const radioGroups = {};
    stepEl.querySelectorAll('input[type="radio"]').forEach(radio => {
        if (!radioGroups[radio.name]) radioGroups[radio.name] = [];
        radioGroups[radio.name].push(radio);
    });

    for (let name in radioGroups) {
        if (!radioGroups[name].some(r => r.checked)) valid = false;
    }

    stepEl.querySelectorAll('textarea').forEach(textarea => {
        if (textarea.name.includes('comment')) return; 
        if (textarea.hasAttribute('required') && textarea.value.trim() === '') valid = false;
    });

    if (!valid && errorBox) errorBox.classList.remove('d-none');
    return valid;
}

function showStep(step, isSubmit = false) {

    const currentStep = Array.from(
        document.querySelectorAll('[id^="step"]')
    ).find(el => window.getComputedStyle(el).display !== 'none');

    if (!currentStep) {
        console.error('Current assessment step not found.');
        return;
    }

    const currentStepNumber = parseInt(
        currentStep.id.replace('step', ''),
        10
    );

    // Validate only when moving forward
    if (
        step > currentStepNumber &&
        !validateStep(currentStep)
    ) {
        return;
    }

    if (isSubmit) {
        document.getElementById('assessmentForm').requestSubmit();
        return;
    }

    // Save draft
    if (typeof saveDraft === 'function') {
        saveDraft();
    }

    // Hide all steps
    document.querySelectorAll('[id^="step"]').forEach(el => {
        el.style.display = 'none';
    });

    // Show requested step
    const activeStep = document.getElementById('step' + step);

    if (activeStep) {
        activeStep.style.display = 'block';
    } else {
        console.error('Step not found:', step);
    }
}
/* ==========================================================================
 * 2. INITIALIZATION ON DOM CONTENT LOADED
 * ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const isTermsAgreed = @json((bool) ($termAgreed ?? false));
    console.log('Is Terms Agreed on load:', isTermsAgreed);
    const consentChecks = document.querySelectorAll('.consent-check');

    if (isTermsAgreed && consentChecks.length > 0) {
        consentChecks.forEach(cb => cb.checked = true);
        
        // Auto-advance to Step 2 if already agreed
        document.querySelectorAll('[id^="step"]').forEach(el => el.style.display = 'none');
        const step2 = document.getElementById('step2');
        if (step2) step2.style.display = 'block';
    }

    consentChecks.forEach(cb => {
        cb.addEventListener('change', function () {
            const allChecked = Array.from(consentChecks).every(c => c.checked);
            const errorDiv = document.getElementById('consentValidationError');
            if (errorDiv && allChecked) errorDiv.classList.add('d-none');
        });
    });

    // Pre-fill Qualitative and Quantitative Data
    const savedQualitative = @json($savedQualitative ?? []);
    const savedQuantitativeRaw = @json($savedQuantitative ?? []);
    const savedQuantitative = savedQuantitativeRaw.answers || savedQuantitativeRaw || [];

    if (Array.isArray(savedQualitative) && savedQualitative.length > 0) {
        const stepToFieldNameMap = {
            'Managing a Challenging Task Under Pressure': 'qualitative_answer_step2',
            'Managing Social Conflict or Disagreement': 'qualitative_answer_step3',
            'Following Instructions & Managing Routine Changes': 'qualitative_answer_step4'
        };

        savedQualitative.forEach(item => {
            if (item.step && stepToFieldNameMap[item.step]) {
                const fieldName = stepToFieldNameMap[item.step];
                const radios = document.querySelectorAll(`input[name="${fieldName}"]`);
                radios.forEach(radio => {
                    const label = document.querySelector(`label[for="${radio.id}"]`);
                    if (label && label.innerText.trim() === item.answer) radio.checked = true;
                });
                const commentKey = fieldName.replace('answer', 'comment');
                const commentEl = document.querySelector(`[name="${commentKey}"]`);
                if (commentEl) commentEl.value = item.comment || '';
            }

            if (item.question) {
                const qText = item.question.toLowerCase();
                if (qText.includes('strength')) {
                    const el = document.querySelector('[name="qualitative_step6_q1"]');
                    if (el) el.value = item.answer || '';
                } else if (qText.includes('challenge')) {
                    const el = document.querySelector('[name="qualitative_step6_q2"]');
                    if (el) el.value = item.answer || '';
                } else if (qText.includes('improve') || qText.includes('areas')) {
                    const el = document.querySelector('[name="qualitative_step6_q3"]');
                    if (el) el.value = item.answer || '';
                }
            }
        });
    }

    if (Array.isArray(savedQuantitative) && savedQuantitative.length > 0) {
        savedQuantitative.forEach(item => {
            if (!item.question_id) return;
            const radio = document.querySelector(`input[name="q_${item.question_id}"][value="${item.selected_answer}"]`);
            const textField = document.querySelector(`textarea[name="q_${item.question_id}"], input[name="q_${item.question_id}"]`);
            if (radio) radio.checked = true;
            else if (textField && textField.type !== 'radio') textField.value = item.selected_answer || '';
        });
    }
});

/* ==========================================================================
 * 3. FINAL FORM SUBMISSION
 * ========================================================================== */

document.getElementById('assessmentForm').addEventListener('submit', function (e) {

    e.preventDefault();

    const currentStep = Array.from(
        document.querySelectorAll('[id^="step"]')
    ).find(el => window.getComputedStyle(el).display !== 'none');

    if (!currentStep) {
        console.error('Current assessment step not found.');
        return;
    }

    // Validate only the visible step
    if (!validateStep(currentStep)) {
        return;
    }

    const formFields = document.querySelectorAll(
        '#assessmentForm input, #assessmentForm textarea, #assessmentForm select'
    );

    const formButtons = document.querySelectorAll(
        '#assessmentForm button'
    );

    // Disable controls
    formFields.forEach(el => el.disabled = true);

    formButtons.forEach(btn => {
        btn.disabled = true;

        if (btn.innerText.trim().toLowerCase().includes('submit')) {
            btn.innerText = 'Submitting...';
        }
    });

    const payload = buildAssessmentPayload();

    console.log('Submitting assessment payload:', payload);

    fetch("{{ route('program.assessment.submit') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify(payload)
    })
    .then(async response => {

        const responseText = await response.text();

        console.log('HTTP Status:', response.status);
        console.log('Raw response:', responseText);

        let data;

        try {
            data = JSON.parse(responseText);
        } catch (error) {
            throw new Error(
                `Server returned non-JSON response. HTTP ${response.status}: ${responseText}`
            );
        }

        if (!response.ok) {
            throw new Error(
                data.message || `HTTP error ${response.status}`
            );
        }

        return data;
    })
    .then(data => {

        console.log('Submission response:', data);

        if (data.success) {

            document.getElementById('assessmentForm').style.display = 'none';

            document.getElementById('successScreen').style.display = 'block';

        } else {

            alert(
                data.message ||
                'Submission failed. Please try again.'
            );

            resetFormControls();
        }
    })
    .catch(error => {

        console.error('Submission error:', error);

        alert(
            error.message ||
            'Network error. Please try again.'
        );

        resetFormControls();
    });

    function resetFormControls() {

        formFields.forEach(el => {
            el.disabled = false;
        });

        formButtons.forEach(btn => {

            btn.disabled = false;

            if (btn.innerText === 'Submitting...') {
                btn.innerText = 'Submit';
            }
        });
    }
});
function skipQualitativeSection() {

    // Automatically find the first quantitative section
    const quantitativeStep = document.querySelector('.assessment-step');

    if (!quantitativeStep) {
        console.error('First quantitative step not found.');
        return;
    }

    // Hide all steps
    document.querySelectorAll('[id^="step"]').forEach(el => {
        el.style.display = 'none';
    });

    // Open first quantitative step
    quantitativeStep.style.display = 'block';

    // Save any qualitative data already entered
    if (typeof saveDraft === 'function') {
        saveDraft();
    }
}
</script>
@endsection
