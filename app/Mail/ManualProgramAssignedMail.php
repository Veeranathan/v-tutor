<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManualProgramAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $program;
    public $orderId;
    public $expiresAt;

    public function __construct($student, $program, $orderId, $expiresAt)
    {
        $this->student   = $student;
        $this->program   = $program;
        $this->orderId   = $orderId;
        $this->expiresAt = $expiresAt;
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor Learning Program')
            ->to($this->student->email)
            ->cc('support@v-tutor.com.au')
            ->subject('Learning Program Assigned Successfully')
            ->view('mail.manual-program-assigned');
    }
}