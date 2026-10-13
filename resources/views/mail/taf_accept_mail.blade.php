
<!DOCTYPE html>
<html>
    <head>
        <title>Tutor Application Form Accepted</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div style="max-width:640px; margin:0 auto;">
            {{-- <div style="/*width:620px;*/background:#F6E8D5; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;border-color: #b80f0ab3;">
                <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('/') }}') repeat center center">
                        <a href="{{ url('/') }}"><img src="{{public_asset('assets/images/email_header.png')}}" style="width: 100%;
    height: 100%;" width="auto" alt=""></a>
                </div>
            </div> --}}
            <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
                <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear {{ @$data['taf_data']->first_name }} ,</h1>
                
                <p>Congratulations! We are pleased to inform you that your tutor application has been reviewed and <b>conditionally accepted</b>.</p>

                <p>You now have <b>limited access</b> to our platform, allowing you to update your tutor profile. Full access will be granted upon the successful completion of all onboarding requirements. </p>

                <p>To access the platform, please use the following link and log in with the same credentials used during your application: </p>

                {{-- <p><a href="https://v-tutor.com.au/" target="_blank">https://v-tutor.com.au/</a></p> --}}
                <p><a href="{{ route('landing.page') }}" target="_blank">{{ route('landing.page') }}</a></p>

                <p>Please note that this approval is <b>conditional</b>, pending the completion of additional checks and formalities. You will shortly receive further instructions from our Academics Team outlining the next steps. We kindly request that you respond promptly to avoid any delays in the onboarding process.</p>

                <p>We’re excited to welcome you to the team and look forward to having you on board as a tutor. </p>
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Kind regards,</p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">V-Tutor Team </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
                <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
            </div>
        </div>
    </body>
</html>
