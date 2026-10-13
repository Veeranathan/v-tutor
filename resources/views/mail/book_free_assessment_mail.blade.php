<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:20px;">

<div style="max-width:620px; margin:0 auto; background:#ffffff; border:1px solid #eee; padding:25px;">

    <h2 style="font-size:18px; margin-bottom:20px;">
        Dear {{ $assessment->first_name }},
    </h2>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        Congratulations on taking the first step toward improving your child’s learning journey.
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        We’re excited to support you in identifying your child’s strengths and areas for growth,
        and in building a tailored learning program that truly meets their needs.
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        As your next step, we invite you to complete our diagnostic assessment,
        which will help us better understand your child’s current level and learning requirements.
        Based on the results, we will guide you through the next steps and design a personalised learning plan.
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        You can begin the assessment using the link below:
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
    🔗 
    <a href="https://v-tutor.com.au/learning-program-assessment" style="color:#337ab7; text-decoration:underline;">
        https://v-tutor.com.au/learning-program-assessment
    </a>
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        Once completed, our team will review the results and reach out to guide you on the most suitable learning pathway for your child.
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        If you have any questions or need assistance at any stage, please feel free to contact us at  
        <a href="mailto:support@v-tutor.com.au">support@v-tutor.com.au</a>.
    </p>

    <p style="font-size:14px; line-height:1.7; color:#333;">
        We look forward to supporting your child’s progress and success.
    </p>

    <br>

    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thanks and Regards</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tuor</p>
    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
    <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>

</div>

</body>
</html>