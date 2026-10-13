    <!-- MODAL -->
    <div class="modal fade" id="assessmentModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content assessment-modal">

                <!-- TOP PROGRESS BAR -->
                <div class="assessment-top-progress">
                    <div class="assessment-top-progress-fill" id="assessmentProgress"></div>
                </div>

                <form id="assessmentForm" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="assessment_for" id="assessmentFor">

                    <div class="modal-body assessment-form">

                        <!-- STEP 0 -->
                        <div class="assessment-step step-0 active">
                            <div class="step-header">
                                <span></span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                Great! What are you looking for today?
                            </h4>

                            <div class="reason-grid reason-grid-compact">

                                <label class="reason-card">
                                    <input type="radio" name="visit_reason" value="free_assessment" required>
                                    <div class="reason-content">
                                        <div class="reason-icon">🎓</div>
                                        <div class="reason-text">Diagnostic Assessment</div>
                                        <p class="reason-subtext">
                                            A complimentary assessment to see where your child stands
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="visit_reason" value="book_session" disabled>
                                    <div class="reason-content">
                                        <div class="reason-icon">📅</div>
                                        <div class="reason-text">Tutoring Session</div>
                                        <p class="reason-subtext">
                                            Book a 1-to-1 session with a qualified tutor
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="visit_reason" value="explore" disabled>
                                    <div class="reason-content">
                                        <div class="reason-icon">🔍</div>
                                        <div class="reason-text">Academic Learning Programs</div>
                                        <p class="reason-subtext">
                                            Discovery programs designed around your child's needs
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="visit_reason" value="research" disabled>
                                    <div class="reason-content">
                                        <div class="reason-icon">📘</div>
                                        <div class="reason-text">Simply Exploring</div>
                                        <p class="reason-subtext">
                                            Looking around to see if V-Tutor is right for you
                                        </p>
                                    </div>
                                </label>

                            </div>
                        </div>


                        <!-- STEP 1 (School Year – List + Inline Dropdown) -->
                        <div class="assessment-step step-1">
                            <div class="step-header">
                                <span class="step-back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                Excellent! Which grade is your child currently in?
                            </h4>

                            <div class="school-year-list">
                                <input type="hidden" name="grade" id="selectedGrade">
                                <!-- ITEM -->
                                <div class="school-year-item" data-level="Primary School">
                                    <label class="school-year-label">
                                        <input type="radio" name="school_year" value="Primary School">
                                        <span class="icon">🧒</span>
                                        <span class="text">Primary School</span>
                                    </label>

                                    <div class="inline-dropdown">
                                        <select class="grade-select">
                                            <option value="">Select Grade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="school-year-item" data-level="High School">
                                    <label class="school-year-label">
                                        <input type="radio" name="school_year" value="High School">
                                        <span class="icon">🎒</span>
                                        <span class="text">High School</span>
                                    </label>

                                    <div class="inline-dropdown">
                                        <select class="grade-select">
                                            <option value="">Select Grade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="school-year-item" data-level="Senior Secondary">
                                    <label class="school-year-label">
                                        <input type="radio" name="school_year" value="Senior Secondary">
                                        <span class="icon">🎓</span>
                                        <span class="text">Senior Years</span>
                                    </label>

                                    <div class="inline-dropdown">
                                        <select class="grade-select">
                                            <option value="">Select Grade</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="school-year-item" data-level="Home Schooled">
                                    <label class="school-year-label">
                                        <input type="radio" name="school_year" value="Home Schooled">
                                        <span class="icon">🏡</span>
                                        <span class="text">Home Schooled</span>
                                    </label>

                                    <div class="inline-dropdown">
                                        <select class="grade-select">
                                            <option value="">Select Grade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="school-year-item" data-level="Not Studying">
                                    <label class="school-year-label">
                                        <input type="radio" name="school_year" value="Not Studying">
                                        <span class="icon">⏸️</span>
                                        <span class="text">Not Studying</span>
                                    </label>

                                    <div class="inline-dropdown">
                                        <select class="grade-select">
                                            <option value="">Select Age</option>
                                        </select>
                                    </div>
                                </div> -->

                            </div>
                        </div>



                        <!-- STEP 2 (State Selection – BOX STYLE) -->
                        <div class="assessment-step step-2">
                            <div class="step-header">
                                <span class="step-back" id="step2Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                Great! Which state or territory are you based in?
                            </h4>

                            <div class="state-grid">

                                @php
                                    $states = [
                                        'New South Wales' => '🏙️',
                                        'Victoria' => '🎭',
                                        'Queensland' => '🌴',
                                        'South Australia' => '🏜️',
                                        'Tasmania' => '🌲',
                                        'Western Australia' => '🌅',
                                        'Australian Capital Territory' => '🏛️',
                                        'Northern Territory' => '🌄',
                                    ];
                                @endphp

                                @foreach ($states as $state => $icon)
                                    <label class="state-card">
                                        <input type="radio" name="state" value="{{ $state }}" required>

                                        <div class="state-content">
                                            <div class="state-icon">{{ $icon }}</div>
                                            <div class="state-text">{{ $state }}</div>
                                        </div>
                                    </label>
                                @endforeach

                            </div>
                        </div>


                        <!-- STEP 3 (Subject Selection – ) -->
                        <!-- <div class="assessment-step step-3">
                            <div class="step-header">
                                <span class="step-back" id="step3Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                Awesome! Which subjects would your child like support with?
                            </h4>
                            @php
                                $allowedBranches = ['Maths', 'Science', 'English'];
                            @endphp

                            <div class="state-grid">
                                @foreach ($branches->whereIn('branch_name', $allowedBranches) as $branch)
                                <label class="state-card">
                                    <input type="radio" name="subject" value="{{ $branch->branch_name }}" required>
                                    <div class="state-content">
                                        <div class="state-icon">
                                            @if($branch->branch_name == 'English') 📘
                                            @elseif($branch->branch_name == 'Maths') 📐
                                            @elseif($branch->branch_name == 'Science') 🔬
                                            @endif
                                        </div>
                                    <div class="state-text">
                                        {{ $branch->branch_name }}
                                    </div>
                                </div>
                                </label>
                                @endforeach
                            </div>
                        </div> -->
                        <div class="assessment-step step-3">
    <div class="step-header">
        <span class="step-back" id="step3Back">&larr;</span>
        <span class="step-close" data-dismiss="modal">&times;</span>
    </div>

    <h4 class="text-center mb-4 mt-3">
        Awesome! Which subjects would your child like support with?
    </h4>
    <h5 class="text-center mb-3 mt-3 reason-italic">
        Select all subjects that apply
    </h5>

    @php
        $allowedBranches = ['Maths', 'Science', 'English'];
    @endphp

    <div class="state-grid">
        @foreach ($branches->whereIn('branch_name', $allowedBranches) as $branch)
        <label class="state-card">
            <input type="checkbox" name="subjects[]" value="{{ $branch->branch_name }}">
            <div class="state-content">
                <div class="state-icon">
                    @if($branch->branch_name == 'English') 📘
                    @elseif($branch->branch_name == 'Maths') 📐
                    @elseif($branch->branch_name == 'Science') 🔬
                    @endif
                </div>
                <div class="state-text">
                    {{ $branch->branch_name }}
                </div>
            </div>
        </label>
        @endforeach
    </div>

    <!-- CONTINUE BUTTON & VALIDATION -->
    <div class="text-center mt-4">
        <button type="button" class="assessment-btn" id="toStep4FromSubject">
            Continue
        </button>
        <div class="text-center mt-2">
            <small class="error-text d-none" id="subjectError">
                Please select at least one subject to continue.
            </small>
        </div>
    </div>
