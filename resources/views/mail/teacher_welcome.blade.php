<!DOCTYPE html>
<html>

<head>
    <title>Welcome to V-Tutor</title>
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
                    Welcome to V-Tutor, and congratulations on taking the first step toward joining our tutoring
                    platform.
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    To begin the onboarding process, we kindly invite you to complete your Tutor Application. You can
                    access the application by logging in using the following link:
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    <a href="{{ route('tutor_landing') }}"
                        style="font-family: Arial; font-size: 17px; font-weight: 500; color:#d73c5e; display: inline-block;">{{ route('tutor_landing') }}</a>

                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Should you have any questions or require assistance, please feel free to contact us at <a href="https://mail.google.com/mail/?view=cm&fs=1&to=be-a-tutor@v-tutor.com.au" target="_blank">
    be-a-tutor@v-tutor.com.au
</a>
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    We look forward to reviewing your application and working with you.
                </p>
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
