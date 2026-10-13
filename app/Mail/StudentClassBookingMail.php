<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StudentClassBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function build()
    {
        $data['data'] = $this->request;
        $booking = $data['data']['bookingDataInformation'];
         Log::info("Building tutor mail");

        $startTime = Carbon::parse($booking['booking_date'] . ' ' . $booking['from_time_user'])->utc();
        $endTime = Carbon::parse($booking['booking_date'] . ' ' . $booking['to_time_user'])->utc();

        $uid = uniqid();
        $summary = 'V-Tutor Session - Booking ' . $booking['booking_no'];
        $description = 'Your session with V-Tutor. Please be on time and have Zoom ready.';
        $location = 'Online via Zoom';

        $icsContent = <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//V-Tutor//Booking Calendar//EN
CALSCALE:GREGORIAN
METHOD:REQUEST
BEGIN:VEVENT
UID:$uid
DTSTAMP:{$startTime->format('Ymd\THis\Z')}
DTSTART:{$startTime->format('Ymd\THis\Z')}
DTEND:{$endTime->format('Ymd\THis\Z')}
SUMMARY:$summary
DESCRIPTION:$description
LOCATION:$location
STATUS:CONFIRMED
SEQUENCE:0
BEGIN:VALARM
TRIGGER:-PT10M
ACTION:DISPLAY
DESCRIPTION:Reminder
END:VALARM
END:VEVENT
END:VCALENDAR
ICS;

        return $this->view('mail.student_class_booking_mail', $data)
            ->to($booking['getStudent']['email'])
            ->bcc(["academicsadmin@v-tutor.com.au", "opsadmin@v-tutor.com.au", "booking@v-tutor.com.au"])
            ->subject("V-Tutor - Booking Confirmation - " . $booking['booking_no'])
            ->from('booking@v-tutor.com.au', 'V-Tutor');
            // ->from('signup@v-tutor.com.au', 'V-Tutor')
            /* ->attachData($icsContent, 'booking.ics', [
                'mime' => 'text/calendar; charset=UTF-8; method=REQUEST',
            ]); */
    }
}
