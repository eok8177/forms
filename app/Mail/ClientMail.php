<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The message instance.
     *
     * @var Message
     */
    public $data;

    /**
     * Create a new data instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->data['to'])
            ->from($this->data['from_email'], $this->data['from_name'])
            ->subject($this->data['subject'])
            ->view('email.client')->with([
                'msg' => $this->data['message'],
            ]);
    }
}
