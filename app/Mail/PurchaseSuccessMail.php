<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $orderId;
    public $subTotal;
    public $gst;
    public $total;
    public $items;

    public function __construct($user, $orderId, $subTotal, $gst, $total, $items)
    {
        $this->user     = $user;
        $this->orderId  = $orderId;
        $this->subTotal = $subTotal;
        $this->gst      = $gst;
        $this->total    = $total;
        $this->items    = $items;
    }

    public function build()
    {
        return $this->from('support@v-tutor.com.au', 'V-Tutor Academic Program')
            ->to($this->user->email)
            ->cc('support@v-tutor.com.au')
            ->subject('V-Tutor Academic Program Purchase Successful – Order ' . $this->orderId)
            ->view('mail.purchase-success')
            ->with([
                'name'     => $this->user->parent_f_name ?? $this->user->name,
                'order_id' => $this->orderId,
                'subTotal' => $this->subTotal,
                'gst'      => $this->gst,
                'total'    => $this->total,
                'items'    => $this->items,
            ]);
    }
}