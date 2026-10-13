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
                {{ @$data['parent_name'] }} ,</h1>
                {{-- {{ @$data['student_name'] }} ,</h1> --}}


            <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    This is a friendly reminder that your session with <b>{{ @$data['tutor_name'] }}</b> is scheduled to begin in <b>{{ @$data['remaining_time'] }}</b> mins at <b>{{ @$data['class_time'] }}</b>.
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    You can join the session by clicking the link below:  <a href="{{ @$data['join_link'] }}"
                        style="font-family: Arial; font-size: 17px; font-weight: 500; color:#d73c5e; display: inline-block;">{{ @$data['join_link'] }}</a>
                </p>

                <!-- @if (isset($data['pmi']) && $data['pmi'])
                    <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                        Alternatively, you may enter the following ID on Zoom: <b>{{ @$data['pmi'] }}</b>
                    </p>
                @endif -->
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;font-weight: 600;">
                    To ensure a smooth learning experience:
                </p>
                <ul style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;padding-left: 30px;">
                    <li>The meeting link will be active 5 minutes before the scheduled session. </li>
                    <li>Log in to the meeting a few minutes early to test your audio and video. </li>
                    <li>Ensure you have a stable internet connection and are in a quiet, well-lit space. </li>
                    <li>If joining from a new device, make sure the camera and microphone permissions are enabled. </li>
                    <li>Keep your child’s learning materials ready for an uninterrupted session.  </li>
                </ul>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    <b>Need to Cancel? </b>
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    If you wish to cancel this session, please refer to the Cancellation Policy section under our <a href="{{ route('terms.service') }}"
                        style="font-family: Arial; font-size: 14px; font-weight: 500; color:#d73c5e; display: inline-block;">Terms of Service</a>
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    For cancellations, the session must be withdrawn through your V-Tutor account, following the policy guidelines. 
                </p>

                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    If you experience any issues accessing the link, simply reply to this email or contact us at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=support@v-tutor.com.au." target="_blank">support@v-tutor.com.au.</a>. Please include the <b>Booking ID</b> for faster assistance. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Thank you, and we hope your child has a productive session. 
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
