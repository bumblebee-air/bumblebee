<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $content;
    public $title;
    public $client;
    public function __construct($content, $title, $client = 'doorder')
    {
        $this->content = $content;
        $this->title = $title;
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.doorder_custom_notifications')->with(['content' => $this->content, 'client' => $this->client]);
    }
}
