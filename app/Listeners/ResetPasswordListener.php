<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Password;

class ResetPasswordListener {
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
	 * @param ResetPasswordEvent $event
	 *
	 */
	public function handle( ResetPasswordEvent $event ) {
		Password::sendResetLink( [ 'email' => $event->user->email ] );
	}
}
