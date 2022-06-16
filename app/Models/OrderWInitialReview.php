<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWInitialReview extends Model
{
    use HasFactory;

    protected $fillable = [
      "order_id","assigned_to","note","is_review_done","is_check_upload","created_by","updated_by"
    ];

    public function assignee(){
        return $this->belongsTo(User::class,'assigned_to','id');
    }
}
