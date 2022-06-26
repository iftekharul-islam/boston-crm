<?php

namespace App\Models;

use App\Models\ContactInfo;
use App\Models\BorrowerInfo;
use App\Models\PropertyInfo;
use App\Models\OrderWHistory;
use App\Models\OrderWRewrite;
use App\Models\OrderWRevision;
use App\Models\AppraisalDetail;
use App\Models\ProvidedService;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use App\Models\OrderWInitialReview;
use App\Models\OrderWReportAnalysis;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'orders';

    protected $appends = ['order_file_types', 'order_status'];

    protected $casts = [
      'due_date' => 'date:d M Y',
      'received_date' => 'date:d M Y',
      'created_at' => 'date:d M Y H:i A'
    ];

    protected $status_code = [
        [
            "Active" => 1,
            "Cancelled" => 2,
            "Deleted" => 3,
        ]
    ];

    public const OrderStatus = [
        0 => "To be schedule",
        1 => "Scheduled",
        2 => "Rescheduled",
        3 => "Inspected",
        4 => "Report Preparation & Initial Review",
        5 => "Ready for Analysis and Review",
        6 => "Check and Upload",
        7 => "Rewrite",
        8 => "Under Rewriting",
        9 => "Ready for Analysis and Review",
        10 => "Under Quality Assurance (E&O)",
        11 => "Ready for Submission/Delivery",
        12 => "Under Correction/Revision",
        13 => "Delivered",
        14 => "Cancelled",
        15 => "Deleted",
        16 => "Declined"
    ];

    protected $fillable = [
      "amc_id","lender_id","status","client_order_no","system_order_no","received_date","due_date"
    ];

    protected static function booted()
    {

    }


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

    public function getOrderStatusAttribute(){
        return self::OrderStatus[$this->status];
    }

    /**
     * @return string[]
     */
    public function getWorkflowStepsAttribute(): array
    {
        return array(
            'orderCreate' => 1,
            'scheduling' => 0,
            'reportPreparation'=> 0,
            'inspection'=> 0,
            'initialReview'=> 0,
            'reportAnalysisReview'=> 0,
            'reWritingReport'=> 0,
            'qualityAssurance'=> 0,
            'submission'=> 0,
            'revision'=> 0,
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

    public function inspection()
    {
        return $this->hasOne(OrderWInspection::class,'order_id','id');
    }

    public function report()
    {
        return $this->hasOne(OrderWReport::class,'order_id', 'id');
    }

    public function reportRewrite()
    {
        return $this->hasOne(OrderWRewrite::class,'order_id', 'id');
    }

    public function analysis()
    {
        return $this->hasOne(OrderWReportAnalysis::class,'order_id', 'id');
    }

    public function initialReview()
    {
        return $this->hasOne(OrderWInitialReview::class,'order_id', 'id');
    }

    public function qualityAssurance()
    {
        return $this->hasOne(OrderWQa::class,'order_id','id');
    }
    public function workHisotry()
    {
        return $this->hasMany(OrderWHistory::class,'order_id', 'id');
    }
    public function submission()
    {
        return $this->hasOne(OrderWSubmission::class,'order_id', 'id');
    }

    public function revission()
    {
        return $this->hasMany(OrderWRevision::class,'order_id', 'id');
    }

    public function comlist()
    {
        return $this->hasOne(OrderWComList::class,'order_id', 'id');
    }

    public function callLog()
    {
        return $this->hasMany(CallLog::class,'order_id', 'id');
    }
}
