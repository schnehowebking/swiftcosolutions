<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TerminationSend extends Mailable
{
    use Queueable, SerializesModels;

    public $termination;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($termination)
    {
        $this->termination = $termination;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.termination_send')->with('termination', $this->termination)->subject('Ragarding to termination letter.');
    }
}
