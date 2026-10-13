<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCloseAccountMail extends Mailable
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

        $subject = $data['data']['subject'];
        $admin = Admin::first();
        $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        // $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au"];
        return $this->view('mail.admin_close_account_mail', $data)
        ->to($data['data']['user']['email'])
        ->bcc($bccArr)
        ->subject("Account CLosed")
        ->from('signup@v-tutor.com.au', 'V-Tutor');
        // ->subject("Your vtutor account is closed by admin!You will not be able to login into your vtutor account using your old email ".@$data['data']['user']['email'])
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
        // ->from('no-reply@v-tutor.com.au', 'V-Tutor');
        // return $this->view('view.name');
    }
}
