<?php

namespace App\Listeners;

use App\Events\EmailNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailNotificationListener implements ShouldQueue {
    use InteractsWithQueue;

    public string $user;
    public string $subject;

    /**
     * Handle the event.
     *
     * @param EmailNotificationEvent $event
     *
     * @return void
     */
    public function handle(EmailNotificationEvent $event) {
        $this->user    = $event->user;
        $this->subject = $event->subject;
        Mail::send('mail', $event->data['user'], function($message) {
            $message->to($this->user->email, $this->user->name)->subject($this->subject);
        });
        Mail::send('mail', $event->data['admin'], function($message) {
            $message->to(env('MAIL_FROM_ADDRESS'), 'Admin')->subject($this->subject);
        });
    }
}
