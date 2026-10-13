<!DOCTYPE html>
<html>

<head>
    <title>Reminder: Your session starts in 1 hour - V-Tutor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div style="max-width:640px; margin:0 auto;">
        {{-- <div
            style="/*width:620px;*/background:#F6E8D5; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;border-color: #b80f0ab3;">
            <div
                style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('/') }}') repeat center center">
                <a href="{{ url('/') }}"><img src="{{ public_asset('assets/images/email_header.png') }}"
                        style="width: 100%;
    height: 100%;" width="auto" alt=""></a>
            </div>
        </div> --}}
        <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
            <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear
                {{ @$data['tutor_name'] }} ,</h1>


            <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    This is a friendly reminder that your session with {{ @$data['student_name'] }} is scheduled to begin in  {{ @$data['remaining_time'] }} at {{ @$data['class_time'] }}.
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Please join using this link: <a href="{{ @$data['join_link'] }}"
                        style="font-family: Arial; font-size: 17px; font-weight: 500; color:#d73c5e; display: inline-block;">{{ @$data['join_link'] }}</a>
                </p>

                <!-- @if (isset($data['pmi']) && $data['pmi'])
                    <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                        Alternatively, you may use the following Meeting ID on Zoom: <b>{{ @$data['pmi'] }}</b>
                    </p>
                @endif -->

                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;font-weight: 600;">
                    Before Your Session 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    To ensure a smooth and professional experience, please: 
                </p>
                <ul style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;padding-left: 30px;">
                    <li>Join the session a few minutes early to greet the student and start on time. </li>
                    <li>Test your audio, video, and internet connection in advance. </li>
                    <li>Ensure you’re in a quiet, well-lit space free from distractions. </li>
                    <li>Have your lesson plan and learning materials ready. </li>
                    <!-- <li>Log in using your assigned V-Tutor Zoom account credentials. </li> -->
                </ul>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    <b>Need to Cancel? </b>
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    If you wish to cancel this session, please refer to the Cancellation Policy section under the Tutor Terms & Conditions. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Cancellations must be made through your V-Tutor account in accordance with the policy guidelines.
                </p>

                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    If you experience any technical issues or need assistance, please reply to this email or contact <a href="https://mail.google.com/mail/?view=cm&fs=1&to=tutor.support@v-tutor.com.au." target="_blank">tutor.support@v-tutor.com.au.</a>. When doing so, kindly include the <b>Booking ID</b> for quicker support. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Thank you for your professionalism and dedication to providing quality learning experiences. 
                </p>
            </div>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Kind Regards,</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">
                Academics Team </p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a
                    href="{{ url('/') }}">{{ url('/') }}</a></p>
            <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
        </div>
    </div>
</body>

</html>
