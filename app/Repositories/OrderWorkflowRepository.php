<?php

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWQa;
use App\Models\OrderWComList;
use App\Models\OrderWInspection;
use App\Models\OrderWInitialReview;

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
        $order = Order::find($data['order_id']);
        if ($data['schedule_id'] > 0) {
            $order_workflow_schedule = OrderWInspection::find($data['schedule_id']);
            $order_workflow_schedule->updated_by = Auth::user()->id;

            if (isset($data['reschedule_note'])) {
                $order_workflow_schedule->reschedule_note = $data['reschedule_note'];
                $order->status = 2;
                $order->save();
            }
        } else {
            $order_workflow_schedule = new OrderWInspection();
            $order_workflow_schedule->created_by = Auth::user()->id;

            $order->forceFill([
                'workflow_status->scheduling' => 1,
                'status' => 1
            ])->save();
        }
        $order_workflow_schedule->order_id = $data["order_id"];
        $order_workflow_schedule->inspector_id = $data["appraiser_id"];
        //$order_workflow_schedule->inspection_date_time = new \DateTime($data['inspection_date_time']);

        //formated from js date object
        $formated_date_time = \DateTime::createFromFormat('D M d Y H:i:s e+', $data['inspection_date_time']);
        $order_workflow_schedule->inspection_date_time = Carbon::parse($formated_date_time)->format('Y-m-d H:i:s');

        $order_workflow_schedule->duration = $data["duration"];
        $order_workflow_schedule->note = $data["note"];
        $order_workflow_schedule->save();

        return $order_workflow_schedule ? true : false;
    }


    public function deleteSchedule($schedule_id)
    {
        $order_workflow_schedule = OrderWInspection::find($schedule_id);
        $order_workflow_schedule->delete();
        return $order_workflow_schedule ? true : false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateInitialReviewData($data): bool
    {
        if ($data['initial_review_id'] > 0) {
            $order_initial_review = OrderWInitialReview::find($data['initial_review_id']);
            $order_initial_review->updated_by = Auth::user()->id;
        } else {
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

    public function saveQualityAssurance($data)
    {
        if ($data['qa_id'] > 0) {
            $order_quality_assurance = OrderWQa::find($data['qa_id']);
            $order_quality_assurance->updated_by = Auth::user()->id;
        } else {
            $order_quality_assurance = new OrderWQa();
            $order_quality_assurance->created_by = Auth::user()->id;
        }
        $order_quality_assurance->order_id = $data['order_id'];
        $order_quality_assurance->assigned_to = $data['assigned_to'];
        $order_quality_assurance->effective_date = Carbon::parse($data['effective_date'])->format('Y-m-d H:i:s');
        $order_quality_assurance->save();

        $order = Order::find($data['order_id'])->forceFill([
            'workflow_status->qualityAssurance' => 1
        ])->save();

        return $order && $order_quality_assurance;
    }

    public function updateQualityAssurance($data)
    {
        if ($data['qa_id'] > 0) {
            $order_quality_assurance = OrderWQa::find($data['qa_id']);
            $order_quality_assurance->updated_by = Auth::user()->id;
            $order_quality_assurance->note = $data['note'];
            if (isset($data['files'])) {
                foreach ($data['files'] as $file) {
                    $order_quality_assurance->addMedia($file)
                        ->toMediaCollection('qa');
                }
            }

            $order_quality_assurance->save();

            return $order_quality_assurance;
        }
    }

    public function saveCom($data, $id)
    {
        $order_w_com = OrderWComList::where('order_id', $id)->first();
        if ($order_w_com) {
            $com = $order_w_com;
        } else {
            $com = new OrderWComList();
        }
        if(isset($data['assigned_to'])){
            $com->assigned_to = $data['assigned_to'];
        }
        $com->order_id = $id;
        $com->destination = json_encode($data);
        $com->created_by = auth()->user()->id;
        $com->save();

        return $com;
    }

    public function saveComRoute($data,$com_id,$assigned_to){
        $order_w_com = OrderWComList::find($com_id);
        $order_w_com->destination = json_encode($data);
        $order_w_com->assigned_to = $assigned_to;
        $order_w_com->updated_by = auth()->user()->id;
        $order_w_com->save();

        return $order_w_com;
    }
}
