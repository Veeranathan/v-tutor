<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class TutorClassBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function build()
    {
        $data['data'] =  $this->request;
        Log::info("Building tutor mail");

        return $this->view('mail.student_class_booking_mail', $data)
        ->to($data['data']['bookingDataInformation']['getTutor']['email'])
        ->subject("V-Tutor - Booking Confirmation - " . $data['data']['bookingDataInformation']['booking_no'])
        // ->subject("Booking Confirmation ".$data['data']['bookingDataInformation']['booking_no'])
        ->from('booking@v-tutor.com.au', 'V-Tutor');
        // ->from('signup@v-tutor.com.au', 'V-Tutor');
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
    }
}
