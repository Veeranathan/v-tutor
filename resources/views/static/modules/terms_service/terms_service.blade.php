@extends('layouts.app')

@section('page_title', 'V-Tutor | Online Tutors & Tutoring Platform Australia – Terms & Services')
@section('meta_description', 'Read V-Tutor’s Terms of Service to understand the guidelines, policies, and conditions for using Australia’s leading online tutoring platform with qualified tutors')
@section('meta_keywords', 'online tutoring terms, Australia tutoring rules, V-Tutor policies, ACARA-aligned tutors, WWCC verified tutors, online learning Australia, home tutoring Australia, remote tutoring Australia, online tuition Australia, best online tutors Australia')

@section('left_part')
    {{-- @include('include.left_part') --}}
    @include('include.header_menu_part')
@endsection
@section('content')
@php
$title = 'Terms Of Service';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])
    <!-- bannersec -->
    <!-- bannersec -->
    {{-- <div class="top_mar"></div>
    <section class="about-banner">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">{!! strip_tags(@$contentDetails->title) !!}</li>
						</ol>
					</nav>
					<div class="inner-banner-title">
						<h1 class="title">
		            {!! strip_tags(@$contentDetails->title) !!}
		          </h1>
		          @include('include.errors') </div>
				</div>
			</div>
		</div>
	</section> --}}
    <section class="terms-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="privacy-content">
                        <h2 class="text-center">TERMS OF SERVICE (PARENTS & STUDENTS) </h2>
                        <br />

                        {{-- {!! @$contentDetails->description!!} --}}
                        <h3>About V-Tutor</h3>

                        <p>V-Tutor is Australia’s online tutoring marketplace — a platform created by educators and
                            technologists to make high-quality learning accessible, flexible, and curriculum-aligned for
                            students across all states and territories. V-Tutor connects families with experienced,
                            independently operating tutors who provide personalised online learning support.</p>
                        <p>V-Tutor facilitates the technology, governance, compliance checks, communication, and secure
                            learning infrastructure. Tutors listed on the platform remain independent contractors and
                            deliver tutoring services directly to students. V-Tutor acts solely as the intermediary,
                            facilitator, and payment agent for these engagements.</p>
                        <p>These Terms outline how parents and students may use the platform, what to expect from tutors,
                            and the responsibilities of all parties.</p>

                        <h3>1. Access, Accounts & Parent Responsibilities</h3>

                        <p>Parents must create an account to use V-Tutor services and are responsible for providing accurate
                            information and supervising their child’s access where required. By creating an account, you
                            confirm you are the lawful parent/guardian (for minors) and consent to the student participating
                            in online tutoring.</p>

                        <p>Parents must ensure the student:</p>
                        <ul>
                            <li>Joins sessions on time</li>

                            <li>Has a suitable device, camera, audio, and stable internet</li>

                            <li>Behaves respectfully during sessions</li>

                            <li>Uses Zoom links and platform tools safely</li>

                            <li>Parents must not allow unauthorised access, record sessions independently, or engage tutors
                                privately outside the platform.</li>
                        </ul>


                        <h3>2. Role of V-Tutor as Agent & Contractual Relationship with Tutors</h3>

                        <p>V-Tutor is a platform that facilitates communication, discovery, bookings, session planning, and
                            payments between parents and independent tutors. When a session is booked, parents enter a
                            direct contractual relationship with the tutor, not with V-Tutor.</p>

                        <p>Tutors retain full autonomy over lesson preparation, content, pedagogy, and teaching approaches.
                            V-Tutor does not supervise tutors, direct their teaching methods, or guarantee academic
                            outcomes.</p>

                        <p>Parents acknowledge that tutors are solely responsible for:</p>

                        <ul>
                            <li>Session preparation and delivery</li>
                            <li>Content accuracy and curriculum alignment</li>
                            <li>Professional conduct</li>
                            <li>Learning support and feedback</li>
                            <li>V-Tutor does not provide tutoring, does not employ tutors, and is not liable for the
                                performance, accuracy, or outcomes of tutoring services.</li>
                        </ul>

                        <h3>3. Bookings, Session Plans & Learning Delivery</h3>

                        <p>A booking is confirmed once payment is processed. Parents will receive a confirmation email with
                            session details and a secure Zoom link.</p>
                        <p>A session plan is generated for each session and outlines the intended learning objectives, key
                            topics, and curriculum alignment. Tutors prepare and deliver the lesson based on this plan.</p>
                        <p>Sessions are delivered via Zoom links generated by the V-Tutor platform. V-Tutor may observe or
                            review sessions for training, quality assurance, safety, and compliance purposes.</p>


                        <h3>4. Attendance, Conduct & Learning Environment</h3>

                        <p>Parents must ensure that students attend sessions on time in a quiet, safe, and distraction-free
                            environment. Respectful behaviour is required from both students and parents.</p>
                        <p>Unauthorised session recordings, inappropriate conduct, or attempts to contact tutors privately
                            outside the platform are prohibited.</p>

                        <h3>5. Cancellations, Cooling-Off Rights & Refunds</h3>
                        <h4>Cooling-Off Period</h4>
                        <p>Any new booking cancelled within 30 minutes of being made will receive a full refund, regardless
                            of session timing.</p>
                        <h4>Parent Cancellations</h4>
                        <p>V-Tutor does not support rescheduling. To change a time or tutor, the booking must be cancelled
                            and rebooked.</p>
                        <p>Refunds apply as follows:</p>
                        <ul>
                            <li>More than 24 hours before session: Full refund</li>
                            <li>6–24 hours before session: 50% refund</li>
                            <li>Less than 6 hours: No refund</li>
                        </ul>

                        <h4>No-Show</h4>

                        <p>If a student does not join within up to 15 minutes of the scheduled start time, the session is
                            marked as a no-show and no refund applies.</p>

                        <h4>Tutor Cancellations</h4>
                        <p>If a tutor cancels a session, parents receive a full refund. Any replacement session must be
                            booked separately.</p>
                        <h3>6. Payments & Billing</h3>

                        <p>Payments are processed securely via Stripe. V-Tutor does not store card details. Refunds are
                            returned to the original payment method.</p>

                        <h3>7. Educational Standards, Quality & Learning Outcomes</h3>

                        <p>V-Tutor maintains governance processes to support consistent, curriculum-aligned tutoring. Tutors
                            are expected to prepare structured, engaging lessons that reflect good teaching practice.</p>
                        <p>Learning outcomes vary depending on student participation, consistency, study habits, and broader
                            educational support. V-Tutor does not guarantee specific grades or academic results.</p>


                        <h4>7A. Scope of Educational Support & Future Services</h4>
                        <p>V-Tutor’s current service offering is focused on online tutoring and general educational support.
                            Tutors may provide informal feedback, guidance, and help students understand their schoolwork.
                            However, tutors do not currently offer formal educational assessments, diagnostic evaluations,
                            or official reporting required by schools or external organisations.</p>
                        <p>If V-Tutor expands its services in future to include structured assessments, specialist programs,
                            or formal progress reporting, these will be introduced under separate terms or updated policies.
                            Parents will be informed of any changes to the scope of educational services in accordance with
                            V-Tutor’s commitment to transparency.</p>

                        <h3>8. Privacy, Confidentiality, Data Protection & Session Recordings</h3>

                        <p>V-Tutor collects and stores data only for service delivery, safety, payments, compliance, and
                            quality assurance.</p>
                        <p>All sessions delivered on V-Tutor are recorded for compliance, safety, training, and quality
                            control. By agreeing to these Terms, parents expressly consent to session recordings.</p>


                        <p>Recordings:</p>
                        <ul>
                            <li>May be stored on secure servers, including servers outside Australia</li>

                            <li>Are not shared with parents by default</li>

                            <li>May be accessed by parents upon written request on a case-by-case basis</li>

                            <li>Are not distributed externally except where required by law</li>

                            <li>Parents and students must not independently record sessions or distribute tutoring
                                materials.</li>
                        </ul>


                        <h3>9. Platform Integrity, Fair Use & Security Requirements</h3>

                        <p>Parents agree to use the platform only for lawful and intended purposes. Misuse, including system
                            interference, data extraction, harmful uploads, or sharing login credentials, may lead to
                            account restrictions or removal.</p>
                        <p>V-Tutor may investigate misuse and take steps to protect users, tutors, and the platform.</p>



                        <h3>10. Child Safety, Welfare & Mandatory Reporting</h3>
                        <p>All tutors must hold a valid WWCC or state equivalent. Parents must ensure their child
                            participates in sessions from a safe environment.</p>
                        <p>If concerns arise regarding a child’s safety or wellbeing, V-Tutor may be legally required to
                            report such matters to relevant authorities. Parents acknowledge that V-Tutor may act to protect
                            the welfare of the child where needed.</p>

                        <h3>11. Intellectual Property & Use of Materials</h3>
                        <p>V-Tutor owns all platform content, branding, and system interfaces. Tutors retain ownership of
                            their teaching content and materials.</p>
                        <p>Parents and students may use materials only for personal educational purposes and must not
                            reproduce, distribute, or publicly share session materials or recordings.</p>

                        <h3>12. Marketing Communications & Service Announcements</h3>
                        <p>By creating an account, parents consent to receiving essential service notifications such as
                            booking confirmations, reminders, safety notices, and policy updates. Optional marketing
                            communications may be unsubscribed from at any time.</p>

                        <h3>13. Service Availability & Technical Limitations</h3>
                        <p>While V-Tutor strives for stable and uninterrupted service, the platform may experience
                            maintenance periods or disruptions caused by external services (e.g., Zoom, Stripe, internet
                            providers).</p>
                        <p>V-Tutor is not responsible for technical issues on the student’s side, including device failures
                            or internet connectivity problems.</p>


                        <h3>14. Dispute Resolution & Escalation</h3>

                        <p>Parents should contact support@v-tutor.com.au for any concerns. V-Tutor will review session
                            recordings, communication logs, and tutor feedback to resolve issues fairly.</p>
                        <p>If a matter cannot be resolved internally, parents may escalate the issue to their state consumer
                            protection body. Both parties agree to communicate in good faith.</p>


                        <h3>15. Limitation of Liability</h3>
                        <p>To the fullest extent permitted by law, V-Tutor’s liability is limited to the amount paid for the
                            affected session. V-Tutor is not liable for indirect, consequential, or academic losses and is
                            not responsible for tutor performance, session content, or student outcomes.</p>
                        <p>This clause does not restrict rights under Australian Consumer Law.</p>

                        <h3>16. Updates to These Terms</h3>
                        <p>V-Tutor may update these Terms as needed for operational, regulatory, or service changes.
                            Continued use of the platform constitutes acceptance of updated Terms.</p>
                        <h3>17. Homework, Assignments & Project Support</h3>
                        <p>Tutors may help students with homework, assignments, projects, and study tasks by explaining
                            concepts, guiding problem-solving, reviewing drafts, and helping them develop understanding.
                            Tutors may support students in structuring ideas and identifying learning gaps.</p>
                        <p>However, tutors must not complete graded schoolwork, take-home exams, assessments, essays, code,
                            or project components intended for submission. All assessed work must be completed by the
                            student. This protects academic integrity and ensures a genuine learning experience.</p>
                        <p>Parents acknowledge that final responsibility for academic submissions rests solely with the
                            student.</p>


                        <h3>Agreement to Terms</h3>
                        <p>By using the platform, creating an account, or booking a session, you agree to these Terms of
                            Service and acknowledge that tutoring services are delivered by independent tutors, with V-Tutor
                            acting solely as an intermediary and facilitator.</p>

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
@endsection
