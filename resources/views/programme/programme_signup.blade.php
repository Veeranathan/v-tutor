@extends('layouts.app')

@section('title')
    <title>V-Tutor | Tutor | Sign up</title>
@endsection

<!-- @section('left_part')
    @include('include.header_menu_part')
@endsection -->

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden;
    }

    /* ---------- Full Page Fit: NO Browser Scroll ---------- */

    section.login-body {
        min-height: 100vh;
        overflow: hidden;
    }

    /* ---------- Left + Right Layout ---------- */
    /* ---------- Left + Right Layout: Equal Split ---------- */

    .login-body {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* Left side: 50% */
    .login-body .left-side {
        flex: 0 0 50%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #000;
    }

    /* Left image: fit the container */
    .left-banner-img {
        width: 100%;
        height: auto;
        max-height: 100%;
        object-fit: contain;
        /* KEY FIX */
        display: block;
        transform: scale(1.07);
    }


    /* Right side: 50% */
    .login-body .right-side {
        flex: 0 0 50%;
        height: 100vh;
        overflow-y: auto;
        padding: 50px 30px;
        background: #f5f5f5;
    }

    /* ---------- Responsive: Stack on small screens ---------- */
    @media (max-width: 991px) {
        .login-body {
            flex-direction: column;
            height: auto;
        }

        .left-side,
        .right-side {
            flex: 1 1 100%;
            height: auto;
            padding: 20px;
        }

    }

    /* ---------- Form Container ---------- */
    .programme-details {
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
        background: #fff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
    }

    /* Heading */
    .upper-login h2 {
        margin-bottom: 6px;
    }

    .upper-login p {
        margin-bottom: 25px;
        color: #666;
        font-size: 14px;
    }

    /* Inputs */
    .form_area input[type="text"],
    .form_area input[type="email"],
    .form_area select {
        width: 100%;
        padding: 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form_area input:focus,
    .form_area select:focus {
        border-color: #D7263D;
        box-shadow: 0 4px 12px rgba(215, 38, 61, 0.15);
        outline: none;
    }

    /* Buttons */
    .submit-login {
        background: #D7263D !important;
        color: #fff !important;
        border: none;
        padding: 14px 25px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 10px;
        width: 100%;
        box-shadow: 0 6px 15px rgba(215, 38, 61, 0.3);
        transition: all 0.25s ease;

        /* Fix text alignment */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .submit-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(215, 38, 61, 0.4);
    }

    /* Step sections */
    .step-section {
        display: none;
    }

    .step-section.active {
        display: block;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    /* ---------- Card Styles ---------- */
    /* ---------- Program Select Card ---------- */
    .select-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 15px;
        cursor: pointer;
        padding: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #f7f8fa 100%);

        /* Stronger box shadow */
        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.1),
            0 4px 10px rgba(0, 0, 0, 0.08);

        transition: all 0.3s ease;
    }

    /* Hover effect */
    .select-card:hover {
        transform: translateY(-3px);
        border-color: #D7263D;
        box-shadow:
            0 12px 30px rgba(215, 38, 61, 0.2),
            0 8px 20px rgba(0, 0, 0, 0.12);
    }

    /* Selected (Active) card */
    .select-card.active {
        border-color: #D7263D;
        background: linear-gradient(180deg, #fff5f6 0%, #ffecee 100%);
        box-shadow:
            0 16px 40px rgba(215, 38, 61, 0.25),
            0 10px 25px rgba(0, 0, 0, 0.15);
    }


    .select-card input {
        display: none;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
    }

    /* Desktop: align Grade and Time in same vertical line */
    @media (min-width: 992px) {

        /* large screens and above */
        .select-card .card-text {
            display: grid;
            grid-template-columns: 250px 1fr;
            /* fixed left column width */
            gap: 10px;
            margin-bottom: 5px;
        }

        .select-card .card-text span {
            display: block;
        }

        .select-card .card-text span.left {
            text-align: left;
        }

        .select-card .card-text span.right {
            text-align: left;
            /* you can change to right if desired */
        }
    }

    /* Mobile: use default stacked layout */
    @media (max-width: 991px) {
        section.login-body {
            margin: 0 !important;
            padding: 0 !important;
        }

        .login-body.mb-8 {
            margin-bottom: 0 !important;
        }

        .login-body {
            flex-direction: column;
        }

        .login-body .left-side {
            width: 100%;
            height: 220px;
            padding: 0;
            margin: 0;
            overflow: hidden;
            background: #f5f5f5;

            /* IMPORTANT FIX */
            display: block;
            /* remove flex on mobile */
        }

        .left-banner-img {
            width: 100%;
            height: 100%;
            display: block;

            /* Chrome + Firefox consistent */
            object-fit: cover;
            /* 🔑 key change */
            object-position: center top;
            transform: none;
        }


        .login-body .right-side {
            width: 100%;
            height: auto;
            overflow: visible;
            padding: 20px;
        }
    }


    .txt-center {
        text-align: center;
    }


    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .center-logo {
        display: block;
        margin: 0 auto 20px auto;
        width: 110px;
    }
</style>

@section('content')
    <section class="login-body tutor-body mb-8">

        <!-- LEFT IMAGE -->
        <div class="left-side">
            <img src="{{ public_asset('assets/tutor_landing/summer_holiday_program_2025_hero.svg') }}" alt="Holiday Programme"
                class="left-banner-img" id="scrollToForm">
        </div>

        <!-- RIGHT FORM -->
        <div class="right-side">
            <div class="programme-details" id="formSection">

                <div id="successMessage"
                    style="display:none;text-align:center;padding:40px 20px;animation: fadeIn .6s ease-in-out;">
                    <img src="{{ public_asset('assets/tutor_landing/v-tutor-logo-program.png') }}" class="center-logo"
                        alt="Online Tutors Australia">
                    <h2 style="color:#28a745; margin-bottom:10px;">Thank You for Registering! </h2>
                    <p style="font-size:16px; color:#444;">
                        Your participation is confirmed. Please check your email for workshop information.<br>
                        For enquiries, email events@v-tutor.com.au
                    </p>
                </div>


                @include('include.errors')

                <form method="POST" id="mainForm">
                    @csrf

                    <!-- STEP 2  First-->
                    <div id="step2" class="step-section">
                        <h3 class="txt-center">Pick Your Holiday Workshops</h3>
                        <p class="mb-4 txt-center">Choose at least one session your child would like to join</p>

                        @php
                            $programmes = [
                                [
                                    'topic' => 'Book Chat Club',
                                    'subject' => 'English',
                                    'grade' => 'All levels',
                                    'date' => '18th Dec',
                                    'day' => 'Thursday',
                                    'time' => '4:45-5:45pm',
                                    'description' =>
                                        'A fun reading circle where students explore stories together through themes, characters, vocabulary, and meaningful discussions.',
                                ],
                                [
                                    'topic' => 'Creative Story Writing',
                                    'subject' => 'English',
                                    'grade' => 'All levels',
                                    'date' => '19th Dec',
                                    'day' => 'Friday',
                                    'time' => '4:45-5:45pm',
                                    'description' =>
                                        'Students learn how to build strong characters, themes and messages, then craft a creative story inspired by their favourite reads.',
                                ],
                                [
                                    'topic' => 'Hot Topics in Science',
                                    'subject' => 'Science',
                                    'grade' => 'All years',
                                    'date' => '20th Dec',
                                    'day' => 'Saturday',
                                    'time' => '11am-12pm',
                                    'description' =>
                                        'An interactive science session exploring cool facts and real-world wonders across biology, chemistry, physics and space.',
                                ],
                                [
                                    'topic' => 'Maths Brain Games 1',
                                    'subject' => 'Maths',
                                    'grade' => 'Years 1-6',
                                    'date' => '20th Dec',
                                    'day' => 'Saturday',
                                    'time' => '1-2pm',
                                    'description' =>
                                        'An interactive maths class with puzzles, patterns, riddles and fast-paced challenges to build skills and confidence.',
                                ],
                                [
                                    'topic' => 'Maths Brain Games 2',
                                    'subject' => 'Maths',
                                    'grade' => 'Years 7-10',
                                    'date' => '22nd Dec',
                                    'day' => 'Monday',
                                    'time' => '11am-12pm',
                                    'description' =>
                                        'An interactive maths class with puzzles, patterns, riddles and fast-paced challenges to build skills and confidence.',
                                ],
                                [
                                    'topic' => 'Public Speaking & Confidence Booster',
                                    'subject' => 'General + Tech',
                                    'grade' => 'All years',
                                    'date' => '23rd Dec',
                                    'day' => 'Tuesday',
                                    'time' => '11am-12pm',
                                    'description' =>
                                        'A guided discussion and debate session that builds confidence, critical thinking and responsible use of technology and AI.',
                                ],
                                [
                                    'topic' => 'Healthy and Positive Studying',
                                    'subject' => 'General',
                                    'grade' => 'Years 7-12',
                                    'date' => '23rd Dec',
                                    'day' => 'Tuesday',
                                    'time' => '1-2pm',
                                    'description' =>
                                        'A wellbeing-focused session where students build confidence, resilience and healthy study habits while setting goals for 2026.',
                                ],
                            ];
                        @endphp

                        @foreach ($programmes as $index => $p)
                            <div class="select-card" data-target="program{{ $index }}">
                                <input type="checkbox" id="program{{ $index }}" name="programs[]"
                                    value="{{ $p['topic'] }}" class="program-check">
                                <div class="card-title mb-1">{{ $p['topic'] }}</div>
                                <p style="font-size:12px; line-height:1.2; color:#555; margin-bottom:2px;">
                                    {{ $p['description'] }}</p>
                                <div class="card-text">
                                    <span class="left"><strong>Subject:</strong> {{ $p['subject'] }}</span>
                                    <span class="right"><strong>Grade:</strong> {{ $p['grade'] }}</span>
                                </div>
                                <div class="card-text">
                                    <span class="left"><strong>Date:</strong> {{ $p['date'] }}
                                        ({{ $p['day'] }})
                                    </span>
                                    <span class="right"><strong>Time:</strong> {{ $p['time'] }}</span>
                                </div>
                            </div>
                        @endforeach

                        <div style="display:flex; justify-content:space-between; gap:20px; margin-top:25px;">
                            <button type="button" class="submit-login" id="goStep3" style="width:48%;">Next</button>
                        </div>
                    </div>

                    <!-- STEP 3 Second -->
                    <div id="step3" class="step-section">
                        <h3 class="txt-center">Program Terms & Guidelines</h3>
                        <p class="mb-4 txt-center">Please read the terms below and confirm to continue</p>

                        @php
                            $terms = [
                                'Our workshops are group-based sessions created to encourage shared learning, creativity, and a fun holiday experience.',
                                "These activities are not formal tutoring or academic lessons. For personalised 1:1 support, you’re welcome to explore our tutoring options on the <a href='" .
                                route('landing.page') .
                                "' target='_blank'>homepage</a>.",
                                'We kindly request that all communication between parents, students, and tutors remains positive, respectful, and supportive.',
                                "Some sessions may be recorded for quality and monitoring, and all recordings are handled in line with our <a href='" .
                                route('privacy.policy') .
                                "' target='_blank'>Privacy Policy</a>.",
                                "If you have any questions at any time, our team is here to help at <a href='mailto:events@v-tutor.com.au'>events@v-tutor.com.au</a>.",
                            ];
                        @endphp

                        <!-- Terms as simple list -->
                        <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 20px;">
                            @foreach ($terms as $term)
                                <li style="margin-bottom: 10px;">{!! $term !!}</li>
                            @endforeach
                        </ul>

                        <!-- Final confirmation checkbox -->
                        <div class="check-box">
                            <input type="checkbox" id="finalConfirm" name="terms" class="terms-check" value="1">
                            <label for="finalConfirm" class="checklabeel">
                                I agree to all terms and conditions of the program.
                            </label>
                        </div>

                        <div style="display:flex; justify-content:space-between; gap:20px; margin-top:25px;">
                            <button type="button" class="submit-login" id="backToStep2" style="width:48%;">Back</button>
                            <button type="button" class="submit-login" id="goStep1" style="width:48%;">Next</button>
                        </div>
                    </div>

                    <!-- STEP 1 Final -->
                    <div id="step1" class="step-section active">
                        <div class="upper-login">
                            <h2 class="txt-center">Summer Holiday Program 2025</h2>
                            <p class="txt-center mb-4">Enter the following details to get started</p>
                        </div>
                        <div class="form_area">
                            <input type="text" name="parent_name" placeholder="Parent Name" required>
                        </div>
                        <div class="form_area">
                            <input type="email" name="email" placeholder="Email Address" required id="email">
                            <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
                        </div>
                        <div class="form_area">
                            <input type="text" name="student_name" placeholder="Student Name" required>
                        </div>
                        <div class="form_area">
                            <select name="student_grade" required>
                                <option value="">Select Student Grade</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="Year {{ $i }}">Year {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form_area">
                            <select name="ref_source" required>
                                <option value="">Select the State / Territory you are from?</option>
                                <option value="Google">New South Wales</option>
                                <option value="Victoria">Victoria</option>
                                <option value="Queensland">Queensland</option>
                                <option value="South Australia">South Australia</option>
                                <option value="Tasmania">Tasmania</option>
                                <option value="Western Australia">Western Australia</option>
                                <option value="Australian Capital Territory">Australian Capital Territory</option>
                                <option value="Northern Territory">Northern Territory</option>
                            </select>
                        </div>
                        <div class="form_area checkbox-item">
                            <input type="checkbox" name="subscribe" value="1" style="width:auto;">
                            <span>Subscribe for newsletters, announcements and promotional emails in future.</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; gap:20px; margin-top:25px;">
                            <button type="button" class="submit-login" id="backToStep3"
                                style="width:48%;">Back</button>
                            <button type="submit" class="submit-login" id="finalSubmitBtn"
                                style="width:48%;">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            /** -----------------------------
             HELPER: SHOW STEP
             ----------------------------- **/
            function showStep(stepId) {
                $(".step-section").removeClass("active");
                $("#" + stepId).addClass("active");
            }

            /** -----------------------------
             RESET FORM ON PAGE LOAD
             ----------------------------- **/
            function resetForm() {
                $("#mainForm")[0].reset();
                $(".step-section").removeClass("active");
                $(".select-card").removeClass("active");
                $("#successMessage").hide();
                $("#emailError").hide();

                // START FROM STEP 2 (NEW FIRST STEP)
                showStep("step2");
            }

            resetForm();

            /** -----------------------------
             STEP NAVIGATION (NEW FLOW)
             ----------------------------- **/

            // STEP 2 → STEP 3
            $("#goStep3").click(function() {
                if ($(".program-check:checked").length === 0) {
                    alert("Please select at least one programme.");
                    return;
                }
                showStep("step3");
            });

            // STEP 3 → STEP 2
            $("#backToStep2").click(function() {
                showStep("step2");
            });

            // STEP 3 → STEP 1
            $("#goStep1").click(function() {
                if (!$("#finalConfirm").is(":checked")) {
                    alert("Please confirm the terms to continue.");
                    return;
                }
                showStep("step1");
            });

            // STEP 1 → STEP 3
            $("#backToStep3").click(function() {
                showStep("step3");
            });

            /** -----------------------------
             DUPLICATE EMAIL CHECK (FIXED)
             ----------------------------- **/
            let emailCheckRequest = null;

            $("#email").on("blur", function() {
                let email = $(this).val().trim();
                let errorSpan = $("#emailError");

                // Clear old error immediately
                errorSpan.hide().text("");

                if (email === "") {
                    return;
                }

                // Abort previous request if still running
                if (emailCheckRequest !== null) {
                    emailCheckRequest.abort();
                }

                emailCheckRequest = $.ajax({
                    url: "{{ route('programme.signup.email.check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(res) {
                        // ✅ Show error ONLY if input still matches response email
                        if ($("#email").val().trim() !== email) {
                            return;
                        }

                        if (res.exists) {
                            errorSpan.text(res.message).show();
                        } else {
                            errorSpan.hide().text("");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.statusText !== "abort") {
                            errorSpan.hide().text("");
                        }
                    }
                });
            });

            /** -----------------------------
             CARD CLICK SELECT
             ----------------------------- **/
            $(".select-card").on("click", function() {
                let checkbox = $(this).find("input[type='checkbox']");
                checkbox.prop("checked", !checkbox.prop("checked"));
                $(this).toggleClass("active", checkbox.is(":checked"));
            });

            /** -----------------------------
             AJAX FORM SUBMISSION (FINAL STEP)
             ----------------------------- **/
            $("#mainForm").on("submit", function(e) {
                e.preventDefault();

                let emailError = $("#emailError").text().trim();
                if (emailError !== "") {
                    alert("This email is already registered.");
                    return;
                }

                if (!$("#mainForm").valid()) {
                    return;
                }

                let submitBtn = $("#finalSubmitBtn");
                submitBtn.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" style="margin-right:6px;"></span>
            Submitting...
        `);

                fetch("{{ route('programme.signup.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: new FormData(this)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            $("#mainForm").hide();
                            $("#successMessage").show();
                        } else {
                            alert("Validation error.");
                        }
                        submitBtn.prop("disabled", false).html("Submit");
                    })
                    .catch(() => {
                        submitBtn.prop("disabled", false).html("Submit");
                    });
            });

        });
        // Scroll to form on image click (responsive mainly)
        $("#scrollToForm").on("click", function() {
            if ($(window).width() < 992) { // only for small screens
                $('html, body').animate({
                    scrollTop: $("#formSection").offset().top
                }, 600);
            }
        });
    </script>
@endsection
