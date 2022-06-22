<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Auth;

class Client extends Model implements HasMedia, Auditable
{
    use SoftDeletes, InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        "name",
        "email",
        "phone",
        "client_type",
        "address",
        "city",
        "state",
        "processing_fee",
        "zip",
        "deducts_technology_fee",
        "fee_for_1004uad",
        "fee_for_1004d",
        "can_sign",
        "can_inspect",
        "instruction",
        "company_id",
        "created_by"
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = json_encode($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = json_encode($value);
    }

    public function scopeFilterByCompany($query, $company_id)
    {
        return $query->where('company_id', $company_id);
    }

    public function scopeSearchFilters($query, $search_key, $company_id)
    {
        return $query->where(function ($q) use ($search_key, $company_id) {
            $q->orWhere('name', 'like', '%' . $search_key . '%')
                ->orWhere('email', 'like', '%' . $search_key . '%')
                ->orWhere('phone', 'like', '%' . $search_key . '%');
        })->where('company_id', $company_id);
    }

    public function scopeAmc($query)
    {
        return $query->where('client_type', 'amc');
    }

    public function scopeLender($query)
    {
        return $query->where('client_type', 'lender');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
