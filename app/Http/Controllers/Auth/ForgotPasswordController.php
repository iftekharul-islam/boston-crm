<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
	 /*
	 |--------------------------------------------------------------------------
	 | Password Reset Controller
	 |--------------------------------------------------------------------------
	 |
	 | This controller is responsible for handling password reset emails and
	 | includes a trait which assists in sending these notifications from
	 | your application to your users. Feel free to explore this trait.
	 |
	 */
	 use SendsPasswordResetEmails;
	 
	 /**
		* Validate the email for the given request.
		*
		* @param Request $request
		*
		* @return void
		*/
	 protected function validateEmail(Request $request): void
	 {
			$request->validate( [
				'email' => 'required|email|exists:users',
			], [
				'email.exists' => 'There is no account associated with the email you provided. Please enter a valid email address.',
			] );
	 }
}
