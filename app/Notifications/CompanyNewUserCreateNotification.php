<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyNewUserCreateNotification extends Notification implements ShouldQueue{
    use Queueable;

    protected string $name, $email, $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $name, $email, $password ) {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
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