</div>


                        <!-- STEP 4 (Learning Needs) -->
                        <!-- <div class="assessment-step step-4">

                            <div class="step-header">
                                <span class="step-back" id="step4Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                What best describes your
                                {{-- <span id="needYearText"></span> --}}
                                <span id="needSubjectText"></span>
                                learning needs?
                            </h4>

                            <div class="reason-grid">
                                <input type="hidden" name="learning_need_title" id="learningNeedTitle">
                                <label class="reason-card">
                                    <input type="radio" name="learning_need" value="falling_behind" required>
                                    <div class="reason-content" data-need="falling_behind">
                                        <div class="reason-icon">📉</div>
                                        <div class="reason-text"></div>
                                        <p></p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="learning_need" value="motivation">
                                    <div class="reason-content" data-need="motivation">
                                        <div class="reason-icon">🔥</div>
                                        <div class="reason-text"></div>
                                        <p></p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="learning_need" value="extend_learning">
                                    <div class="reason-content" data-need="extend_learning">
                                        <div class="reason-icon">🚀</div>
                                        <div class="reason-text"></div>
                                        <p></p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="radio" name="learning_need" value="individual_needs">
                                    <div class="reason-content" data-need="individual_needs">
                                        <div class="reason-icon">🧩</div>
                                        <div class="reason-text"></div>
                                        <p></p>
                                    </div>
                                </label>

                            </div>
                        </div> -->
                        <!-- STEP 4 (Learning Needs) -->
<div class="assessment-step step-4">

    <div class="step-header">
        <span class="step-back" id="step4Back">&larr;</span>
        <span class="step-close" data-dismiss="modal">&times;</span>
    </div>

    <h4 class="text-center mb-4 mt-3">
        What best describes your
        <span id="needSubjectText"></span>
        learning needs?
    </h4>

    <div class="reason-grid">
        <input type="hidden" name="learning_need_title" id="learningNeedTitle">
        
        <label class="reason-card">
            <input type="radio" name="learning_need" value="falling_behind" required>
            <div class="reason-content" data-need="falling_behind">
                <div class="reason-icon">📉</div>
                <div class="reason-text">Building Strong Foundations</div>
                <p>My child would benefit from support with reading, writing, or comprehension skills.</p>
            </div>
        </label>

        <label class="reason-card">
            <input type="radio" name="learning_need" value="motivation">
            <div class="reason-content" data-need="motivation">
                <div class="reason-icon">🔥</div>
                <div class="reason-text">Confidence & Expression</div>
                <p>My child understands the work but struggles with confidence, expression, or engagement.</p>
            </div>
        </label>

        <label class="reason-card">
            <input type="radio" name="learning_need" value="extend_learning">
            <div class="reason-content" data-need="extend_learning">
                <div class="reason-icon">🚀</div>
                <div class="reason-text">Extending Skills & Thinking</div>
                <p>My child is doing well and would benefit from more advanced learning, deeper thinking, or greater challenge.</p>
            </div>
        </label>

        <label class="reason-card">
            <input type="radio" name="learning_need" value="individual_needs">
            <div class="reason-content" data-need="individual_needs">
                <div class="reason-icon">🧩</div>
                <div class="reason-text">Personalised Learning Support</div>
                <p>My child learns best with tailored guidance, individual attention, and support beyond the classroom.</p>
            </div>
        </label>

    </div>
