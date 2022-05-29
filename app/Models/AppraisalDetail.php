<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalDetail extends Model
{
    use HasFactory;

    protected $casts = [
        "due_date" => "date:d M Y",
        "received_date" => "date:d M Y",
    ];

    protected $fillable = [
        'order_id','appraiser_id','system_order_no','client_order_no','loan_no','loan_type','received_date','due_date',
        'technology_fee','fha_case_no'
    ];

    public function appraiser(){
        return $this->belongsTo(User::class);
    }

    public function loantype(){
        return $this->belongsTo(LoanType::class,'loan_type_id','id');
    }
}
