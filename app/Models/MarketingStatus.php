<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function client()
    {
        return $this->hasMany(MarketingClient::class,'status_id','id');
    }
}
