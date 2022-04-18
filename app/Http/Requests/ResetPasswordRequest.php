<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ResetPasswordRequest extends FormRequest {
    /**
     * @return string[]
     */
    #[ArrayShape( [ 'token' => "string", 'email' => "string", 'password' => "string" ] )] public function rules(
    ): array {
        return [
            'token'    => 'required|string',
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }
}
