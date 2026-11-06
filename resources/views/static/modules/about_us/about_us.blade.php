@extends('layouts.app')

@section('page_title', 'V-Tutor | About Our Online Tutoring Platform Australia')
@section('meta_description', 'Learn about V-Tutor, Australia’s trusted online tutoring platform. Connect with qualified Maths, Science, and English tutors for online tutoring and personalised learning.')
@section('meta_keywords', 'online tutoring Australia, online tutors, qualified tutors, Maths tutors, Science tutors, English tutors, tutoring platform Australia')

@section('left_part')
@include('include.header_menu_part')
<link href="{{ public_asset('assets/faro_font/stylesheet.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
@endsection

@section('content')
@php
$title = 'About Us';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
'title' => $title,
'showBreadcrumb' => true
])
<!-- 1. HERO PAGE -->
<div class="about-page">
<section class="abt-hero" aria-labelledby="abt-hero-title">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-7 abt-hero-content">
				<span class="abt-eyebrow">
					A different approach to learning
				</span>
				<h1 id="abt-hero-title" class="abt-h1 mb-3">
					More tutoring isn't <br class="desk-top"> always the answer.
				</h1>
				<div class="mb-3">
					<p class="abt-p">
						Sometimes, the most important step isn't doing more.<br class="mobile">
						It's understanding what your child needs and finding<br class="mobile">
						the support that makes sense for them.
					</p>
				</div>

				<p class="abt-p mb-4">
					V-Tutor helps families identify learning needs and access<br class="mobile">
					structured, personalised learning support through our<br class="mobile">
					learning programs and subject-focused tutors.
				</p>

				<a href="{{ route('program.assessment') }}" class="abt-btn">
					Book Free Diagnostic Assessment
					<i class="fas fa-arrow-right"></i>
				</a>

			</div>
		</div>
	</div>
</section>

<!-- 2. WHY WE EXIST -->
<section class="abt-section abt-why" aria-labelledby="abt-why-title">
	<div class="container">
		<div class="row align-items-stretch g-4">

			<div class="col-lg-6 order-2 order-lg-1">
				<div class="abt-why-photo-wrap">
					<div class="abt-photo abt-why-photo"
						role="img"
						aria-label="A student resting her chin on her hand, looking puzzled">

						<img src="{{ public_asset('assets/images/about/image2.png') }}"
							alt="A student thinking about her learning challenges">
					</div>
				</div>
			</div>

			<div class="col-lg-6 order-1 order-lg-2">
				<div class="abt-why-content">
					<span class="abt-eyebrow">Why we exist</span>
					<h2 id="abt-why-title" class="abt-h2 abt-serif mb-3">
						When a child struggles, the reason isn't always obvious.
					</h2>
					<p class="abt-p mb-3">
						A student may spend hours practising maths but still struggle
						to apply the concepts. Another may understand a lesson today,
						only to find it difficult to build on that knowledge tomorrow.
						And sometimes, repeated difficulties begin to affect a child's
						confidence in their own abilities.
					</p>

					<p class="abt-p">
						These challenges can look alike, but their underlying causes -
						and the support that may help - can be very different.
					</p>

					<div class="abt-highlight">
						<i class="far fa-lightbulb" aria-hidden="true"></i>
						<span>
							We believe the first step is to understand the challenge,
							not simply add more practice.
						</span>
					</div>

					<p class="abt-p mb-0">
						That's why V-Tutor takes a learning-first approach: helping
						families gain a clearer understanding of their child's needs
						and explore the support that may help them progress.
					</p>

				</div>
			</div>

		</div>
	</div>
</section>

