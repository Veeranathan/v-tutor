<!DOCTYPE html>
<html>
<head>
    <title>V-Tutor Student Assessment - OTP Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:20px;">

<div style="max-width:620px; margin:0 auto; background:#ffffff; border:1px solid #eee; padding:25px;">

    <h2 style="margin-top:0; font-size:20px; color:#333;">
        Hi {{ $assessment->first_name }},
    </h2>

    <p style="font-size:14px; color:#444; line-height:1.6;">
        To continue with your <strong>V-Tutor Student Assessment</strong>, please verify
        your email address using the One-Time Password (OTP) below.
    </p>

    <div style="margin:25px 0; text-align:center;">
        <div style="
            display:inline-block;
            background:#f5f7fa;
            border:1px dashed #337ab7;
            padding:15px 25px;
            font-size:22px;
            font-weight:bold;
            letter-spacing:3px;
            color:#337ab7;
        ">
            {{ $otp }}
        </div>
    </div>

    <div style="margin:15px 0; text-align:center;">
        <p style="font-size:13px; color:#d9534f; font-weight:bold; line-height:1.5;">
           Note: This OTP is valid for 15 minutes only.
        </p>
    </div>

    <p style="font-size:14px; color:#444; line-height:1.6;">
        Please do not share this OTP with anyone. If you did not request this
        verification, you may safely ignore this email.
    </p>

    <p style="font-size:14px; color:#444; line-height:1.6;">
        If you have any questions, feel free to contact us at  
        <strong>
            <a href="mailto:support@v-tutor.com.au">support@v-tutor.com.au</a>
        </strong>.
    </p>

    <br>

    <p style="font-size:14px; color:#333; margin:0;">
        Warm regards,<br>
        <strong>The V-Tutor Team</strong>
    </p>

    <p style="font-size:12px; color:#888; margin-top:25px; font-style:italic;">
        This email is confidential and intended only for the recipient.
    </p>

</div>

</body>
</html>
