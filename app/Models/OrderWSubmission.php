<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWSubmission extends Model
{
    use HasFactory;

    public function trainee(){
        return $this->belongsTo(User::class,'trainee_id','id');
    }

    public function deliveryMan(){
        return $this->belongsTo(User::class,'delivery_man_id','id');
    }
}
