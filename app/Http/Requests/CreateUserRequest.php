<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{


    public function response(array $errors): \Illuminate\Http\RedirectResponse|array
    {
        return Redirect::back()->withErrors($errors)->withInput();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'password'  => 'required|confirmed|min:6',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string',
            'state'     => 'nullable|string',
            'zip_code'  => 'nullable|string',
            'email'     => 'unique:users|required|email',
            'phone'     => 'required',
            'role'      =>  'required',
            'image'     => 'nullable|mimes:jpeg,jpg,png|max:' . config()->get('constants.image_file_size.max'),
        ];
    }
}
