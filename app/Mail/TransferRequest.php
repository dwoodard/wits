<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $transfers;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transfers)
    {
        $this->transfers = $transfers;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.transferRequest');
    }
}
