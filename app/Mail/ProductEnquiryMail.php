<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor Website')
            ->to([
                "tickets@v-tutor.p.tawk.email",
                "support@v-tutor.com.au",
                "veeravg2@gmail.com"
            ])
            ->subject('New Academic Product Enquiry')
            ->view('mail.product_enquiry_mail')
            ->with([
                'data' => $this->data
            ]);
    }
}