<!-- 3. HOW WE ARE DIFFERENT -->
<section class="abt-section" aria-labelledby="abt-diff-title">
	<div class="container">
		<div class="row g-4 align-items-center abt-diff">
			<div class="col-lg-5">
				<span class="abt-eyebrow">A learning-first approach</span>
				<h2 id="abt-diff-title" class="abt-h2 abt-serif mb-3">We look beyond the lesson.</h2>
				<p class="abt-p mb-3">Finding a tutor is one part of the journey. Understanding what a student needs to learn, where they need support and what to focus on next is just as important.</p>
				<p class="abt-p mb-0">V-Tutor brings a more targeted perspective to learning support, helping families explore personalised learning programs and suitable tutors based on their child's needs and goals.</p>
			</div>
			<div class="col-lg-7">
				<div class="row g-3 abt-grid">
					<div class="col-md-6">
						<article class="abt-card">
							<div class="abt-icon red"><i class="fas fa-search"></i></div>
							<div>
								<h3>Understand the bigger picture</h3>
								<p>Look beyond the immediate challenge to identify areas where a student may need additional support.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-card">
							<div class="abt-icon orange"><i class="fas fa-bullseye"></i></div>
							<div>
								<h3>Personalised support</h3>
								<p>Explore learning programs and tutor support suited to your child's learning needs and goals.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-card">
							<div class="abt-icon blue"><i class="fas fa-puzzle-piece"></i></div>
							<div>
								<h3>Purposeful learning</h3>
								<p>Focus on the concepts, skills and learning objectives that matter.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-card">
							<div class="abt-icon green"><i class="fa-solid fa-chart-line"></i></div>
							<div>
								<h3>Progress in focus</h3>
								<p>Keep learning goals clear and review what has improved and what may need further attention.</p>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- 4. OUR APPROACH -->
<section class="abt-approach" aria-labelledby="abt-approach-title">
	<div class="container">
		<div class="abt-approach-panel">
			<div class="row g-3 align-items-end mb-4">
				<div class="col-lg-6">
					<span class="abt-eyebrow">Our approach</span>
					<h2 id="abt-approach-title" class="abt-h2 abt-serif mb-0 text-nowrap">A clearer path forward starts here.</h2>
				</div>
				<div class="col-lg-6 abt-responsive-text">
					<p class="mb-0 mx-5">Every student has a different starting point. Our managed learning approach helps families move from understanding learning needs to finding suitable support and working towards meaningful progress.</p>
				</div>
			</div>

			<div class="row g-4">
				<div class="col-12 col-md-6 col-lg-3">
					<div class="abt-step text-center ">
						<div class="abt-circle">
							<img src="{{ public_asset('assets/images/about/search.png') }}">

						</div>
						<!-- <div class="abt-circle c1"><i class="fas fa-search"></i></div> -->
						<div class="abt-step-num">01 · Understand</div>
						<h3>Identify learning needs.</h3>
						<p>A diagnostic assessment can help identify strengths, highlight areas that may need attention and guide the next steps.</p>
					</div>
					<div class="abt-arrow">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="abt-step text-center">
						<div class="abt-circle">
							<img src="{{ public_asset('assets/images/about/people.png') }}">

						</div>
						<!-- <div class="abt-circle c2"><i class="fas fa-sliders-h"></i></div> -->
						<div class="abt-step-num">02 · Personalise</div>
						<h3>Recommend the right program.</h3>
						<p>Based on a student's needs and goals, explore suitable learning programs and tutor support.</p>
					</div>
					<div class="abt-arrow">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="abt-step text-center">
						<div class="abt-circle">
							<img src="{{ public_asset('assets/images/about/book.png') }}">

						</div>
						<!-- <div class="abt-circle c3"><i class="fas fa-chalkboard-teacher"></i></div> -->
						<div class="abt-step-num">03 · Build</div>
						<h3>Strengthen skills and understanding.</h3>
						<p>Purposeful sessions with a suitable tutor help students work towards clear learning objectives using relevant teaching approaches and resources.</p>
					</div>
					<div class="abt-arrow">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<div class="abt-step text-center">
						<div class="abt-circle">
							<img src="{{ public_asset('assets/images/about/bar.png') }}">

						</div>
						<!-- <div class="abt-circle c4"><i class="fas fa-chart-line"></i></div> -->
						<div class="abt-step-num">04 · Review</div>
						<h3>Recognise progress and plan next steps.</h3>
						<p>Where appropriate, review learning outcomes, consider progress and identify areas for continued development.</p>
					</div>
				</div>
			</div>

			<p class="abt-approach-close">It's not about doing more for the sake of doing more. It's about making learning more purposeful.</p>
		</div>
	</div>
