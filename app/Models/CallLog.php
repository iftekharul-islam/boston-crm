<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    public function caller()
    {
        return $this->hasOne(User::class,'id', 'caller_id');
    }
}
