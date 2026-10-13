@extends('layouts.app')

@section('page_title', 'V-Tutor | Resume Assessment')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')

<section class="about-banner" style="background-image: url({{ public_asset('assets/images/faq-banner.jpg') }});">
    <div class="container">
        <h1 class="text-white text-center">
            Continue Assessment
        </h1>
    </div>
</section>

<section class="makes_special_sec faq-sec mt-6">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-md-8 offset-md-2">
                <div class="assessment-box">
                    <h4 class="text-center mt-2 mb-4">
                        Enter Email to Continue
                    </h4>

                    <form id="resumeForm" autocomplete="off" novalidate>
                        @csrf
                        <input type="hidden" name="form_slug" value="{{ $type }}">

                        <div class="mb-3">
                            <input
                                type="email"
                                name="email"
                                id="resumeEmail"
                                class="form-control"
                                placeholder="Enter your registered email"
                                required
                            >
                            <div class="text-danger mt-1 d-none" id="emailError">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <div id="alertMsg" class="alert alert-danger d-none mt-3" role="alert"></div>

                        <!-- Action Controls Layout -->
                        <!-- Action Controls Layout -->
<div class="mt-4 action-row align-items-end">
    <!-- Left Spacer (Maintains true center alignment for Continue button) -->
    <div class="d-none d-md-block"></div>

    <!-- Centered Continue Button -->
    <div class="text-center">
        <button
            type="button"
            id="continueBtn"
            class="btn btn-danger px-4"
            onclick="checkAssessment()"
        >
            Continue
        </button>
    </div>

    <!-- Right-Aligned Back Link (Pure CSS Inline Override) -->
    <div class="pt-2 pt-md-0" style="text-align: right !important; width: 100%;">
        <a href="javascript:history.back()" 
           class="text-decoration-underline fw-bold fs-6 d-inline-block" 
           style="color: #D7263D !important; line-height: 1.2; float: right;">
            Back
        </a>
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
async function checkAssessment() {
    const emailInput = document.getElementById('resumeEmail');
    const emailError = document.getElementById('emailError');
    const alertMsg = document.getElementById('alertMsg');
    const continueBtn = document.getElementById('continueBtn');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    alertMsg.classList.add('d-none');
    
    if (!emailInput.value.trim() || !emailPattern.test(emailInput.value.trim())) {
        emailError.classList.remove('d-none');
        return;
    } else {
        emailError.classList.add('d-none');
    }

    continueBtn.disabled = true;
    continueBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Checking...';

    try {
        const response = await fetch("{{ route('program.assessment.check_existing') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                email: emailInput.value.trim(),
                form_slug: "{{ $type }}"
            })
        });

        const data = await response.json();

        if (response.ok && data.success && data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            alertMsg.textContent = data.message || 'No assessment existing please create new one.';
            alertMsg.classList.remove('d-none');
        }
    } catch (error) {
        console.error(error);
        alertMsg.textContent = 'Something went wrong. Please try again.';
        alertMsg.classList.remove('d-none');
    } finally {
        continueBtn.disabled = false;
        continueBtn.innerHTML = 'Continue';
    }
}
</script>
@endsection