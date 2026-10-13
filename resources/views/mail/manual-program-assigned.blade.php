<!DOCTYPE html>
<html>
<head>
    <title>Learning Program Assigned</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>
        Hi {{ $student->f_name ?? $student->name }},
    </h2>

    <p>
        A learning program has been successfully assigned to your V-Tutor account.
    </p>

    <p>
        You can now log in and start booking your learning sessions.
    </p>

    <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td><strong>Program</strong></td>
            <td>{{ $program->name }}</td>
        </tr>

        <tr>
            <td><strong>Program Code</strong></td>
            <td>{{ $program->code }}</td>
        </tr>

        <tr>
            <td><strong>Order ID</strong></td>
            <td>{{ $orderId }}</td>
        </tr>

        <tr>
            <td><strong>Validity Till</strong></td>
            <td>{{ \Carbon\Carbon::parse($expiresAt)->format('d M Y') }}</td>
        </tr>

        <tr>
            <td><strong>Sessions</strong></td>
            <td>{{ $program->number_of_sessions }}</td>
        </tr>
    </table>

    <br>

    <p>
        Please log in to your account to view the assigned program and schedule sessions.
    </p>

    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Thanks and Regards</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Team V-Tutor</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">
        <a href="{{ url('/') }}">{{ url('/') }}</a>
    </p>

    <p style="font-style: italic !important;font-size:13px;">
        This email and its attachments are confidential and intended only for the named recipient.
        If you received this message in error, please notify us immediately and delete it.
    </p>

</body>
</html>