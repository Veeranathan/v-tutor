<!DOCTYPE html>
<html>

<head>
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div style="max-width:640px; margin:0 auto;">
        {{-- <div style="/*width:620px;*/background:#F6E8D5; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;border-color: #b80f0ab3;">
            <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('#') }}') repeat center center">
               <a href="{{ url('/') }}"><img src="{{public_asset('assets/images/email_header.png')}}" style="width: 100%;
    height: 100%;" width="auto" alt=""></a>
            </div>
         </div> --}}
        <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
            <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear
                admin,</h1>
            <div style="display:block; overflow:hidden; width:100%;">
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">

                </p>

                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                    You have a new contact request from web site. Below are the details:
                </p>
                <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">

                </p>
                <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
                    <p
                        style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#f5f5f5;">
                        Message : {!! strip_tags(@$data['message']) !!}
                    </p>
                </div>
                <p>
                    <strong>Name</strong>: {{ @$data['name'] }}
                </p>
                <p>
                    <strong>Email</strong>: {{ @$data['email'] }}
                </p>
                <p>
                    <strong>Number</strong>: {{ @$data['number'] }}
                </p>
                @if (!empty($data['role']))
                    <p><strong>Role</strong>: {{ $data['role'] }}</p>
                @endif
                @if (!empty($data['category']))
                    <p><strong>Category</strong>: {{ $data['category'] }}</p>
                @endif
                @if (!empty($data['contact_method']))
                    <p><strong>Preferred Contact Method</strong>: {{ $data['contact_method'] }}</p>
                @endif
                @if (!empty($data['best_time']))
                    <p><strong>Best Time to Reach</strong>: {{ $data['best_time'] }}</p>
                @endif
                <p>
                    <strong>Subject</strong>: {{ @$data['subject'] }}
                </p>
                <p>
                    <strong>Message</strong>: {!! strip_tags(@$data['message']) !!}
                </p>
            </div>


            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thank
                & Regards</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">
                Team V-Tuor
            </p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a
                    href="{{ url('/') }}">{{ url('/') }}</a></p>
            <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and
                intended only for the named recipient. If you received this message in error, please notify us
                immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
        </div>
    </div>
</body>

</html>
