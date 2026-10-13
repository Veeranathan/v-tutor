<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssessmentOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessment;

    /**
     * Create a new message instance.
     */
    public function __construct($assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor Student Assessment')
            ->to($this->assessment->email)
            ->subject('Your OTP to Access V-Tutor Student Assessment')
            ->view('mail.assessment_otp_mail')
            ->with([
                'assessment' => $this->assessment,
                'otp'        => $this->assessment->otp,
                'expiresAt'  => $this->assessment->otp_expires,
            ]);
    }
}
