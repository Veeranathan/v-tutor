<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookFreeAssessmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessment;

    public function __construct($assessment)
    {
        $this->assessment = $assessment;
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor Team')
            ->to($this->assessment->email)
            ->cc('support@v-tutor.com.au')
            ->subject("Congrats from V-Tutor - You have taken the First Step")
            ->view('mail.book_free_assessment_mail')
            ->with([
                'assessment' => $this->assessment,
            ]);
    }
}