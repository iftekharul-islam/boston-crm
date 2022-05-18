<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','appraiser_type_id','system_order_no','client_order_no','loan_no','loan_type','received_date','due_date',
        'technology_fee','fha_case_no'
    ];
}
