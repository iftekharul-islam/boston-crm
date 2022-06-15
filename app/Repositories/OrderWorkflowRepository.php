<?php

namespace App\Repositories;

use App\Models\OrderWInitialReview;
use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWInspection;

class OrderWorkflowRepository extends BaseRepository
{
    /**
     * @param OrderWInspection $owi_model
     */
    public function __construct(OrderWInspection $owi_model)
    {
        parent::__construct($owi_model);
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateOrderScheduleData($data): bool
    {
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

    /**
     * @param $data
     * @return bool
     */
    public function updateInitialReviewData($data): bool
    {
        $order_initial_review = OrderWInitialReview::updateOrCreate(
            ['id' => $data['initial_review_id']],
            [
                "order_id" => $data["order_id"],
                "assigned_to" => $data["assigned_to"],
                "note" => $data["note"],
                "is_review_done" => $data["is_review_done"] == "1" ? 1 : 0,
                "is_check_upload" => $data["is_check_upload"] == "1" ? 1 : 0,
                "created_by" => Auth::user()->id
            ]
        );
        $order = Order::find($data['order_id'])->forceFill([
            'workflow_status->initialReview' => 1
        ])->save();
        return $order && $order_initial_review;
    }
}
