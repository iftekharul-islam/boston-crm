<?php

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWInspection;

class OrderWorkflowRepository extends BaseRepository
{
    public function __construct(OrderWInspection $owi_model)
    {
        parent::__construct($owi_model);
    }

    public function updateOrderScheduleData($data){
        $order_workflow_schedule = OrderWInspection::updateOrCreate(
            ['id' => $data['schedule_id']],
            [
                "order_id" => $data["order_id"],
                "inspector_id" => $data["appraiser_id"],
                "inspection_date_time" => Carbon::parse($data["inspection_date_time"])->format('Y-m-d H:i:s'),
                "duration" => $data["duration"],
                "note" => $data["note"],
                "created_by" => Auth::user()->id
            ]
        );
        $order = Order::find($data['order_id'])->forceFill([
            'workflow_status->scheduling' => 1
        ])->save();
        return $order && $order_workflow_schedule;
    }
}
