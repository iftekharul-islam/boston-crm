<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','appraiser_id','client_order_no','loan_no','loan_type','received_date','due_date',
        'technology_type','fha_case_no'
    ];
}
