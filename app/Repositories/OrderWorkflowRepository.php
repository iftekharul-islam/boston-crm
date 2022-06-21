<?php

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWQa;
use App\Models\OrderWCom;
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

            $order->status = 2;
            $order->save();
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
        $order_workflow_schedule->inspection_date_time = Carbon::parse($data["inspection_date_time"])->format('Y-m-d H:i:s');
        $order_workflow_schedule->duration = $data["duration"];
        $order_workflow_schedule->note = $data["note"];
        $order_workflow_schedule->save();

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
        for($i = 0; $i < count($data); $i++){
            $com = new OrderWCom();
            $com->order_id = $id;
            $com->address = $data[$i]['address'];
            $com->lat = $data[$i]['lat'];
            $com->lng = $data[$i]['lng'];
            $com->serial = $i+1;
            $com->save();
        }
        return true;
    }

    public function addCom($data){
        $comSerial = OrderWCom::where('order_id',$data['order_id'])
            ->orderBy('serial','desc')
            ->first();
        $com = new OrderWCom();
        $com->order_id = $data['order_id'];
        $com->address = $data['address'];
        $com->lat = $data['lat'];
        $com->lng = $data['lng'];
        if($comSerial){
            $com->serial = $comSerial->serial + 1;
        }else{
            $com->serial = 1;
        }

        $com->save();

        return true;
}

    public function deleteCom($id){
        $order_w_com = OrderWCom::find($id);
        if($order_w_com){
            $order_w_com->delete();
        }
        return true;
    }
}
