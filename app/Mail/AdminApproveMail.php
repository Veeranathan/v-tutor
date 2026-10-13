<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminApproveMail extends Mailable
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
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        $data['data'] =  $this->request;
        $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        $subject = $data['data']['subject'];
        return $this->view('mail.admin_approve_mail', $data)
        ->to($data['data']['user']['email'])
        ->bcc($bccArr)
        ->subject("Tutor Application Approved")
        ->from('signup@v-tutor.com.au', 'V-Tutor');
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
    }
}
