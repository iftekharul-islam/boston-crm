<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message)
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New task mail')->view('emails.task-email', [
            'name' => $this->name,
            'message' => $this->message,
        ]);
    }
}
