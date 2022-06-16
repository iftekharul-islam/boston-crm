<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderWRewrite extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function assignee(){
        return $this->belongsTo(User::class,'assigned_to','id');
    }

    public function attachments()
    {
        return $this->media()->where('collection_name', '=', 'report_rewrite');
    }

}
