<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingTask extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'date:d M Y',
        'reminder' => 'date:d M Y H:i A'
    ];
}
