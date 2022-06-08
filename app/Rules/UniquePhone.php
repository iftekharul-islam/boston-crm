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
        ($this->client_id > 0) ? $this->client_phones = json_decode(Client::whereNotNull('phone')->where('id','!=', $this->client_id)->pluck('phone'),true)
            : $this->client_phones = json_decode(Client::whereNotNull('phone')->pluck('phone'),true);

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
        if($this->array_has_duplicates($value)){
            return false;
        }
        foreach ($this->client_phones as $phone){
            $decoded_phone = !is_array($phone) ? [$phone] : json_decode($phone, true);
            foreach ($decoded_phone as $phoneStr){
                $d_phone = json_decode($phoneStr);
                if(array_intersect($d_phone, $value)) {
                    $passed = false;
                }
            }
        }
        return $passed;
    }

    /**
     * @param $array
     * @return bool
     */
    public function array_has_duplicates($array): bool
    {
        return count($array) !== count(array_unique($array));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number has already taken/duplicate phone.';
    }
}
