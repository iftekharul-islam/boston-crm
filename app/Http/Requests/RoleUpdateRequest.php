<?php

namespace App\Http\Requests;

use App\Rules\UniqueRoleUpdateRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape( [ 'name' => "array", 'permissions' => "string" ] )] public function rules(): array {
        return [
            'name'        => [
                'required',
                new UniqueRoleUpdateRule($this->id),
            ],
            'permissions' => 'nullable|array',
        ];
    }
}
