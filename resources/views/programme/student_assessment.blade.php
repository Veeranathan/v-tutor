@extends('layouts.app')

@section('page_title', 'V-Tutor | Assessment')

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

<section class="makes_special_sec faq-sec mt-6">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">
                <div class="assessment-box">
                    <form id="assessmentForm" autocomplete="off" novalidate>
                        @csrf
                        <input type="hidden" 
                               id="learning_program_assessment_id" 
                               name="learning_program_assessment_id" 
                               value="{{ $assessment->id ?? $learning_program_assessment_id ?? '' }}">
                        <input type="hidden" name="assessment_form_name" value="{{ $form->form_name ?? '' }}">

                        {{-- STEP 1 : INFORMATION --}}
                        <div id="step1">
                            <h4 class="text-center mt-3">
                                V-Tutor {{ strtoupper($type) }} Assessment
                            </h4>

                            <div class="mt-4">
                                <input
                                    type="text"
                                    name="parent_name"
                                    class="form-control mb-3"
                                    placeholder="Parent Name"
                                    value="{{ old('parent_name', $draft->parent_name ?? '') }}"
                                    required
                                >

                                <input
                                    type="text"
                                    name="child_name"
                                    class="form-control mb-3"
                                    placeholder="Student Name"
                                    value="{{ old('child_name', $draft->child_name ?? '') }}"
                                    required
                                >

                                <!-- <select
                                    name="year_level"
                                    class="form-control mb-3"
                                    required
                                >
                                    <option value="">Select Year</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="Grade {{ $i }}" {{ (isset($draft->year_level) && $draft->year_level == "Grade $i") ? 'selected' : '' }}>
                                            Year {{ $i }}
                                        </option>
                                    @endfor
                                </select> -->

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Email"
                                    value="{{ old('email', $draft->email ?? '') }}"
                                    required
                                > 
                                <div class="text-danger mt-1 d-none email-error">
                                    Please enter a valid email address.
                                </div>

                                <select
                                    name="state"
                                    class="form-control mt-3"
                                    required
                                >
                                    <option value="">Select State</option>
                                    @php
                                        $states = [
                                            'New South Wales',
                                            'Victoria',
                                            'Queensland',
                                            'South Australia',
                                            'Tasmania',
                                            'Western Australia',
                                            'Australian Capital Territory',
                                            'Northern Territory'
                                        ];
                                    @endphp
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}" {{ (isset($draft->state) && $draft->state == $state) ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-danger mt-1 d-none state-error">
                                    Please select a state.
                                </div>
                            </div>

                            <!-- Action Controls Layout -->
                            <div class="mt-4 action-row align-items-end">
                                <!-- Left Spacer (Maintains true center alignment for button) -->
                                <div class="d-none d-md-block"></div>

                                <!-- Centered Start Button -->
                                <div class="text-center">
                                    <button
                                        type="button"
                                        id="startBtn"
                                        class="btn btn-danger px-5"
                                        onclick="startAssessment()"
                                    >
                                        Start
                                    </button>
                                </div>

                                <!-- Right-Aligned Link -->
                                <div class="pt-2 pt-md-0 ms-auto text-end" style="text-align: right !important;">
                                    <a href="{{ route('program.assessment.resume.form', ['slug' => $type]) }}" 
                                        class="text-decoration-underline fw-bold fs-6 d-inline-block float-end" 
                                        style="color: #D7263D !important; line-height: 1.2;">
                                         Continue with existing assessment
                                    </a>
                                </div>
                            </div>

                            <div class="text-danger mt-2 text-center d-none validation-error">
                                Please enter all required fields correctly.
                            </div>
                        </div>
                    </form>
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
.assessment-box {
    background: #fff;
    border-top: 6px solid #b80f0a;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.15);
}

/* CSS Grid layout for action row on desktop */
@media (min-width: 768px) {
    .action-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
    }
}
</style>
<script>
let startingAssessment = false;

function validateForm() {
    const step1 = document.getElementById('step1');
    let valid = true;

    // Email validation
    const emailField = document.querySelector('[name="email"]');
    const emailError = document.querySelector('.email-error');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailField || !emailField.value.trim() || !emailPattern.test(emailField.value.trim())) {
        valid = false;
        emailError?.classList.remove('d-none');
    } else {
        emailError?.classList.add('d-none');
    }

    // Required fields validation
    const requiredInputs = step1.querySelectorAll('[required]');
    requiredInputs.forEach(el => {
        if (!el.value || !el.value.trim()) {
            valid = false;
        }
    });

    const validationError = step1.querySelector('.validation-error');
    if (validationError) {
        validationError.classList.toggle('d-none', valid);
    }

    return valid;
}

async function fetchDirectAssessmentDraft() {
    const startBtn = document.getElementById('startBtn');

    const payload = {
        parent_name: document.querySelector('[name="parent_name"]').value.trim(),
        child_name: document.querySelector('[name="child_name"]').value.trim(),
       // year_level: document.querySelector('[name="year_level"]').value,
        state: document.querySelector('[name="state"]').value,
        email: document.querySelector('[name="email"]').value.trim()
    };

    startBtn.disabled = true;
    startBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Starting...';

    try {
        const response = await fetch("{{ route('assessment.fetch_draft', ['type' => $type]) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.status === 422) {
            alert('Please fill out all fields correctly.');
            return;
        }

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Unable to start assessment.');
        }

        const targetUrl = data.redirect_url || data.redirect;
        if (targetUrl) {
            window.location.href = targetUrl;
        } else {
            throw new Error('No redirect URL was returned by the server.');
        }

    } catch (error) {
        console.error(error);
        alert(error.message || 'Something went wrong. Please try again.');
    } finally {
        startingAssessment = false;
        startBtn.disabled = false;
        startBtn.innerHTML = 'Start';
    }
}

function startAssessment() {
    if (startingAssessment) {
        return;
    }

    if (!validateForm()) {
        return;
    }

    startingAssessment = true;
    fetchDirectAssessmentDraft();
}
</script>
@endsection