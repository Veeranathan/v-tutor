<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
@page {
    margin: 20px;
    background-color: #F8EFE2; 
}
body {
    font-family: Helvetica, Arial, sans-serif;
    color: #333333;
    font-size: 9px;
    margin: 0;
    padding: 0;
    background-color: #F8EFE2;
}
.page {
    padding: 10px;
    background-color: #F8EFE2;
}
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}
td {
    word-wrap: break-word;
    vertical-align: top;
}
.header td {
    border-bottom: 1px solid #D8CDBF;
    padding-bottom: 10px;
}
.section-title {
    font-size: 12px;
    margin-top: 20px;
    color: #d9482e;
    font-weight: bold;
}
.preserve-breaks {
    white-space: pre-line;
}

/* 
   mPDF Table Card Architecture 
   Using tables completely bypasses mPDF's broken div margin-collapse logic.
*/
.card-table {
    width: 100%;
    margin-bottom: 15px;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 8px;
    page-break-inside: avoid;
}
.card-cell {
    padding: 12px;
}

/* Inner block containers using safe padding rules */
.inner-box {
    width: 100%;
    margin-top: 10px;
    border-radius: 4px;
}
.inner-cell {
    padding: 10px;
}

.summary-wrapper {
    margin-top: 25px;
    page-break-inside: avoid;
}
.summary-title {
    text-align: center;
    font-size: 11px;
    letter-spacing: 1px;
    color: #8d704c;
    font-weight: bold;
    text-transform: uppercase;
}
.summary-percentage {
    text-align: center;
    margin-top: 6px;
}
.summary-marks {
    text-align: center;
    font-size: 13px;
    color: #6d5035;
    margin: 8px 0 30px;
}
.summary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.summary-table td {
     padding: 10px 2px !important;
     border-bottom: 1px solid #dbcdbd !important;
}
.summary-table td:last-child {
    text-align: right !important;
}
</style>
</head>
<body>
<div class="page">
@php
$result = isset($result) && is_array($result) ? $result : [];

$total = (int)($result['total_marks'] ?? 0);
$obtained = (int)($result['obtained_marks'] ?? 0);
$overall = $total > 0 ? round(($obtained / $total) * 100) : 0;

$sections = isset($result['sections']) && is_array($result['sections']) ? $result['sections'] : [];
$qualitative = isset($result['qualitative']) && is_array($result['qualitative']) ? $result['qualitative'] : [];
@endphp

<table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #d7c6b5;padding-bottom:12px;">
    <tr>
        <td width="50%" valign="middle">
            <span style="color:#d9482e;font-size:16px;font-weight:bold;margin-left:6px;vertical-align:middle;">
                Student Diagnostic Assessment
            </span>
        </td>
        <td width="50%" align="right" style="font-size:9px;color:#666;letter-spacing:1px;">
            PRELIMINARY ASSESSMENT REPORT
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:22px;">
<tr>
<td width="70%" valign="top">
    @if(!empty($logoRed) && file_exists($logoRed))
        <img src="{{ $logoRed }}" width="55">
    @endif

    <div style="font-size:26px;font-weight:bold;color:#222;margin-top:6px;">
        {{ $assessment->last_name ?? '-' }}
    </div>

    <div style="margin-top:8px;font-size:12px;color:#555;">
        {{ $assessment->grade ?? '-' }} &nbsp;&nbsp;·&nbsp;&nbsp;
        Assessment #{{ $assessment->id ?? '-' }} &nbsp;&nbsp;·&nbsp;&nbsp;
        {{ !empty($assessment->created_at) ? \Carbon\Carbon::parse($assessment->created_at)->format('j M Y') : '-' }}
    </div>
</td>

<td width="30%" align="right" valign="top">

    @php
        $scoreColor = $result['performance_color'] ?? '#16784d';
    @endphp

    <div style="font-size:54px; font-weight:bold; color: {{ $scoreColor }}; line-height:55px;">
        {{ $overall }}%
    </div>

    <div style="margin-top:6px;font-size:12px;color:#7b5c3d;">
        {{ $obtained }} / {{ $total }} marks · {{ $result['performance'] ?? '' }}
    </div>

    <div style="margin-top:10px;">
        @for($i=1;$i<=5;$i++)
            @if($i<=floor($overall/20))
                <img src="{{ $starFilled }}" width="13">
            @endif
        @endfor
    </div>
</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #d7c6b5;padding-bottom:12px;margin-top:10px;"></table>

<!-- ===============================
 Qualitative Assessment
================================ -->
<h2 class="section-title">QUALITATIVE ASSESSMENT (Not Graded)</h2>
<p style="margin:0 0 15px;font-size:10px;color:#666;line-height:1.5;">
        <i>(The qualitative assessment is not graded. It provides valuable insight into the student's learning behaviours, study habits and 
            parent perspectives, forming an important part of the overall academic review and supporting the preparation of the Academic Feedback & Learning Recommendations Report.)</i>
</p>

