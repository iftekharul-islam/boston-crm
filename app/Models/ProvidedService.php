<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidedService extends Model
{
    use HasFactory;

//    protected $casts = [
//      "appraisal_type_fee" => 'array'
//    ];

    protected $fillable = [
      "order_id","appraiser_type_fee","total_fee","note"
    ];
}
