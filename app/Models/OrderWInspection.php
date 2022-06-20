<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderWInspection extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'inspection_date_time' => 'date:d M Y H:i A'
    ];

    protected $fillable = [
      'id','order_id','inspector_id','inspection_date_time','duration','note','created_by','updated_by'
    ];

    public function user(){
        return $this->belongsTo(User::class,'inspector_id','id');
    }

    public function createBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function attachments()
    {
        return $this->media()->where('collection_name', '=', 'inspection');
    }
}
