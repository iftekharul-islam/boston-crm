<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyNewUserCreateNotification extends Notification implements ShouldQueue{
    use Queueable;

    protected string $email, $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $email, $code ) {
        $this->email    = $email;
        $this->code = $code;
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
        return ( new MailMessage )->subject( "New User Invite" )->view( 'emails.invite-new-user', [
            'email' => $this->email,
            'code' => $this->code,
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
        return [
        ];
    }
}
