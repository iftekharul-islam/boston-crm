<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderWRevision extends Model
{
    use HasFactory;

    protected $appends = ['users', 'open_solution', 'delivery_date_format', 'revision_date_format'];

    public function users() {
        return collect([
            "created_by" => User::where('id', $this->created_by)->first(),
            "updated_by" => User::where('id', $this->updated_by)->first(),
            "delivered_by" => User::where('id', $this->delivered_by)->first(),
            "completed_by" => User::where('id', $this->completed_by)->first(),
        ]);
    }

    public function getUsersAttribute()
    {
        return $this->users();
    }

    public function getDeliveryDateFormatAttribute()
    {
        return date('Y-m-d', strtotime($this->delivery_date));
    }

    public function getRevisionDateFormatAttribute()
    {
        return date('Y-m-d', strtotime($this->revision_date));
    }

    public function getOpenSolutionAttribute() {
        return false;
    }

    // public function created_by() {
    //     return $this->belongsTo(User::class, 'created_by', 'id');
    // }

    // public function updated_by() {
    //     return $this->belongsTo(User::class, 'updated_by', 'id');
    // }

    // public function delivered_by() {
    //     return $this->belongsTo(User::class, 'delivered_by', 'id');
    // }
}
