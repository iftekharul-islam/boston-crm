<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProfileUpdateRequest extends FormRequest
{
	/**
	 * @return string[]
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	#[ArrayShape( [
		'company_name' => "string",
		'user_name'         => "string",
		'address'      => "string",
		'city'         => "string",
		'state'        => "string",
		'zip_code'     => "string",
		'phone'        => "string",
		'image'        => "string"
	] )] public function rules(): array {
		return [
			'company_name' => 'required|string',
			'user_name'         => 'required|string',
//			'address'      => 'nullable|string',
//			'city'         => 'nullable|string',
//			'state'        => 'nullable|string',
//			'zip_code'     => 'nullable|string',
//			'phone'        => 'nullable|string',
//			'image'        => 'nullable|mimes:jpeg,jpg,png|max:' . config()->get('constants.image_file_size.max'),
		];
	}
}
