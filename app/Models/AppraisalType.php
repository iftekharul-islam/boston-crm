<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AppraisalType extends Model implements Auditable
{
	 use SoftDeletes;
	 use \OwenIt\Auditing\Auditable;
	 
	 protected $fillable = ['company_id', 'form_type', 'modified_form'];
	 
	 /**
		* @return BelongsTo
		*/
	 public function company(): BelongsTo
	 {
			return $this->belongsTo(Company::class);
	 }
}
