@php
    use Illuminate\Support\Facades\URL;
    use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;


@endphp
<!DOCTYPE html>
<html>
   <head>
      <title>Booking Cancelled - Booking Ref. {{ @$data['bookingDataInformation']['booking_no'] }}</title>
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
            <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear @if(@$data['mail_send_to'] == 'S') {{@$data['bookingDataInformation']['getStudent']['parent_f_name']}}, @else {{@$data['bookingDataInformation']['getTutor']['f_name']}}, @endif</h1>
            <div style="display:block; overflow:hidden; width:100%;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
               </p>
               {{-- <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Greeting from Vtutor!.
               </p> --}}
               <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#FFFFFF;padding: 4px; background:#B80F0A;">
                 <b>Cancellation Details</b>
               </p>
            </div>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                 Your session has been cancelled. For more details, please refer below:
               </p>
               <p>
                  <strong>Booking Ref.</strong>: {{ @$data['bookingDataInformation']['booking_no'] }}
               </p>
               <p>
                  <strong>Tutor</strong>:  {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getTutor']['l_name']}}
               </p>
               <p>
                  <strong>Student</strong>: {{@$data['bookingDataInformation']['getStudent']['f_name']}} {{@$data['bookingDataInformation']['getStudent']['l_name']}}
               </p>
               <p>
                  <strong>Subject</strong>: {{@$data['bookingDataInformation']['getSubject']['subject']}}
               </p>

               <p>

                  <strong>Booked  for</strong>:
                  @if(@$data['mail_send_to'] == 'S')
                  {{date('d-m-Y',strtotime(@$data['bookingDataInformation']['booking_date']))}} {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time_user']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time_user']))}}
                  @else
                  {{date('d-m-Y',strtotime(@$data['bookingDataInformation']['booking_date']))}} {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time_tutor']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time_tutor']))}}
                  @endif
               </p>
               <p>
                  <strong>Cancelled on</strong>:
                   @if(@$data['mail_send_to'] == 'S')
                  {{ date('d-m-Y h:i:s a',strtotime(@$data['bookingDataInformation']['cancelled_on_user'])) }}
                  @else
                  {{ date('d-m-Y h:i:s a',strtotime(@$data['bookingDataInformation']['cancelled_on_tutor'])) }}
                  @endif
               <p>
                  <strong>Cancelled by</strong>: @if(@$data['bookingDataInformation']['cancelled_by'] =='A') Admin @elseif(@$data['bookingDataInformation']['cancelled_by'] =='T')  {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getTutor']['l_name']}} @elseif(@$data['bookingDataInformation']['cancelled_by'] =='S') {{@$data['bookingDataInformation']['getStudent']['parent_f_name']}} {{@$data['bookingDataInformation']['getStudent']['parent_l_name']}} @endif
               </p>
               <p>
                  <strong>Booking Amount</strong>: ${{ number_format(@$data['bookingDataInformation']['booking_amount'] + @$data['bookingDataInformation']['stripe_charge'],2) }}
               </p>
               <p>
                  <strong>Refund Amount</strong>: ${{ number_format(@$data['bookingDataInformation']['getPaymentsInfo']['refund_amount'],2) }}
               </p>
               <p>
                  <strong>Refund Status</strong>:
                  @if(@$data['bookingDataInformation']['getPaymentsInfo']['refund_type'] == '100')
                  Full Refund
                  @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['refund_type'] == '75')
                  75% amount refunded
                  @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['refund_type'] == '50')
                  50% amount refunded
                  @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['refund_type'] == '25')
                  25% amount refunded
                  @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['refund_type'] == 'N')
                  No refund
                  @endif
               </p>
               <p style="font-style: italic; font-size:13px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Refunds are subject to <a href="{{ route('help') }}">Cancellation Policy</a> available from the <a href="{{ route('help') }}">Help section</a> on the site. If you are eligible for a refund, it will be processed in the next 2-3 days. Kindly allow 24-48 hours after that for the amount to reflect in your bank account.
               </p>
               @if(@$data['mail_send_to'] == 'T')

               @elseif(@$data['mail_send_to'] == 'S')

               @else

               @endif

               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 20px 0px 10px 0px;">Thanks & Regards,</p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tutor</p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
               <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
            </div>
         </div>
      </div>
   </body>
</html>
