<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProgrammeSignupMail extends Mailable
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
        return $this->from('events@v-tutor.com.au', 'V-Tutor Events')
                    ->to($this->data['email']) 
                    ->subject('Registration Confirmed! V-Tutor Summer Holiday Camp 2025')
                    ->view('mail.programme_signup')
                    ->with(['data' => $this->data]);            
    }

}
