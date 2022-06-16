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
        if($data['initial_review_id'] > 0){
            $order_initial_review = OrderWInitialReview::find($data['initial_review_id']);
            $order_initial_review->updated_by = Auth::user()->id;
        }else{
            $order_initial_review = new OrderWInitialReview();
            $order_initial_review->created_by = Auth::user()->id;
        }
        $order_initial_review->order_id = $data["order_id"];
        $order_initial_review->assigned_to = $data["assigned_to"];
        $order_initial_review->note = $data["note"];
        $order_initial_review->is_review_done = $data["checkbox"] == "1" ? 1 : 0;
        $order_initial_review->is_check_upload = $data["checkbox"] == "2" ? 1 : 0;
        $order_initial_review->save();

        $order = Order::find($data['order_id'])->forceFill([
            'workflow_status->initialReview' => 1
        ])->save();
        return $order && $order_initial_review;
    }
}
