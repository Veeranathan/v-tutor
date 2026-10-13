<!DOCTYPE html>
<html>

<head>
    <title>V-Tutor – Welcome Onboard – Your Application Has Been Rejected</title>
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
                    Thank you for taking the time to apply as a tutor on our platform. We appreciate your interest and the effort you put into your application. 
                </p>
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    After careful review, we regret to inform you that your application does not meet our current selection criteria.
                </p>
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    Please know this decision is not a reflection of your abilities as a tutor, but rather based on specific requirements we are looking for at this time.
                </p>
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    You are very welcome to reapply in the future. If you choose to do so, please note that a new application—including all required documents and assessments—will need to be submitted from the beginning. 
                </p>
                
                <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                    We wish you all the best in your tutoring journey and look forward to hearing from you again when you're ready. 
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