<?php

namespace App\Models;

use App\Models\ContactInfo;
use App\Models\BorrowerInfo;
use App\Models\PropertyInfo;
use App\Models\AppraisalDetail;
use App\Models\ProvidedService;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'orders';

    protected $appends = ['order_file_types'];

    protected $casts = [
      'due_date' => 'date:d M Y',
      'received_date' => 'date:d M Y'
    ];

    protected $status_code = [
        [
            "Active" => 1,
            "Cancelled" => 2,
            "Deleted" => 3,
        ]
    ];

    protected $fillable = [
      "amc_id","lender_id","status","client_order_no","system_order_no","received_date","due_date"
    ];

    /**
     * @return string[]
     */
    public function getOrderFileTypesAttribute(): array
    {
        return array(
            'Assessor Card','Binder for Inspection','Comparable Photos','Condo Questionnaires',
            'Floor Plan','Improvement List', 'Inspection Photos','Inspection Sheet','Master Deed',
            'Missing Photos', 'Offer to Purchase', 'Order Form','Permit', 'Property (MLS)', 'Public Record',
            'Purchase and Sales Agreement','Rehab List','Renovation List', 'Report Binder','Title',
            'Unit Deed','Zip File'
        );
    }

    public function amc()
    {
        return $this->belongsTo(Client::class,'amc_id','id');
    }

    public function lender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class,'lender_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    
    public function appraisalDetail()
    {
        return $this->belongsTo(AppraisalDetail::class, 'id', 'order_id');
    }
    
    public function providerService()
    {
        return $this->belongsTo(ProvidedService::class, 'id', 'order_id');
    }
    
    public function propertyInfo()
    {
        return $this->belongsTo(PropertyInfo::class, 'id', 'order_id');
    }

    public function borrowerInfo()
    {
        return $this->belongsTo(BorrowerInfo::class, 'id', 'order_id');
    }
   
    public function contactInfo()
    {
        return $this->belongsTo(ContactInfo::class, 'id', 'order_id');
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class,'order_id','id');
    }
}
