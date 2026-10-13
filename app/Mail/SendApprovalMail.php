<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendApprovalMail extends Mailable
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
        
        // $bccArr = ["convergentinfowarepvtltd@gmail.com"];
        
        return $this->view('mail.send_approval', $data)
        ->to("academicsadmin@v-tutor.com.au")
        // ->bcc($bccArr)
        ->subject(@$data['data']['user']['unique_id']." ".@$data['data']['user']['email']." has submitted their application.")
        // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
        ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
