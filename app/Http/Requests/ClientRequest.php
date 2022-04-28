<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
	 public function rules(): array
	 {
			return [
				"name"                   => "required",
				"email"                  => "required|unique:clients,email," . (int) $this->route( 'id' ),
				"phone"                  => "required|unique:clients,phone," . (int) $this->route( 'id' ),
				"client_type"            => "required",
				"address"                => "required_if:client_type,==,lender",
				"city"                   => "required_if:client_type,==,lender",
				"state"                  => "required_if:client_type,==,lender",
				"country"                => "required_if:client_type,==,lender",
				"zip"                    => "required_if:client_type,==,lender",
				"deducts_technology_fee" => "required_if:client_type,==,amc",
				"fee_for_1004uad"        => "required_if:client_type,==,amc",
				"fee_for_1004d"          => "required_if:client_type,==,amc",
				"can_sign"               => "required_if:client_type,==,amc",
				"can_inspect"            => "required_if:client_type,==,amc",
				"instruction"            => "nullable",
			];
	 }
}
