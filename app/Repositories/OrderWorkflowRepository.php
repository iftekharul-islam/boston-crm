<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\OrderWInspection;
use Auth;

class OrderWorkflowRepository extends BaseRepository
{
    public function __construct(OrderWInspection $owi_model)
    {
        parent::__construct($owi_model);
    }

    public function updateOrderScheduleData($data){
        return OrderWInspection::create([
            "order_id" => $data["order_id"],
            "inspector_id" => $data["appraiser_id"],
            "inspection_date_time" => Carbon::parse($data["inspection_date_time"])->format('Y-m-d H:i:s'),
            "duration" => $data["duration"],
            "note" => $data["note"],
            "created_by" => Auth::user()->id
        ]);
    }
}
