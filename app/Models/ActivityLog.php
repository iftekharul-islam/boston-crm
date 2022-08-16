<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    protected $casts = [
      // 'created_at' => 'date:m-d-Y H:i A'
    ];

    protected $fillable = [
      "order_id", "activity_text", "activity_by"
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'activity_by');
    }
}
