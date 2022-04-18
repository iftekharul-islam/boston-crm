<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProfileUpdateRequest extends FormRequest {
	/**
	 * Get the validation rules that apply to the request.
	 * Name is required and must be string type.
	 * Email is required and type must be email.
	 * Company name is required and must be string type.
	 * Phone number is nullable but have to numeric.
	 * Description is nullable and must be string.
	 * Image nullable
	 * Image supported formats are jpeg, jpg and png
	 * Image size maximum 2 mb
	 * @return array
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	#[ArrayShape( [ 'name'         => "string",
                    'email'        => "string",
                    'company_name' => "string",
                    'phone'        => "string",
                    'Description'  => "string",
                    'image'        => "string"
    ] )] public function rules(): array {
		return [
			'name'         => 'required|string',
			'email'        => 'required|email',
			'company_name' => 'required|string',
			'phone'        => 'nullable|phone:auto',
			'Description'  => 'nullable|string',
			'image'        => 'nullable|mimes:jpeg,jpg,png|max:' . config()->get( 'constants.image_file_size.max' ),
		];
	}
}
