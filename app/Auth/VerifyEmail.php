<?php

namespace App\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailService;

class VerifyEmail extends VerifyEmailService {
	protected function verificationUrl( $notifiable ): string {
        // frontend_api_url use for api registration mail verify
		$frontend_api_url = Config::get( 'app.api_url' ) . '/auth/email/verify';
		$frontend_url = '/auth/email/verify';
		$verifyUrl   = URL::temporarySignedRoute( 'verification.verify',
			Carbon::now()->addMinutes( Config::get( 'auth.verification.email_expire', 60 ) ), [
				'id'   => $notifiable->getKey(),
				'hash' => sha1( $notifiable->getEmailForVerification() ),
			] );

        // frontend_api_url use for api url for vue registration mail verify
//		return $frontend_api_url . '?verify_url=' . urlencode( $verifyUrl );
		return $verifyUrl;
	}
}
