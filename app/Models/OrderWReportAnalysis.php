<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderWReportAnalysis extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts=[
        'updated_at' => 'date:d M Y h:i A',
    ];

    public function assignee(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by','id');
    }

    public function updateBy(){
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function attachments()
    {
        $data = $this->media()->where('collection_name', '=', 'analysis');
        return $data;
    }

}
