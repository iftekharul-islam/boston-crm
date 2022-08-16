<?php

namespace App\Http\Requests;

use App\Rules\UniqueEmail;
use App\Rules\UniquePhone;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ClientRequest extends FormRequest
{

    public function response(array $errors): \Illuminate\Http\RedirectResponse|array
    {
        return Redirect::back()->withErrors($errors)->withInput();
    }

    public function rules(): array
    {
        return [
            "name"                   => "required|unique:clients,name," . (int) $this->route('id'),
            "email"                  => ["required", "array", new UniqueEmail((int) $this->route('id'))],
            "phone"                  => ["required", "array", new UniquePhone((int) $this->route('id'))],
            "client_type"            => "required",
            "address"                => "required_if:client_type,lender,both",
            "city"                   => "required_if:client_type,lender,both",
            "state"                  => "required_if:client_type,lender,both",
            "zip"                    => "required_if:client_type,lender,both",
            "processing_fee"         => "required_if:client_type,amc,both",
            "deducts_technology_fee" => "required_if:client_type,amc,both",
            "fee_for_1004uad"        => "required_if:client_type,amc,both",
            "fee_for_1004d"          => "required_if:client_type,amc,both",
            "can_sign"               => "required_if:client_type,amc,both",
            "can_inspect"            => "required_if:client_type,amc,both",
            "com_required"           => "required_if:client_type,amc,both",
            "instruction"            => "nullable",
        ];
    }
}
