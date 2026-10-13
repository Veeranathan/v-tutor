<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminAcceptTAFMail extends Mailable
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
        // dd($data);

        $subject = @$data['data']['subject'] ? $data['data']['subject'] : 'Tutor Application Accepted – Next Steps for Onboarding';
        $to = @$data['data']['taf_data']->primary_email ? $data['data']['taf_data']->primary_email : 'geekaaydev@gmail.com';
        return $this->view('mail.taf_accept_mail', $data)
            ->to($to)
            // ->to("gj@yopmail.com")
            ->subject($subject)
            ->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
