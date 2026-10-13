
<!DOCTYPE html>
<html>
    <head>
        <title>Close Account</title>
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
                {{-- <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear {{@$data['user']['f_name']}} ,</h1> --}}
                <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear @if(@$data['user']['user_type'] == 'T') {{@$data['user']['f_name']}} , @else {{@$data['user']['parent_f_name']}} , @endif</h1>
                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                    <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#F6E8D5;">
                        <strong><b>Account Closed</b></strong>
                        {{-- You have closed your @if(@$data['user']['user_type'] == 'S') student @else tutor @endif account.You will not be able to login into your vtutor account using your old email {{@$data['user']['email']}} and password!Your vtutor @if(@$data['user']['user_type'] == 'S') student @else tutor @endif account is closed successfully! --}}
                    </p>
                </div>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  {{-- Your account has been closed by our compliance team. --}}
                  We see that you have decided to close your V-Tutor account.
               </p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;font-style:italic;">
                  {{-- Closed incorrectly or by accident? Write to us at compliance@v-tutor.com.au --}}
                  Please note you will no longer be able to login with your V-Tutor credentials.
               </p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;font-style:italic;">
                  {{-- We see that you have decided to close your V-Tutor account.  --}}
                  Closed incorrectly or by accident? Write to us at compliance@v-tutor.com.au

               </p>

                <!-- <div style="display:block;overflow:hidden; width:100%; text-align:center; margin: 0px 0px 10px 0px;">
                        <a href="" style="font-family: Arial;
                                                    border-radius: 4px;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color:#FFF;
                                                    display: inline-block;
                                                    padding: 8px 15px;
                                                    background:#1F80AA;
                                                    text-decoration: none;">Click</a>
                </div> -->
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thanks and Regards</p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tutor</p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
                <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
            </div>
        </div>
    </body>
</html>
