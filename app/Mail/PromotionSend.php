<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromotionSend extends Mailable
{
    use Queueable, SerializesModels;

    public $promotion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.promotion_send')->with('promotion', $this->promotion)->subject('Ragarding to job promotion congratulation letter.');
    }
}
