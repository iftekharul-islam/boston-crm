<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Fortify\Rules\Password;

class ResetPasswordController extends Controller
{
	 use PasswordValidationRules;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;
	 
	 /**
		* Get the password reset validation rules.
		*
		* @return array
		*/
	 #[ArrayShape([ 'token' => "string", 'email' => "string", 'password' => "array" ])] protected function rules(): array
	 {
			return [
				'token' => 'required',
				'email' => 'required|email',
				'password' => $this->passwordRules(),
			];
	 }
	 
	 /**
		* Make password 6 digit minimum
		*
		* @return array
		*/
	 protected function passwordRules(): array {
			return [
				'required',
				'string',
				( new Password )->length( 6 ),
				'confirmed',
			];
	 }
}
