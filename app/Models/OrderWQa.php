<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWQa extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','note','effective_date','assigned_to','created_by','updated_by'
    ];
}
