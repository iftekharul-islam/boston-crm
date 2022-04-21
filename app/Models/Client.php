<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Client extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "client_type",
        "address",
        "city",
        "state",
        "country",
        "zip",
        "deducts_technology_fee",
        "fee_for_1004uad",
        "fee_for_1004d",
        "can_sign",
        "can_inspect",
        "instruction",
        "company_id"
    ];
}
