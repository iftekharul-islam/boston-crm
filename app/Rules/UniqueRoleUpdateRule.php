<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use JetBrains\PhpStorm\NoReturn;

class UniqueRoleUpdateRule implements Rule {
    protected ?\Illuminate\Contracts\Auth\Authenticatable $user;
    protected $userCompany;
    protected $roleNames;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    #[NoReturn] public function __construct( $id ) {
        $this->user        = auth()->user();
        $this->userCompany = $this->user->companies()->first();
        $this->roleNames   = $this->userCompany->roles()->where( 'id', '!=', $id )->pluck( 'name' )->toArray();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes( $attribute, $value ): bool {
        return ! in_array( $value, $this->roleNames );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string {
        return 'Role already exists.';
    }
}
