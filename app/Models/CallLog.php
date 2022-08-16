<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d M Y h:i A'
    ];
    protected $appends = ['format_date'];

    public function getFormatDateAttribute(){
        return $this->created_at->format('d M Y h:i A');
    }


    public function caller()
    {
        return $this->hasOne(User::class,'id', 'caller_id');
    }
}
