@extends('layouts.app')

@section('title')
    <title>V-Tutor</title>
@endsection

@section('left_part')
    @include('include.header_menu_part')
    <link href="{{ public_asset('assets/faro_font/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ public_asset('assets/css/landing_animation.css') }}" rel="stylesheet" type="text/css">
    
    <style type="text/css">
        body, h1, h2, h3, h4, h5, h6, p, span, button, ul, li {
            font-family: Faro !important;
        }

        body {
            background-color: white !important;
        }
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* --- Hero Banner Section --- */
        .hero-banner-section {
            position: relative;
            background-color: #fafbfc;
            padding: 80px 0 40px 0;
            min-height: 520px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* --- Background Slider Styles --- */
        .hero-slider-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            opacity: 0;
            animation: heroFadeSlide 15s infinite;
        }

        /* Background Images & Staggered Animation Delays */
        .hero-slide:nth-child(1) {
            background-image: url("{{ public_asset('assets/images/landing_tutor/hero_student.png') }}");
            animation-delay: 0s;
        }

        .hero-slide:nth-child(2) {
            background-image: url("{{ public_asset('assets/images/landing_tutor/hero_tutor.png') }}");
            animation-delay: 5s;
        }

        .hero-slide:nth-child(3) {
            background-image: url("{{ public_asset('assets/images/landing_tutor/hero_tutor_2.png') }}");
            animation-delay: 10s;
        }

        @keyframes heroFadeSlide {
            0% { opacity: 0; }
            10% { opacity: 1; }
            33.33% { opacity: 1; }
            43.33% { opacity: 0; }
            100% { opacity: 0; }
        }

        /* Gradient Overlay for the entire left side */
        .hero-banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 55%;
            background: linear-gradient(to right, 
                rgba(253, 248, 245, 0.98) 0%, 
                rgba(253, 248, 245, 0.92) 70%, 
                rgba(253, 248, 245, 0) 100%
            );
            z-index: 1;
        }

        .hero-banner-section .container {
            position: relative;
            z-index: 2;
        }

        .hero-content-wrapper {
            max-width: 540px;
        }

        .hero-tag {
            color: #c21f34;
            font-size: 0.85rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .hero-title {
            color: #0c1a30;
            font-size: 2.3rem;
            font-weight: 700;
            line-height: 1.15;
        }

        .hero-title .highlight-red {
            color: #dc2626;
        }

        .hero-description {
            color: #334155;
            font-size: 1rem;
            line-height: 1.6;
        }

        .btn-red-primary {
            background-color: #dc2626;
            color: #ffffff !important;
            border: none;
            border-radius: 6px;
            padding: 12px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .btn-red-primary:hover {
            background-color: #b91c1c;
        }

        .btn-outline-custom {
            background-color: #ffffff;
            color: #1e293b !important;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 12px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: #f8fafc;
        }

        /* Trust Badges */
        .trust-badge-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trust-badge-icon {
            color: #c21f34;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .trust-badge-text {
            font-size: 0.75rem;
            font-weight: 700;
            color: #334155;
            line-height: 1.2;
        }

        /* Floating Pathway Overlay Card */
        .floating-pathway-card {
            position: absolute;
            top: 20%;
            right: 6%;
            background: #ffffff;
            border-radius: 12px;
            padding: 22px 24px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            width: 250px;
            z-index: 5;
        }

        .floating-pathway-card h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .pathway-steps {
            list-style: none;
            padding: 0;
            margin: 0;
            position: relative;
        }

        .pathway-steps::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 10px;
            bottom: 16px;
            width: 2px;
            background-color: #cbd5e1;
            z-index: 1;
        }

        .pathway-step {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            position: relative;
            z-index: 2;
            font-size: 0.75rem;
            font-weight: 600;
            color: #334155;
        }

        .pathway-step:last-child {
            margin-bottom: 0;
        }

        .step-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            flex-shrink: 0;
        }

        .step-icon.completed {
            background-color: #c21f34;
            color: #ffffff;
        }

        .step-icon.pending {
            border: 2px solid #cbd5e1;
            background-color: #ffffff;
        }

        @media only screen and (max-width: 991px) {
            .hero-banner-section {
                padding: 40px 0;
            }
            .hero-banner-section::before {
                width: 100%;
                background: rgba(253, 248, 245, 0.95);
            }
            .hero-title {
                font-size: 2.25rem;
            }
            .floating-pathway-card {
                position: relative;
                top: 0;
                right: 0;
                margin-top: 30px;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .trust-badge-item {
                margin-bottom: 12px; 
                align-items: flex-start; 
            }

            .trust-badge-text {
                font-size: 0.7rem; 
                line-height: 1.3;
            }
        }
        /* --- Intervention Section Styles --- */
        .intervention-section {
            padding: 60px 0 40px 0;
            background-color: #fff;
        }

        .intervention-subheading {
            color: #c21f34;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .intervention-title {
            color: #0d1b2a;
            font-size: 2.25rem;
            font-weight: 700;
        }

        .intervention-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px 24px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .intervention-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .intervention-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #fff;
            font-size: 1.25rem;
        }

        .icon-green { background-color: #1b7339; }
        .icon-orange { background-color: #f59e0b; }
        .icon-red { background-color: #dc2626; }
        .icon-blue { background-color: #0f4c81; }

        .intervention-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .intervention-card p {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 0;
        }

        .intervention-footer-text {
            color: #475569;
            font-size: 0.95rem;
            font-weight: 500;
        }
        /* vertical spacing on mobile screens */
        @media (max-width: 767px) {
            .intervention-section .row > [class*="col-"] {
                margin-bottom: 16px;
            }
            .intervention-section .row > [class*="col-"]:last-child {
                margin-bottom: 0;
            }
        }

        /* --- Methodology Section Styles --- */
        .methodology-section {
            padding: 60px 0 80px 0;
            background-color: #FFF9EC;
        }

        .methodology-tag {
            color: #c21f34;
            font-size: 0.75rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .methodology-title {
            color: #0d1b2a;
            font-size: 1.85rem;
            font-weight: 700;
            line-height: 1.25;
            max-width: 320px;
        }

        .methodology-step-item {
            position: relative;
            text-align: left;
        }

        /* Circular Icon Styling with unique colors */
        .methodology-circle-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            background-color: #ffffff;
            margin-bottom: 16px;
        }

        .circle-step-1 { border: 1px solid #1b7339; color: #1b7339; }
        .circle-step-2 { border: 1px solid #f59e0b; color: #f59e0b; }
        .circle-step-3 { border: 1px solid #f97316; color: #f97316; }
        .circle-step-4 { border: 1px solid #ef4444; color: #ef4444; }
        .circle-step-5 { border: 1px solid #3b82f6; color: #3b82f6; }
        .circle-step-6 { border: 1px solid #10b981; color: #10b981; }

        /* Dashed Connector Arrow between circles */
        .methodology-step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 30px;
            right: -25px;
            width: 30px;
            height: 12px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%20c2d3c7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12h14M12 5l7 7-7 7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
            opacity: 0.6;
        }

        .methodology-step-item h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .methodology-step-item h4 span {
            color: #1b7339;
            margin-right: 2px;
        }

        .methodology-step-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .methodology-step-list li {
            font-size: 0.75rem;
            color: #475569;
            margin-bottom: 6px;
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.3;
        }

        .methodology-step-list li::before {
            content: '✓';
            color: #c21f34;
            font-size: 0.7rem;
            font-weight: bold;
        }

        @media only screen and (max-width: 991px) {
            .methodology-step-item:not(:last-child)::after {
                display: none;
            }
            .methodology-title {
                max-width: 100%;
            }
        }

/* --- Programs Comparison Section Styles --- */
 .programs-section {
    padding: 40px 0 60px 0;
    background-color: #ffffff;
}

.program-card {
    border-radius: 12px;
    padding: 32px 28px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    background-color: #ffffff;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

/* Green Theme - Micro Learning (Visible Border + Glow Shadow) */
.program-card.card-micro {
    border: 2px solid #28a745; /* Darker, clearly visible green border */
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15), 0 4px 6px rgba(0, 0, 0, 0.05); /* Colored elevation shadow */
}

.program-card.card-micro:hover {
    transform: translateY(-4px); /* Subtle lift on hover */
    box-shadow: 0 15px 30px rgba(40, 167, 69, 0.25), 0 6px 10px rgba(0, 0, 0, 0.08);
}

.program-card.card-micro .program-title {
    color: #1b7339;
}

.program-card.card-micro .program-badge {
    background-color: #e8f5e9;
    color: #1b7339;
}

.program-card.card-micro .program-chip {
    background-color: #e8f5e9;
    color: #1b7339;
}

.program-card.card-micro .feature-icon {
    color: #1b7339;
}

/* Orange Theme - Academic Learning (Visible Border + Glow Shadow) */
.program-card.card-academic {
    border: 2px solid #ff7700; /* Darker, clearly visible orange border */
    box-shadow: 0 10px 25px rgba(255, 119, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.05); /* Colored elevation shadow */
}

.program-card.card-academic:hover {
    transform: translateY(-4px); /* Subtle lift on hover */
    box-shadow: 0 15px 30px rgba(255, 119, 0, 0.25), 0 6px 10px rgba(0, 0, 0, 0.08);
}

.program-card.card-academic .program-title {
    color: #e65100;
}

.program-card.card-academic .program-badge {
    background-color: #fff3e0;
    color: #e65100;
}

.program-card.card-academic .program-chip {
    background-color: #fff3e0;
    color: #e65100;
}

.program-card.card-academic .feature-icon {
    color: #e65100;
}

    .program-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .program-title {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin: 0;
        text-transform: uppercase;
    }

    .program-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .program-description {
        color: #475569;
        font-size: 0.92rem;
        line-height: 1.5;
        margin-bottom: 24px;
        max-width: 90%;
    }

    .program-features {
        display: flex;
        flex-wrap: wrap;
        gap: 16px 24px;
        margin-bottom: 28px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
    }

    .feature-icon {
        font-size: 1rem;
    }

    .popular-programs-title {
        font-size: 0.8rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .program-card.card-micro .popular-programs-title {
        color: #1b7339;
    }

    .program-card.card-academic .popular-programs-title {
        color: #e65100;
    }

    .program-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .program-chip {
        font-size: 0.8rem;
        font-weight: 700;
        padding: 8px 14px;
        border-radius: 6px;
        display: inline-block;
    }
    /* --- Mobile Responsive Fixes for Program Cards --- */
@media (max-width: 576px) {
    .program-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .program-badge {
        white-space: normal; 
        word-break: break-word;
    }
    
    .program-description {
        max-width: 100%; 
    }
}
/* Button Styles for Program Cards */
.btn-program-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    font-size: 0.9rem;
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
    margin-top: 24px;
}

/* Micro Learning Button (Green Theme) */
.btn-micro {
    background-color: #1b7339;
    color: #ffffff !important;
    border: 1px solid #1b7339;
}

.btn-micro:hover {
    background-color: #145a2c;
    border-color: #145a2c;
    box-shadow: 0 4px 12px rgba(27, 115, 57, 0.25);
}

/* Core Training Button (Orange Theme) */
.btn-academic {
    background-color: #e65100;
    color: #ffffff !important;
    border: 1px solid #e65100;
}

.btn-academic:hover {
    background-color: #bf4300;
    border-color: #bf4300;
    box-shadow: 0 4px 12px rgba(230, 81, 0, 0.25);
}
/* Vertical spacing between stacked program cards on mobile/tablet */
@media (max-width: 991px) {
    .programs-section .col-12:not(:last-child) {
        margin-bottom: 24px; 9*
    }
}
    .compare-link-wrapper {
        text-align: center;
        margin-top: 24px;
    }

    .gap-analysis-section {
        padding: 60px 0;
        background-color: #FFF9EC;
        font-family: Arial, sans-serif;
    }

@media (max-width: 512px) {
    .gap-analysis-section .row > div:nth-child(3) {
        margin-top: -12px;
    }
}
@media (max-width: 762px) {
    .gap-analysis-section .row > div:nth-child(3) {
        margin-top: -3px;
    }
}
    .section-eyebrow {
        color: #c21f34;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .section-title-serif {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .section-description {
        color: #4b5563;
        font-size: 0.95rem;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .checklist-group {
        list-style: none;
        padding: 0;
        margin: 0 0 28px 0;
    }

    .checklist-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
    }

    .checklist-icon {
        color: #c21f34;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .btn-assessment {
        background-color: #d92525;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .btn-assessment:hover {
        background-color: #b91c1c;
        color: #ffffff;
    }

    /* Middle Image Column */
    .feature-image-wrapper {
        width: 100%;
        height: 100%;
        min-height: 380px;
        border-radius: 16px;
        overflow: hidden;
    }

    .feature-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

@media (max-width: 991px) {
    .gap-analysis-section .btn-assessment {
        margin-bottom: 28px;
        display: inline-flex; 
    }
    .specialists-section .row > div:not(:last-child) {
        margin-bottom: 24px;
    }
}
    .trust-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .trust-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .trust-card-headline {
        color: #c21f34;
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .trust-card-headline-serif {
        font-family: 'Playfair Display', Georgia, serif;
    }

    .trust-card-subtext {
        color: #4b5563;
        font-size: 0.8rem;
        line-height: 1.3;
        margin: 0;
    }
    .specialists-section {
        padding: 60px 0;
        background-color: #ffffff;
        font-family: Arial, sans-serif;
    }

    .specialists-eyebrow {
        color: #c21f34;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .specialists-title-serif {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 32px;
        line-height: 1.2;
    }

    /* Tutor Cards */
    .tutor-avatar {
    width: 100px !important;
    height: 100px !important;
    min-width: 100px !important;
    min-height: 100px !important;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.tutor-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    display: flex !important;
    flex-direction: row !important;
    align-items: flex-start;
    gap: 20px;
    height: 100%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    width: 100%;
    box-sizing: border-box;
}
    .tutor-info {
        flex-grow: 1;
    }

    .tutor-name {
        font-size: 1.2rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 2px;
    }

    .tutor-role {
        font-size: 0.85rem;
        color: #4b5563;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .tutor-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .tutor-qualifications, .tutor-specialties {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tutor-qualifications li {
        font-size: 0.78rem;
        color: #374151;
        font-weight: 600;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tutor-qualifications li i {
        color: #c21f34;
        font-size: 0.85rem;
    }

    .specialises-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .tutor-specialties li {
        font-size: 0.78rem;
        color: #4b5563;
        margin-bottom: 4px;
        position: relative;
        padding-left: 10px;
    }

    .tutor-specialties li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #4b5563;
    }

    /* Testimonial Card */
 .testimonial-card {
    background-color: #faf9f6;
    border: 1px solid #f3f0e6;
    border-radius: 12px;
    padding: 28px 24px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    width: 100%;
    box-sizing: border-box;
}

    .quote-icon {
        color: #c21f34;
        font-size: 2rem;
        line-height: 1;
        margin-bottom: 12px;
    }

    .testimonial-text {
    color: #374151;
    font-size: 0.88rem;
    line-height: 1.6;
    margin-bottom: 16px;
    flex-grow: 1;
    overflow-y: auto;
    max-height: 220px; 
}

    .testimonial-author {
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 576px) {
        .tutor-card {
            flex-direction: column;
            text-align: center;
        }
        .tutor-details-grid {
            grid-template-columns: 1fr;
            text-align: left;
        }
    }
/* Ensure carousel items stretch full height */
.specialists-section .owl-stage {
    display: flex;
}

.specialists-section .owl-item {
    display: flex;
    flex: 1 0 auto;
}

.specialists-section .item {
    width: 100%;
}

/* Custom owl dots & nav placement for specialists section */
.specialists-section .owl-dots {
    margin-top: 15px !important;
}

.specialists-section .owl-theme .owl-dots .owl-dot span {
    background: #e5e7eb;
}

.specialists-section .owl-theme .owl-dots .owl-dot.active span,
.specialists-section .owl-theme .owl-dots .owl-dot:hover span {
    background: #c21f34;
}
/* --- Fix Tutor Card Layout Inside Owl Carousel --- */

/* Flex sizing fix for Owl Carousel children */
.specialists-section .row {
    display: flex;
    flex-wrap: wrap;
}

.specialists-section .col-12 {
    display: flex;
    flex-direction: column;
}

/*  Owl Carousel containers to expand and match full height */
#tutorsCarousel, 
#testimonialsCarousel,
#tutorsCarousel .owl-stage-outer,
#testimonialsCarousel .owl-stage-outer,
#tutorsCarousel .owl-stage,
#testimonialsCarousel .owl-stage {
    display: flex !important;
    flex: 1 1 auto;
    height: 100%;
}
/* Ensure mobile layout stacks vertically cleanly without stretching image */
@media (max-width: 576px) {
    .tutor-card {
        flex-direction: column !important;
        align-items: center !important;
        text-align: center;
    }
    
    .tutor-details-grid {
        grid-template-columns: 1fr;
        text-align: left;
    }
}
    .accreditation-section {
        padding: 40px 0;
        background-color: #FFF9EC;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        font-family: Arial, sans-serif;
    }

    .accreditation-eyebrow {
        color: #c21f34;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .divider-col {
        border-right: 1px solid #e5e7eb;
    }

    /* States Section */
    .states-grid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .state-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
    }

    .state-map-icon {
        height: 36px;
        width: auto;
        object-fit: contain;
    }

    .state-label {
        font-size: 0.8rem;
        font-weight: 800;
        color: #1f2937;
        letter-spacing: 0.5px;
    }

/* Curriculum Section */
.curriculum-grid {
    display: flex;
    align-items: stretch;
    gap: 10px;
    flex-wrap: wrap; /* Allows cards to wrap on smaller screens */
}

.curriculum-card {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 8px; 
    text-align: center;
    flex: 1 1 calc(50% - 10px); 
    min-width: 0;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    box-sizing: border-box;
}
@media (min-width: 1200px) {
    .curriculum-card {
        flex: 1 1 0;
    }
}

.curriculum-logo {
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    line-height: 1;
}

.curriculum-card.acara .curriculum-logo { color: #0088cc; }
.curriculum-card.nesa .curriculum-logo { color: #00529b; }
.curriculum-card.vcaa .curriculum-logo { color: #0a4a8a; }
.curriculum-card.qcaa .curriculum-logo { color: #e11d48; }

.curriculum-subtext {
    font-size: 0.65rem;
    color: #6b7280;
    font-weight: 600;
    margin: 0;
    line-height: 1.2;
    white-space: normal;
    word-break: break-word; 
}
.cta-banner-section {
    background-color: #c21f34;
    padding: 36px 0;
    color: #ffffff;
    font-family: Arial, sans-serif;
}

/* Force title to pure white */
.cta-banner-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #ffffff !important; 
}

.cta-banner-description {
    font-size: 0.95rem;
    color: #ffffff;
    opacity: 0.9;
    margin: 0;
    line-height: 1.4;
}


.cta-buttons-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: nowrap; 
}

.btn-cta-primary {
    background-color: #ffffff;
    color: #1b4d3e;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 12px 18px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
    white-space: nowrap;
}

.btn-cta-primary:hover {
    background-color: #f1f5f9;
    color: #13382d;
}

.btn-cta-secondary {
    background-color: transparent;
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 12px 18px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    white-space: nowrap; 
}

.btn-cta-secondary:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border-color: #ffffff;
}

@media (max-width: 991px) {
    .cta-buttons-wrapper {
        justify-content: flex-start;
        margin-top: 20px;
    }
}

/* Screen size adjustment so buttons stay inline on smaller mobile screens */
@media (max-width: 576px) {
    .cta-buttons-wrapper {
        gap: 8px;
    }
    
    .btn-cta-primary, 
    .btn-cta-secondary {
        font-size: 0.75rem;
        padding: 10px 10px;
    }
}
@media (max-width: 762px) {
    /* Allow buttons to stack vertically on small mobile screens */
    .cta-buttons-wrapper {
        flex-direction: column;
        align-items: stretch; /* Makes buttons full-width for a cleaner UI */
        gap: 10px;
    }

    .btn-cta-primary,
    .btn-cta-secondary {
        justify-content: center; /* Centers button text */
        text-align: center;
        white-space: normal;      /* Allows long text to wrap if screen is very narrow */
        width: 100%;             /* Fits nicely inside the CTA box */
    }
}
    </style>
@endsection

@section('content')
    <!-- Banner Section -->
    <section class="hero-banner-section">
        
        <div class="hero-slider-bg">
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-content-wrapper">
                        <p class="hero-tag mb-2">Australian Structured Online Learning Programs</p>
                        <h1 class="hero-title mb-3">
                            Every learning challenge has<br>
                            a reason.<br>
                            <span class="highlight-red">We help families address it.</span>
                        </h1>
                        <p class="hero-description mb-4">
                           We identify learning gaps, personalise learning pathways and connect students with specialist support to build understanding, confidence and measurable progress.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <a href="{{ route('program.assessment') }}" target="_blank" rel="noopener noreferrer" class="btn-red-primary">
                                <i class="far fa-calendar-alt"></i> Book Free Diagnostic Assessment
                            </a>
                            <a href="{{ route('products', ['type' => 'learning']) }}" target="_blank" rel="noopener noreferrer" class="btn-outline-custom">
                                Explore Learning Programs
                            </a>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="row g-2 pt-2">
                            <div class="col-6 col-sm-3">
                                <div class="trust-badge-item">
                                    <div class="trust-badge-icon"><i class="fas fa-user-shield"></i></div>
                                    <div class="trust-badge-text">WWCC<br>Verified Tutors</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="trust-badge-item">
                                    <div class="trust-badge-icon"><i class="fas fa-book-open"></i></div>
                                    <div class="trust-badge-text">ACARA-Aligned<br>Programs</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="trust-badge-item">
                                    <div class="trust-badge-icon"><i class="fas fa-sliders-h"></i></div>
                                    <div class="trust-badge-text">Flexible Learning<br>Pathways</div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3">
                                <div class="trust-badge-item">
                                    <div class="trust-badge-icon"><i class="fas fa-chart-line"></i></div>
                                    <div class="trust-badge-text">Progress Monitored<br>& Supported</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay Card -->
        <div class="floating-pathway-card d-none d-lg-block">
            <h4>Managed Learning Pathway</h4>
            <ul class="pathway-steps">
                <li class="pathway-step">
                    <span class="step-icon completed"><i class="fas fa-check"></i></span>
                    <span>Assessment Complete</span>
                </li>
                <li class="pathway-step">
                    <span class="step-icon completed"><i class="fas fa-check"></i></span>
                    <span>Learning Gaps Identified</span>
                </li>
                <li class="pathway-step">
                    <span class="step-icon completed"><i class="fas fa-check"></i></span>
                    <span>Program In Progress</span>
                </li>
                <li class="pathway-step">
                    <span class="step-icon pending"></span>
                    <span>Skills Mastered</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- Intervention Section -->
    <section class="intervention-section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="intervention-subheading mb-1">YOUR CHILD DOESN'T NEED MORE TUTORING.</p>
                <h2 class="intervention-title">They need targeted intervention to address the gap.</h2>
            </div>

            <div class="row g-4 mb-4">
                <!-- Knowledge Gaps -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="intervention-card">
                        <div class="intervention-icon icon-green">
                            <i class="fas fa-puzzle-piece"></i>
                        </div>
                        <h3>Knowledge Gaps</h3>
                        <p>Foundational knowledge gaps that make new learning harder</p>
                    </div>
                </div>

                <!-- Skill Gaps -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="intervention-card">
                        <div class="intervention-icon icon-orange">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Skill Gaps</h3>
                        <p>Knowing what to do, but struggling to apply it independently</p>
                    </div>
                </div>

                <!-- Confidence Gaps -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="intervention-card">
                        <div class="intervention-icon icon-red">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Confidence Gaps</h3>
                        <p>Understanding the work, but lacking confidence to show it</p>
                    </div>
                </div>

                <!-- Learning Behaviour Gaps -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="intervention-card">
                        <div class="intervention-icon icon-blue">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Learning Behaviour Gaps</h3>
                        <p>Challenges with organisation, study skills and effective learning habits</p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="intervention-footer-text mb-0">
                    We identify the gap first, so support can be targeted where it matters.
                </p>
            </div>
        </div>
    </section>

    <!-- Methodology Section -->
    <section class="methodology-section">
        <div class="container">
            <div class="row align-items-start g-4">
                <!-- Left Title Column -->
                <div class="col-12 col-lg-3">
                    <p class="methodology-tag mb-2">WHY V-TUTOR IS DIFFERENT</p>
                    <h2 class="methodology-title">A structured approach designed around your child's needs.</h2>
                </div>

                <!-- Right 6-Step Workflow Column -->
                <div class="col-12 col-lg-9">
                    <div class="row g-3">
                        <!-- Step 1 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-1">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h4><span>1.</span> Targeted Learning</h4>
                                <ul class="methodology-step-list">
                                    <li>Support focused on the areas that matter most.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-2">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <h4><span>2.</span> Personalised Programs</h4>
                                <ul class="methodology-step-list">
                                    <li>Learning pathways shaped around individual needs.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-3">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <h4><span>3.</span> Specialist Tutors</h4>
                                <ul class="methodology-step-list">
                                    <li>Subject-focused tutors matched to the learning need.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-4">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4><span>4.</span>Visible Progress</h4>
                                <ul class="methodology-step-list">
                                    <li>Learning progress is regularly tracked and assessed.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-5">
                                    <i class="fas fa-route"></i>
                                </div>
                                <h4><span>5.</span> Flexible Learning Pathways</h4>
                                <ul class="methodology-step-list">
                                    <li>Programs that adapt as learning needs change.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Step 6 -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <div class="methodology-step-item">
                                <div class="methodology-circle-icon circle-step-6">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <h4><span>6.</span> Ongoing Support</h4>
                                <ul class="methodology-step-list">
                                    <li>Guidance throughout the learning journey.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Program Section -->
<section class="programs-section">
    <div class="container">
        <div class="row g-4">
            <!-- Micro Learning Programs -->
            <div class="col-12 col-lg-6">
                <div class="program-card card-micro">
                    <div>
                        <div class="program-header">
                            <h3 class="program-title">Micro Learning Programs</h3>
                            <span class="program-badge">
                                <i class="fas fa-caret-right"></i> Best for targeted learning
                            </span>
                        </div>
                        <p class="program-description">
                            Short, focused programs designed to address a specific learning gap.
                        </p>

                        <div class="program-features">
                            <div class="feature-item">
                                <i class="far fa-calendar-alt feature-icon"></i>
                                <span>3-5 sessions</span>
                            </div>
                            <div class="feature-item">
                                <i class="far fa-check-circle feature-icon"></i>
                                <span>Targeted focus</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-bullseye feature-icon"></i>
                                <span>Clear learning goals</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-running feature-icon"></i>
                                <span>Fast to complete</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="popular-programs-title">Popular Programs</div>
                        <div class="program-chips">
                            <span class="program-chip">Master Fractions</span>
                            <span class="program-chip">Master Times Tables</span>
                            <span class="program-chip">Master Essay Writing</span>
                            <span class="program-chip">Master Algebra Foundations</span>
                        </div>
                        <!-- Explore MLP Button -->
                        <a href="{{ route('products', ['type' => 'mlp']) }}" target="_blank" rel="noopener noreferrer" class="btn-program-action btn-micro">
                            Explore MLP Programs <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Academic Learning Programs -->
            <div class="col-12 col-lg-6">
                <div class="program-card card-academic">
                    <div>
                        <div class="program-header">
                            <h3 class="program-title">Core Training Programs</h3>
                            <span class="program-badge">
                                <i class="fas fa-caret-right"></i> Best for sustained progress
                            </span>
                        </div>
                        <p class="program-description">
                            Comprehensive programs designed to address learning gaps and build skills through structured progression.
                        </p>

                        <div class="program-features">
                            <div class="feature-item">
                                <i class="far fa-calendar-alt feature-icon"></i>
                                <span>8-15 sessions</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-project-diagram feature-icon"></i>
                                <span>Structured pathways</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-chart-line feature-icon"></i>
                                <span>Progress milestones</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-bullhorn feature-icon"></i>
                                <span>Skill attainment</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="popular-programs-title">Popular Programs</div>
                        <div class="program-chips">
                            <span class="program-chip">Master Number Sense</span>
                            <span class="program-chip">Master Reading Comprehension</span>
                            <span class="program-chip">Master Algebra</span>
                            <span class="program-chip">Master Study Skills</span>
                        </div>
                        <!-- Explore CTP Button -->
                        <a href="{{ route('products', ['type' => 'ctp']) }}" target="_blank" rel="noopener noreferrer" class="btn-program-action btn-academic">
                            Explore CTP Programs <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Learning Gap Analysis-->
<section class="gap-analysis-section">
    <div class="container">
        <div class="row g-4 align-items-center">
            
            <!-- Left Column: Content & Bullet Points -->
            <div class="col-12 col-lg-4">
                <div class="section-eyebrow">FIRST STEP TOWARDS THE RIGHT SUPPORT</div>
                <h2 class="section-title-serif">Diagnostic Assessment</h2>
                <p class="section-description">
                    Understand where your child is today, identify where support is needed and recommend the right direction for their learning.
                </p>

                <ul class="checklist-group">
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Academic Feedback</span>
                    </li>
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Learning Recommendations</span>
                    </li>
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Curriculum-Aligned Learning Focus</span>
                    </li>
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Personalised Program Recommendation</span>
                    </li>
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Specialist Tutor Recommendation</span>
                    </li>
                    <li class="checklist-item">
                        <i class="far fa-check-circle checklist-icon"></i>
                        <span>Learning Pathway Guidance</span>
                    </li>
                </ul>

                <a href="{{ route('program.assessment') }}" target="_blank" rel="noopener noreferrer" class="btn-assessment">
                    <i class="far fa-calendar-alt"></i>
                     Book Free Diagnostic Assessment
                    <i class="far fa-calendar-alt"></i>
                </a>
            </div>

            <!-- Middle Column: Banner Image -->
            <div class="col-12 col-lg-4">
                <div class="feature-image-wrapper">
                    <img src="{{ public_asset('assets/images/landing_tutor/learning_gap.png') }}" alt="Student and Tutor Learning Session">
                </div>
            </div>

            <!-- Right Column: Why Parents Trust Cards Grid -->
            <div class="col-12 col-lg-4">
                <div class="section-eyebrow mb-3">Why Parents Trust V-Tutor</div>
                <div class="trust-card-grid">
                    
                    <div class="trust-card">
                        <div class="trust-card-headline">100%</div>
                        <p class="trust-card-subtext">WWCC verified<br>tutors</p>
                    </div>

                    <div class="trust-card">
                        <div class="trust-card-headline trust-card-headline-serif">Personalised</div>
                        <p class="trust-card-subtext">Learning pathways</p>
                    </div>

                    <div class="trust-card">
                        <div class="trust-card-headline trust-card-headline-serif">ACARA<br>Aligned</div>
                        <p class="trust-card-subtext">curriculum-aligned<br>learning</p>
                    </div>

                    <div class="trust-card">
                        <div class="trust-card-headline trust-card-headline-serif">Visible Progress</div>
                        <p class="trust-card-subtext">Learning progress<br>tracked & assessed</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Specialist Section -->
<section class="specialists-section">
    <div class="container">
        
        <div class="specialists-eyebrow">Meet Our Learning Specialists</div>
        <h2 class="specialists-title-serif">Qualified tutors specialising in targeted learning support</h2>

        <div class="row g-4">
            
            <!-- Left Column: Tutors Carousel -->
            <div class="col-12 col-lg-8">
                <div class="owl-carousel owl-theme" id="tutorsCarousel">
                    
                    <!-- Tutor Card 1 -->
                    <div class="item">
                        <div class="tutor-card">
                            <img src="{{ public_asset('assets/images/team/tutor-4.jpg') }}" alt="Nina" class="tutor-avatar">
                            <div class="tutor-info">
                                <h3 class="tutor-name">Nina</h3>
                                <div class="tutor-role">Primary Numeracy Specialist</div>
                                
                                <div class="tutor-details-grid">
                                    <ul class="tutor-qualifications">
                                        <li><i class="fas fa-check"></i> B.Ed Primary Education</li>
                                        <li><i class="fas fa-check"></i> 8 years’ teaching experience</li>
                                        <li><i class="fas fa-check"></i> WWCC verified</li>
                                        <li><i class="fas fa-check"></i> Primary Mathematics Specialist</li>
                                        <li><i class="fas fa-check"></i> Years 1-6 Mathematics</li>
                                    </ul>
                                    <div>
                                        <div class="specialises-label">Specialises in:</div>
                                        <ul class="tutor-specialties">
                                            <li>Number sense</li>
                                            <li>Numeracy intervention</li>
                                            <li>Years 1–6 Mathematics</li>
                                            <li>Primary Mathematics Foundations</li>
                                            <li>Building Mathematical Confidence</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tutor Card 2 -->
                    <div class="item">
                        <div class="tutor-card">
                            <img src="{{ public_asset('assets/images/team/Krishna.jpg') }}" alt="THUY Y VAN" class="tutor-avatar">
                            <div class="tutor-info">
                                <h3 class="tutor-name">Krishna</h3>
                                <div class="tutor-role">Senior Biology Specialist</div>
                                
                                <div class="tutor-details-grid">
                                    <ul class="tutor-qualifications">
                                        <li><i class="fas fa-check"></i> Master’s Degree - Education</li>
                                        <li><i class="fas fa-check"></i> Biology Senior - Yrs 11–12</li>
                                        <li><i class="fas fa-check"></i> Science & Technology</li>
                                        <li><i class="fas fa-check"></i> VCE, IB & HSC Curricula</li>
                                    </ul>
                                    <div>
                                        <div class="specialises-label">Specialises in:</div>
                                        <ul class="tutor-specialties">
                                            <li>Biology & Env Science</li>
                                            <li>Senior Secondary Biology</li>
                                            <li>VCE Science</li>
                                            <li>IB Science</li>
                                            <li>HSC Science</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tutor Card 3 -->
                    <div class="item">
                        <div class="tutor-card">
                            <img src="{{ public_asset('assets/images/team/parla.png') }}" alt="Yuk Chun" class="tutor-avatar">
                            <div class="tutor-info">
                                <h3 class="tutor-name">Parla</h3>
                                <div class="tutor-role">Mathematics & English Tutor</div>
            
                            <div class="tutor-details-grid">
                                <ul class="tutor-qualifications">
                                    <li><i class="fas fa-check"></i> Bachelor’s Degree - Engineering</li>
                                    <li><i class="fas fa-check"></i> Mathematics - Years 3–10</li>
                                    <li><i class="fas fa-check"></i> English - Years 8–9</li>
                                    <li><i class="fas fa-check"></i> Selective School Entry Experience</li>
                                </ul>
                                <div>
                                    <div class="specialises-label">Specialises in:</div>
                                        <ul class="tutor-specialties">
                                            <li>Mathematics Foundations</li>
                                            <li>Concept Reinforcement</li>
                                            <li>Personalised Learning Support</li>
                                            <li>Building Student Confidence</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tutor Card 4 -->
                    <div class="item">
                        <div class="tutor-card">
                            <img src="{{ public_asset('assets/images/team/tutor-1.jpg') }}" alt="SARAH CHEN" class="tutor-avatar">
                            <div class="tutor-info">
                                <h3 class="tutor-name">Ruvindya</h3>
                                <div class="tutor-role">Mathematics & STEM Tutor</div>
            
                            <div class="tutor-details-grid">
                                <ul class="tutor-qualifications">
                                    <li><i class="fas fa-check"></i> Bachelor of Engg (Honours)</li>
                                    <li><i class="fas fa-check"></i> 5+ years’ experience</li>
                                    <li><i class="fas fa-check"></i> Mathematics, English & Science</li>
                                    <li><i class="fas fa-check"></i> Structured learning approach</li>
                                </ul>
                                <div>
                                    <div class="specialises-label">Specialises in:</div>
                                        <ul class="tutor-specialties">
                                            <li>Mathematics Foundations</li>
                                            <li>English & Science</li>
                                            <li>Concept Reinforcement</li>
                                            <li>Guided Practice & Problem Solving</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Testimonial Carousel -->
            <div class="col-12 col-lg-4">
                <div class="owl-carousel owl-theme" id="testimonialsCarousel">
                    
                    <div class="item">
                        <div class="testimonial-card">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                For the first time, we understood why our son was struggling.<br><br>
                                The progress reports helped us see improvement every week.<br><br>
                                We started with a micro program and eventually enrolled in a full learning pathway.
                            </p>
                            <p class="testimonial-author">– Sarah, Parent</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial-card">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                The tutors are patient and highly engaging. My daughter looks forward to her sessions every week and her confidence has grown dramatically.
                            </p>
                            <p class="testimonial-author">– Michael, Parent</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Accreditation Section -->
<section class="accreditation-section">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Left Side: Supporting Students Across Australia -->
            <div class="col-12 col-lg-7 divider-col pe-lg-4">
                <div class="accreditation-eyebrow">Supporting Students Across Australia</div>
                <div class="states-grid">
                    
                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/nsw.png') }}" alt="NSW Map" class="state-map-icon">
                        <span class="state-label">NSW</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/vic.png') }}" alt="VIC Map" class="state-map-icon">
                        <span class="state-label">VIC</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/qld.png') }}" alt="QLD Map" class="state-map-icon">
                        <span class="state-label">QLD</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/wa.png') }}" alt="WA Map" class="state-map-icon">
                        <span class="state-label">WA</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/sa.png') }}" alt="SA Map" class="state-map-icon">
                        <span class="state-label">SA</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/tas.png') }}" alt="TAS Map" class="state-map-icon">
                        <span class="state-label">TAS</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/act.png') }}" alt="ACT Map" class="state-map-icon">
                        <span class="state-label">ACT</span>
                    </div>

                    <div class="state-item">
                        <img src="{{ public_asset('assets/images/landing_tutor/nt.png') }}" alt="NT Map" class="state-map-icon">
                        <span class="state-label">NT</span>
                    </div>

                </div>
            </div>

            <!-- Right Side: Curriculum Aligned -->
            <div class="col-12 col-lg-5 ps-lg-4">
                <div class="accreditation-eyebrow">Curriculum Aligned</div>
                <div class="curriculum-grid">
                    
                    <div class="curriculum-card acara">
                        <div class="curriculum-logo">ACARA</div>
                        <p class="curriculum-subtext">Australian Curriculum</p>
                    </div>

                    <div class="curriculum-card nesa">
                        <div class="curriculum-logo">NESA</div>
                        <p class="curriculum-subtext">NSW Curriculum</p>
                    </div>

                    <div class="curriculum-card vcaa">
                        <div class="curriculum-logo">VCAA</div>
                        <p class="curriculum-subtext">Victorian Curriculum</p>
                    </div>

                    <div class="curriculum-card qcaa">
                        <div class="curriculum-logo">QCAA</div>
                        <p class="curriculum-subtext">Queensland Curriculum</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!--CTAction -->
<section class="cta-banner-section">
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Left Text Content -->
            <div class="col-12 col-lg-7">
                <h2 class="cta-banner-title">Not sure where to start?</h2>
                <p class="cta-banner-description">
                    Start with a free diagnostic assessment and we'll recommend the right program for your child.
                </p>
            </div>

            <!-- Right Buttons -->
            <div class="col-12 col-lg-5">
                <div class="cta-buttons-wrapper">
                    <a href="{{ route('program.assessment') }}" target="_blank" rel="noopener noreferrer" class="btn-cta-primary">
                        Book Free Diagnostic Assessment
                        <i class="far fa-calendar-alt"></i>
                    </a>
                    <a href="{{ route('products', ['type' => 'learning']) }}" target="_blank" rel="noopener noreferrer" class="btn-cta-secondary">
                        Explore Programs
                    </a>
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
        $(document).ready(function () {
    // Initialize Tutors Carousel
    const $tutorsCarousel = $("#tutorsCarousel");
    if ($tutorsCarousel.length) {
        $tutorsCarousel.owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            dots: true,
            nav: false,
            margin: 20,
            responsive: {
                0: { items: 1 },
                768: { items: 2 },
                992: { items: 2 }
            }
        });
    }

    // Initialize Testimonials Carousel
    const $testimonialsCarousel = $("#testimonialsCarousel");
    if ($testimonialsCarousel.length) {
        $testimonialsCarousel.owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: true,
            nav: false,
            margin: 10,
            items: 1
        });
    }
});
    </script>
@endsection