<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class LoanType extends Model implements Auditable
{
	 use SoftDeletes;
	 use \OwenIt\Auditing\Auditable;

	 protected $fillable = ['company_id', 'name', 'is_fha'];

	 /**
		* @return BelongsTo
		*/
	 public function company(): BelongsTo
	 {
			return $this->belongsTo(Company::class);
	 }
}
