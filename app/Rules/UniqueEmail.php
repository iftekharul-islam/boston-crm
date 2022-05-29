<?php

namespace App\Rules;

use App\Models\Client;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmail implements Rule
{
    protected $client_id;
    protected $client_emails;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
        ($this->client_id > 0) ? $this->client_emails = json_decode(Client::where('id','!=', $this->client_id)->pluck('email'),true)
            : $this->client_emails = json_decode(Client::pluck('email'),true);

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $passed = true;
        foreach ($this->client_emails as $email){
            $decoded_email = json_decode($email,true);
            if(array_intersect($value,$decoded_email)){
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
        return 'This email has already taken.';
    }
}
