<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWReport extends Model
{
    use HasFactory;


    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }
    
    public function trainee(){
        return $this->belongsTo(User::class, 'trainee_id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
