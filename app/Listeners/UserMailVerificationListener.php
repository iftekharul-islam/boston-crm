<?php

namespace App\Listeners;

use App\Events\UserMailVerificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserMailVerificationListener implements ShouldQueue {
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserMailVerificationEvent $event
     *
     * @return void
     */
    public function handle(UserMailVerificationEvent $event) {
        $event->user->sendEmailVerificationNotification();
    }
}
