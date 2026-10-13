<?php
namespace App\Mail;
use App\Models\Session;
use Illuminate\Mail\Mailable;

class SessionReminderMail extends Mailable
{
    public function __construct(public Session $session) {}

    public function build()
    {
        return $this->subject("Reminder: Session {$this->session->session_code}")
                    ->view('emails.session_reminder')
                    ->with(['session' => $this->session]);
    }
}
