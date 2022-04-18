<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CheckEmailExistRequest extends FormRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	#[ArrayShape( [ 'email' => "string" ] )] public function rules(): array {
		return [
			'email' => 'required | email',
		];
	}
}
