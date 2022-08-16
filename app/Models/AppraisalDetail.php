<?php

namespace App\Models;

use App\Models\LoanType;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppraisalDetail extends Model
{
    use HasFactory;

    protected $casts = [
        "due_date" => "date:d M Y",
        "received_date" => "date:d M Y",
    ];

    protected $fillable = [
        'order_id','appraiser_id','system_order_no','client_order_no','loan_no','loan_type','received_date','due_date',
        'technology_fee','fha_case_no','property_type'
    ];

    public function appraiser(){
        return $this->belongsTo(User::class,'appraiser_id','id');
    }

    public function getLoanType(){
        return $this->belongsTo(LoanType::class,'loan_type','id');
    }

    public function loanType(){
        return LoanType::where('id', $this->loan_type)->first();
    }

    public function propertyType(){
        return $this->belongsTo(PropertyType::class,'property_type','id')->withDefault([
            'name' => '-'
        ]);
    }
}
