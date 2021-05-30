<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractorRegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $contractor_registration;

    public function __construct($contractor_registration) {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('email.contractor_registration_success');
    }
}
