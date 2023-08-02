<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class CommonEmailTemplate extends Mailable
{
    use Queueable, SerializesModels;
    public $template;
    public $settings;
    public $mailTo;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $settings , $mailTo)
    {
        $this->template = $template;
        $this->settings = $settings;
        $this->mailTo = $mailTo;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     
        return $this->from($this->settings['company_email'], $this->mailTo)->markdown('email.common_email_template')->subject($this->template->subject)->with('content', $this->template->content);
    }
}