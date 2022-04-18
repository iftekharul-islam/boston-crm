<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserCreateNotification extends Notification implements ShouldQueue {
    use Queueable;

    protected string $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( string $name ) {
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via( mixed $notifiable ): array {
        return [ 'mail' ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail( mixed $notifiable ): MailMessage {
        return ( new MailMessage )->subject( "New User Create" )->view( 'emails.new-user', [
                'name' => $this->name,
            ] );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray( mixed $notifiable ): array {
        return [];
    }
}
