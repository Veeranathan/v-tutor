<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TafWWCCExpireReminder extends Mailable
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
        return $this->view('mail.taf_wwcc_expire_reminder')->to($email)->subject("Reminder: Your Working With Children Check (WWCC) is Expiring Soon")->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
