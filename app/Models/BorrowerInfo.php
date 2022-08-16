<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerInfo extends Model
{
    use HasFactory;

    protected $fillable = [
      "order_id","borrower_name","co_borrower_name","contact_email"
    ];
}
