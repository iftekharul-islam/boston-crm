<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d M Y H:i A'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
