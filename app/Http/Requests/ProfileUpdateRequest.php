<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProfileUpdateRequest extends FormRequest
{
	public function rules(): array {
		return [
			'company_name' => 'required|string',
			'name'         => 'required|string',
			'address'      => 'nullable|string',
			'city'         => 'nullable|string',
			'state'        => 'nullable|string',
			'zip_code'     => 'nullable|string',
			'phone'        => 'nullable|phone:auto',
			'image'        => 'nullable|mimes:jpeg,jpg,png|max:' . config()->get('constants.image_file_size.max'),
		];
	}
}
