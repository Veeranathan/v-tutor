<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailCheck extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    public function __construct($request)
    {
        //
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $data['data'] =  $this->request;
        // dd($data['data']['email']);
        return $this->view('mail.send_mail', $data)
        ->to($data['data']['email'])
        ->subject("Hello from V-Tutor !Join us!")
        ->from("signup@v-tutor.com.au", 'V-Tutor');
    }
}
