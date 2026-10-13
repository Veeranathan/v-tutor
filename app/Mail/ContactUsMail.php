<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Admin;

class ContactUsMail extends Mailable
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
        $data['admin_email'] = Admin::first();
        $bccArr = ["subhashini@itrobes.com"];
        if(@$data['admin_email']){
            $a_email = ["tickets@v-tutor.p.tawk.email","support@v-tutor.com.au"];
            return $this->view('mail.contact_us_mail', $data)
            ->to($a_email)
            ->bcc($bccArr)
            ->subject("Contact Us")

            // ->from(env('MAIL_USERNAME',env('MAIL_FROM_ADDRESS')), 'Vtutor');
            // ->from('noreply1@v-tutor.com.au', 'V-Tutor');
            // ->from(env('MAIL_FROM_ADDRESS'), 'V-Tutor');
            ->from('signup@v-tutor.com.au', 'V-Tutor');
        }

    }
}
