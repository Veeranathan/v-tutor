<!DOCTYPE html>
<html>

<head>
    <title>V-Tutor – We have received your application</title>
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
                    Thank you for taking the time to submit your tutor application. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    We are pleased to confirm that your application has been successfully received. Please note that the review process may take approximately 24 to 48 hours and is subject to further verification checks. Should any additional information be required, a member of our team will contact you directly. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Kindly await an email notification regarding the outcome of your application. We recommend monitoring your inbox regularly, including your spam or junk folders, to ensure you do not miss any communication from us. 
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Thank you once again for your interest in joining V-Tutor. We sincerely appreciate your time and enthusiasm. 
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