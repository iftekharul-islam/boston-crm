<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ForgetPasswordRequest extends FormRequest {
    /**
     * @return string[]
     */
    #[ArrayShape( [ 'email' => "string" ] )] public function rules(): array {
        return [
            'email' => 'required | email',
        ];
    }
}
