<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Admin;

class DeleteAccountMail extends Mailable
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
        // return $this->view('view.name');

        $data['data'] =  $this->request;
        $subject = $data['data']['subject'];
        $admin = Admin::first();
        $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","booking@v-tutor.com.au"];
        return $this->view('mail.delete_account_mail', $data)
        ->to(@$data['data']['user']['email'])
        ->bcc($bccArr)
        // ->subject("Your vtutor account is deleted by admin!You will not be able to login into your vtutor account using your old email ".@$data['data']['user']['email'])
        ->subject(" Account Deleted ")

        // ->from('noreply1@v-tutor.com.au', 'V-Tutor');
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
        ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