</div>


                        <!-- STEP 5 (Free Time Preference) -->
                        <div class="assessment-step step-5">
                            <div class="step-header">
                                <span class="step-back" id="step5Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                To help us personalise learning, tell us what your child enjoys most?
                            </h4>

                            <div class="hobby-grid">

                                <label class="hobby-card">
                                    <input type="radio" name="free_time" value="creative" required>
                                    <div class="hobby-content">
                                        <div class="hobby-icon">🎨</div>
                                        <h5>Creative & Curious​</h5>
                                        <p>
                                            Enjoys reading, writing, drawing, building, or creating — with hands or code.
                                        </p>
                                    </div>
                                </label>

                                <label class="hobby-card">
                                    <input type="radio" name="free_time" value="performing">
                                    <div class="hobby-content">
                                        <div class="hobby-icon">🎭</div>
                                        <h5>Expressive & Social</h5>
                                        <p>
                                            Enjoys performing, music, drama, storytelling, or entertaining others.
                                        </p>
                                    </div>
                                </label>

                                <label class="hobby-card">
                                    <input type="radio" name="free_time" value="playing">
                                    <div class="hobby-content">
                                        <div class="hobby-icon">⚽</div>
                                        <h5>Active & Energetic</h5>
                                        <p>
                                            Enjoys sports, outdoor activities, and staying physically active.
                                        </p>
                                    </div>
                                </label>


                            </div>
                        </div>
                        <!-- 6 (Assessment Outcome) -->
                        <div class="assessment-step step-6">

                            <div class="step-header">
                                <span class="step-back" id="step6Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-3 mt-3">
                                Finally, what would you like to achieve from this assessment?
                            </h4>
                            <h5 class="text-center mb-3 mt-3 reason-italic">
                                Select all outcomes that apply
                            </h5>

                            <div class="reason-grid reason-grid-compact">

                                <label class="reason-card">
                                    <input type="checkbox" name="assessment_outcomes[]"
                                        value="Get an overall learning snapshot">
                                    <div class="reason-content">
                                        <div class="reason-icon">💪</div>
                                        <div class="reason-text">Get an overall learning snapshot​</div>
                                        <p class="reason-subtext">
                                            I’d like a clear picture of my child’s current learning level.
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="checkbox" name="assessment_outcomes[]"
                                        value="Identify specific areas that need support">
                                    <div class="reason-content">
                                        <div class="reason-icon">🧠</div>
                                        <div class="reason-text">Identify specific areas that need support</div>
                                        <p class="reason-subtext">
                                            I want to understand which topics or skills may need attention.
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="checkbox" name="assessment_outcomes[]"
                                        value="Clarify focus areas going forward">
                                    <div class="reason-content">
                                        <div class="reason-icon">📝</div>
                                        <div class="reason-text">Clarify focus areas going forward</div>
                                        <p class="reason-subtext">
                                            I’d like guidance on which subjects or areas my child should prioritise.
                                        </p>
                                    </div>
                                </label>

                                <label class="reason-card">
                                    <input type="checkbox" name="assessment_outcomes[]"
                                        value="Understand my child’s strengths and potentials">
                                    <div class="reason-content">
                                        <div class="reason-icon">🚀</div>
                                        <div class="reason-text"> Understand my child’s strengths and potential</div>
                                        <p class="reason-subtext">
                                            I’d like to know where my child’s strengths or competitive edge may be.
                                        </p>
                                    </div>
                                </label>

                                <!-- <label class="reason-card">
                                    <input type="checkbox" name="assessment_outcomes[]"
                                        value="Explore tutoring support options">
                                    <div class="reason-content">
                                        <div class="reason-icon">🧩</div>
                                        <div class="reason-text"> Explore tutoring support options</div>
                                        <p class="reason-subtext">
                                            I’d like help finding tutoring support for the areas of concern.
                                        </p>
                                    </div>
                                </label> -->

                            </div>

                            <!-- CONTINUE BUTTON -->
                            <div class="text-center mt-4">
                                <button type="button" class="assessment-btn" id="toStep6FromOutcome">
                                    Continue
                                </button>
                                <div class="text-center mt-2">
                                    <small class="error-text d-none" id="outcomeError">
                                        Please select at least one outcome to continue.
                                    </small>
                                </div>

                            </div>

                        </div>

                        <!-- STEP 7 (Name) -->
                        <div class="assessment-step step-7">
                            <div class="step-header">
                                <span class="step-back" id="step7Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-4 mt-3">
                                Before we continue, May we have your name?
                            </h4>
                            <div class="form-narrow">
                                <div class="form_area">
                                    <label>Parent Name</label>
                                    <input type="text" name="first_name">
                                    <small class="error-text" data-error-for="first_name"></small>
                                </div>

                                <div class="form_area">
                                    <label>Student Name</label>
                                    <input type="text" name="last_name">
                                    <small class="error-text" data-error-for="last_name"></small>
                                </div>

                                <button type="button" class="assessment-btn w-100" id="toStep7">
                                    Continue
                                </button>
                            </div>
                        </div>


                        <!-- STEP 8 (Email + Phone) -->
                        <div class="assessment-step step-8">
                            <div class="step-header">
                                <span class="step-back" id="step8Back">&larr;</span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>

                            <h4 class="text-center mb-2 mt-3">
                                You’re almost done – kindly share your contact details!
                            </h4>
                            <p class="mb-2" style="text-align: center;">
                                We’ll use this to contact you with personalised recommendations.
                            </p>

                            <div class="form-narrow">
                                <div class="form_area">
                                    <label>Email Address<span class="text-danger">*</span></label>
                                    <input type="email" name="email">
                                    <small class="error-text" data-error-for="email"></small>
                                </div>

                                <div class="form_area">
                                    <label>Mobile Number (Optional)</label>
                                    <input type="tel" name="phone" maxlength="10">
                                    <small class="error-text" data-error-for="phone"></small>
                                </div>
                                <div class="form_area mt-3">
                                    <!-- privacy -->
                                    <div class="check-box privacy-only d-none">
                                        <input type="checkbox" id="assessmentPrivacyConfirm" name="privacy_agreed"
                                            value="1">

                                        <label for="assessmentPrivacyConfirm">
                                            I consent to V-Tutor contacting me and processing my personal information
                                            in accordance with its
                                            <a href="{{ url('/privacy-policy') }}" target="_blank">Privacy Policy</a>
                                        </label>
                                    </div>


                                    <small id="termsError" style="color:#D7263D; display:none;">
                                        Please accept the required policy to continue.
                                    </small>

                                </div>


                                <button type="submit"  id="assessmentSubmitBtn" class="assessment-btn w-100">
                                    Get My Learning Program
                                </button>
                            </div>
                        </div>

                        <!-- STEP 9 (Success – Getting Started) -->
                        <div class="assessment-step step-9">
                            <div class="step-header">
                                <span></span>
                                <span class="step-close" data-dismiss="modal">&times;</span>
                            </div>
                            <div class="success-mode success-free_assessment">
                                <div class="text-center">
                                    <h3 class="mt-8">Thanks! You're all set!</h3>
                                    <p class="mt-2">
                                         We'll send you a secure link to initiate your child's Diagnostic Assessment.
                                    </p>
                                    <p class="mt-2">
                                            The assessment helps us understand your child's current competency levels across key skill areas, identify learning gaps, and provide more personalised learning recommendations.
                                    </p>
                                    <p class="mt-2">
                                             You'll receive an email with simple instructions on how to access and complete the assessment.
                                    </p>
                                    <p class="mt-2">
                                        If you don't see the email, please check your spam or junk folder, or contact us at
                                        support@v-tutor.com.au
                                    </p>
                                    <div class="assessment-actions mt-6">
                                        <button type="button" class="assessment-btn explore-now-btn">Explore Learning Programs</button>
                                    </div>
                                </div>
                            </div>

                            <div class="success-mode success-book_session">
                                <div class="text-center">
                                    <h3 class="mt-8">Thanks! You’re all set!</h3>

                                    <div class="assessment-actions mt-6">
                                        <button type="button" class="assessment-btn" data-type="child">Try a Free Trial
                                            Session</button>
                                    </div>
                                </div>
                            </div>

                            <div class="success-mode success-explore">
                                <div class="text-center">
                                    <h3 class="mt-8">Thanks! You’re all set!</h3>
                                    <p class="mt-2">
                                        We’ll be in touch shortly to discuss the next steps in your child’s learning
                                        journey.
                                    </p>
                                    <p class="mt-2">
                                        You can also book a free counselling session with our academic counsellors here.
                                    </p>
                                    <p class="mt-2">
                                        Alternatively, you may contact us at support@v-tutor.com.au
                                    </p>
                                    <div class="assessment-actions mt-6">
                                         <button type="button" class="assessment-btn explore-now-btn">Explore Now</button>
                                    </div>
                                </div>
                            </div>

                            <div class="success-mode success-research">
                                <div class="text-center">
                                    <h3 class="mt-8">Thanks! You’re all set!</h3>
                                    <p class="mt-2">
                                        We’ll be in touch shortly to discuss the next steps in your child’s learning
                                        journey.
                                    </p>
                                    <p class="mt-2">
                                        You can also book a free counselling session with our academic counsellors here.
                                    </p>
                                    <p class="mt-2">
                                        Alternatively, you may contact us at support@v-tutor.com.au
                                    </p>
                                    <div class="assessment-actions mt-6">
                                        <button type="button" class="assessment-btn explore-now-btn">Explore Now</button>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </form>

            </div>
        </div>
    </div>
