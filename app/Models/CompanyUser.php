<?php

namespace App\Models;

use App\Models\Company;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyUser extends Pivot {
    use HasRoles;

    protected $table = 'company_users';

    protected string $guard_name = 'web';

    protected $fillable = [
        'company_id',
        'user_id',
        'role_id',
        'role_name',
        'status',
        'active_company',
        'join_date'
    ];

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
