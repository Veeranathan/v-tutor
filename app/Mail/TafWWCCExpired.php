<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TafWWCCExpired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
         $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->data['email_subject'];
        $email = $this->data['email'];
        return $this->view('mail.taf_wwcc_expired')->to($email)->subject("Reminder: Your WWCC Expired")->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
