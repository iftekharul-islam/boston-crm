<?php

namespace App\Models;

use App\Helpers\CrmHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

class OrderWInspection extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, CrmHelper;

    protected $casts = [
        'created_at' => 'date:d M Y',
        'updated_at' => 'date:d M Y H:i A'
    ];
    protected $appends = ['inspection_date_time_formatted'];
    
    protected $fillable = [
      'id','order_id','inspector_id','inspection_date_time','duration','note','created_by','updated_by'
    ];

    public function getInspectionDateTimeFormattedAttribute() {
        $formatedDate = Carbon::parse($this->attributes['inspection_date_time'])->format('d M Y h:i A');
        return $formatedDate;
    }

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
