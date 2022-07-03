<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
      "order_id","search_address","street_name","city_name","state_name","zip","country","latitude","longitude",
        "unit_no"
    ];

    protected $appends = ['full_addr'];

    protected function getFullAddrAttribute() {
      return $this->street_name.", ". $this->unitNo().$this->city_name.", ".$this->zip;
    }

    protected function unitNo() {
        if ($this->unit_no) {
          return $this->unit_no.", ";
        }
        return "";
    }

}
