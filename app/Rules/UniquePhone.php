<?php

namespace App\Rules;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class UniquePhone implements Rule
{
    protected $client_id;
    protected $client_phones;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
        ($this->client_id > 0) ? $this->client_phones = json_decode(Client::where('id','!=', $this->client_id)->pluck('phone'),true)
            : $this->client_phones = json_decode(Client::pluck('phone'),true);

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passed = true;
        foreach ($this->client_phones as $phone){
            $decoded_phone = json_decode($phone,true);
            if(array_intersect($value,$decoded_phone)){
                $passed = false;
            }
        }
        return $passed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number has already taken.';
    }
}
