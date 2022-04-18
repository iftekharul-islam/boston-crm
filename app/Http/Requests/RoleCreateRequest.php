<?php

namespace App\Http\Requests;

use App\Rules\UniqueRoleCreateRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RoleCreateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape( [ 'name' => "array", 'permissions' => "string" ] )] public function rules(): array {
        return [
            'name'        => [
                'required',
                new UniqueRoleCreateRule(),
            ],
            'permissions' => 'nullable|array',
        ];
    }
}
