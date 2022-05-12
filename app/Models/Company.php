<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model implements Auditable
{
	 use SoftDeletes;
	 use \OwenIt\Auditing\Auditable;
	 use HasRoles;
	 
	 protected $fillable = [
		 'name',
		 'address',
		 'contact',
		 'status',
		 'owner_id',
		 'description',
	 ];
	 protected string $guard_name = 'web';
	 
	 /**
		* @return BelongsToMany
		*/
	 public function users(): BelongsToMany
	 {
			return $this->belongsToMany( User::class, 'company_users', 'company_id',
				'user_id' )->using( CompanyUser::class )->withPivot( 'id', 'role_id', 'status', 'active_company', 'join_date' );
	 }
	 
	 /**
		* @return HasMany
		*/
	 public function appraisalTypes(): HasMany
	 {
			return $this->hasMany( AppraisalType::class );
	 }
	 
	 /**
		* @return HasMany
		*/
	 public function loanTypes(): HasMany
	 {
			return $this->hasMany( LoanType::class );
	 }
}
