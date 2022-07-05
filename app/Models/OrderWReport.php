<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderWReport extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'updated_at' => 'date:d M Y H:i A'
    ];


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

    public function attachments()
    {
        return $this->media()->where('collection_name', '=', 'preparation') ?? [];
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