</section>

<!-- 5. OUTCOMES -->
<section class="abt-section" aria-labelledby="abt-outcomes-title">
	<div class="container">
		<div class="row g-4 align-items-stretch">
			<div class="col-lg-5">
				<div class="abt-outcomes-photo-wrap">
					<div class="abt-photo abt-outcomes-photo" role="img" aria-label="A smiling student wearing headphones, writing in a notebook">
						<img src="{{ public_asset('assets/images/about/image3.png') }}">
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<span class="abt-eyebrow">What we want for every student</span>
				<h2 id="abt-outcomes-title" class="abt-h2 abt-serif mb-3">Helping students move forward - in learning and in confidence.</h2>
				<p>Academic progress matters. But so does the confidence to tackle a difficult question, the ability to apply what you've learnt and the independence to keep going when learning gets challenging. We want students to develop more than subject knowledge. We want them to build the understanding, skills and confidence to take their next steps - at school and beyond.</p>

				<div class="row mb-3 mt-3 abt-grid">
					<div class="col-md-6">
						<article class="abt-mini-card">
							<div class="abt-icon red"><i class="fas fa-brain"></i></div>
							<div>
								<h3>Stronger Understanding</h3>
								<p>Build a sound understanding of concepts and the foundations needed for new learning.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-mini-card">
							<div class="abt-icon green"><i class="fas fa-seedling"></i></div>
							<div>
								<h3>Growing Confidence</h3>
								<p>Approach learning challenges with greater confidence and a willingness to keep trying.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-mini-card">
							<div class="abt-icon blue"><i class="fas fa-user-check"></i></div>
							<div>
								<h3>Greater Independence</h3>
								<p>Develop the ability to think through problems, apply knowledge and take more ownership of learning.</p>
							</div>
						</article>
					</div>
					<div class="col-md-6">
						<article class="abt-mini-card">
							<div class="abt-icon orange"><i class="fas fa-star"></i></div>
							<div>
								<h3>Meaningful Progress</h3>
								<p>Understand what's improving, what still needs attention and where to focus next.</p>
							</div>
						</article>
					</div>
				</div>

				<p class="mb-0 fw-bold">Every student has their own starting point. What matters is helping each one find a meaningful way forward.</p>
			</div>
		</div>
	</div>
</section>

<!-- 6. OUR COMMITMENT -->
<section class="abt-section abt-commit" aria-labelledby="abt-commit-title">
	<div class="container">
		<div class="mb-5">
			<span class="abt-eyebrow">Our commitment to families</span>
			<h2 id="abt-commit-title" class="abt-h2 abt-serif mb-3">Learning support you can feel confident about.</h2>
			<p class="abt-p ">Choosing learning support for your child is a decision that matters. Parents want to know that their child's needs are being considered, that the support is relevant to their schooling and that they can make informed choices along the way.
				At V-Tutor, we aim to make finding learning support a more considered and reassuring experience - one that puts the student's needs at the centre of the decision.</p>
		</div>

		<div class="row mb-4">
			<div class="col-12 col-md-6 col-lg-3">
				<article class="abt-card">
					<div class="abt-icon red">
						<i class="fas fa-user-graduate"></i>
					</div>
					<div class="abt-content">
						<h3>Student-focused by design</h3>
						<p>We believe learning support should reflect each student's individual needs, strengths and priorities.</p>
					</div>
				</article>
			</div>
			<div class="col-12 col-md-6 col-lg-3">
				<article class="abt-card">
					<div class="abt-icon green">
						<i class="fas fa-user-shield"></i>
					</div>
					<div class="abt-content">
						<h3>Safety matters</h3>
						<p>Tutors on our platform are required to meet V-Tutor's Working With Children Check requirements.</p>
					</div>
				</article>
			</div>
			<div class="col-12 col-md-6 col-lg-3">
				<article class="abt-card">
					<div class="abt-icon orange">
						<i class="fas fa-book-open"></i>
					</div>
					<div class="abt-content">
						<h3>Relevant to Australian learning</h3>
						<p>We recognise the importance of aligning learning support with Australian school curricula and classroom expectations.</p>
					</div>
				</article>
			</div>

			<div class="col-12 col-md-6 col-lg-3">
				<article class="abt-card">
					<div class="abt-icon blue">
						<i class="fas fa-compass"></i>
					</div>
					<div class="abt-content">
						<h3>Informed choices</h3>
						<p>We help families explore learning programs and tutor options with a clearer understanding of the support available.</p>
					</div>
				</article>
			</div>
		</div>
		<p class="text-center abt-p mb-0 fw-bold">Our commitment is simple: help families make informed learning decisions and give students a clearer path towards their next step.</p>
	</div>
