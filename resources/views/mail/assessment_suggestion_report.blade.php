<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Child's Academic Feedback & Learning Recommendations Report is Ready</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f8fafc;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 30px;
        }
        .program-card {
            background-color: #f1f5f9;
            border-left: 4px solid #c21f34;
            padding: 12px 16px;
            margin-top: 8px;
            margin-bottom: 16px;
            border-radius: 0 6px 6px 0;
        }
        .program-card a {
            color: #c21f34;
            font-weight: bold;
            font-size: 16px;
            text-decoration: underline;
        }
        .supporting-section {
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .supporting-list {
            padding-left: 20px;
            margin-top: 8px;
        }
        .supporting-list li {
            margin-bottom: 8px;
        }
        .supporting-list a {
            color: #c21f34;
            font-weight: 600;
            text-decoration: underline;
        }
        .feature-list {
            padding-left: 20px;
            margin-top: 8px;
            margin-bottom: 16px;
        }
        .feature-list li {
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<div class="email-container">
    <p>Dear {{ $assessment->first_name ?? $assessment->last_name ?? 'Parent' }},</p>

    <p>Thank you for taking the time to complete your child's V-Tutor Diagnostic Assessment.</p>

    <p>Following a comprehensive review of both the quantitative assessment results and the qualitative responses, our Academic Team has now prepared your child's <strong>Academic Feedback & Learning Recommendations Report</strong>, which is attached to this email.</p>

    <p>This report goes beyond the initial assessment by providing a personalised academic review of your child's current learning profile, including:</p>

    <ul class="feature-list">
        <li>Academic Advisor Summary</li>
        <li>Key strengths and demonstrated capabilities</li>
        <li>Identified learning gaps and areas requiring improvement</li>
        <li>Recommended learning priorities</li>
        <li>A personalised V-Tutor learning pathway</li>
    </ul>

    <p>Based on your child's assessment results and responses, we have also identified some V-Tutor learning programs that we believe are best suited to address the learning gaps identified throughout the assessment. These recommendations are tailored to your child's current level of understanding and are designed to strengthen foundational knowledge while building the skills and confidence required for long-term academic success.</p>

    <p style="font-weight: bold; color: #1e293b; margin-bottom: 8px;">Recommended Learning Program(s):</p>

    {{-- Primary Program Section --}}
    @if(!empty($suggestion->primary_programs) && $suggestion->primary_programs->count() > 0)
        <p style="margin-bottom: 4px; font-weight: bold; color: #1e293b;">Primary Recommendation</p>
        @foreach($suggestion->primary_programs as $primaryProgram)
            <div class="program-card">
                @if(!empty($primaryProgram->url))
                    <a href="{{ $primaryProgram->url }}" target="_blank">
                        {{ $primaryProgram->name }}
                    </a>
                @elseif(!empty($primaryProgram->slug))
                    <a href="{{ 'https://v-tutor.com.au/program/' . $primaryProgram->slug . '?year=' . ($assessment->grade_id ?? '') . '&state=' . \Illuminate\Support\Str::slug($assessment->state) }}" target="_blank">
                        {{ $primaryProgram->name }}
                    </a>
                @else
                    <span style="font-weight: bold; color: #c21f34;">{{ $primaryProgram->name }}</span>
                @endif
            </div>
        @endforeach
    @endif

    {{-- Secondary / Supporting Programs Section --}}
    @if(!empty($suggestion->secondary_programs) && $suggestion->secondary_programs->count() > 0)
        <div class="supporting-section">
            <p style="margin-bottom: 4px; font-weight: bold; color: #1e293b;">Supporting Programs</p>
            <ul class="supporting-list">
                @foreach($suggestion->secondary_programs as $program)
                    <li>
                        @if(!empty($program->url))
                            <a href="{{ $program->url }}" target="_blank">{{ $program->name }}</a>
                        @elseif(!empty($program->slug))
                            <a href="{{ 'https://v-tutor.com.au/program/' . $program->slug . '?year=' . ($assessment->grade_id ?? '') . '&state=' . \Illuminate\Support\Str::slug($assessment->state) }}" target="_blank">
                                {{ $program->name }}
                            </a>
                        @else
                            <span style="font-weight: 600;">{{ $program->name }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>If you would like to discuss the report or better understand our recommendations, we would be pleased to arrange a complimentary consultation with one of our Academic Advisors. During this session, we'll walk you through the findings, answer any questions you may have and discuss the most appropriate learning pathway for your child.</p>

    <p>If you have any questions in the meantime, please don't hesitate to contact us at <a href="mailto:support@v-tutor.com.au" style="color: #c21f34;">support@v-tutor.com.au</a>.</p>

    <p>Thank you for choosing V-Tutor. We appreciate the opportunity to support your child's learning journey and look forward to helping them achieve their academic goals.</p>

    <p style="margin:20px 0 0 0;">Kind regards,</p>
    <p style="margin:0;">The Academic Team</p>
    <p style="margin:0 0 10px 0; font-weight: bold;">V-Tutor</p>
</div>
<p style="font-size:13px;font-style:italic;color:#666;">
This email and any attachments are confidential and intended solely for the named recipient. If you have received this email in error, please notify us immediately and delete it. Any unauthorised use, disclosure, copying, or distribution of this communication is strictly prohibited.
</p>
</body>
</html>