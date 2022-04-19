<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
		 'phone'
	 ];
	 
	 public function user()
	 {
			return $this->belongsTo(User::class);
	 }
}