</section>

<!-- 7. CLOSING CTA -->
<section class="abt-cta mt-3" aria-labelledby="abt-cta-title">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12 col-lg-8">
				<div class="d-flex align-items-center abt-cta-left">
					<div class="abt-cta-image">
						<img src="{{ public_asset('assets/images/about/last_image.png') }}"
							alt="Diagnostic assessment">
					</div>

					<div class="abt-cta-content">
						<span class="abt-eyebrow">Ready to take the next step?</span>

						<h2 id="abt-cta-title" class="abt-cta-title">
							Start with a free diagnostic assessment.
						</h2>

						<p class="abt-cta-desc">
							Get a clearer understanding of your child's learning needs and receive recommendations to help guide the next step.
						</p>
					</div>

				</div>
			</div>

			<div class="col-12 col-lg-4 text-lg-end abt-cta-right">
				<a href="{{ route('program.assessment') }}" class="abt-btn">
					Book Free Diagnostic Assessment
					<i class="fas fa-arrow-right"></i>
				</a>
				<p class="abt-cta-support">
					Start with understanding. Find a clearer way forward.
				</p>
			</div>
		</div>
	</div>
</section>
</div>
@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')
<style type="text/css">
	:root {
		--abt-red: #e61e33;
		--abt-red-btn: #dc2626;
		--abt-red-btn-hover: #b91c1c;
		--abt-text: #475569;
		--abt-text-dark: #334155;
		--abt-muted: #64748b;
		--abt-cream: #FFF9EC;
		--abt-cream-hero: #fdf8f5;
		--abt-border: #e2e8f0;
		--abt-pink: #feedec;
		--abt-green: #0e9c61;
		--abt-green-bg: #e8f5e9;
		--abt-orange: #f59e0b;
		--abt-orange-dark: #e65100;
		--abt-orange-bg: #fff3e0;
		--abt-blue: #0f4c81;
		--abt-blue-bg: #e6eef6;
		--abt-serif: 'Playfair Display', Georgia, serif;
		--abt-hand: 'Caveat', cursive;
	}

	html,
	body {
		max-width: 100%;
		overflow-x: hidden;
	}
	.about-page {
		background-color: #fff;
	}

	.abt-eyebrow {
		display: block;
		color: var(--abt-red);
		font-size: 0.8rem;	
		letter-spacing: 1.2px;
		text-transform: uppercase;
		font-weight: 800;
		margin-bottom: 10px;
	}

	.abt-h1 {
		font-size: clamp(2.1rem, 4.6vw, 3.1rem);
		font-weight: 700;
		line-height: 1.15;
	}

	.abt-h2 {
		font-size: clamp(1.7rem, 3vw, 2.25rem);
		font-weight: 700;
		line-height: 1.2;
	}

	.abt-p {
		color: var(--abt-text);
		font-size: 0.97rem;
		line-height: 1.65;
	}

	.abt-section {
		padding: 20px 0;
	}

	/* ---------- Buttons---------- */
	.abt-btn {
		background-color: var(--abt-red-btn);
		color: #fff !important;
		border: none;
		border-radius: 6px;
		padding: 12px 22px;
		font-weight: 600;
		font-size: 0.9rem;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
		transition: background-color .2s ease;
	}

	.abt-btn:hover {
		background-color: var(--abt-red-btn-hover);
	}


	.abt-photo {
		background: linear-gradient(135deg, #f1dfd3, #cfae98);
		background-size: cover;
		background-position: center;
		position: relative;
		overflow: hidden;
	}

	.abt-photo img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

    /* 1. HERO */
	.abt-hero {
		position: relative;
		padding: 2%;
		background-image: url("{{ public_asset('assets/images/about/image1.png') }}");
		background-repeat: no-repeat;
		background-size: 60% 100%;
		background-position: right 1%;
		background-color: var(--abt-cream-hero);
		overflow: hidden;
	}

	.abt-hero::before {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(90deg,
				var(--abt-cream-hero) 0%,
				var(--abt-cream-hero) 42%,
				rgba(255, 248, 235, 0.85) 52%,
				rgba(255, 248, 235, 0.1) 70%,
				transparent 100%);
		z-index: 1;
	}

	.abt-hero .container {
		position: relative;
		z-index: 2;
	}

	.abt-hero-content {
		max-width: 650px;
	}
	@media (max-width: 991px) {
		.desk-top{
         display: none;
		}
		.mobile{
			display: none;
		}
		.abt-hero {
			background-size: cover;
		}

	}

	/* 2. WHY WE EXIST */
	.abt-why {
		position: relative;
		overflow: hidden;
		background: #fff;
	}

	.abt-why::before {
		content: '';
		position: absolute;
		left: -80px;
		top: -20px;
		width: 520px;
		height: 520px;
		border-radius: 50%;
		background: radial-gradient(circle,
				var(--abt-pink) 0%,
				rgba(253, 236, 238, 0) 70%);
	}

	.abt-why .row {
		position: relative;
		z-index: 1;
		align-items: stretch;
	}
	.abt-why .col-lg-6:first-child {
		display: flex;
	}

	.abt-why-photo-wrap {
		position: relative;
		width: 100%;
		height: 100%;
		min-height: 100%;
	}

	.abt-why-photo {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		overflow: hidden;
	}

	.abt-why-photo img {
		display: block;
		width: 100%;
		height: 100%;
		object-fit: cover;
		object-position: center;
	}

	.abt-why-content {
		width: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.abt-highlight {
		background: var(--abt-pink);
		border-radius: 10px;
		padding: 16px 20px;
		display: flex;
		align-items: center;
		gap: 14px;
		color: var(--abt-red);
		font-weight: 700;
		font-size: 0.98rem;
		margin: 20px 0;
	}

	.abt-highlight i {
		font-size: 1.6rem;
		flex-shrink: 0;
	}

	@media (max-width: 991px) {

		.abt-why .col-lg-6:first-child {
			display: block;
		}

		.abt-why-photo-wrap {
			height: 350px;
			min-height: 350px;
		}

		.abt-why-photo {
			border-radius: 24px;
		}

		.abt-why-content {
			height: auto;
		}
	}

	@media (max-width: 576px) {

		.abt-why-photo-wrap {
			height: 280px;
			min-height: 280px;
		}

		.abt-highlight {
			padding: 14px;
			font-size: 0.9rem;
		}

	}

    /* 3. HOW WE ARE DIFFERENT  */
	.abt-diff {
		background: var(--abt-cream);
		padding: 30px 30px;
		margin: auto;
	}

	.abt-card {
		border: 1px solid var(--abt-border);
		border-radius: 12px;
		padding: 22px 20px;
		background: #fff;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
		height: 100%;
		display: flex;
		gap: 6px;
		align-items: flex-start;
		transition: transform .2s ease, box-shadow .2s ease;
	}

	.abt-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
	}

	.abt-card h3 {
		font-size: 1.05rem;
		font-weight: 700;
		color: #1e293b;
		margin-bottom: 6px;
	}

	.abt-card p {
		font-size: 0.88rem;
		color: var(--abt-muted);
		line-height: 1.5;
		margin: 0;
	}

	.abt-icon {
		width: 48px;
		height: 48px;
		border-radius: 8px;
		flex-shrink: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		font-size: 1.2rem;
	}

	.abt-icon.green {
		background: var(--abt-green);
	}

	.abt-icon.orange {
		background: var(--abt-orange);
	}

	.abt-icon.red {
		background: var(--abt-red-btn);
	}

	.abt-icon.blue {
		background: var(--abt-blue);
	}

	@media (max-width: 767px) {
    .abt-diff {
        padding: 0 !important;
    }
}

    /* 4. OUR APPROACH  */
	.abt-approach {
		background: #fff;
		padding: 20px 0 20px;
	}

	.abt-approach-panel {
		background: #eff8fe;
		border-radius: 14px;
		padding: 36px 32px 34px;
		border: 1px solid #f3ead2;
	}

	.abt-step {
		position: relative;
		text-align: left;
	}

	.abt-circle {
		display: flex;
		justify-content: center;
		align-items: center;
		margin: 0 auto 15px;
	}

	.abt-arrow {
		position: absolute;
		left: 28%;
		transform: translateY(150%);
		color: #6b6966;
		font-size: 24px;
		z-index: 2;
	}

.abt-section p,
.abt-hero p,
.abt-approach p,
.abt-cta p {
    color: var(--abt-text);
}	

	.abt-circle img {
		width: 90px;
		height: 90px;
		object-fit: contain;
	}

	.abt-step-num {
		font-size: 0.8rem;
		font-weight: 800;
		color: var(--abt-red);
		letter-spacing: .5px;
		text-transform: uppercase;
	}

	.abt-step h3 {
		font-size: 1rem;
		font-weight: 700;
		color: #0f172a;
		margin: 4px 0 8px;
	}

	.abt-step p {
		font-size: 0.85rem;
		color: var(--abt-text);
		line-height: 1.5;
		margin: 0;
	}

	.abt-step:not(:last-child)::after {
		content: '\f061';
		font-family: 'Font Awesome 5 Free', 'Font Awesome 6 Free';
		font-weight: 900;
		position: absolute;
		top: 35px;
		right: -16px;
		color: #676b70;
		font-size: 1rem;
	}

	.abt-approach-close {
		text-align: center;
		color: var(--abt-navy);
		font-weight: 700;
		margin: 28px 0 0;
	}
    @media (max-width: 767px) {
		.abt-arrow {
			display: none;
		}
	}
	@media (max-width: 991px) {
		.abt-step:not(:last-child)::after {
			display: none;
		}
			.mx-5 {
				margin-left: 0 !important;
				margin-right: 0 !important;
				margin-top: 6%;
			}

		#abt-approach-title{
          white-space: normal !important;
		}

		.abt-arrow {
			display: none;
		}
	}

	@media (min-width: 992px) {
		.abt-approach .row > [class*="col-lg-3"] {
           position: relative;
        }

		.abt-arrow {
			position: absolute;
			right: -12px;
			top: 35%;
			transform: translateY(-50%);
			color: #6b6966;
			font-size: 24px;
			z-index: 2;
		}
	}

    /* 5. OUTCOMES */
	.abt-outcomes-photo-wrap {
		position: relative;
		min-height: 320px;
		height: 100%;
	}

	.abt-outcomes-photo {
		position: absolute;
		inset: 0;
		border-radius: 16px;
		overflow: hidden;
	}

	.abt-outcomes-photo img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		object-position: right;
		display: block;
	}

	.abt-outcomes-note {
		position: absolute;
		right: 6%;
		top: 12%;
		transform: rotate(-8deg);
		font-size: 1.5rem;
		line-height: 1.1;
		color: var(--abt-navy);
		font-weight: 600;
		max-width: 9.5rem;
		z-index: 2;
	}

	.abt-mini-card {
		border: 1px solid var(--abt-border);
		border-radius: 12px;
		background: #fff;
		padding: 16px;
		display: flex;
		gap: 10px;
		height: 100%;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
	}

	.abt-mini-card .abt-icon {
		width: 42px;
		height: 42px;
		font-size: 1.05rem;
	}

	.abt-mini-card h3 {
		font-size: 0.80rem;
		font-weight: 700;
		color: #1e293b;
		margin-bottom: 4px;
	}

	.abt-mini-card p {
		font-size: 0.8rem;
		color: var(--abt-muted);
		line-height: 1.45;
		margin: 0;
	}

	.abt-grid {
		row-gap: 14px;
	}

	.abt-grid>div {
		display: flex;
	}

	.abt-card {
		width: 100%;
		min-height: 130px;
		padding: 24px 22px;
	}

    /* 6. COMMITMENT */
	.abt-commit {
		background: var(--abt-cream);
	}

	.abt-commit .abt-card {
		display: flex;
		flex-direction: row;
		align-items: flex-start;
		gap: 16px;
		height: 100%;
		padding: 18px 12px;
	}

	.abt-commit .abt-icon {
		flex: 0 0 48px;
		width: 48px;
		height: 48px;
		margin: 0;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.abt-commit .abt-content {
		flex: 1;
		min-width: 0;
	}

	.abt-commit .abt-content h3 {
		margin: 0 0 8px;
		font-size: 18px;
	}

	.abt-commit .abt-content p {
		margin: 0;
		line-height: 1.6;
	}
@media (max-width: 767px) {
    .abt-commit .row{
        gap: 20px;
    }
	.abt-outcomes-photo img{
		object-fit: fill;
	}
}
    /* 7. CTA */
	.abt-cta {
		background-color: var(--abt-pink);
		color: #fff;
		width: 100%;
		margin: 0;
		padding: 13px;
		border-radius: 0;
	}

	.abt-cta .container {
		max-width: 1320px;
	}

	.abt-cta-left {
		gap: 25px;
	}

	.abt-cta-image {
		width: 120px;
		height: 110px;
		flex: 0 0 120px;
		border-radius: 12px;
		overflow: hidden;
	}

	.abt-cta-image img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.abt-cta-content {
		flex: 1;
		min-width: 0;
		margin-left: 15px;
	}

	.abt-cta-title {
		font-size: 1.5rem;
		font-weight: 700;
		margin-bottom: 8px;
		white-space: nowrap;
		color: var(--abt-text);

	}

	.abt-cta-desc {
		font-size: 0.9rem;
		color: var(--abt-text);
		margin: 0;
		line-height: 1.5;
	}

	.abt-cta-right {
		display: flex;
		flex-direction: column;
		align-items: flex-end;
	}

	.abt-cta-support {
		font-size: 0.8rem;
		color: var(--abt-text);
		margin: 10px 0 0;
	}

	@media (max-width: 991px) {
		.abt-cta-title {
			white-space: normal;
			font-size: 1.3rem;
		}

		.abt-cta-right {
			align-items: center;
			margin-top: 20px;
		}
	}

	@media (max-width: 576px) {
		.abt-cta-image {
			width: 75px;
			height: 75px;
		}

		.abt-cta-content {
			margin-left: 0;
		}

		.abt-cta-title {
			font-size: 1.1rem;
		}

		.abt-btn {
			width: 100%;
			justify-content: center;
		}
		  .abt-cta-left {
        flex-direction: column !important;
        align-items: center !important;
        text-align: center;
    }

    .abt-cta-image {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
		overflow: visible;
    }

    .abt-cta-image img {
        width: 220px;
        max-width: 100%;
        height: fit-content;
        object-fit: contain;
        display: block;
    }

    .abt-cta-content {
        width: 100%;
        text-align: center;
    }

	}
	
</style>
@endsection