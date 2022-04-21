<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class InviteUserUpdateRequest extends FormRequest
{
	use PasswordValidationRules;
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	#[ArrayShape( [
		'name'     => "string",
		'password' => "array",
		'address'  => "string",
		'city'     => "string",
		'state'    => "string",
		'zip_code' => "string",
		'phone'    => "string",
		'image'    => "string",
	] )] public function rules(): array {
		return [
			'name'     => 'required|string|max:255',
			'password' => $this->passwordRules(),
			'address'  => 'nullable|string',
			'city'     => 'nullable|string',
			'state'    => 'nullable|string',
			'zip_code' => 'nullable|string',
			'phone'    => 'nullable|string',
			'image'    => 'nullable|mimes:jpeg,jpg,png|max:' . config()->get('constants.image_file_size.max'),
		];
	}
}
