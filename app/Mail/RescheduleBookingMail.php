<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RescheduleBookingMail extends Mailable
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
        $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        return $this->view('mail.reschedule_booking_mail', $data)
        ->to($data['data']['bookingDataInformation']['getStudent']['email'])
        ->bcc($bccArr)
        ->subject("Booking Rescheduled! Booking No :".$data['data']['bookingDataInformation']['booking_no'])

        // ->from(env('MAIL_USERNAME',env('MAIL_FROM_ADDRESS')), 'Vtutor');
        // ->from('noreply1@v-tutor.com.au', 'V-Tutor');
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
        ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
