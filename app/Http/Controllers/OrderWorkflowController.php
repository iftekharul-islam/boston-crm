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
        //$this->service->setOrderSchedule($request->order_id);

        $order = Order::find($request->order_id);
        $user = auth()->user();
        $historyTitle = "Order Schedule Created by " . $user->name;

        $this->addHistory($order, $user, $historyTitle, 'scheduling');

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
    public function uploadInspectionFiles(Request $request, $inspection_id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if($request->has('public')){
            $inspection_id = base64_decode($inspection_id);
        }
        $data = $this->saveInspectionFiles($request->all(), $inspection_id);

        logger($data);

        if ($request->ajax()) {
            return response()->json([
                "file" => $data['media'],
                "message" => "inspection file uploaded successfully"
            ]);
        }
        return redirect()
            ->back()
            ->with(['success' => 'inspection file uploaded successfully']);
    }

    public function saveInspectionFiles($data, $inspection_id)
    {
        $inspection = OrderWInspection::find($inspection_id);
        if(!$inspection){
            return false;
        }
        foreach ($data['files'] as $file){
            $inspection->find($inspection_id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('inspection');
        }
        $inspection = OrderWInspection::with('attachments')->where('id', $inspection_id)->first();
        return [
            'status' => true,
            'media' => $inspection->attachments,
        ];
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

//        addHistory( $report, auth()->user()->id, 'report preparation created by', 'report-preparation' );

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

            if(isset($request['files']) && count($request['files'])) {
                $this->savePreparationFiles($request->all(), $report->id);
            }
//            addHistory( $report, auth()->user()->id, 'report preparation updated by', 'report-preparation' );

            return response()->json(['message' => 'Report updated successfully']);
        }

        return response()->json(['message' => 'Report not available']);

    }

    public function savePreparationFiles($data, $id)
    {
        $report = OrderWReport::find($id);
        if(!$report){
            return false;
        }
        foreach ($data['files'] as $file){
            $report->find($id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('preparation');
        }
        $report = OrderWReport::with('attachments')->where('id', $id)->first();
        return [
            'status' => true,
            'media' => $report->attachments,
        ];
    }

    public function storeReportAnalysis(Request $request, $id) {
        logger("hello from storeReportAnalysis");
        logger($request->all());
        $report = OrderWReportAnalysis::where('order_id', $id)->first();
        if($report){
            if($request->noteCheck == '1'){
                $report->is_review_send_back = 1;
                $report->is_check_upload = 0;
                $report->rewrite_note = $request->note;
            } else {
                $report->is_review_send_back = 0;
                $report->is_check_upload = 1;
                $report->note = $request->note;
            }
            $report->assigned_to = $request->assigned_to;
            $report->updated_by = auth()->user()->id;
            $report->save();

            if(isset($request['files']) && count($request['files'])){
                $this->saveAnalysisFiles($request->all(), $report->id);
            }

//            addHistory( $report, auth()->user()->id, 'report analysis created by', 'report-preparation' );

            return response()->json(['message' => 'Report Analysis updated successfully']);
        }

        $new = new OrderWReportAnalysis();
        $new->order_id = $id;
        if($request->noteCheck == '1'){
            $new->is_review_send_back = 1;
            $new->is_check_upload = 0;
            $new->rewrite_note = $request->note;
        } else {
            $new->is_review_send_back = 0;
            $new->is_check_upload = 1;
            $new->note = $request->note;
        }
        $new->assigned_to = $request->assigned_to;
        $new->created_by = auth()->user()->id;
        $new->save();

        if(isset($request['files']) && count($request['files'])){
            $this->saveAnalysisFiles($request->all(), $id);
        }

//        addHistory( $new, auth()->user()->id, 'report analysis updated by', 'report-analysis-review' );

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
        $analysis = OrderWReportAnalysis::with('attachments')->where('id', $id)->first();
        return [
            'status' => true,
            'media' => $analysis->attachments,
        ];
    }

    public function saveInitialReview(Request $request){
        $this->repository->updateInitialReviewData($request->all());
        return response()->json(['message' => 'Initial Review saved successfully']);
    }

    public function saveQualityAssurance(Request $request){
        $this->repository->saveQualityAssurance($request->all());
        return response()->json(['message' => 'Quality Assurance saved successfully']);
    }

    public function updateQualityAssurance(Request $request){
        $this->repository->updateQualityAssurance($request->all());
        return response()->json(['message' => 'Quality Assurance updated successfully']);
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

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reWritingReport'] = 1;

        $order->status = 8;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'rewriting-report');
        $orderData = $this->orderDetails($get->order_id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function revissinAdd(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $deliveredDate = Carbon::parse($get->date);

        $reWrite = new OrderWRevision();
        $reWrite->order_id = $order->id;
        $reWrite->created_at = Carbon::now();
        $reWrite->created_by = $user->id;
        $reWrite->updated_by = $user->id;
        $reWrite->revision_date = $deliveredDate;
        $reWrite->delivery_date = Carbon::now();
        $reWrite->revision_details = $get->revission;
        $reWrite->solution_details = "-";
        $reWrite->save();
        $historyTitle = "New revission created by ".$user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 12;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function revissinEdit(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $deliveredDate = Carbon::parse($get->date);

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->where('id', $get->id)->first();
        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Revission Information Not Found'
            ]);
        }

        $reWrite->updated_at = Carbon::now();
        $reWrite->updated_by = $user->id;
        $reWrite->revision_date = $deliveredDate;
        $reWrite->revision_details = $get->revission;
        $reWrite->solution_details = "-";
        $reWrite->save();
        $historyTitle = "Revission has been updated by ".$user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 12;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function revissinSolutionAdd(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->where('id', $get->revission['id'])->first();
        if (!$reWrite) {
            return response()->json([
                'error' => true,
                'message' => 'Order Revission Information Not Found'
            ]);
        }
        $reWrite->updated_at = Carbon::now();
        $reWrite->updated_by = $user->id;
        $reWrite->completed_by = $user->id;
        $reWrite->delivered_by = $user->id;
        $reWrite->delivery_date = Carbon::now();
        $reWrite->solution_details = $get->revission['solution_details_edited'];
        $reWrite->save();

        $historyTitle = "Solution added for revission. Solution added by ".$user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 13;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);

        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function revissinSolutionMarked(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->where('id', $get->id)->first();
        if (!$reWrite) {
            return response()->json([
                'error' => true,
                'message' => 'Order Revission Information Not Found'
            ]);
        }
        $reWrite->updated_at = Carbon::now();
        $reWrite->updated_by = $user->id;
        $reWrite->completed_by = $get->completed_by;
        $reWrite->delivered_by = $get->delivered_by;
        $reWrite->delivery_date = Carbon::parse($get->delivery_date);
        $reWrite->solution_details = $get->solution_details;
        $reWrite->save();

        $historyTitle = "Revission marked as delivered by ".$user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 13;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);

        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function revissinSolutionDelete(Request $get) {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->where('id', $get->id)->first();
        if (!$reWrite) {
            return response()->json([
                'error' => true,
                'message' => 'Order Revission Information Not Found'
            ]);
        }
        $reWrite->delete();

        $historyTitle = "Revission has been deleted by ".$user->name;
        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->first();
        if (!$reWrite) {
            $workStatus = json_decode($order->workflow_status, true);
            $workStatus['revision'] = 0;
            $order->workflow_status = json_encode($workStatus);
            $order->save();
        }

        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

}
