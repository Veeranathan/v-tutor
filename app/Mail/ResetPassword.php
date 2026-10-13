<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
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
        $data['data'] =  $this->data;
        //dump($this->request);
        $subject=env('APP_NAME')." - Reset Password";
        // $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        return $this->view('mail.reset_password', $data)
                     ->to($this->data['email'])
                     // ->bcc($bccArr)
                     ->subject("Reset Password")

                     // ->from(env('MAIL_USERNAME'),env('APP_NAME'));
                     // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
                     ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
