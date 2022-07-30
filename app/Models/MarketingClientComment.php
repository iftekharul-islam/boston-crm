<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingClientComment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'description', 'created_by'];

    protected $casts = [
        'created_at' => 'date:d M Y H:i A'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
