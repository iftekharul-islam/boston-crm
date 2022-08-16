<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'user_id',
		'address',
		'city',
		'state',
		'zip_code',
		'phone',
	];
	
	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
}
