<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssessmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessment;

    public function __construct($assessment, $isReminder = false)
    {
        $this->assessment = $assessment;
        $this->isReminder = $isReminder;
    }

    public function build()
    {
         $subject = $this->isReminder
            ? 'Reminder - Complete Your V-Tutor Student Assessment'
            : 'Complete Your V-Tutor Student Assessment';
            
        return $this->from('support@v-tutor.com.au', 'V-Tutor Student Assessment')
            ->to($this->assessment->email)
            ->cc([
                'marketing@v-tutor.com.au',
                'support@v-tutor.com.au',
                'marketing@v-tutor.com.au',
            ])
            ->subject($subject)
            ->view('mail.assessment_mail')
            ->with([
            'assessment' => $this->assessment,
            'signupUrl' => route('program.assessment.email.link',$this->assessment->token),
        ]);
    }

}
