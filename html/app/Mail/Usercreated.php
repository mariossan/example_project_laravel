<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Usercreated extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Welcome';
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $message )
    {
        $this->msg = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view( 'admin.mails.user-created' )->subject( $this->subject );
    }
}
