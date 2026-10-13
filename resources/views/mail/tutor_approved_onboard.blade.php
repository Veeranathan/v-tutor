<!DOCTYPE html>
<html>

<head>
    <title>V-Tutor – Welcome Onboard – Your Application Has Been Approved</title>
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
                {{ @$data['name'] }} ,</h1>


            <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Congratulations, and welcome to <b>V-Tutor</b>!
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    We are pleased to inform you that your application has been fully approved. You now have full access to our tutoring platform and can begin engaging with students and managing your sessions. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Please use the link below to log in to your account:
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    <a href="{{ url('/') }}"
                        style="font-family: Arial; font-size: 17px; font-weight: 500; color:#d73c5e; display: inline-block;">{{ url('/') }}</a>
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    In addition, we have created a Zoom account for you to conduct all your tutoring sessions. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    The login details are provided below: 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Zoom Login: {{ @$data['zoomemail'] }}
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Temporary Password: {{ @$data['zoompassword'] }}
                </p>                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Zoom Login Link: <a href="https://zoom.us/signin"
                        style="font-family: Arial; font-size: 14px; font-weight: 500; color:#d73c5e; display: inline-block;">https://zoom.us/signin</a>
                </p>                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;font-font-style: italic;">
                    Please note: These credentials are for Zoom access only and are to be used exclusively for hosting tutoring sessions through the Tutor platform. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    To reset Zoom account password, visit <a href="https://gsydm1037.siteground.biz/webmail/log-in"
                        style="font-family: Arial; font-size: 14px; font-weight: 500; color:#d73c5e; display: inline-block;">https://gsydm1037.siteground.biz/webmail/log-in</a> 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Kindly note this mailbox is monitored by V-Tutor in accordance with our <a href="{{ route('terms.conditions') }}"
                        style="font-family: Arial; font-size: 14px; font-weight: 500; color:#d73c5e; display: inline-block;">Terms & Conditions</a>.
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Should you have any questions or require assistance at any stage, please feel free to contact our support team at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=tutor.support@v-tutor.com.au." target="_blank">tutor.support@v-tutor.com.au.</a>.
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    We are excited to have you on board and look forward to working with you. Wishing you every success as you embark on your tutoring journey with us.
                </p>
                {{-- <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Wishing you every success as you embark on your tutoring journey with us.
                </p> --}}
            </div>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Kind Regards,</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">
                V-Tutor Team</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a
                    href="{{ url('/') }}">{{ url('/') }}</a></p>
            <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
        </div>
    </div>
</body>

</html>
