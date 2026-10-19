<!DOCTYPE html>
<html>
   <head>
      <title>Booking Confirmation Class Ref {{@$data['bookingDataInformation']['booking_no']}}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div style="max-width:660px; margin:0 auto;">
          {{-- <div style="/*width:620px;*/background:#F6E8D5; /*padding: 0px 10px;*/ border:1px solid #dcd7d7;border-color: #b80f0ab3;">
            <div style="float: none; text-align: center; margin-top: 0px; background:url('{{ URL::to('#') }}') repeat center center;">
               <a href="{{ url('/') }}"><img src="{{public_asset('assets/images/email_header.png')}}" style="width: 100%;
    height: 100%;" width="auto" alt=""></a>
            </div>
         </div> --}}
         <div style="max-width:640px; border:1px solid #f0f0f0; margin:0 0; padding:15px 15px 0px; ">
            <h1 style="font-family:Arial; font-size:14px; font-weight:500; /*color:#8ccd56;*/ margin:5px 0 12px 0;">@if(@$data['mail_send_to'] == 'T')Dear  {{@$data['bookingDataInformation']['getTutor']['f_name']}}, @else Dear {{@$data['bookingDataInformation']['getStudent']['parent_f_name']}}, @endif</h1>
            <div style="display:block; overflow:hidden; width:100%;">
               {{-- <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
               </p> --}}
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Greetings from V-Tutor
               </p>
               <div style="display:block;overflow:hidden; width:100%; margin: 5px 0px 10px 0px;">
               <p style="font-family:Arial; font-size:14px; font-weight:500; text-align:center; color:#FFFFFF;padding: 4px; background:#B80F0A;">
                 <b>Booking Details</b>
               </p>
            </div>
               <p style="font-family:Arial; font-size:14px; font-weight:500; color:#000;margin: 15px 0px 15px;">
                  Your session <b>{{@$data['bookingDataInformation']['booking_no']}}</b> is booked with  @if(@$data['mail_send_to'] == 'T') {{@$data['bookingDataInformation']['getStudent']['f_name']}}  {{@$data['bookingDataInformation']['getStudent']['l_name']}} @else Tutor  {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getTutor']['l_name']}}  @endif for <b>{{date('d-m-Y',strtotime(@$data['bookingDataInformation']['booking_date']))}}</b> between <b>{{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time_user']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time_user']))}}</b>
               </p>
               <p>
                  <strong>Order Placed</strong>: {{date('d-m-Y',strtotime(@$data['bookingDataInformation']['created_at_user']))}} at {{date('h:i:s a',strtotime(@$data['bookingDataInformation']['created_at_user']))}}
               </p>
               <p>
                  <strong>Order by</strong>: {{@$data['bookingDataInformation']['getStudent']['parent_f_name']}} {{@$data['bookingDataInformation']['getStudent']['parent_l_name']}}
               </p>
               <p>
                  <strong>Booked for</strong>: {{@$data['bookingDataInformation']['getStudent']['f_name']}} {{@$data['bookingDataInformation']['getStudent']['l_name']}}
               </p>
               @if(@$data['mail_send_to'] == 'S')
               <p>
                  <strong>Tutor Name</strong>:  {{@$data['bookingDataInformation']['getTutor']['f_name']}} {{@$data['bookingDataInformation']['getTutor']['l_name']}}
               </p>
               @else
               <p>
                  <strong>Student Name</strong>: {{@$data['bookingDataInformation']['getStudent']['f_name']}} {{@$data['bookingDataInformation']['getStudent']['l_name']}}
               </p>
               @endif

               @if(@$data['mail_send_to'] == 'S')
                  <p>
                     @php
                     $paidVia = json_decode(@$data['bookingDataInformation']['getPaymentsInfo']['response']);
                     @endphp
                     <strong>Paid via</strong>: {{strtoupper(@$paidVia->payment_method_details->card->brand)}} {{strtoupper(@$paidVia->payment_method_details->card->funding)}} {{strtoupper(@$paidVia->payment_method_details->type)}} ************{{@$paidVia->payment_method_details->card->last4}}
                     {{-- //{{@$paidVia->payment_method_details->card->brand}} --}}
                  </p>
                  @if (isset($data['bookingDataInformation']['net_total']) && $data['bookingDataInformation']['net_total'])
                     <p>
                        <strong>Amount Paid</strong>: ${{number_format(@$data['bookingDataInformation']['net_total'],2)}}
                     </p>
                  @else
                     <p>
                        <strong>Amount Paid</strong>: ${{number_format(@$data['bookingDataInformation']['booking_amount'] + @$data['bookingDataInformation']['stripe_charge'],2)}}
                     </p>
                  @endif
                  <p>
                     <strong>Payment Status</strong>:
                     @if(@$data['bookingDataInformation']['getPaymentsInfo']['status'] =='S')
                     Success
                     @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['status'] =='I')
                     Initiated
                     @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['status'] =='F')
                     Failed
                     @elseif(@$data['bookingDataInformation']['getPaymentsInfo']['status'] =='F')
                     Cancelled
                     @endif
                  </p>
                  <p>
                     <strong>Transaction Id</strong>: {{@$data['bookingDataInformation']['getPaymentsInfo']['txn_id']}}
                  </p>
                  <p>
                     <strong>Amount</strong>: $ {{@$data['bookingDataInformation']['booking_amount']}}
                  </p>
               @endif

               @if(@$data['mail_send_to'] == 'T')
               {{-- <p>
                  <strong>Session Link</strong>: <a href="{{@$data['bookingDataInformation']['start_url']}}">{{@$data['bookingDataInformation']['start_url']}}</a>
               </p> --}}
               <p>
                  <strong>Session Link</strong>: <a href="{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$data['bookingDataInformation']['id']]) }}" style="color:#B80F0A;">{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$data['bookingDataInformation']['booking_no']]) }}</a>
               </p>
               {{-- <p>
                  <strong>Session Link</strong>: <a href="{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$data['bookingDataInformation']['id']]) }}" style="color:#B80F0A;">{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$data['bookingDataInformation']['id']]) }}</a>
               </p> --}}
               @elseif(@$data['mail_send_to'] == 'S')
               <p>
                  {{-- <strong>Session Link</strong>: <a href="{{@$data['bookingDataInformation']['join_url']}}">{{@$data['bookingDataInformation']['join_url']}}</a> --}}
                  <strong>Session Link</strong>: <a href="{{ route('class.session.link',['userid' => Auth()->user()->unique_id, 'id' =>@$data['bookingDataInformation']['booking_no']]) }}" style="color:#B80F0A;">{{ route('class.session.link',['userid' => Auth()->user()->unique_id, 'id' =>@$data['bookingDataInformation']['booking_no']]) }}</a>
                  {{-- <strong>Session Link</strong>: <a href="{{ route('class.session.link',['userid' => Auth()->user()->unique_id, 'id' =>@$data['bookingDataInformation']['booking_no']]) }}" style="color:#B80F0A;">{{ route('class.session.link',['userid' => Auth()->user()->unique_id, 'id' =>@$data['bookingDataInformation']['id']]) }}</a> --}}
               </p>
               @else
               <p>
                  <strong>Session Link</strong>: <a href="{{ route('tutor.class.session.link',['userid' => Auth()->user()->unique_id, 'id' => @$data['bookingDataInformation']['booking_no']]) }}" style="color:#B80F0A;">Join</a>
               </p>
               {{-- <p>
                  <strong>Session Link</strong>: <a href="{{@$data['bookingDataInformation']['join_url']}}">{{@$data['bookingDataInformation']['join_url']}}</a>
               </p> --}}
               @endif
               @if(@$data['bookingDataInformation']['booking_status'] == 'C')
                  <p>
                     <strong>Cancelled on</strong>:
                     {{ @$data['bookingDataInformation']['cancelled_on'] }}
                  </p>
                  <p>
                     <strong>Cancelled by</strong>:
                     @if(@$data['bookingDataInformation']['cancelled_by'] == 'T')
                     {{@$data['bookingDataInformation']['getTutor']['parent_f_name']}} {{@$data['bookingDataInformation']['getTutor']['parent_l_name']}}
                     @elseif(@$data['bookingDataInformation']['cancelled_by'] == 'S')
                     {{@$data['bookingDataInformation']['getStudent']['parent_f_name']}} {{@$data['bookingDataInformation']['getStudent']['parent_l_name']}}
                     @elseif(@$data['bookingDataInformation']['cancelled_by'] == 'A')
                     Admin
                     @endif
                  </p>
                  @if(@$data['bookingDataInformation']['getPaymentsInfo']['refund_id'])
                  <p>
                     <strong>Refund Id</strong>:
                     {{ @$data['bookingDataInformation']['getPaymentsInfo']['refund_id'] }}
                  </p>
                  @endif
                  <p>
                     <strong>Refund Amount</strong>:
                     ${{ @$data['bookingDataInformation']['getPaymentsInfo']['refund_amount'] }}
                  </p>
               @endif
            </div>
         </div>
         <div style="clear:both">
            <div class="table_res" style="max-width:100%; overflow:auto;">
               <table cellpadding="0" cellspacing="0" style="margin:5px 0 0; padding:0; width:100%; float:left;">
                  <tr>
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Booking ID</th>
                     @if(@$data['mail_send_to'] == 'T')
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Student</th>
                     @else
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Tutor</th>
                     @endif
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Date</th>
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Time</th>
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Grade</th>
                     <th style="padding:10px 4px; background:#d73c5e; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:capitalize;">Subject</th>
                  </tr>
                  <tr>
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{@$data['bookingDataInformation']['booking_no']}}</p>
                     </td>
                     @if(@$data['mail_send_to'] == 'T')
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{@$data['bookingDataInformation']['getStudent']['f_name']}}  {{@$data['bookingDataInformation']['getStudent']['l_name']}}</p>
                     </td>
                     @else
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p> {{@$data['bookingDataInformation']['getTutor']['f_name']}}  {{@$data['bookingDataInformation']['getTutor']['l_name']}}</p>
                     </td>
                     @endif
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{date('d-m-Y',strtotime(@$data['bookingDataInformation']['booking_date']))}}</p>
                     </td>
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{date('h:i a' ,strtotime(@$data['bookingDataInformation']['from_time_user']))}} - {{date('h:i a' ,strtotime(@$data['bookingDataInformation']['to_time_user']))}}</p>
                     </td>
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{@$data['bookingDataInformation']['getStudentGrade']['grade_name']}}</p>
                     </td>
                     <td style="padding:4px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
                        <p>{{@$data['bookingDataInformation']['getSubject']['subject']}}  </p>
                     </td>
                  </tr>
               </table>
            </div>
            <div class="testPro">
               <div class="proDiv">
                  <p style="font-style: italic !important;font-size:13px;"><b>Disclaimer:</b> V-Tutor acts solely as a facilitator and authorised payment agent between parents/students and tutors. All tutoring engagements are directly between the tutor and the parent/student. V-Tutor does not hold funds on trust and accepts no responsibility for tutoring outcomes once payment has been settled.  </p>
               </div>

               <div class="proDiv">
                   {{-- <h6>Please note:</h6>  --}}
                   <p style="font-style: italic !important;font-size:13px;font-weight: bold;"><b>Please note:</b> </p>
                   <p style="font-style: italic !important;font-size:13px;">1. You can join the session at your scheduled time. The tutor or meeting link may not be active if you join too early.</p>
                   <p style="font-style: italic !important;font-size:13px;">2. If you fail to join within 15 minutes of the scheduled start time, it will be marked as a ‘no show’, and session charges may be forfeited.</p>
                   <p style="font-style: italic !important;font-size:13px;">3. Session durations are fixed and cannot be extended under any circumstances. If a session is interrupted due to technical issues from the tutor’s end or the platform, it will be treated as ‘cancelled’, and charges will be refunded.</p>
                   <p style="font-style: italic !important;font-size:13px;">4. Please ensure a stable internet connection, test your audio/video, and join from a quiet, well-lit space for the best learning experience.</p>

               </div>
           </div>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 20px 0px 10px 0px;">Thanks & Regards,</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team V-Tutor</p>
            <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;"><a href="{{ url('/') }}">{{ url('/') }}</a></p>
            <p style="font-style: italic !important;font-size:13px;">This email and its attachments are confidential and intended only for the named recipient. If you received this message in error, please notify us immediately and delete it. Any unauthorized use, disclosure, or distribution is prohibited.</p>
         </div>
      </div>

   </body>
</html>
