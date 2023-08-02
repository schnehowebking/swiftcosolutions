<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AwardSend extends Mailable
{
    use Queueable, SerializesModels;

    public $award;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($award)
    {
        $this->award = $award;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.award_send')->with('award', $this->award)->subject('Ragarding to  award letter to recognize an employee.');
    }
}
