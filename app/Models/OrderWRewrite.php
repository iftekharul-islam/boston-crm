<?php

namespace App\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderWRewrite extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'updated_at' => 'date:d M Y H:i A'
    ];

    public function assignee(){
        return $this->belongsTo(User::class,'assigned_to','id');
    }

    public function attachments()
    {
        return $this->media()->where('collection_name', '=', 'report-rewrite');
    }

    public function updateBy() {
        return $this->belongsTo(User::class,'created_by','id');
    }

}
