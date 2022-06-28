<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;


    public function assignee()
    {
        return $this->hasOne(User::class,'id', 'assigned_to');
    }

    public function solver()
    {
        return $this->hasOne(User::class,'id', 'solution_by');
    }

    public function creator()
    {
        return $this->hasOne(User::class,'id', 'created_by');
    }

    public function updater()
    {
        return $this->hasOne(User::class,'id', 'updated_by');
    }
}