@if(!empty($qualitative) && is_array($qualitative) && count($qualitative) > 0)
    @foreach($qualitative as $index => $item)
    @php $item = (array)$item; @endphp
    <table class="card-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="card-cell">
                <b>Question {{$index+1}}</b>
                <p class="preserve-breaks" style="margin-top:5px; margin-bottom:5px;">{{ $item['question'] ?? '-' }}</p>
                
                <!-- Response Box -->
                <table class="inner-box" cellpadding="0" cellspacing="0" style="background-color: #f2f8ff;">
                    <tr>
                        <td class="inner-cell">
                            <b>Response</b><br>
                            <span class="preserve-breaks">{{ $item['answer'] ?? 'None' }}</span>
                        </td>
                    </tr>
                </table>
                
                <!-- Comment Box -->
                @if(!empty($item['comment']))
                <table class="inner-box" cellpadding="0" cellspacing="0" style="background-color: #f7fff0;">
                    <tr>
                        <td class="inner-cell">
                            <b>Comment</b><br>
                            <span class="preserve-breaks">{{ $item['comment'] ?? 'None' }}</span>
                        </td>
                    </tr>
                </table>
                @endif
            </td>
        </tr>
    </table>
    @endforeach
@else
    <p style="font-style: italic; color: #666; padding: 5px;">No qualitative data recorded for this assessment.</p>
@endif

<!-- ===============================
 Quantitative Assessment
================================ -->
@if(!empty($sections) && is_array($sections) && count($sections) > 0)
    <h2 class="section-title">QUANTITATIVE ASSESSMENT</h2>
    <p style="margin:0 0 15px;font-size:10px;color:#666;line-height:1.5;">
        <i>(Some questions in this section are qualitative in nature and are not assigned a score. The information provided will be reviewed 
            and incorporated into the Academic Feedback & Learning Recommendations Report to support our assessment and recommendations.)</i>
    </p>

    @foreach($sections as $sectionName => $section)
        @php $section = (array)$section; @endphp
        @if(!empty($section['answers']) && is_array($section['answers']))
        <h3>
            {{ strtoupper($sectionName) }}
            <span style="float:right">
                {{ $section['obtained_marks'] ?? 0 }} / {{ $section['total_marks'] ?? 0 }}
            </span>
        </h3>

        @foreach($section['answers'] as $index=>$answer)
        @php 
            $answer = (array)$answer; 
            $isTextQuestion = ($answer['question_type'] ?? '') === 'text';
            $awarded = (int)($answer['awarded_mark'] ?? 0);
            $maxMark = (int)($answer['question_mark'] ?? 0);
            
            // Assign pure hex colors for reliability inside tables
            if ($isTextQuestion) {
                $bgColor = '#f9f9f9'; // neutral info gray
            } else {
                $bgColor = ($awarded >= $maxMark && $maxMark > 0) ? '#effff0' : '#fff3f3'; // green or red
            }
        @endphp
        <table class="card-table" cellpadding="0" cellspacing="0">
            <tr>
                <td class="card-cell">
                    <b>Question {{$index+1}}</b>
                    <p class="preserve-breaks" style="margin-top:5px; margin-bottom:5px;">{{ $answer['question'] ?? '-' }}</p>

                    <!-- Selected Answer Box -->
                    <table class="inner-box" cellpadding="0" cellspacing="0" style="background-color: {{ $bgColor }};">
                        <tr>
                            <td class="inner-cell">
                                <b>Selected Answer</b><br>
                                <span class="preserve-breaks">{{ $answer['selected_answer'] ?? '-' }}</span>
                            </td>
                        </tr>
                    </table>

                    <!-- Correct Answer Box -->
                    @if(!$isTextQuestion)
                    <table class="inner-box" cellpadding="0" cellspacing="0" style="background-color: #effff0; margin-top: 5px;">
                        <tr>
                            <td class="inner-cell">
                                <b>Correct Answer</b><br>
                                <span class="preserve-breaks">{{ $answer['correct_answer'] ?? '-' }}</span>
                            </td>
                        </tr>
                    </table>
                    <p style="margin-top:8px; margin-bottom:0;">
                        <b>Marks Awarded:</b>
                        {{ $awarded }} / {{ $maxMark }}
                    </p>
                    @endif
                </td>
            </tr>
        </table>
        @endforeach
        @endif
    @endforeach
@endif

<!-- ===============================
 Assessment Summary Table
================================ -->
<div class="summary-wrapper">
    <div class="summary-title">ASSESSMENT SUMMARY</div>
    <div class="summary-percentage" style="font-size:54px; font-weight:bold; color: {{ $scoreColor }}; line-height:55px;">{{ $overall }}%</div>
    <div class="summary-marks">{{ $obtained }} of {{ $total }} marks obtained</div>

    <table class="summary-table">
        <colgroup>
            <col width="75%">
            <col width="25%">
        </colgroup>
        <tbody>
           @if(!empty($sections) && is_array($sections) && count($sections) > 0)
               @foreach($sections as $name => $section)
                    @php
                        $section = (array)$section;
                        $sTotal = (int)($section['total_marks'] ?? 0);
                        $sObtained = (int)($section['obtained_marks'] ?? 0);
                        $percent = $sTotal ? round(($sObtained / $sTotal) * 100) : 0;
                    @endphp
                    <tr>
                        <td style="text-align: left;">{{ ucfirst($name) }}</td>
                        <td style="text-align: right;">{{ $sObtained }} / {{ $sTotal }} ({{ $percent }}%)</td>
                    </tr>
                @endforeach
           @endif
            <tr class="summary-total">
                <td style="text-align: left; font-weight: bold; border-bottom: 2px solid #8d704c !important;">Total</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 2px solid #8d704c !important;">{{ $obtained }} / {{ $total }} ({{ $overall }}%)</td>
            </tr>
        </tbody>
    </table>
</div>

</div>
</body>
</html>