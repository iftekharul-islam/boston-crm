<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Traits\HasRoles;

class CompanyUser extends Pivot {
    use HasRoles;

    protected $table = 'company_users';
    protected string $guard_name = 'web';
    protected $fillable = [
        'company_id',
        'user_id',
        'role_id',
        'status',
        'active_company',
        'join_date'
    ];
}
