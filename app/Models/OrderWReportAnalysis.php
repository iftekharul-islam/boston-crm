<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderWReportAnalysis extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function attachments()
    {
        return $this->media()->where('collection_name', '=', 'analysis');
    }

}
