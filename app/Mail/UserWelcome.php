<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserWelcome extends Mailable
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
        $subject = $this->data['email_subject'];
        $email = $this->data['email'];
        // return $this->view('mail.teacher_verify')->subject($subject)->from(env('MAIL_USERNAME'), env('APP_NAME'));
        // $bccArr = ["academicsadmin@v-tutor.com.au","opsadmin@v-tutor.com.au","accountsupport@v-tutor.com.au","convergentinfowarepvtltd@gmail.com"];
        // $bccArr = ["convergentinfowaresolutionspvt@gmail.com"];
        return $this->view('mail.user_welcome')->to($email)->subject($subject)->from('signup@v-tutor.com.au', 'V-Tutor');
    }
}
