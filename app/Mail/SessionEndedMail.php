<?php

namespace App\Mail;
use App\Models\Session;
use Illuminate\Mail\Mailable;

class SessionEndedMail extends Mailable
{
    public function __construct(public Session $session) {}

    public function build()
    {
        return $this->subject("Session Completed: {$this->session->session_code}")
                    ->view('emails.session_ended')
                    ->with(['session' => $this->session]);
    }
}
