<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEvent {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($user) {
		$this->user = $user;
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
