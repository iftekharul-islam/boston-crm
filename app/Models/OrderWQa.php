<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderWQa extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'effective_date' => 'date:d M Y',
        'updated_at' => 'date:d M Y h:i A'
    ];

    protected $fillable = [
        'order_id','note','effective_date','assigned_to','created_by','updated_by'
    ];

    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function attachments(){
        return $this->media()->where('collection_name', '=', 'qa');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
    public function updateBy() {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
