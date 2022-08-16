<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoanTypeCreateRequest extends FormRequest
{
	 /**
		* Get the validation rules that apply to the request.
		*
		* @return array
		*/
	 #[ArrayShape([ 'name' => "string" ])] public function rules(): array
	 {
			return [
				'name' => 'required|string|unique:loan_types,name',
			];
	 }
}
