<?php
namespace App\Mail;
use App\Models\Session;
use Illuminate\Mail\Mailable;

class SessionStartedMail extends Mailable
{
    public function __construct(public Session $session) {}

    public function build()
    {
        return $this->subject("Session Started: {$this->session->session_code}")
                    ->view('emails.session_started')
                    ->with(['session' => $this->session]);
    }
}
