<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWInspection extends Model
{
    use HasFactory;

    protected $fillable = [
      'id','order_id','inspector_id','inspection_date','inspection_time','duration','note'
    ];
}
