<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ResetPasswordNotification extends Notification {
	use Queueable;
	
	public $url;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct( string $url ) {
		$this->url = $url;
	}
	
	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function via( $notifiable ): array {
		return [ 'mail' ];
	}
	
	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return MailMessage
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function toMail( $notifiable ): MailMessage {
		return ( new MailMessage )->line( 'Forget Password?' )->action( 'Click to reset',
			$this->url )->line( 'This password reset link will expire in ' . config()->get( 'auth.verification.expire' ) . ' minutes. If you did not request a password reset, no further action is required.' );
	}
	
	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray( $notifiable ): array {
		return [//
		];
	}
}
