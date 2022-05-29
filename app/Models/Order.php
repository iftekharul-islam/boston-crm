<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'orders';

    protected $appends = ['order_types'];

    protected $casts = [
      'due_date' => 'date:d M Y',
      'received_date' => 'date:d M Y'
    ];

    protected $fillable = [
      "amc_id","lender_id","status","client_order_no","system_order_no","received_date","due_date"
    ];

    /**
     * @return string[]
     */
    public function getOrderTypesAttribute(): array
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
}
