<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','address','email','phone'
    ];

    public function comments()
    {
        return $this->hasMany(MarketingClientComment::class,'client_id','id');
    }

    public function tasks(){
        return $this->hasMany(MarketingTask::class,'client_id','id');
    }
}
