<!DOCTYPE html>
<html>
<head>
    <title>V-Tutor Student Assessment Result</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
        }
        .text-right { text-align: right; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<button class="no-print" onclick="window.print()">Download PDF</button>

<h2>V-Tutor Student Assessment Result</h2>

<p><strong>Student:</strong> {{ $assessment->first_name }} {{ $assessment->last_name }}</p>
<p><strong>Subject:</strong> {{ $assessment->subject }}</p>

<h3>Quantitative Section</h3>
<table>
<tr>
    <th>Question</th>
    <th>Correct Answer</th>
    <th>Student Answer</th>
    <th>Marks</th>
</tr>
@foreach($results->where('type','quantitative') as $r)
<tr>
    <td>{{ $r->question }}</td>
    <td>{{ $r->correct_answer }}</td>
    <td>{{ $r->student_answer }}</td>
    <td class="text-right">{{ $r->marks_obtained }}</td>
</tr>
@endforeach
</table>

<h3>Qualitative Section</h3>
<table>
<tr>
    <th>Question</th>
    <th>Student Answer</th>
    <th>Remarks</th>
    <th>Marks</th>
</tr>
@foreach($results->where('type','qualitative') as $r)
<tr>
    <td>{{ $r->question }}</td>
    <td>{{ $r->student_answer }}</td>
    <td>{{ $r->remarks }}</td>
    <td class="text-right">{{ $r->marks_obtained }}</td>
</tr>
@endforeach
</table>

<h3>Final Score</h3>
<p>
    <strong>Total Marks:</strong> {{ $results->sum('total_marks') }} <br>
    <strong>Obtained Marks:</strong> {{ $results->sum('marks_obtained') }}
</p>

</body>
</html>
