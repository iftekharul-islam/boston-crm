<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Helpers\CrmHelper;
use App\Models\OrderWReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OrderWInspection;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\JsonResponse;
use App\Models\OrderWReportAnalysis;
use App\Models\OrderWRevision;
use App\Models\OrderWRewrite;
use App\Services\OrderWorkflowService;
use App\Repositories\OrderWorkflowRepository;


class OrderWorkflowController extends BaseController
{
    protected OrderWorkflowService $service;
    protected OrderWorkflowRepository $repository;
    use CrmHelper;

    public function __construct(OrderWorkflowService $order_w_service, OrderWorkflowRepository $order_w_repository)
    {
        parent::__construct();
        $this->service = $order_w_service;
        $this->repository = $order_w_repository;
    }

    public function updateOrderSchedule(Request $request){
        $this->repository->updateOrderScheduleData($request->all());
        //work for set event on google calender
        $this->service->setOrderSchedule($request->order_id);

        return response()->json(['message' => 'Schedule has been updated successfully']);
    }

    public function checkEvent(){
        //create a new event
//        $event = new Event;
//
//        $event->name = '580 E 2Nd St, Unit 3, Boston, Massachusetts, Suffolk, 02127 Safayet Hoque (Micelotta, Daniel 781-987-4946) ';
//        $event->description = 'Event description';
//        $event->startDateTime = Carbon::parse('2022-06-19 12:00');
//        $event->endDateTime = Carbon::parse('2022-06-19 13:00');
//        $event->location = '580 E 2Nd St, Unit 3, Boston, Massachusetts, Suffolk, 02127';
//        $event->colorId = 11;
//        $event->description = 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown';
//        $event->addAttendee(['email' => 'safayet.hoque@gmail.com']);
//        $event->save();
//
//        return \response()->json(['message' => 'success']);

        //Event::quickCreate('Appointment at Somewhere on July 1 10am-10:25am');
    }

    public function storeAdminReportPreparation(Request $request, $id) {
        logger("hello from storeAdminReportPreparation");
        logger($request->all());
        $report = OrderWReport::where('order_id', $id)->first();
        if($report){
            $report->reviewed_by = $request->reviewed_by;
            $report->creator_id = $request->creator_id;
            $report->save();
            return response()->json(['message' => 'Report updated successfully']);
        }
        $new = new OrderWReport();
        $new->order_id = $id;
        $new->reviewed_by = $request->reviewed_by;
        $new->creator_id = $request->creator_id;
        $new->created_by = auth()->user()->id;
        $new->save();

        return response()->json(['message' => 'Report created successfully']);

    }

    public function storeAssigneeReportPreparation(Request $request, $id) {
        logger("hello from storeAssigneeReportPreparation");
        logger($request->all());
        $report = OrderWReport::where('order_id', $id)->first();
        if($report){
            $report->assigned_to = $request->assigned_to;
            $report->trainee_id = $request->trainee_id;
            $report->note = $request->note;
            $report->updated_by = auth()->user()->id;
            $report->save();
            return response()->json(['message' => 'Report updated successfully']);
        }

        return response()->json(['message' => 'Report not available']);

    }
    public function storeReportAnalysis(Request $request, $id) {
        logger("hello from storeReportAnalysis");
        logger($request->all());
        $report = OrderWReportAnalysis::where('order_id', $id)->first();
        if($report){
            $report->note = $request->note;
            logger(gettype($request->noteCheck));
            if($request->noteCheck == '1'){
                logger('this is note 1');
                $report->is_review_send_back = 1;
                $report->is_check_upload = 0;
            } else {
                logger('this is note 2');
                $report->is_review_send_back = 0;
                $report->is_check_upload = 1;
            }
            $report->assigned_to = $request->assigned_to;
            $report->updated_by = auth()->user()->id;
            $report->save();

            $this->saveAnalysisFiles($request->all(), $report->id);

            return response()->json(['message' => 'Report Analysis updated successfully']);
        }
        
        $new = new OrderWReportAnalysis();
        $new->order_id = $id;
        $new->note = $request->note;
        if($request->noteCheck == '1'){
            $new->is_review_send_back = 1;
            $new->is_check_upload = 0;
        } else {
            $new->is_review_send_back = 0;
            $new->is_check_upload = 1;
        }
        $new->assigned_to = $request->assigned_to;
        $new->created_by = auth()->user()->id;
        $new->save();

        $this->saveAnalysisFiles($request->all(), $report->id);

        return response()->json(['message' => 'Report Analysis created successfully']);

    }

    public function saveAnalysisFiles($data, $id)
    {
        $analysis = OrderWReportAnalysis::find($id);
        if(!$analysis){
            return false;
        }
        foreach ($data['files'] as $file){
            $analysis->find($id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('analysis');
        }
        $analysis = OrderWInspection::with('attachments')->where('id', $id)->first();
        return [
            'status' => true,
            'media' => $analysis->attachments,
        ];
    }
    public function saveInitialReview(Request $request){
        $this->repository->updateInitialReviewData($request->all());
    }

    public function updateQa(Request $request){
        
    }

    public function rewriteReport(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();
        
        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }
        
        $reWrite = OrderWRewrite::where('order_id', $order->id)->first();
        if (!$reWrite) {
            $reWrite = new OrderWRewrite();
            $reWrite->order_id = $order->id;
            $reWrite->created_at = Carbon::now();
            $reWrite->created_by = $user->id;
            $reWrite->assigned_to = $get->assigned_to;
            $reWrite->save();
            $historyTitle = "New assignee assiged by ".$user->name.' on the Re-writing the report section.';
        } else {
            $reWrite->updated_by = $user->id;
            $reWrite->updated_at = Carbon::now();
            $historyTitle = "Re-writing the report section updated by ".$user->name;
        }

        $reWrite->note = $get->note;
        $reWrite->save();

        $order->status = 8;
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'rewriting-report');
        $orderData = $this->orderDetails($get->order_id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

}
