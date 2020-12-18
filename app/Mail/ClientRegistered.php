<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Vanguard\User;

class ClientRegistered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $token;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = sprintf("[%s] %s", setting('app_name'), __('You are registered'));

        return $this->subject($subject)->markdown('mail.client-registered')->with(['user' => $this->user]);
    }
}
