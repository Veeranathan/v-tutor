<!DOCTYPE html>
<html>
<head>
    <title>V-Tutor Academic Program Product Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:20px;">

<div style="max-width:620px; margin:0 auto; background:#ffffff; border:1px solid #eee; padding:25px;">

    <h2 style="margin-top:0; font-size:20px; color:#333;">
        New Academic Product Enquiry
    </h2>

    <p style="font-size:14px; color:#444; line-height:1.6;">
        You have received a new product enquiry from the website.
    </p>

    <hr style="margin:20px 0;">

    <p><strong>Product Name:</strong> {{ $data['program_name'] ?? 'N/A' }}</p>
    <p><strong>Product Code:</strong> {{ $data['program_type'] ?? 'N/A' }}</p>

    <br>

    <p><strong>Customer Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['number'] }}</p>

    <br><br>

    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Thanks and Regards</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">Team V-Tutor</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0 0 10px 0;">
        <a href="{{ url('/') }}">{{ url('/') }}</a>
    </p>

    <p style="font-style: italic !important;font-size:13px;">
        This email and its attachments are confidential and intended only for the named recipient.
        If you received this message in error, please notify us immediately and delete it.
    </p>

</div>

</body>
</html>
