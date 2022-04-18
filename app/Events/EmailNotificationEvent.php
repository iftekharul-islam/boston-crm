<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailNotificationEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $subject;
    public array $data;
    public object $user;

    /**
     * EmailNotificationEvent constructor.
     *
     * @param string $subject
     * @param object $user
     * @param array  $data
     */
    public function __construct(string $subject, object $user, array $data) {
        $this->subject = $subject;
        $this->data    = $data;
        $this->user    = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel
     */
    public function broadcastOn(): Channel|PrivateChannel {
        return new PrivateChannel('channel-name');
    }
}
