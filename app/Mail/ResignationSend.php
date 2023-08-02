<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResignationSend extends Mailable
{
    use Queueable, SerializesModels;

    public $resignation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resignation)
    {
        $this->resignation = $resignation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.resignation_send')->with('resignation', $this->resignation)->subject('Ragarding to resignation letter.');
    }
}
