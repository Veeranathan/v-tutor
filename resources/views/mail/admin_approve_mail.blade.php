
<!DOCTYPE html>
<html>
    <head>
        <title>V-Tutor Approved</title>
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
                <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear {{@$data['user']['f_name']}} ,</h1>
                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                    {{-- <li> --}}
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            Thanks for taking the time for the interview.
                        </p>
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            Congrats! We are glad to inform you that your application to join the tutor team at V-Tutor has been approved.
                        </p>
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            This is an important milestone in your tutoring journey with us.

                        </p>
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            As part of the next steps, you will receive an email with the contract agreement. Please follow the instructions mentioned in that email.

                        </p>
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            Kindly note that your tutor profile will now have access to all the modules and is available for booking on our platform. One of the first things you can do is to set your availability by choosing the days and time slots. It will help the parents to know when they can book your session.
                        </p>
                        <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:left; padding: 4px;">
                            Do let us know if you have any queries at support@v-tutor.com.au. All the best for V-Tutor’ing.
                        </p>
                </div>
                <div style="display:block;overflow:hidden; width:100%; text-align:center; margin: 0px 0px 10px 0px;">
                        <a href="{{ route('login') }}" style="font-family: Arial;
                                                    border-radius: 4px;
                                                    font-size: 17px;
                                                    font-weight: 500;
                                                    color:#FFF;
                                                    display: inline-block;
                                                    padding: 8px 15px;
                                                    background:#d73c5e;
                                                    text-decoration: none;">Login</a>
                </div>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thanks & Regards,</p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tutor</p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
                <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
            </div>
        </div>
    </body>
</html>
