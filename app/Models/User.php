<?php

namespace App\Models;

use App\Auth\VerifyEmail;
use App\Models\CompanyUser;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
	use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];
	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];
	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	
	/**
	 * @return BelongsToMany
	 */
	public function companies(): BelongsToMany {
		return $this->belongsToMany(Company::class, 'company_users', 'user_id',
			'company_id')->using(CompanyUser::class)->withPivot('id', 'role_id', 'status', 'active_company',
			'join_date');
	}
	
	/**
	 * @param $user_id
	 * @param $company_id
	 *
	 * @return string
	 */
	public function getUserRole($user_id, $company_id): string {
		$role_id = CompanyUser::query()->where('company_id', $company_id)->where('user_id', $user_id)->pluck('role_id');
		$role    = Role::query()->where('id', $role_id)->pluck('name')->toArray();
		
		return implode(',', $role);
	}
	
	/**
	 * Send the email verification notification.
	 *
	 * @return void
	 */
	public function sendEmailVerificationNotification(): void {
		$this->notify(new VerifyEmail());
	}
	
//	/**
//	 * Send Password reset notification.
//	 *
//	 * @param $token
//	 *
//	 * @return void
//	 */
//	public function sendPasswordResetNotification($token): void {
//		$url = Config::get('app.url') . '/reset-password?token=' . $token . '&email=' . $this->email;
//		$this->notify(new ResetPasswordNotification($url));
//	}
	
	/**
	 * @return HasOne
	 */
	public function userProfile(): HasOne {
		return $this->hasOne(UserProfile::class);
	}


	public function getCompanyProfile(){
		return CompanyUser::where('user_id', $this->id)->first();
	}

}
