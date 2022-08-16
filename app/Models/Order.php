<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\LoanType;
use App\Models\ContactInfo;
use App\Models\BorrowerInfo;
use App\Models\PropertyInfo;
use App\Models\OrderWHistory;
use App\Models\OrderWRewrite;
use App\Models\OrderWRevision;
use App\Models\AppraisalDetail;
use App\Models\ProvidedService;
use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use App\Models\OrderWInitialReview;
use App\Models\OrderWReportAnalysis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'orders';

    protected $appends = ['order_file_types', 'order_status', 'selected', 'extra_data', 'call_date_formatted', 'last_call'];

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
        5 => "Ready for Submission/Delivery",
        6 => "Check and Upload",
        7 => "Rewrite",
        8 => "Under Rewriting",
        9 => "Ready for Analysis and Review",
        10 => "Under Quality Assurance (E&O)",
        11 => "Delivered",
        12 => "Under Correction/Revision",
        13 => "Delivered",
        14 => "Cancelled",
        15 => "Deleted",
        16 => "Declined",
        17 => "Cancel With Payment",
        18 => "Cancel Without Payment",
        19 => "On Hold",
        20 => "Re-Active"
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

    public function getSelectedAttribute(){
        return false;
    }

    public function getLastCallAttribute(){
        $log = CallLog::where('order_id', $this->id)->first();
        return $log ? $log->created_at->format('d M Y h:i A') : null;
    }

    public function getCallDateFormattedAttribute(){
        return Carbon::parse($this->call_date)->format('d M Y h:i A');
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

    public function lender()
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
        return $this->belongsTo(ContactInfo::class, 'id', 'order_id')->withDefault([
            'contact' => '-'
        ]);
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class,'order_id','id');
    }

    public function inspection()
    {
        return $this->hasOne(OrderWInspection::class,'order_id', 'id')->orderBy('id', 'desc');
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
        return $this->hasMany(OrderWHistory::class,'order_id', 'id')->orderBy('id', 'desc');
    }
    public function submission()
    {
        return $this->hasOne(OrderWSubmission::class,'order_id', 'id');
    }

    public function revission()
    {
        return $this->hasMany(OrderWRevision::class,'order_id', 'id')->orderBy('status', 'asc');
    }

    public function comlist()
    {
        return $this->hasOne(OrderWComList::class,'order_id', 'id');
    }

    public function callLog()
    {
        return $this->hasMany(CallLog::class,'order_id', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'order_id', 'id');
    }

    public function pendingTickets() {
        return $this->hasMany(Ticket::class,'order_id', 'id')->where('status', 0);
    }

    protected function getLoanType($id) {
        $lonType = LoanType::find($id);
        return $lonType;
    }

    public function getExtraDataAttribute() {
        $appraiserDatails = $this->appraisalDetail;
        $propertyInfo = $this->propertyInfo;
        $borrowerInfo = $this->borrowerInfo;
        return [
            "client_order_no" => $this->client_order_no,
            "system_order_no" => $this->system_order_no,
            "loan_no" => $appraiserDatails->loan_no ?? '-',
            "receive_date" => date("d-m-Y", strtotime($this->received_date)),
            "due_date" => date("d-m-Y", strtotime($this->due_date)),
            "loan_type" => $appraiserDatails->getLoanType->name ?? '-',
            "fha_case_no" => $appraiserDatails ? $appraiserDatails->fha_case_no : '-',
            "appraiser_name" => $appraiserDatails->appraiser->name ?? '-',
            "property_type" => $appraiserDatails->propertyType->type ?? '-',
            "amc_name" => $this->amc->name,
            "technology_fee" => $appraiserDatails->technology_fee ?? '-',
            "lender" => $this->lender->name,
            "full_address" => $propertyInfo->full_addr,
            "state_name" => $propertyInfo->state_name,
            "area" => $propertyInfo->city_name,
            "unit_no" => $propertyInfo->unit_no,
            "street_name" => $propertyInfo->street_name,
            "zip_code" => $propertyInfo->zip,
            "latitude" => $propertyInfo->latitude,
            "longitude" => $propertyInfo->longitude,
            "county" => $propertyInfo->county,
            "provided_note" => $this->providerService->note,
            "borrower_name" => $borrowerInfo->borrower_name,
            "co_borrower_name" => $borrowerInfo->co_borrower_name,
            "contact_name" => $this->contactInfo->contact,
        ];
    }
}
