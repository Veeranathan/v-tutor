<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LearningProgramBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $student;
    public $tutor;
    public $program;

    public function __construct($booking, $student, $tutor, $program)
    {
        $this->booking = $booking;
        $this->student = $student;
        $this->tutor   = $tutor;
        $this->program = $program;
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor')
            ->to('support@v-tutor.com.au')
            ->subject('New Learning Program Booking - ' . $this->booking->booking_no)
            ->view('mail.academic-program-booking-notification');
    }
}