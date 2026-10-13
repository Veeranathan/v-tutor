<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminVerifyMail extends Mailable
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
        $this->request = $request;
    }

    public function build()
    {
        $data['data'] =  $this->request;

        
        if ($this->request['mailBody']=='forgotpassword') {
            $subject = 'Reset Password';
        }else{
            $subject = 'Reset Password';
        }
        // $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        return $this->view('mail.admin_verify_mail', $data)
                    // ->to($this->request['email'])
                    ->to("geekaaydev@gmail.com")
                    // ->bcc($bccArr)
                    ->subject($subject)
                     // ->from('noreply1@v-tutor.com.au', 'V-Tutor');
                    // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
                    ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
