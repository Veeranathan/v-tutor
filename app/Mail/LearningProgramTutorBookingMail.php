<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LearningProgramTutorBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $student;
    public $tutor;
    public $program;

    public $bookingDate;
    public $fromTime;
    public $toTime;
    public $timezone;

    public function __construct($booking, $student, $tutor, $program)
    {
        $this->booking = $booking;
        $this->student = $student;
        $this->tutor   = $tutor;
        $this->program = $program;

        $this->timezone = $tutor->timezone_id ?? 'Australia/Sydney';

        $fromDateTime = Carbon::parse(
            $booking->booking_date . ' ' . $booking->from_time,
            'UTC'
        )->setTimezone($this->timezone);

        $toDateTime = Carbon::parse(
            $booking->booking_date . ' ' . $booking->to_time,
            'UTC'
        )->setTimezone($this->timezone);

        $this->bookingDate = $fromDateTime->format('Y-m-d');
        $this->fromTime = $fromDateTime->format('h:i A');
        $this->toTime = $toDateTime->format('h:i A');
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor')
            ->to($this->tutor->email)
            ->subject('New Learning Program Booking - ' . $this->booking->booking_no)
            ->view('mail.academic-program-booking-tutor');
    }
}