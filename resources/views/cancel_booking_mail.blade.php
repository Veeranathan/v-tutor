<!DOCTYPE html>
<html>
   <head>
      <title>Booking Cancelled - Booking Ref. {{ @$data['bookingDataInformation']['booking_no'] }}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div style="max-width:640px; margin:0 auto;">
         <div style="/*width:620px;*/background:#F5F5F3; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;">
            <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('#') }}') repeat center center">
               <img src="{{ public_asset('assets/images/logo.png') }}" width="200" alt="">
            </div>
         </div>
         <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
            <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear {{@$data['bookingDataInformation']['getStudent']['f_name']}},</h1>
            <div style="display:block; overflow:hidden; width:100%;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
               </p>
               {{-- <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Greeting from Vtutor!.
               </p> --}}
               <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#f5f5f5;">
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
                  <strong>Tutor</strong>: {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getTutor']['l_name']}}
               </p>
               <p>
                  <strong>Student</strong>: {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getStudent']['l_name']}}
               </p>
               <p>
                  <strong>Subject</strong>: {{@$data['bookingDataInformation']['getSubject']['subject']}}
               </p>
               <p>
                  <strong>Booked for</strong>: {{date('d-m-Y',strtotime(@$data['bookingDataInformation']['booking_date']))}} {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time']))}}
               </p>
               <p>
                  <strong>Cancelled on</strong>: {{ date('d-m-Y h:i:s a',strtotime(@$data['bookingDataInformation']['cancelled_on'])) }}
               </p>
               <p>
                  <strong>Cancelled by</strong>: @if(@$data['bookingDataInformation']['cancelled_by'] =='A') Admin @elseif(@$data['bookingDataInformation']['cancelled_by'] =='T') Tutor @elseif(@$data['bookingDataInformation']['cancelled_by'] =='S') Student @endif
               </p>
               <p>
                  <strong>Booking Amount</strong>: ${{ number_format(@$data['bookingDataInformation']['booking_amount'] + @$data['bookingDataInformation']['stripe_charge'],2) }}
               </p>
               <p>
                  <strong>Refund Amount</strong>: ${{ @$data['bookingDataInformation']['getPaymentsInfo']['refund_amount'] }}
               </p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Refunds are subject to Cancellation Policy available from the Help section on the site. If you are eligible for a refund, it will be processed in the next 2-3 days. Kindly allow 24-48 hours after that for the amount to reflect in your bank account.
               </p>
               @if(@$data['mail_send_to'] == 'T')

               @elseif(@$data['mail_send_to'] == 'S')

               @else

               @endif
               <div class="testPro">
               <div class="proDiv">
                   {{-- <h6>Please note:</h6>  --}}
                   <p style="font-style: italic !important;"><b>Please note:</b> </p>
                   <p style="font-style: italic !important;">1. You may click to join the session at your scheduled time. The tutor or meeting link may not be available in case you join early.</p>
                   <p style="font-style: italic !important;">2. You need an active Zoom account to join sessions. If you don’t have one already, kindly create one and stay logged in.</p>
                   <p style="font-style: italic !important;">3. In case you fail to join the session within 10 minutes from the start time, it will be considered as ‘no show’ and you stand to forfeit charges for the session</p>
                   <p style="font-style: italic !important;">4. Session timings are fixed and cannot be extended for any reasons, though legitimate. If the session is interrupted due to technical reasons from tutor’s end or due to unavailability of the learning platform, the session will be considered as ‘cancelled’ and session charges would be refunded.</p>
               </div>
           </div>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 20px 0px 10px 0px;">Thanks & Regards,</p>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tutor</p>
            </div>
         </div>
      </div>
   </body>
</html>
