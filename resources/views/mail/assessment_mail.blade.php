<!DOCTYPE html>
<html>
<head>
    <title>V-Tutor Student Assessment</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:20px;">

<div style="max-width:620px; margin:0 auto; background:#ffffff; border:1px solid #eee; padding:25px;">

    <h2 style="margin-top:0; font-size:20px; color:#333;">
        Hi {{ $assessment->first_name }},
    </h2>

    <p style="font-size:14px; color:#444; line-height:1.7;">
        Thank you for your interest in the <strong>V-Tutor Student Diagnostic Assessment</strong>.
    </p>

    <p style="font-size:14px; color:#444; line-height:1.7;">
        To better understand your child's learning needs, we'd like you to complete a short online assessment.
        Your responses will help our Academic Team identify your child's learning strengths, highlight areas
        for improvement, and gain a better understanding of their current academic needs.
    </p>

    <div style="margin:25px 0; text-align:center;">
        <a href="{{ $signupUrl }}"
           style="display:inline-block; background:#337ab7; color:#ffffff; padding:12px 24px;
                  text-decoration:none; border-radius:4px; font-size:14px; font-weight:bold;">
            Begin Assessment
        </a>
    </div>

    <p style="font-size:14px; color:#444; line-height:1.7;">
        The assessment takes only a few minutes to complete and can be accessed at your convenience.
    </p>

    <p style="font-size:14px; color:#444; line-height:1.7;">
        If you have any questions, please contact us at
        <strong><a href="mailto:support@v-tutor.com.au">support@v-tutor.com.au</a></strong>.
    </p>

    <br>

    <p style="font-size:14px; color:#444; margin:0 0 8px 0;">Kind regards,</p>
    <p style="font-size:14px; color:#444; margin:0 0 8px 0;">The V-Tutor Academics Team</p>
    <p style="font-size:14px; margin:0 0 12px 0;">
        <a href="https://v-tutor.com.au">https://v-tutor.com.au</a>
    </p>

    <p style="font-style:italic; font-size:13px; color:#666;">
        This email and its attachments are confidential and intended only for the named recipient.
        If you received this message in error, please notify us immediately and delete it.
        Any unauthorised use, disclosure, or distribution is prohibited.
    </p>

</div>

</body>
</html>