<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class AppraisalTypeCreateRequest extends FormRequest
{
	 /**
		* Get the validation rules that apply to the request.
		*
		* @return array
		*/
	 #[ArrayShape([ 'form_type' => "string", 'modified_form' => "string" ])] public function rules(): array
	 {
			return [
				'form_type'     => 'required|string|unique:appraisal_types,form_type',
				'modified_form' => 'required|string',
			];
	 }
}
