@extends('layouts.app')
@section('title')
<title>V-Tutor | Student | Assessment</title>
@endsection

@section('left_part')
@include('include.header_menu_part')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="top_mar"></div>

<section class="user-account">
    <div class="container">
        <div class="row">
            <div class="zin">
                @include('include.student_left_common')

                <div class="user-right-panel">
                    <div class="user-right-top-new">
                        @include('include.errors')
                        <h2 class="profile-heading">Student Assessment</h2>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm p-4">

                                <!-- STEP INDICATOR -->
                                <div class="mb-3">
                                    <h5>Step <span id="stepNo">1</span> of 2</h5>
                                </div>

                                <form id="assessmentForm">
                                    <input type="hidden" name="learning_program_assessment_id" value="{{ session('assessment')->id ?? '' }}">

                                    <!-- ================= STEP 1 ================= -->
                                    <div id="step1">

                                        <h4 class="mb-1">Qualitative Assessment</h4>
                                        <p class="text-muted">
                                            This assessment should be completed by the parent to help us understand the student’s learning behavior and needs.
                                        </p>

                                        @php
                                            $qualitativeQuestions = session('qualitativeQuestions', []);
                                        @endphp

                                        @foreach($qualitativeQuestions as $index => $question)
                                            <div class="mb-4 mt-4">
                                                <label class="form-label fw-semibold">
                                                    {{ $index + 1 }}. {{ $question->question }}
                                                </label>

                                                @if($question->question_type === 'choose_best' && !empty($question->options))
                                                    <div class="row">
                                                        @foreach($question->options as $optIndex => $option)
                                                            <div class="col-md-6 mb-2">
                                                                <label>
                                                                    <input type="radio" name="q_parent_{{ $index + 1 }}" value="{{ $option }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($question->question_type === 'text')
                                                    <textarea class="form-control" rows="3" name="q_parent_{{ $index + 1 }}" placeholder="Write here..."></textarea>
                                                @endif
                                            </div>
                                        @endforeach

                                        <div class="text-end mt-4">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="showStep(2)">
                                                Continue
                                            </button>
                                        </div>
                                        <div id="step1Error" class="text-danger mt-2" style="display:none;"></div>
                                    </div>

                                    <!-- ================= STEP 2 ================= -->
                                    <div id="step2" style="display:none;">

                                        <h4 class="mb-1">Quantitative Assessment</h4>
                                        <p class="text-muted">
                                            This assessment should be completed by the student to evaluate their understanding and confidence in the subject.
                                        </p>

                                        @php
                                            $quantitativeQuestions = session('quantitativeQuestions', []);
                                        @endphp

                                        @foreach($quantitativeQuestions as $index => $question)
                                            <div class="mb-4 mt-4">
                                                <label class="form-label fw-semibold">
                                                    {{ $index + 1 }}. {{ $question->question }}
                                                </label>

                                                @if($question->question_type === 'choose_best' && !empty($question->options))
                                                    <div class="row">
                                                        @foreach($question->options as $optIndex => $option)
                                                            <div class="col-md-6 mb-2">
                                                                <label>
                                                                    <input type="radio" name="q_student_{{ $index + 1 }}" value="{{ $option }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($question->question_type === 'text')
                                                    <textarea class="form-control" rows="3" name="q_student_{{ $index + 1 }}" placeholder="Write here..."></textarea>
                                                @endif
                                            </div>
                                        @endforeach

                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="showStep(1)">Back</button>
                                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                        </div>
                                        <div id="step2Error" class="text-danger mt-2" style="display:none;"></div>

                                    </div>

                                </form>

                                <!-- SUCCESS SCREEN -->
                                <div id="successScreen" style="display:none;" class="text-center p-5">
                                    <h3 class="text-success mb-3">Assessment Submitted Successfully 🎉</h3>
                                    <p class="text-muted">
                                        Thank you for completing the assessment.<br>
                                        Our team will review the responses and contact you soon.
                                    </p>
                                </div>

                            </div>
                        </div>
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

<script>
// ---------- STEP NAVIGATION WITH VALIDATION ----------
// function showStep(step) {
//     if (step === 2 && !validateStep1()) {
//         alert('Please answer all questions before continuing.');
//         return;
//     }

//     const step1 = document.getElementById('step1');
//     const step2 = document.getElementById('step2');
//     const stepNo = document.getElementById('stepNo');

