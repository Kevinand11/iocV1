<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function build()
    {
        return $this->view('emails.verify-email');
    }
}
