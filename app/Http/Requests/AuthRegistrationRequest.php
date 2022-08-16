<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Fortify\Rules\Password;

class AuthRegistrationRequest extends FormRequest {
	use PasswordValidationRules;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
    #[ArrayShape( [ 'full_name'    => "string",
                    'email'        => "string",
                    'password'     => "array",
                    'company_name' => "string"
    ] )] public function rules(): array {
		return [
			'full_name' => 'required|string|max:255',
			'email'     => 'required|string|email|unique:users,email',
			'password'  => $this->passwordRules(),
            'company_name' => 'required'
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
		];
	}

	/**
	 * Create new user
	 *
	 * @return User|Model
	 */
	public function commit(): Model|User {
		return User::query()->create( [
			'name'     => $this->get( 'full_name' ),
			'email'    => $this->get( 'email' ),
			'password' => Hash::make( $this->get( 'password' ) ),
		] );
	}
}