//     step1.style.display = step === 1 ? 'block' : 'none';
//     step2.style.display = step === 2 ? 'block' : 'none';
//     stepNo.innerText = step;
// }


// ---------- STEP NAVIGATION WITH VALIDATION ----------
function showStep(step) {
    const step1Error = document.getElementById('step1Error');

    if (step === 2) {
        if (!validateStep1()) {
            step1Error.innerText = 'Please answer all questions before continuing.';
            step1Error.style.display = 'block';
            return;
        } else {
            step1Error.style.display = 'none';
        }
    }

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const stepNo = document.getElementById('stepNo');

    step1.style.display = step === 1 ? 'block' : 'none';
    step2.style.display = step === 2 ? 'block' : 'none';
    stepNo.innerText = step;
}

// ---------- VALIDATION STEP 1 ----------
function validateStep1() {
    let valid = true;

    @foreach(session('qualitativeQuestions', []) as $index => $q)
        @if($q->question_type === 'choose_best')
            const radios{{ $index }} = document.querySelectorAll('[name="q_parent_{{ $index + 1 }}"]');
            if (![...radios{{ $index }}].some(r => r.checked)) {
                valid = false;
            }
        @elseif($q->question_type === 'text')
            const textEl{{ $index }} = document.querySelector('[name="q_parent_{{ $index + 1 }}"]');
            if (!textEl{{ $index }}.value.trim()) valid = false;
        @endif
    @endforeach

    return valid;
}

// ---------- VALIDATION STEP 2 ----------
function validateStep2() {
    let valid = true;

    @foreach(session('quantitativeQuestions', []) as $index => $q)
        @if($q->question_type === 'choose_best')
            const radios{{ $index }} = document.querySelectorAll('[name="q_student_{{ $index + 1 }}"]');
            if (![...radios{{ $index }}].some(r => r.checked)) {
                valid = false;
            }
        @elseif($q->question_type === 'text')
            const textEl{{ $index }} = document.querySelector('[name="q_student_{{ $index + 1 }}"]');
            if (!textEl{{ $index }}.value.trim()) valid = false;
        @endif
    @endforeach

    return valid;
}


// ---------- FORM SUBMIT ----------
document.getElementById('assessmentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const step2Error = document.getElementById('step2Error');

    if (!validateStep2()) {
        step2Error.innerText = 'Please answer all questions before submitting.';
        step2Error.style.display = 'block';
        return;
    } else {
        step2Error.style.display = 'none';
    }

    let qualitative = [];
    let quantitative = [];

    // STEP 1: Qualitative
    @foreach(session('qualitativeQuestions', []) as $index => $q)
        qualitative.push({
            question_id: {{ $q->id }},
            question: @json($q->question),
            answer: document.querySelector(
                '[name="q_parent_{{ $index + 1 }}"]:checked'
            )?.value
            || document.querySelector(
                '[name="q_parent_{{ $index + 1 }}"]'
            )?.value
            || null
        });
    @endforeach

    // STEP 2: Quantitative
    @foreach(session('quantitativeQuestions', []) as $index => $q)
        quantitative.push({
            question_id: {{ $q->id }},
            question: @json($q->question),
            selected_answer: document.querySelector(
                '[name="q_student_{{ $index + 1 }}"]:checked'
            )?.value || null
        });
    @endforeach

    let payload = {
        learning_program_assessment_id:
            document.querySelector('[name="learning_program_assessment_id"]').value,
        qualitative_answers: qualitative,
        quantitative_answers: quantitative
    };

    submitAssessment(payload);
});


// ---------- SUBMIT FUNCTION ----------
function submitAssessment(payload) {
    let btn = document.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = 'Submitting...';

    fetch("{{ route('student.my.assessment.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // SHOW SUCCESS SCREEN
            document.getElementById('assessmentForm').style.display = 'none';
            document.getElementById('successScreen').style.display = 'block';
               // RESET FORM FIELDS
            const form = document.getElementById('assessmentForm');

            // Reset radio buttons
            form.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);

            // Reset textareas
            form.querySelectorAll('textarea').forEach(t => t.value = '');

            // Reset Step View
            // form.style.display = 'block'; // keep form visible if needed, or hide if you want
            // showStep(1);
        } else {
            alert("Validation failed");
            console.error(data);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong");
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Submit';
    });
}
</script>

@endsection
