@extends('layouts.app')

@section('page_title', 'V-Tutor | Learning Program Assessment')

@section('left_part')
    @include('include.header_menu_part')
@endsection

@section('content')
@php
$title = 'Verify Your Email';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => false
])

<!-- =======================
          MAIN SECTION
======================== -->
<section class="makes_special_sec faq-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-md-8 offset-md-2">

                <div class="assessment-box text-center">

                    <h3 class="mb-2">Enter OTP</h3>
                    <p class="mb-4">
                        Please enter the 6-digit OTP sent to your registered email address.
                    </p>

                    <form id="otpForm">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group mb-4">
                            <input
                                type="text"
                                name="otp"
                                class="form-control text-center"
                                placeholder="Enter OTP"
                                maxlength="6"
                                style="font-size:20px; letter-spacing:4px;"
                            >
                        </div>

                        <button type="button" class="assessment-btn" id="verifyOtpBtn">
                            Verify & Continue
                        </button>
                        <!-- Resend OTP Section -->
                        <div class="mt-4">
                            <p class="mb-0 text-muted">
                                Didn't receive the OTP? 
                            <a href="javascript:void(0);" id="resendOtpBtn" class="font-weight-bold text-primary">Resend OTP</a>
                              <span id="resendTimer" class="text-muted ms-2" style="display:none;"></span>
                            </p>
                         </div>
                        <div id="otpError" class="backend-error text-danger mt-3" style="display:none;"></div>
                        <div id="otpSuccess" class="backend-success text-success mt-3" style="display:none;"></div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
    $(document).ready(function () {

    // OTP form validation
    $('#otpForm').validate({
        rules: {
            otp: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6
            }
        },
        messages: {
            otp: {
                required: "OTP is required",
                digits: "OTP must be numeric",
                minlength: "OTP must be 6 digits",
                maxlength: "OTP must be 6 digits"
            }
        }
    });

    // AJAX Verify OTP Submission
    $('#verifyOtpBtn').on('click', function () {

        if (!$('#otpForm').valid()) return;

        $('#otpError, #otpSuccess').hide().text('');

        let btn = $(this);
        btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm"></span> Verifying...`);

        fetch("{{ route('program.assessment.otp.verify') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: new FormData(document.getElementById('otpForm'))
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else if (data.message) {
                $('#otpError').text(data.message).show();
            } else if (data.errors) {
                let errors = Object.values(data.errors).flat();
                $('#otpError').text(errors[0]).show();
            }
        })
        .catch(() => {
            $('#otpError').text("Something went wrong. Please try again.").show();
        })
        .finally(() => {
            btn.prop('disabled', false).text("Verify & Continue");
        });

    });

    // --- RESEND OTP LOGIC ---
    let timerInterval = null;

    function startResendCooldown(seconds = 60) {
        let resendBtn = $('#resendOtpBtn');
        let timerSpan = $('#resendTimer');

        resendBtn.css({'pointer-events': 'none', 'opacity': '0.5'});
        timerSpan.show().text(`(${seconds}s)`);

        timerInterval = setInterval(() => {
            seconds--;
            if (seconds > 0) {
                timerSpan.text(`(${seconds}s)`);
            } else {
                clearInterval(timerInterval);
                resendBtn.css({'pointer-events': 'auto', 'opacity': '1'});
                timerSpan.hide();
            }
        }, 1000);
    }

    $('#resendOtpBtn').on('click', function (e) {
        e.preventDefault();

        $('#otpError, #otpSuccess').hide().text('');

        let resendLink = $(this);
        resendLink.css('pointer-events', 'none').text('Sending...');

        let formData = new FormData();
        formData.append('token', '{{ $token }}');

        fetch("{{ route('program.assessment.otp.resend') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            resendLink.text('Resend OTP');
            if (data.success) {
                $('#otpSuccess').text(data.message).show();
                startResendCooldown(60); // 60-second delay before allowing another resend
            } else {
                resendLink.css('pointer-events', 'auto');
                $('#otpError').text(data.message || "Could not resend OTP.").show();
            }
        })
        .catch(() => {
            resendLink.text('Resend OTP').css('pointer-events', 'auto');
            $('#otpError').text("Something went wrong. Please try again.").show();
        });
    });

    });
    </script>

    <style>
    .assessment-box {
        background: #fff;
        border-top: 6px solid #b80f0a;
        border-radius: 16px;
        padding: 45px 30px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        margin-top: 40px;
    }

    .assessment-btn {
        background: #b80f0a;
        color: #fff;
        padding: 14px 45px;
        font-size: 18px;
        border-radius: 12px;
        border: none;
    }

    .form-control {
        height: 55px;
    }
    </style>

@endsection
