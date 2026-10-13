<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        $data['data'] =  $this->request;
        if(@$data['data']['mail_send_to'] == 'S'){
            $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        }else{
            $bccArr = ["vtutor@v-tutor.com.au"];
        }
        return $this->view('mail.cancel_booking_mail', $data)
        ->to(@$data['data']['email'])
        
            ->bcc($bccArr)
        
        // ->to($data['data']['bookingDataInformation']['getStudent']['email'])
        // ->bcc($data['data']['bookingDataInformation']['getTutor']['email'])
        ->subject("Booking Cancelled ".$data['data']['bookingDataInformation']['booking_no'])
        // ->from('noreply1@v-tutor.com.au', 'V-Tutor');
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
        ->from('booking@v-tutor.com.au', 'V-Tutor');
        // ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
