<!DOCTYPE html>
<html>
<head>
    <title>New Learning Program Booking</title>
</head>
<body style="font-family: Arial, sans-serif;">

<h2>New Learning Program Booking Received</h2>

<table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse;">

    <tr>
        <td><strong>Booking No</strong></td>
        <td>{{ $booking->booking_no }}</td>
    </tr>

    <tr>
        <td><strong>Student Name</strong></td>
        <td>{{ $student->full_name }}</td>
    </tr>

    <tr>
        <td><strong>Student Email</strong></td>
        <td>{{ $student->email }}</td>
    </tr>

    <tr>
        <td><strong>Tutor Name</strong></td>
        <td>{{ $tutor->full_name }}</td>
    </tr>

    <tr>
        <td><strong>Program</strong></td>
        <td>{{ $program->name ?? '-' }}</td>
    </tr>

    <tr>
        <td><strong>Booking Date</strong></td>
        <td>{{ $bookingDate }}</td>
    </tr>

    <tr>
        <td><strong>From Time</strong></td>
        <td>{{ $fromTime }}</td>
    </tr>

    <tr>
        <td><strong>To Time</strong></td>
        <td>{{ $toTime }}</td>
    </tr>

    <tr>
        <td><strong>Timezone</strong></td>
        <td>{{ $timezone }}</td>
    </tr>

</table>

<br>

<p>Regards,</p>
<p>Team V-Tutor</p>

</body>
</html>