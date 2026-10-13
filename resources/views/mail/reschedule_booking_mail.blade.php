<!DOCTYPE html>
<html>
   <head>
      <title>Mail</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div style="max-width:640px; margin:0 auto;">
         {{-- <div style="/*width:620px;*/background:#F5F5F3; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;border-color: #b80f0ab3;">
            <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('#') }}') repeat center center">
               <img src="{{ public_asset('assets/images/email_header.png') }}" width="200" alt="">
            </div>
         </div> --}}
         <div style="max-width:620px; border:1px solid #f0f0f0; margin:0 0; padding:15px; ">
            <h1 style="font-family:Arial; font-size:16px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">Dear {{@$data['bookingDataInformation']['getStudent']['f_name']}}</h1>
            <div style="display:block; overflow:hidden; width:100%;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">

               </p>

                  <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                     Greeting From Vtutor!.
                  </p>
                  <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                     Your booking no {{@$data['bookingDataInformation']['booking_no']}}  has now been rescheduled with {{@$data['bookingDataInformation']['getTutor']['f_name']}} on {{@$data['bookingDataInformation']['booking_date']}} {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time']))}}
                  </p>
                  <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#000;padding: 4px; background:#f5f5f5;">
                 Your Booking Details
               </p>
            </div>
                     <p>
                        <strong>Booking No</strong>: {{@$data['bookingDataInformation']['booking_no']}}
                     </p>
                    <p>
                        <strong>Tutor Name</strong>: {{@$data['bookingDataInformation']['getTutor']['f_name']}}  {{@$data['bookingDataInformation']['getTutor']['l_name']}}
                    </p>
                    <p>
                        <strong>Student Name</strong>: {{@$data['bookingDataInformation']['getStudent']['f_name']}}  {{@$data['bookingDataInformation']['getStudent']['l_name']}}
                    </p>
                    <p>
                        <strong>Subject</strong>: {{@$data['bookingDataInformation']['getSubject']['subject']}}
                    </p>
                    <p>
                        <strong> Booking Date Time</strong>: {{@$data['bookingDataInformation']['booking_date']}} {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time']))}}
                    </p>
                    <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                    </p>
                    <p>
                     <strong>Amount</strong>: ${{@$data['bookingDataInformation']['booking_amount']}}
                    </p>
            </div>


            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Thank & Regards</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">
               Team Vtuor
            </p>
            <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
         </div>
      </div>
   </body>
</html>