<style>
        .reason-card input:disabled + .reason-content {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .reason-card input:disabled + .reason-content:hover {
            border-color: #e0e0e0;
            background-color: #ffffff;
            transform: none;
            box-shadow: none;
        }
        .success-mode {
            display: none;
        }

        .step-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .step-back,
        .step-close {
            font-size: 24px;
            cursor: pointer;
        }

        .assessment-box {
            background: #FFF9EC;
            border-top: 6px solid #b80f0a;
            border-radius: 16px;
            padding: 45px 30px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
            margin-top: 40px;
            margin-bottom: 80px;
        }

        .assessment-actions {
            display: flex;
            justify-content: center;
            gap: 25px;
        }

        .assessment-btn {
            background: #D7263D;
            color: #fff;
            padding: 16px 45px;
            font-size: 18px;
            border-radius: 12px;
            border: none;
        }

        .assessment-modal {
            background-color: #ffffff !important;
            /* White background */
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
        }

        .assessment-top-progress {
            height: 6px;
            background: #eee;
        }

        .assessment-top-progress-fill {
            height: 100%;
            width: 33%;
            background: linear-gradient(90deg, #b80f0a, #e53935);
            transition: width 0.4s ease;
        }

        .reason-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .reason-card input {
            display: none;
        }

        .reason-content {
            border: 2px solid #e0e0e0;
            border-radius: 14px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all .25s ease;
            background-color: #ffffff;
        }

        .reason-icon {
            font-size: 36px;
            margin-bottom: 12px;
        }

        .reason-card input:checked+.reason-content {
            border-color: #b80f0a;
            background-color: #fff5f5;
            /* Highlighted card */
            box-shadow: 0 10px 25px rgba(184, 15, 10, 0.15);
        }

        .assessment-form input,
        .assessment-form select,
        .assessment-form textarea {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .assessment-step {
            display: none;
        }

        .assessment-step.active {
            display: block;
        }

        .year-pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .year-number input {
            display: none;
        }

        .year-number span {
            display: inline-block;
            padding: 12px 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.25s ease;
            background-color: #ffffff;
        }

        .year-number input:checked+span {
            background: #b80f0a;
            color: #fff;
            border-color: #b80f0a;
        }

        #assessmentModal .modal-dialog {
            max-width: 1140px;
            width: 100%;
            height: 90vh;
            margin: 5vh auto;
        }

        #assessmentModal .modal-body {
            min-height: 420px;
            overflow-y: auto;
            max-height: calc(90vh - 60px);
            /* subtract progress bar */
            background-color: #ffffff;
        }

        .state-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 500px;
            margin: 0 auto;
        }

        .state-tab input {
            display: none;
        }

        .state-tab span {
            display: block;
            padding: 14px 18px;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.25s ease;
            background-color: #ffffff;
        }

        .state-tab input:checked+span {
            background-color: #b80f0a;
            color: #fff;
            border-color: #b80f0a;
            box-shadow: 0 8px 18px rgba(184, 15, 10, 0.2);
        }

        .subject-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 600px;
            margin: 0 auto;
        }

        .subject-tab input {
            display: none;
        }

        .subject-tab span {
            display: block;
            padding: 14px 18px;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.25s ease;
            background-color: #ffffff;
        }

        .subject-tab input:checked+span {
            background-color: #b80f0a;
            color: #fff;
            border-color: #b80f0a;
            box-shadow: 0 8px 18px rgba(184, 15, 10, 0.2);
        }

        .hobby-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .hobby-card input {
            display: none;
        }

        .hobby-content {
            border: 2px solid #e0e0e0;
            border-radius: 16px;
            padding: 28px 22px;
            cursor: pointer;
            transition: all 0.25s ease;
            background-color: #ffffff;
            text-align: center;
            height: 100%;
        }

        .hobby-icon {
            font-size: 36px;
            margin-bottom: 12px;
        }

        .hobby-content h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .hobby-content p {
            margin: 0;
            color: #555;
            font-size: 15px;
            line-height: 1.5;
        }

        .hobby-card input:checked+.hobby-content {
            border-color: #b80f0a;
            background-color: #fff5f5;
            /* Highlighted */
            box-shadow: 0 10px 25px rgba(184, 15, 10, 0.18);
        }

        @media (max-width: 768px) {
            .hobby-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Hide site footer when modal is open */
        body.modal-open footer {
            display: none !important;
        }

        /* Narrow form layout */
        .form-narrow {
            max-width: 420px;
            margin: 0 auto;
            text-align: left;
        }

        .form-narrow input {
            width: 100%;
            max-width: 100%;
        }

        .form-narrow .assessment-btn {
            width: auto;
            padding: 12px 32px;
            font-size: 16px;
            margin-top: 10px;
        }

        /* ===========================
                   GLOBAL TRANSITIONS
                =========================== */
        .reason-content,
        .year-number span,
        .state-tab span,
        .subject-tab span,
        .hobby-content,
        .assessment-btn {
            transition: all 0.25s ease;
        }

        /* ===========================
                   REASON CARDS (Step 0 & 4)
                =========================== */
        .reason-content:hover {
            border-color: #b80f0a;
            background-color: #fff5f5;
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        /* ===========================
                   YEAR SELECTION (Step 1)
                =========================== */
        .year-number span:hover {
            border-color: #b80f0a;
            color: #b80f0a;
            transform: translateY(-2px);
        }

        /* ===========================
                   STATE SELECTION (Step 2)
                =========================== */
        .state-tab span:hover {
            border-color: #b80f0a;
            background-color: #fff5f5;
            transform: translateY(-2px);
        }

        /* ===========================
                   SUBJECT SELECTION (Step 3)
                =========================== */
        .subject-tab span:hover {
            border-color: #b80f0a;
            background-color: #fff5f5;
            transform: translateY(-2px);
        }

        /* ===========================
                   HOBBY CARDS (Step 5)
                =========================== */
        .hobby-content:hover {
            border-color: #b80f0a;
            background-color: #fff5f5;
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.15);
        }

        /* ===========================
                   MAIN BUTTONS
                =========================== */
        .assessment-btn:hover {
            background: #c21f34;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(184, 15, 10, 0.25);
        }

        /* ===========================
                   BACK & CLOSE ICONS
                =========================== */
        .step-back:hover,
        .step-close:hover {
            color: #b80f0a;
            transform: scale(1.15);
        }

        /* =========================
                   SUCCESS STEP (STEP 9)
                ========================= */
        /* =========================
                   SUCCESS STEP (STEP 9)
                ========================= */

        .success-wrapper {
            max-width: 1000px;
            margin: 40px auto;
            padding: 10px 20px;
        }

        .success-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-subtitle {
            font-size: 18px;
            color: #555;
            margin-bottom: 40px;
        }

        .success-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 40px;
        }

        /* LEFT LIST */
        .success-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .success-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 17px;
            color: #333;
        }

        .success-item .icon {
            font-size: 22px;
            line-height: 1;
        }

        /* RIGHT IMAGE */
        .success-image img {
            width: 100%;
            max-width: 420px;
            margin-left: auto;
            display: block;
        }

        /* GETTING STARTED BOX */
        .getting-started-box {
            background: #ffffff;
            border-top: 4px solid #b80f0a;
            border-radius: 14px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .getting-started-box h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .getting-started-box p {
            font-size: 16px;
            color: #555;
            margin-bottom: 18px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .success-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .success-image img {
                margin: 0 auto;
            }

            .success-item {
                justify-content: center;
            }
        }

        /* =========================
                SUCCESS BUTTON HOVER
                ========================= */
        .getting-started-box .assessment-btn,
        .getting-started-box .assessment-btn:hover,
        .getting-started-box .assessment-btn:focus,
        .getting-started-box .assessment-btn:active {
            color: #ffffff !important;
            opacity: 1 !important;
            text-decoration: none;
        }

        /* =========================
                   INLINE ERROR STYLES
                ========================= */
        .error-text {
            color: #d32f2f;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 10px;
            display: block;
        }

        input.error {
            border-color: #d32f2f !important;
        }

        /* =========================
                   STEP 0 – COMPACT CARDS
                ========================= */
        .reason-grid-compact {
            max-width: 720px;
            margin: 0 auto;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .reason-grid-compact .reason-content {
            padding: 22px 18px;
            min-height: 170px;
        }

        /* Title */
        .reason-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        /* Subtitle */
        .reason-subtext {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
            margin: 0;
        }

        /* Icon slightly smaller */
        .reason-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .reason-grid-compact {
                grid-template-columns: 1fr;
                max-width: 420px;
            }
        }

        /* =========================
                   STATE BOX GRID (STEP 2)
                ========================= */

        .state-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            max-width: 720px;
            margin: 0 auto;
        }

        .state-card input {
            display: none;
        }

        /* 🔹 Horizontal layout */
        .state-content {
            border: 2px solid #e0e0e0;
            border-radius: 14px;
            padding: 20px 22px;
            cursor: pointer;
            background: #ffffff;
            transition: all 0.25s ease;

            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Icon on left */
        .state-icon {
            font-size: 28px;
            flex-shrink: 0;
        }

        /* Text on right */
        .state-text {
            font-size: 16px;
            font-weight: 600;
        }

        /* Selected state */
        .state-card input:checked+.state-content {
            border-color: #b80f0a;
            background-color: #fff5f5;
            box-shadow: 0 10px 25px rgba(184, 15, 10, 0.18);
        }

        /* Hover effect */
        .state-content:hover {
            border-color: #b80f0a;
            background-color: #fff5f5;
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        /* Mobile */
        @media (max-width: 768px) {
            .state-grid {
                grid-template-columns: 1fr;
                max-width: 420px;
            }
        }

        /* =========================
                   STEP 4 – MATCH STEP 0 SIZE
                ========================= */

        /* Limit width like Step 0 */
        .step-4 .reason-grid {
            max-width: 720px;
            margin: 0 auto;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        /* Match card height & padding */
        .step-4 .reason-content {
            padding: 22px 18px;
            min-height: 170px;
        }

        /* Match icon size */
        .step-4 .reason-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* Match title size */
        .step-4 .reason-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        /* Match description size */
        .step-4 .reason-content p {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
            margin: 0;
        }

        /* Mobile consistency */
        @media (max-width: 768px) {
            .step-4 .reason-grid {
                grid-template-columns: 1fr;
                max-width: 420px;
            }
        }

        /* =========================
                   GRADE DROPDOWN (STEP 1)
                ========================= */
        .grade-dropdown-wrapper {
            max-width: 420px;
            margin: 30px auto 0;
            text-align: left;
        }

        .grade-label {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .grade-select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #ddd;
            font-size: 16px;
            background-color: #fff;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .grade-select:focus {
            outline: none;
            border-color: #b80f0a;
            box-shadow: 0 6px 18px rgba(184, 15, 10, 0.18);
        }

        /* =========================
                   STEP 1 – INLINE YEAR LIST
                ========================= */

        .school-year-list {
            max-width: 420px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .school-year-item {
            border: 2px solid #e0e0e0;
            border-radius: 14px;
            padding: 16px 18px;
            transition: all 0.25s ease;
        }

        .school-year-label {
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
        }

        .school-year-label input {
            display: none;
        }

        .school-year-label .icon {
            font-size: 26px;
        }

        .school-year-label .text {
            font-size: 16px;
            font-weight: 600;
        }

        .school-year-item.active {
            border-color: #b80f0a;
            background-color: #fff5f5;
            box-shadow: 0 10px 25px rgba(184, 15, 10, 0.18);
        }

        /* Inline dropdown */
        .inline-dropdown {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            margin-top: 0;
            transition: max-height 0.25s ease, opacity 0.2s ease;
        }

        .school-year-item.active .inline-dropdown {
            max-height: 120px;
            /* enough for select */
            opacity: 1;
            margin-top: 14px;
        }


        .inline-dropdown .grade-select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #ddd;
            font-size: 16px;
        }

        .inline-dropdown .grade-select:focus {
            border-color: #b80f0a;
            outline: none;
            box-shadow: 0 6px 18px rgba(184, 15, 10, 0.18);
        }

        .check-box input[type="checkbox"]+label {
            margin-bottom: 0px !important;
        }
        .reason-italic {
            font-style: italic;}


    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
        /* ======================
                   GLOBAL STATE
        ====================== */
        let currentStep = 0;
        const totalSteps = 10;

        let selectedMode = '';
        let selectedYear = '';
        let selectedSubject = '';
        let exploreSelectedSubject = '';
        let isRedirectingToTutor = false;
        let stepHistory = [];
        let finalStateBeforeName = false;
        // Logical order of steps as user experiences them
        const progressOrder = [
            0, // mode
            1, // grade
            3, // subject
            4, // learning needs
            5, // free time
            6, // outcome (conditional)
            2, // state (always before name)
            7, // name
            8 // email
        ];

        /* ======================
           SCHOOL LEVEL → GRADES
        ====================== */
        const gradeOptionsMap = {
            "Primary School": {
                label: "Select Grade",
                options: ["Grade 1", "Grade 2", "Grade 3", "Grade 4", "Grade 5", "Grade 6"]
            },
            "High School": {
                label: "Select Grade",
                options: ["Grade 7", "Grade 8", "Grade 9", "Grade 10"]
            },
            "Senior Secondary": {
                label: "Select Grade",
                options: ["Grade 11", "Grade 12"]
            },
           
        };


        /* ======================
           PROGRESS BAR
        ====================== */

        function updateProgress(step) {
            const index = progressOrder.indexOf(step);

            if (index === -1) return;

            const percent = (index / (progressOrder.length - 1)) * 100;
            $('#assessmentProgress').css('width', percent + '%');
        }

        function goToStep(nextStep) {
            if (currentStep !== nextStep) {
                stepHistory.push(currentStep);
            }

            $('.assessment-step').removeClass('active');
            currentStep = nextStep;
            $(`.step-${nextStep}`).addClass('active');
            updateProgress(currentStep);

            // Reset grade whenever we go to Step 1
            if (nextStep === 1) {
                resetGradeSelection();
            }

            if (nextStep === 8) {
                toggleTermsVisibility();
                $('#assessmentSubmitBtn').text(getSubmitButtonText());
            }
        }


        function resetGradeSelection() {
            // Remove active class from all school-year items
            $('.school-year-item').removeClass('active');

            // Uncheck all radio buttons for school_year
            $('.school-year-item input[type="radio"]').prop('checked', false);

            // Clear all grade dropdowns
            $('.grade-select').each(function() {
                const defaultLabel = $(this).closest('.school-year-item').data('level') ?
                    gradeOptionsMap[$(this).closest('.school-year-item').data('level')].label :
                    'Select Grade';
                $(this).empty().append(`<option value="">${defaultLabel}</option>`);
                $(this).val('');
            });

            // Clear hidden grade input
            selectedYear = '';
            $('#selectedGrade').val('');
        }

        function goBackStep() {
            if (!stepHistory.length) return;

            const prev = stepHistory.pop();

            $('.assessment-step').removeClass('active');
            currentStep = prev;
            $(`.step-${prev}`).addClass('active');
            updateProgress(currentStep);

            // RESET GRADE WHEN COMING BACK TO STEP 1
            if (prev === 1) {
                resetGradeSelection();
            }
        }


        /* ======================
           FORCE RADIO NAVIGATION
        ====================== */

        // function forceRadioStep(stepSelector, callback) {
        //     $(document).on('click', `${stepSelector} label`, function (e) {
        //         // Prevent default click duplicate toggles if clicking directly on the input
        //         if ($(e.target).is('input')) return;

        //         const input = $(this).find('input[type="radio"], input[type="checkbox"]');
        //         if (!input.length) return;

        //         if (input.is(':radio')) {
        //             input.prop('checked', true);
        //             if (callback) callback(input);
        //         } else if (input.is(':checkbox')) {
        //             input.prop('checked', !input.prop('checked'));
        //             $('#subjectError').addClass('d-none');
        //         }
        //     });
        // }
        function forceRadioStep(stepSelector, callback) {
            $(document).on('click', `${stepSelector} label`, function (e) {

                if ($(e.target).is('input')) return;

                const input = $(this).find('input[type="radio"], input[type="checkbox"]');

                if (!input.length) return;

                if (input.prop('disabled')) {
                    return;
                }

                if (input.is(':radio')) {
                    input.prop('checked', true);

                    if (callback) {
                        callback(input);
                    }
                } else if (input.is(':checkbox')) {
                    input.prop('checked', !input.prop('checked'));
                    $('#subjectError').addClass('d-none');
                }
            });
        }

        /* ======================
           LEARNING NEED CONTENT
        ====================== */
        // const learningNeedContent = {
        //     English: {
        //         falling_behind: {
        //             title: "Building Strong Foundations",
        //             desc: "My child would benefit from support with reading, writing, or comprehension skills."
        //         },
        //         motivation: {
        //             title: "Confidence & Expression",
        //             desc: "My child understands the work but struggles with confidence, expression, or engagement."
        //         },
        //         extend_learning: {
        //             title: "Extending Writing & Thinking​",
        //             desc: "My child is doing well and would benefit from more advanced writing or critical thinking."
        //         },
        //         individual_needs: {
        //             title: "Personalised English Support",
        //             desc: "My child learns best with tailored guidance beyond the classroom."
        //         }
        //     },
        //     Mathematics: {
        //         falling_behind: {
        //             title: "Keeping Up with the Basics",
        //             desc: "My child is finding some concepts challenging and would benefit from support with the fundamentals."
        //         },
        //         motivation: {
        //             title: "Staying Motivated",
        //             desc: "My child understands the work but isn't very engaged or confident in Maths right now."
        //         },
        //         extend_learning: {
        //             title: "Ready for More Challenge",
        //             desc: "My child is doing well and would benefit from deeper or more advanced Maths learning."
        //         },
        //         individual_needs: {
        //             title: "Individual Learning Needs",
        //             desc: "My child learns best with personalised Maths support beyond the classroom."
        //         }
        //     },
        //     Science: {
        //         falling_behind: {
        //             title: "Understanding Core Concepts",
        //             desc: "My child finds some Science concepts challenging and would benefit from extra explanation."
        //         },
        //         motivation: {
        //             title: "Building Interest & Confidence",
        //             desc: "My child understands the basics but isn't very engaged or confident in Science."
        //         },
        //         extend_learning: {
        //             title: "Exploring Science Further",
        //             desc: "My child enjoys Science and would benefit from deeper or more challenging content."
        //         },
        //         individual_needs: {
        //             title: "Personalised Science Support",
        //             desc: "My child learns Science best with individualised guidance beyond the classroom."
        //         }
        //     },
        //     common: {
        //         falling_behind: {
        //             title: "Strengthening the Foundations",
        //             desc: "My child would benefit from reinforcing core skills and concepts to build confidence moving forward."
        //         },
        //         motivation: {
        //             title: "Building Confidence & Engagement",
        //             desc: "My child understands some concepts but isn't very confident or engaged yet."
        //         },
        //         extend_learning: {
        //             title: "Extending Skills & Understanding",
        //             desc: "My child is doing well and would benefit from deeper learning and progression."
        //         },
        //         individual_needs: {
        //             title: "Personalised Learning Support",
        //             desc: "My child learns best with tailored guidance that supports steady progress over time."
        //         }
        //     }
        // };
        const learningNeedTitles = {
            falling_behind: "Building Strong Foundations",
            motivation: "Confidence & Expression",
            extend_learning: "Extending Skills & Thinking",
            individual_needs: "Personalised Learning Support"
        };

        /* ======================
           RESET FORM
        ====================== */
        function resetAssessmentForm() {
            // Reset the actual form inputs
            $('#assessmentForm')[0].reset();

            // Reset steps
            $('.assessment-step').removeClass('active');
            $('.step-0').addClass('active');
            currentStep = 0;
            stepHistory = [];
            isRedirectingToTutor = false;

            // Reset selected values
            selectedMode = '';
            selectedYear = '';
            selectedSubject = '';

            // Hide all grade dropdowns
            $('.grade-dropdown-wrapper').hide();

            // Reset school-year items (radio buttons)
            $('.school-year-item').removeClass('active');
            $('.school-year-item input[type="radio"]').prop('checked', false);

            // Reset progress bar
            updateProgress(0);

            // Clear dynamic text displays
            $('#selectedYearText, #needYearText, #needSubjectText').text('');
            $('.check-box').addClass('d-none');
            $('#termsError').hide();

            let btn = $('#assessmentSubmitBtn');
            btn.prop('disabled', false).html(getSubmitButtonText());

        }

        /* ======================
           OPEN MODAL
        ====================== */
        $('.assessment-actions .assessment-btn').on('click', function() {
            resetAssessmentForm();
            $('#assessmentFor').val($(this).data('type'));
            $('#assessmentModal').modal('show');
        });

        /* ======================
           Terms Visibility
        ====================== */
        function toggleTermsVisibility() {
            // Always hide terms (removed permanently)
            $('.terms-and-privacy').addClass('d-none');

            // Hide first
            $('.privacy-only').addClass('d-none');
            $('#termsError').hide();

            // Show privacy where needed
            if (
                selectedMode === 'free_assessment' ||
                selectedMode === 'research' ||
                selectedMode === 'explore'
            ) {
                $('.privacy-only').removeClass('d-none');
            }
        }


        /* ======================
           STEP FLOW (RADIO BASED)
        ====================== */

        /* Step 0 → 1 */

        forceRadioStep('.step-0', radio => {
            selectedMode = radio.val();
            // reset privacy checkbox on mode change
            $('#assessmentPrivacyConfirm').prop('checked', false);
            if (selectedMode === 'book_session') {
                // Tutoring session starts directly with subject
                goToStep(1);
            } else {
                // All other modes start with grade
                goToStep(1);
            }
        });

        /* ======================
           STEP 1 SCHOOL LEVEL – INLINE DROPDOWN PER YEAR
        ====================== */
        $(document).on('click', '.school-year-label', function() {
            const $item = $(this).closest('.school-year-item');
            const level = $item.data('level');
            const config = gradeOptionsMap[level];
            if (!config) return;

            // Reset UI
            $('.school-year-item').removeClass('active');
            $('.grade-select').val('');

            // Activate
            $item.addClass('active');

            // HARD RESET grade
            selectedYear = '';
            $('#selectedGrade').val('');

            // Rebuild dropdown
            const $select = $item.find('.grade-select');
            $select.empty().append(`<option value="">${config.label}</option>`);

            config.options.forEach(opt => {
                $select.append(`<option value="${opt}">${opt}</option>`);
            });
        });


        /* Dropdown select → Step 2 */
        $(document).on('change', '.grade-select', function() {
            const grade = $(this).val();
            selectedYear = grade;

            $('#selectedGrade').val(grade);

            if (!grade) return;

            goToStep(3);
        });

        /* Step 2 → 3 */
        forceRadioStep('.step-2', radio => {
            if (selectedMode === 'book_session') {

            if (isRedirectingToTutor) return; // prevent double trigger
                isRedirectingToTutor = true;

                alert('✨ You need to sign up to continue. Redirecting you to the Sign Up page.');
                window.location.href = "{{ url('/sign-up') }}";
                return;
            }

            const state = radio.val();
            if (!state) return;

            let nextStep;

            if (selectedMode === 'book_session') {
                // tutoring session: subject → state → name
                nextStep = 7;
            } else if (selectedMode === 'research') {
                nextStep = 7;
            } else {
                // free_assessment & explore
                nextStep = 7;
            }

            goToStep(nextStep);
        });

        /* Step 3 → Dynamic */
        // forceRadioStep('.step-3', radio => {
        //     selectedSubject = radio.val();
        //     exploreSelectedSubject = radio.val();
        //     $('#needYearText').text(selectedYear);
        //     $('#needSubjectText').text(selectedSubject);

        //     const contentSet =
        //         learningNeedContent[selectedSubject] ||
        //         learningNeedContent.common;

        //     $('.step-4 .reason-content').each(function() {
        //         const key = $(this).data('need');
        //         if (contentSet[key]) {
        //             $(this).find('.reason-text').text(contentSet[key].title);
        //             $(this).find('p').text(contentSet[key].desc);
        //         }
        //     });

        //     //FIXED FLOW
        //     let nextStep;
        //     if (selectedMode === 'book_session') {
        //         nextStep = 2; // subject → state
        //     } else {
        //         nextStep = 4; // ALL assessment modes see STEP 4
        //     }

        //     goToStep(nextStep);
        // });
        /* Step 3 → Dynamic */
        // forceRadioStep('.step-3', radio => {
        //     // Handle array or single string values for multi-select subject support
        //     const val = radio.val();
        //     selectedSubject = Array.isArray(val) ? val.join(', ') : val;
        //     exploreSelectedSubject = selectedSubject;

        //     $('#needYearText').text(selectedYear);
        //     $('#needSubjectText').text(selectedSubject);

        //     let nextStep = (selectedMode === 'book_session') ? 2 : 4;
        //     goToStep(nextStep);
        // });
        /* ======================
   STEP 3 -> STEP 4 (CHECKBOX CONTINUATION)
====================== */
$('#toStep4FromSubject').on('click', function () {
    const selected = $('input[name="subjects[]"]:checked').map(function () {
        return $(this).val();
    }).get();

    if (selected.length === 0) {
        $('#subjectError').removeClass('d-none');
        return;
    }

    $('#subjectError').addClass('d-none');

    selectedSubject = selected.join(', ');
    exploreSelectedSubject = selectedSubject;

    $('#needYearText').text(selectedYear);
    $('#needSubjectText').text(selectedSubject);

    let nextStep = (selectedMode === 'book_session') ? 2 : 4;
    goToStep(nextStep);
});
        /* Step 4 → 5 or 7 */
        // forceRadioStep('.step-4', function(radio) {

        //     const needKey = radio.val();
        //     const contentSet =
        //         learningNeedContent[selectedSubject] ||
        //         learningNeedContent.common;

        //     if (contentSet[needKey]) {
        //         $('#learningNeedTitle').val(contentSet[needKey].title);
        //     }

        //     // FIXED FLOW
        //     if (selectedMode === 'free_assessment') {               
        //         goToStep(6); // Outcome
        //     } else if (selectedMode === 'research') {
        //         finalStateBeforeName = true;
        //         goToStep(2); // State
        //     } else if (selectedMode === 'explore') {
        //         goToStep(5); // Free time
        //     } else {
        //         goToStep(7); // Name (book_session fallback)
        //     }
        // });
        /* Step 4 → 5 or 7 */
        forceRadioStep('.step-4', function(radio) {
            const needKey = radio.val();
            if (learningNeedTitles[needKey]) {
                $('#learningNeedTitle').val(learningNeedTitles[needKey]);
            }

            if (selectedMode === 'free_assessment') {            
                goToStep(6);
            } else if (selectedMode === 'research') {
                finalStateBeforeName = true;
                goToStep(2);
            } else if (selectedMode === 'explore') {
                goToStep(5);
            } else {
                goToStep(7);
            }
        });


        /* Step 5 → 7 */

        forceRadioStep('.step-5', () => {
            finalStateBeforeName = true;
            goToStep(2); // State
        });

        /* Step 6 → 7 */
        $('#toStep6FromOutcome').on('click', function() {
            finalStateBeforeName = true;
            const checked = $('input[name="assessment_outcomes[]"]:checked').length;

            if (!checked) {
                $('#outcomeError').removeClass('d-none');
                return;
            }

            $('#outcomeError').addClass('d-none');
            goToStep(2); // State
        });


        /* Step 7 → 8 */
        $('#toStep7').on('click', function() {
            let valid = true;

            const firstName = $('input[name="first_name"]');
            const lastName = $('input[name="last_name"]');

            $('.error-text').text('');
            $('input').removeClass('error');

            if (!firstName.val().trim()) {
                $('[data-error-for="first_name"]').text('Please enter parent name');
                firstName.addClass('error');
                valid = false;
            }

            if (!lastName.val().trim()) {
                $('[data-error-for="last_name"]').text('Please enter student name');
                lastName.addClass('error');
                valid = false;
            }

            if (!valid) return;

            goToStep(8);
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            return emailRegex.test(email);
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        /* Submit success */
        $('#assessmentForm').on('submit', function(e) {
            e.preventDefault();
            let valid = true;
            const emailInput = $('input[name="email"]');
            const phoneInput = $('input[name="phone"]');

            const emailError = $('[data-error-for="email"]');
            const phoneError = $('[data-error-for="phone"]');

            emailError.text('');
            phoneError.text('');
            emailInput.removeClass('error');
            phoneInput.removeClass('error');

            const email = emailInput.val().trim();
            const phone = phoneInput.val().trim();

            /* EMAIL */
            if (!email) {
                emailError.text('Email is required');
                emailInput.addClass('error');
                return;
            }

            if (!isValidEmail(email)) {
                emailError.text('Please enter a valid email address');
                emailInput.addClass('error');
                return;
            }

            /* PHONE — OPTIONAL */
            if (phone !== '') {
                if (!/^[0-9]{10}$/.test(phone)) {
                    phoneError.text('Enter a valid 10-digit mobile number');
                    phoneInput.addClass('error');
                    return;
                }
            }

            if (!valid) return;

            if (
                (selectedMode === 'free_assessment' || selectedMode === 'research' ||
                selectedMode === 'explore') &&
                !$('#assessmentPrivacyConfirm').is(':checked')
            ) {
                $('#termsError')
                    .text('Please accept the Privacy Policy to continue.')
                    .show();
                return;
            }

            let btn = $('#assessmentSubmitBtn');
           
            /* validations stay SAME – do not change */

            btn.prop('disabled', true).html(
                `<span class="spinner-border spinner-border-sm"></span> Submitting...`
            );
            
            // Collect multi-select subjects as a comma-separated string
const selectedSubjects = $('input[name="subjects[]"]:checked').map(function () {
    return $(this).val();
}).get().join(', ');

// Collect outcomes (if checked on step 6)
const selectedOutcomes = $('input[name="assessment_outcomes[]"]:checked').map(function () {
    return $(this).val();
}).get().join(', ');

// Build custom data object from form inputs
const formData = {
    _token: $('input[name="_token"]').val(),
    visit_reason: $('input[name="visit_reason"]:checked').val() || selectedMode,
    assessment_for: $('#assessmentFor').val() || 'me',
    school_year: $('.school-year-item.active').data('level') || '',
    grade: $('#selectedGrade').val(),
    subject: selectedSubjects || selectedSubject, // Sends single string expected by Laravel
    learning_need: $('input[name="learning_need"]:checked').val() || '',
    learning_need_title: $('#learningNeedTitle').val() || '',
    assessment_outcomes: selectedOutcomes,
    free_time: $('input[name="free_time"]:checked').val() || '',
    state: $('input[name="state"]:checked').val() || '',
    first_name: $('input[name="first_name"]').val(),
    last_name: $('input[name="last_name"]').val(),
    email: $('input[name="email"]').val(),
    phone: $('input[name="phone"]').val(),
    privacy_agreed: $('#assessmentPrivacyConfirm').is(':checked') ? 1 : 0
};

            $.ajax({
                url: "{{ route('learning.program.assessment.store') }}",
                type: "POST",
                // data: $(this).serialize(),
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function() {

                    //  Modes that should show success screen
                    if (
                        selectedMode === 'free_assessment' ||
                        selectedMode === 'explore' ||
                        selectedMode === 'research'
                    ) {
                        goToStep(9);

                        // Hide all success blocks first
                        $('.success-mode').hide();

                        // Show mode-specific success
                        $('.success-' + selectedMode).show();
                    }
                    // Only book_session redirects
                    else {
                        window.location.href = "{{ route('subject') }}";
                    }
                }
            });
        });


        /* BACK BUTTON (GLOBAL) */
        $(document).on('click', '.step-back', goBackStep);

        /* Explore button redirect */
        $(document).on('click', '.explore-now-btn', function () {
            // let slug = exploreSelectedSubject.split('-')[0].toLowerCase();
            // exploreSelectedSubject = '';
            // window.location.href = "/subject/" + slug;
            window.location.href = "/programs/learning";
        });
        function getSubmitButtonText() {
            if (selectedMode === 'free_assessment') {
                return 'Get Free Diagnostic Assessment';
            } else if (selectedMode === 'research' || selectedMode === 'explore') {
                return 'Submit';
            }
            return 'Get My Learning Program'; // Fallback default
        }
</script>
