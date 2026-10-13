<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Academic Advisor Report - {{ $assessment->first_name }} {{ $assessment->last_name }}</title>
    <style>
       * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2d3748;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            background-color: #F8EFE2;
        }

        h1, h2, h3, h4, p, ol, ul, li { 
            margin: 0; 
            padding: 0; 
            color: #1a202c; 
        }

        /* ----------------------------------
           SECTION 1: TOP HEADER TABLE
        ---------------------------------- */
        .header-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 6px; 
        }
        .header-table td { 
            vertical-align: bottom; 
            padding-bottom: 6px;
        }
        .logo-img {
            height: 48px;
            display: block;
        }
        .report-title-red {
            font-size: 16px; 
            font-weight: 800; 
            color: #c21f34; 
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 3px;
        }
        .advisor-meta {
            font-size: 10px; 
            color: #64748b; 
        }
        .advisor-meta strong {
            color: #334155;
        }

        /* Red Divider Bar */
        .header-red-line {
            width: 100%;
            height: 3px;
            background-color: #c21f34;
            margin-bottom: 12px;
        }

        /* ----------------------------------
           SECTION 2: TITLE BANNER
        ---------------------------------- */
        .title-banner {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 6px;
            padding: 8px 12px;
            text-align: center;
            margin-bottom: 12px;
        }
        .title-banner-text {
            font-size: 12px;
            font-weight: 800;
            color: #2c3b52;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ----------------------------------
           SECTION 3: STUDENT PERFORMANCE CARD
        ---------------------------------- */
        .student-card {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 8px;
            border-left: 4px solid #c21f34;
            border-collapse: separate;
            padding: 12px 16px;
            margin-bottom: 14px;
        }
        .student-name {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .student-meta-details {
            font-size: 10px;
            color: #64748b;
        }
        .student-meta-details strong {
            color: #475569;
        }

        /* Score Metrics */
        .score-percentage {
            font-size: 32px;
            font-weight: 800;
            line-height: 32px;
            margin-bottom: 4px;
        }
        .score-subtext {
            font-size: 10px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 3px;
        }
        .star-icon {
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-left: 1px;
        }
/* ----------------------------------
   SECTION 5: KEY STRENGTHS (BADGE & ICON STYLE)
---------------------------------- */
.strength-card {
    border-radius: 6px;
    padding: 6px 8px;
    font-size: 10px;
    font-weight: 600;
    line-height: 1.2;
}

/* Selected Badge Style */
.strength-card-selected {
    background-color: #ecfdf5;
    border: 1px solid #10b981;
    color: #047857;
}

/* Unselected Badge Style */
.strength-card-unselected {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #94a3b8;
}

.additional-strengths-box {
    margin-top: 8px;
    padding: 6px 10px;
    background-color: #fffafb;
    border-left: 3px solid #c21f34;
    border-radius: 4px;
    font-size: 10px;
    color: #334155;
}
/* ----------------------------------
   SECTION 6: LEARNING OPPORTUNITIES (BADGE STYLE)
---------------------------------- */
.opportunity-badge {
    background-color: #fff5f5;
    border: 1px solid #fecdd3;
    border-radius: 20px; /* Rounded pill shape */
    padding: 5px 10px;
    font-size: 10px;
    font-weight: 700;
    color: #9f1239;
    text-align: center;
}

.additional-opportunities-box {
    margin-top: 8px;
    padding: 6px 10px;
    background-color: #fffafb;
    border-left: 3px solid #c21f34;
    border-radius: 4px;
    font-size: 10px;
    color: #334155;
}
/* ----------------------------------
   SECTION 7: ASSESSMENT VALIDATIONS & INSIGHTS (SPACIOUS ALIGNMENT)
---------------------------------- */
/* Highlight Box for Summaries */
.summary-highlight-box {
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #f8fafc;
    border-left: 3px solid #c21f34;
    border-radius: 4px;
    font-size: 10px;
    color: #334155;
    line-height: 1.4;
}
.summary-highlight-box strong {
    color: #c21f34;
}
.validation-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 20px; /* Increased internal padding for breathing room */
    margin-bottom: 16px; /* Extra gap between cards */
}

.validation-title-row {
    margin-bottom: 12px;
}

.check-icon {
    display: inline-block;
    width: 18px;
    height: 18px;
    background-color: #10b981;
    color: #ffffff;
    border-radius: 50%;
    text-align: center;
    line-height: 18px;
    font-size: 11px;
    font-weight: bold;
    margin-right: 8px;
    vertical-align: middle;
}

.validation-header-title {
    font-size: 12px;
    font-weight: 800;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    vertical-align: middle;
}

.status-pill-green-light {
    display: inline-block;
    background-color: #e6f4ea;
    border: 1px solid #c6f6d5;
    color: #15803d;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 6px;
    margin-top: 20px;
    margin-bottom: 12px; /* Extra room before subheading */
}

.validation-subheading {
    font-size: 11px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
}

.validation-body-text {
    font-size: 10.5px;
    color: #475569;
    line-height: 1.5; /* Improved readability */
}

/* Bottom Overall Alignment Card */
.alignment-card {
    background-color: #fcfaff;
    border: 1px solid #f0e7ff;
    border-radius: 10px;
    padding: 16px 20px;
}

.alignment-icon-circle {
    width: 42px;
    height: 42px;
    background-color: #f3e8ff;
    border-radius: 50%;
    text-align: center;
    line-height: 42px;
}

    .status-pill-purple {
        display: inline-block;
        background-color: #f3e8ff;
        border: 1px solid #e9d5ff;
        color: #6b21a8;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
        margin-left: 10px;
        vertical-align: middle;
    }
    .validation-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px 16px;
    }

    .status-pill-green-light {
        display: inline-block;
        background-color: #e6f4ea;
        border: 1px solid #c6f6d5;
        color: #15803d;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 10px;
        bordr-radius: 6px;
    }

    .status-pill-default {
        display: inline-block;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
    }
        /* Section Box Container */
        .section-box {
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .section-header {
            color: #c21f34;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .section-body {
            padding: 8px 10px;
            background-color: #ffffff;
        }

        /* Utilities */
        table.grid {
            width: 100%;
            border-collapse: collapse;
        }
        table.grid td {
            vertical-align: top;
            padding: 0;
        }

        /* Header Table */
        .header-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 10px; 
            border-bottom: 2px solid #c21f34; 
            padding-bottom: 6px; 
        }
        .header-table td { vertical-align: middle; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 6px;
            margin: 2px;
            border-radius: 4px;
            font-size: 10px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: #64748b;
        }
        .badge-active {
            background-color: #c21f34 !important;
            color: #ffffff !important;
            border-color: #9e182a !important;
            font-weight: bold;
        }

        /* Recommendations */
        .program-card {
            background: #fdf8f8;
            border-left: 3px solid #c21f34;
            padding: 6px 10px;
            margin-bottom: 4px;
        }

        ol.priority-list { margin: 0; padding-left: 18px; }
        ol.priority-list li { margin-bottom: 3px; font-weight: 500; }

        /* Strengths */
        .badge-strength-selected {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            color: #15803d;
            text-align: center;
        }

        .badge-strength-unselected {
            background-color: #fafafa;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 4px 8px;
            font-size: 10px;
            color: #475569;
            text-align: center;
        }

        /* Validation Cards */
        .insight-card {
            background-color: #faf8f5;
            border: 1px solid #efeae4;
            border-radius: 6px;
            padding: 8px 10px;
        }

        .insight-title {
            font-size: 11px;
            font-weight: bold;
            color: #1a202c;
        }

        /* Status Pills */
        .status-pill-green {
            display: inline-block;
            background-color: #e6f4ea;
            color: #137333;
            font-size: 9px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 8px;
            margin: 2px 0 4px 0;
        }

        .status-pill-default {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 8px;
            margin: 2px 0 4px 0;
        }

        .insight-body-text {
            font-size: 10px;
            color: #4a5568;
            line-height: 1.3;
        }

        .alignment-dot-green {
            display: inline-block;
            width: 7px;
            height: 7px;
            background-color: #137333;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }

        /* Learning Gap Summary */
        .gap-container-card {
            background-color: #ffffff;
            border-radius: 6px;
        }

        .gap-item-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 4px;
            text-align: center;
        }

        .gap-header-pill {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            padding: 3px 6px;
            border-radius: 10px;
            display: inline-block;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        /* Dot variants */
        .dot-strong { background-color: #10b981; }
        .dot-moderate { background-color: #3b82f6; }
        .dot-developing { background-color: #f59e0b; }
        .dot-needs-work { background-color: #ef4444; }
        .dot-default { background-color: #94a3b8; }

        .gap-status-label {
            font-size: 10px;
            font-weight: bold;
            color: #334155;
            vertical-align: middle;
            line-height: 1;
        }
        /* Learning Gap Summary - List View Enhancements */
        .gap-label-neutral {
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            padding: 2px 0;
            display: inline-block;
        }

        .gap-container-list {
            width: 100%;
        }

        .gap-list-item {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 12px;
        }
        /* Section 10 Pathway Design Enhancements */
    .pathway-card {
        background-color: #fffdfa;
        border: 1px solid #f2e8dc;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 8px;
    }

    .pathway-header-label {
        font-size: 10px;
        font-weight: bold;
        color: #a8202d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .pathway-divider {
        border: 0;
        border-top: 1px solid #f0e2d5;
        margin: 10px 0;
    }

    .primary-program-title {
        font-size: 14px;
        font-weight: bold;
        color: #1a202c;
        margin-bottom: 2px;
    }

    .primary-program-sub {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 2px;
    }   

.primary-program-sessions {
    font-size: 11px;
    font-weight: bold;
    color: #334155;
    margin-bottom: 4px;
}

.primary-program-desc {
    font-size: 10px;
    color: #4a5568;
    line-height: 1.3;
}

.supporting-list {
    margin: 4px 0 0 0;
    padding-left: 14px;
    list-style-type: disc;
}

.supporting-list li {
    font-size: 10px;
    font-weight: bold;
    color: #2d3748;
    margin-bottom: 3px;
}

.meta-box {
    background-color: #fffdfa;
    border: 1px solid #f2e8dc;
    border-radius: 6px;
    padding: 8px 12px;
}

.meta-label {
    font-size: 9px;
    font-weight: bold;
    color: #475569;
}

.meta-value {
    font-size: 11px;
    font-weight: bold;
    color: #1a202c;
    margin-top: 2px;
}
a {
    color: #c21f34;
    text-decoration: underline;
}
a:visited {
    color: #c21f34;
}
    </style>
</head>
<body>

    <!-- Section 1: Header -->
    <table class="header-table">
        <tr>
            <td style="width: 40%;">
                <img src="{{ $logoRed }}" class="logo-img" alt="V-Tutor Logo">
            </td>
            <td style="width: 60%; text-align: right;">
                <div class="report-title-red">Academic Advisor Report</div>
                <div class="advisor-meta">
                    <strong>Advisor:</strong> {{ $suggestion->report_prepared_by ?? 'Master Admin' }}
                    &nbsp;|&nbsp;
                    <strong>Date:</strong> {{ date('d M, Y') }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Red Bottom Border Line -->
    <!-- <div class="header-red-line"></div> -->

    <!-- Section 2: Banner Heading -->
    <div class="title-banner">
        <div class="title-banner-text">Academic Feedback &amp; Learning Recommendations</div>
    </div>

    <!-- Section 3: Student Info & Scorecard -->
    @php
        $result = isset($result) && is_array($result) ? $result : [];
        $total = (int)($result['total_marks'] ?? 0);
        $obtained = (int)($result['obtained_marks'] ?? 0);
        $overall = $total > 0 ? round(($obtained / $total) * 100) : 0;
        $scoreColor = $result['performance_color'] ?? '#16784d';
    @endphp

    <table class="student-card">
        <tr>
            <td style="vertical-align: middle;">
                <div class="student-name">
                    {{ $assessment->first_name ?? '' }} {{ $assessment->last_name ?? '' }}
                </div>
                <div class="student-meta-details">
                    <strong>Grade:</strong> {{ $assessment->grade ?? '-' }}
                    &nbsp;&bull;&nbsp;
                    <strong>Assessment ID:</strong> #{{ $assessment->id ?? '-' }}
                    &nbsp;&bull;&nbsp;
                    <strong>Date:</strong> {{ !empty($assessment->created_at) ? \Carbon\Carbon::parse($assessment->created_at)->format('j M Y') : '-' }}
                </div>
            </td>
            <td style="width: 40%; text-align: right; vertical-align: middle;">
                <div class="score-percentage" style="color: {{ $scoreColor }};">
                    {{ $overall }}%
                </div>
                <div class="score-subtext">
                    {{ $obtained }} / {{ $total }} marks &nbsp;&bull;&nbsp; {{ $result['performance'] ?? '' }}
                </div>
                <div>
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($overall / 20))
                            <img src="{{ $starFilled }}" class="star-icon">
                        @endif
                    @endfor
                </div>
            </td>
        </tr>
    </table>

    <!-- Section 4: Academic Summary -->
    <!-- <div class="section-box">
        <div class="section-header">Academic Advisor Summary</div>
        <div class="section-body">
            <p>{{ $suggestion->advisor_summary_report ?? 'No summary provided.' }}</p>
        </div>
    </div> -->
    <!-- Section 4: Academic Summary (HTML Unescaped Output) -->
    <div class="section-box">
        <div class="section-header">Academic Advisor Summary</div>
        <div class="section-body">
            @if(!empty($suggestion->advisor_summary_report) && trim(strip_tags($suggestion->advisor_summary_report)) !== '')
                {!! $suggestion->advisor_summary_report !!}
            @else
                <p>No summary provided.</p>
            @endif
        </div>
    </div>

<!-- Section 5: Key Strengths -->
@php
    $dbStrengths = is_array($suggestion->key_strengths) 
        ? $suggestion->key_strengths 
        : json_decode($suggestion->key_strengths ?? '[]', true);

    $allStrengths = \App\Models\AssessmentSuggestion::KEY_STRENGTHS_OPTIONS ?? [
        'Reading Comprehension', 'Mathematical Reasoning', 'Logical Thinking', 
        'Problem Solving', 'Independent Learning', 'Written Communication',
        'Creativity', 'Organisation', 'Communication', 'Confidence'
    ];
@endphp

<div class="section-box">
    <div class="section-header">Key Strengths</div>
    <div class="section-body" style="padding: 8px;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 4px;">
            @foreach(array_chunk($allStrengths, 3) as $row)
                <tr>
                    @foreach($row as $strength)
                        @php 
                            $isMatched = is_array($dbStrengths) && in_array($strength, $dbStrengths); 
                        @endphp
                        <td style="width: 33.33%; vertical-align: middle; padding: 0;">
                            <div class="strength-card {{ $isMatched ? 'strength-card-selected' : 'strength-card-unselected' }}">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 16px; vertical-align: middle; text-align: left;">
                                            @if($isMatched)
                                                <!-- Active Green Check Icon -->
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                                    <circle cx="12" cy="12" r="10" fill="#10b981"/>
                                                    <path d="M8 12l3 3 5-5" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            @else
                                                <!-- Inactive Gray Circle Icon -->
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none">
                                                    <circle cx="12" cy="12" r="9" stroke="#cbd5e1" stroke-width="2" fill="none"/>
                                                </svg>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; padding-left: 4px;">
                                            {{ $strength }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    @endforeach
                    @if(count($row) < 3)
                        @for($i = 0; $i < (3 - count($row)); $i++)
                            <td style="width: 33.33%;"></td>
                        @endfor
                    @endif
                </tr>
            @endforeach
        </table>

        @if(!empty($suggestion->additional_strength))
            <div class="additional-strengths-box">
                <strong style="color: #c21f34;">Additional Strengths:</strong> {{ $suggestion->additional_strength }}
            </div>
        @endif
    </div>
</div>

<!-- Section 6: Learning Opportunities -->
@php
    $dbOpportunities = is_array($suggestion->learning_opportunities) 
        ? $suggestion->learning_opportunities 
        : json_decode($suggestion->learning_opportunities ?? '[]', true);
@endphp

<div class="section-box">
    <div class="section-header">Learning Opportunities</div>
    <div class="section-body" style="padding: 8px;">
        @if(is_array($dbOpportunities) && count($dbOpportunities) > 0)
            <table style="width: 100%; border-collapse: separate; border-spacing: 4px;">
                @foreach(array_chunk($dbOpportunities, 3) as $row)
                    <tr>
                        @foreach($row as $opportunity)
                            <td style="width: 33.33%; vertical-align: middle; padding: 0;">
                                <div class="opportunity-badge">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 14px; vertical-align: middle; text-align: left;">
                                                <!-- Red Focus Indicator Dot -->
                                                <svg width="8" height="8" viewBox="0 0 100 100">
                                                    <circle cx="50" cy="50" r="50" fill="#e11d48"/>
                                                </svg>
                                            </td>
                                            <td style="vertical-align: middle; text-align: left; padding-left: 2px;">
                                                {{ $opportunity }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        @endforeach
                        @if(count($row) < 3)
                            @for($i = 0; $i < (3 - count($row)); $i++)
                                <td style="width: 33.33%;"></td>
                            @endfor
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color: #64748b; font-size: 10px; padding: 4px;">No specific learning opportunities highlighted.</p>
        @endif

        @if(!empty($suggestion->additional_opportunity))
            <div class="additional-opportunities-box">
                <strong style="color: #c21f34;">Additional Notes:</strong> {{ $suggestion->additional_opportunity }}
            </div>
        @endif
    </div>
</div>

<!-- Section 7: Assessment Validations & Insights -->
<div class="section-box">
    <div class="section-header">Assessment Validations &amp; Insights</div>
    <div class="section-body" style="padding: 16px;">
        
        <!-- Row 1: Quantitative Assessment -->
        <div class="validation-card" style="margin-bottom: 14px;">
            <div class="validation-title-row" style="margin-bottom: 10px;">
                <span class="check-icon">&#10003;</span>
                <span class="validation-header-title">Quantitative Assessment</span>
            </div>

            @php $quantStatus = $suggestion->quantitative_status ?? 'Validated'; @endphp
            <div style="margin-bottom: 10px;">
                <span class="{{ strtolower($quantStatus) === 'validated' ? 'status-pill-green-light' : 'status-pill-default' }}" style="margin: 0;">
                    {{ $quantStatus }}
                </span>
            </div>

            <p class="validation-body-text">
                {{ $suggestion->quantitative_statement ?? 'Performance in objective sections align well with expected year level outcomes and demonstrate developing understanding of key concepts.' }}
            </p>
            @if(!empty($suggestion->quantitative_assessment_summary))
                <div class="summary-highlight-box">
                    <strong>Quantitative Summary:</strong> {{ $suggestion->quantitative_assessment_summary }}
                </div>
            @endif
        </div>

        <!-- Row 2: Qualitative Responses -->
        <div class="validation-card" style="margin-bottom: 14px;">
            <div class="validation-title-row" style="margin-bottom: 10px;">
                <span class="check-icon">&#10003;</span>
                <span class="validation-header-title">Qualitative Responses</span>
            </div>

            @php $qualStatus = $suggestion->qualitative_status ?? 'Validated'; @endphp
            <div style="margin-bottom: 10px;">
                <span class="{{ strtolower($qualStatus) === 'validated' ? 'status-pill-green-light' : 'status-pill-default' }}" style="margin: 0;">
                    {{ $qualStatus }}
                </span>
            </div>

            <p class="validation-body-text">
                {{ $suggestion->qualitative_statement ?? 'Parent and student responses are broadly consistent with the academic assessment findings and reflect current learning behaviours.' }}
            </p>
            @if(!empty($suggestion->qualitative_responses_summary))
                <div class="summary-highlight-box">
                    <strong>Qualitative Summary:</strong> {{ $suggestion->qualitative_responses_summary }}
                </div>
            @endif
        </div>

        <!-- Row 3: Overall Alignment -->
        <div class="validation-card">
            <div class="validation-title-row" style="margin-bottom: 10px;">
                <span class="check-icon">&#10003;</span>
                <span class="validation-header-title">Overall Alignment</span>
            </div>

            @php $alignStatus = $suggestion->overall_alignment ?? 'Moderate Alignment'; @endphp
            <div style="margin-bottom: 10px;">
                <span class="status-pill-default" style="margin: 0;">
                    {{ $alignStatus }}
                </span>
            </div>

            <p class="validation-body-text">
                {{ $suggestion->alignment_summary ?? 'The quantitative assessment and qualitative responses present a reasonably consistent picture of the student\'s current academic performance and learning behaviours.' }}
            </p>
        </div>

    </div>
</div>

<!-- Section 8: Learning Gap Summary (List Style Layout) -->
<div class="section-box">
    <div class="section-header">Learning Gap Summary</div>
    <div class="section-body" style="padding: 10px 14px;">
        <div class="gap-container-list">
            @php
                $gapCategories = [
                    [
                        'label' => 'Reading',
                        'value' => $suggestion->reading ?? '-',
                        'svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20v2.5A2.5 2.5 0 0 1 17.5 22H6.5A2.5 2.5 0 0 1 4 19.5z" fill="#93c5fd"/><path d="M6.5 2H20v15H6.5A2.5 2.5 0 0 1 4 14.5v-10A2.5 2.5 0 0 1 6.5 2z" fill="#2563eb"/><path d="M12 6h5M12 10h5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/></svg>'
                    ],
                    [
                        'label' => 'Writing',
                        'value' => $suggestion->writing ?? '-',
                        'svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" fill="#a7f3d0" stroke="#059669" stroke-width="1.5"/><path d="M15 5l4 4" stroke="#047857" stroke-width="1.5"/><path d="M2 22l1.5-5.5L7.5 20.5 2 22z" fill="#10b981"/></svg>'
                    ],
                    [
                        'label' => 'Reasoning',
                        'value' => $suggestion->reasoning ?? '-',
                        'svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" fill="#fef08a"/><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" fill="#d97706"/><path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.07-7.07l-1.41 1.41M6.34 17.66l-1.41 1.41m12.73 0l-1.41-1.41M6.34 6.34L4.93 4.93" stroke="#b45309" stroke-width="2" stroke-linecap="round"/></svg>'
                    ],
                    [
                        'label' => 'Logic',
                        'value' => $suggestion->logic ?? '-',
                        'svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 21h6m-4 2h2" stroke="#ea580c" stroke-width="2" stroke-linecap="round"/><path d="M12 2a7 7 0 0 0-7 7c0 3.003 1.893 5.564 4.561 6.564.439.164.439.436.439 1.436v1h4v-1c0-1 0-1.272.439-1.436C17.107 14.564 19 12.003 19 9a7 7 0 0 0-7-7z" fill="#fed7aa" stroke="#f97316" stroke-width="1.5"/><path d="M12 6v4m-2-2h4" stroke="#ea580c" stroke-width="1.5" stroke-linecap="round"/></svg>'
                    ],
                    [
                        'label' => 'Thinking',
                        'value' => $suggestion->thinking ?? '-',
                        'svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 4.5V19.5" stroke="#be185d" stroke-width="1.5" stroke-linecap="round"/><path d="M9.5 2A2.5 2.5 0 0 0 7 4.5v15a2.5 2.5 0 0 0 4.96.44A2.5 2.5 0 0 0 12 17V7a2.5 2.5 0 0 0-2.5-5z" fill="#fbcfe8"/><path d="M14.5 2A2.5 2.5 0 0 1 17 4.5v15a2.5 2.5 0 0 1-4.96.44A2.5 2.5 0 0 1 12 17V7a2.5 2.5 0 0 1 2.5-5z" fill="#f43f5e"/><path d="M6 9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2m12-6a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2" stroke="#e11d48" stroke-width="1.5"/></svg>'
                    ],
                ];
            @endphp

            <table style="width: 100%; border-collapse: separate; border-spacing: 0 6px;">
                @foreach($gapCategories as $cat)
                    @php
                        $valLower = strtolower(trim($cat['value']));
                        if (in_array($valLower, ['strong', 'high', 'good', 'mastered'])) {
                            $dotClass = 'dot-strong';
                        } elseif (in_array($valLower, ['moderate', 'medium', 'average'])) {
                            $dotClass = 'dot-moderate';
                        } elseif (in_array($valLower, ['developing', 'emerging', 'fair'])) {
                            $dotClass = 'dot-developing';
                        } elseif (in_array($valLower, ['needs work', 'low', 'weak', 'gap'])) {
                            $dotClass = 'dot-needs-work';
                        } else {
                            $dotClass = 'dot-default';
                        }
                    @endphp
                    <tr>
                        <td style="padding: 0;">
                            <div class="gap-list-item" style="background-color: transparent; border: 1px solid #e2e8f0;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <!-- Column 1: SVG Icon -->
                                        <td style="width: 32px; vertical-align: middle; text-align: center;">
                                            <div style="display: inline-block; vertical-align: middle;">
                                                {!! $cat['svg'] !!}
                                            </div>
                                        </td>

                                        <!-- Column 2: Label -->
                                        <td style="width: 110px; vertical-align: middle; padding-left: 8px;">
                                            <span class="gap-label-neutral" style="color: #2d3748; font-weight: 600;">
                                                {{ $cat['label'] }}
                                            </span>
                                        </td>

                                        <!-- Column 3: Status Value (No Background Pill) -->
                                        <td style="text-align: left; vertical-align: middle;">
                                            <span style="display: inline-flex; align-items: center; background: none; padding: 0;">
                                                <span class="status-dot {{ $dotClass }}"></span>
                                                <span class="gap-status-label" style="color: #2d3748; font-weight: normal;">{{ ucfirst($cat['value']) }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
    <!-- Section 9: Recommended Learning Priorities -->
    @php
        $priorities = is_array($suggestion->recommended_learning_priorities) ? $suggestion->recommended_learning_priorities : json_decode($suggestion->recommended_learning_priorities ?? '[]', true);
    @endphp
    <div class="section-box">
        <div class="section-header">Recommended Learning Priorities</div>
        <div class="section-body">
            @if(is_array($priorities) && count($priorities) > 0)
                <ol class="priority-list">
                    @foreach($priorities as $priority)
                        <li>{{ $priority }}</li>
                    @endforeach
                </ol>
            @else
                <p style="color: #64748b;">No learning priorities assigned.</p>
            @endif
        </div>
    </div>

 
<!-- Section 10: Recommended Learning Pathway -->
<div class="section-box">
    <div class="section-header">Recommended Learning Pathway</div>
    <div class="section-body" style="padding: 8px;">
        
        <div class="pathway-card">
            <!-- Header Row with Ribbon Badge -->
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="vertical-align: top;">
                        <div class="pathway-header-label">Primary Recommendation</div>
                        <p style="font-size: 10px; color: #4a5568; margin-top: 6px; margin-bottom: 2; line-height: 1.3;">
                            Based on the diagnostic assessment, I recommend commencing the following programs to strengthen the 
                            learning gaps identified during the academic review.
                        </p>
                    </td>
                    <td style="width: 32px; text-align: right; vertical-align: top;">
                        <!-- Gold Badge Ribbon SVG -->
                        <svg width="28" height="32" viewBox="0 0 36 42" fill="none">
                            <path d="M11 26L18 22L25 26V38L18 34L11 38V26Z" fill="#b91c1c"/>
                            <circle cx="18" cy="15" r="13" fill="#f59e0b"/>
                            <circle cx="18" cy="15" r="10" fill="#fbbf24"/>
                            <path d="M18 8L20.1 12.3L24.8 13L21.4 16.3L22.2 21L18 18.8L13.8 21L14.6 16.3L11.2 13L15.9 12.3L18 8Z" fill="#ffffff"/>
                        </svg>
                    </td>
                </tr>
            </table>

<!-- Primary Program Detail Row -->
@php
    // Fetch up to 2 primary programs
    $primaryPrograms = $suggestion->primary_programs ? $suggestion->primary_programs->take(2) : collect();
@endphp

@if($primaryPrograms->count() > 0)
    @foreach($primaryPrograms as $index => $primaryProgram)
        @if($index > 0)
            <!-- Optional separator between multiple primary programs -->
            <hr style="border: 0; border-top: 1px dashed #f0e2d5; margin: 10px 0;">
        @endif

        <table style="width: 100%; border-collapse: collapse; margin-top: 4px;">
            <tr>
                <td style="width: 60px; vertical-align: top; padding-right: 10px;">
                    <!-- Graduation Cap Badge Icon -->
                    <div style="width: 52px; height: 52px; border-radius: 50%; background-color: #faebd7; text-align: center; line-height: 52px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="vertical-align: middle; margin-top: 12px;">
                            <path d="M12 3L1 9L12 15L23 9L12 3Z" fill="#2d3748"/>
                            <path d="M5 13.18V17.5C5 18.88 8.13 20 12 20C15.87 20 19 18.88 19 17.5V13.18L12 17L5 13.18Z" fill="#4a5568"/>
                            <path d="M21 10.5V16.5" stroke="#2d3748" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </td>
                <!-- Added Introductory Paragraph -->
                <p style="font-size: 10px; color: #4a5568; margin-top: 4px; margin-bottom: 8px; line-height: 1.3;">
                    Based on the diagnostic assessment, I recommend commencing the following programs to strengthen the learning gaps identified during the academic review.
                </p>
                <td style="vertical-align: top;">
                    <!-- Primary Program Title with Dynamic Link -->
                    <div class="primary-program-title">
                        @if(!empty($primaryProgram->slug) || !empty($primaryProgram->url))
                            <a href="{{ $primaryProgram->url ?? 'https://v-tutor.com.au/program/' . $primaryProgram->slug . '?year=' . $assessment->grade_id . '&state=' . \Illuminate\Support\Str::slug($assessment->state) }}"
                             target="_blank"
                                style="color: #c21f34; text-decoration: underline;">
                                {{ $primaryProgram->name }}
                            </a>
                        @else
                            {{ $primaryProgram->name }}
                        @endif
                    </div>
                    <div class="primary-program-sub">{{ $primaryProgram->program_type ?? 'Core Training Program' }}</div>
                    @if(!empty($primaryProgram->number_of_sessions))
                        <div class="primary-program-sessions">{{ $primaryProgram->number_of_sessions }} Sessions</div>
                    @endif
                    @if(!empty($primaryProgram->description))
                        <div class="primary-program-desc">
                            <strong>Focus:</strong> {{ $primaryProgram->description }}
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    @endforeach
@else
    <p style="color: #64748b; font-style: italic; font-size: 10px;">No primary recommendations available.</p>
@endif
           

<hr class="pathway-divider">

<!-- Supporting Programs List -->
<div class="pathway-header-label" style="margin-bottom: 4px;">Supporting Programs</div>
@if($suggestion->secondary_programs && $suggestion->secondary_programs->count() > 0)
    <ul class="supporting-list" style="list-style-type: none; padding-left: 0; margin-top: 4px;">
        @foreach($suggestion->secondary_programs as $program)
            <li style="margin-bottom: 8px; font-weight: normal;">
                <!-- Program Title / Link -->
                <div style="font-size: 12px; font-weight: bold;">
                    @if(!empty($program->slug) || !empty($program->url))
                        <a href="{{ $program->url ?? 'https://v-tutor.com.au/program/' . $program->slug . '?year=' . $assessment->grade_id . '&state=' . \Illuminate\Support\Str::slug($assessment->state) }}"
                           target="_blank"
                           style="color: #c21f34; text-decoration: underline;">
                            {{ $program->name }}
                        </a>
                    @else
                        {{ $program->name }}
                    @endif
                </div>

                <!-- Program Type & Sessions Subtitle -->
                <div style="font-size: 10px; color: #64748b; margin-top: 1px;">
                    <span>{{ $program->program_type ?? 'Supporting Program' }}</span>
                    @if(!empty($program->number_of_sessions))
                        &nbsp;&bull;&nbsp; 
                        <strong style="color: #334155;">{{ $program->number_of_sessions }} Sessions</strong>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p style="color: #64748b; font-style: italic; font-size: 10px;">No supporting programs available.</p>
@endif
    </div>
</div>
</div>
<!-- Section: Next Steps -->
<div class="section-box">
    <div class="section-body" style="padding: 12px; text-align: center;">
        <img src="{{ $assessmentStep }}" style="width: 100%; height: auto; display: block;" alt="Next Steps Process Banner">
    </div>
</div>
<!-- Section 11: About This Report -->
<div class="section-box">
    <div class="section-header">About This Report</div>
    <div class="section-body">
        <p style="font-size: 10px; color: #475569; margin-bottom: 6px; line-height: 1.4;">
            This report is prepared by our Academic Team following a comprehensive analysis of the Diagnostic Assessment including both quantitative and qualitative inputs.
        </p>
        <p style="font-size: 10px; color: #475569; margin-bottom: 6px; line-height: 1.4;">
            The recommendations are designed to support your child's academic growth through personalised learning.
        </p>
        <p style="font-size: 10px; color: #475569; margin-bottom: 0; line-height: 1.4;">
            This report is intended for educational guidance only and should be used in conjunction with ongoing feedback from tutors and academic advisors.
        </p>
    </div>
</div>
<!-- Notice Section -->
<div style="margin-top: 12px; text-align: center; font-size: 11px; color: #475569; font-family: sans-serif;">
    <strong>Note:</strong> For a complete list of programs and how we could help your child to fix the learning gaps, visit <a href="https://v-tutor.com.au" style="color: #475569; text-decoration: underline;">https://v-tutor.com.au</a>
</div>
</body>
</html>
