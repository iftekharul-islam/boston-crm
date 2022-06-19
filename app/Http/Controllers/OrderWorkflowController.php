<?php

namespace App\Http\Controllers;

use App\Models\OrderWSubmission;
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

    public function updateOrderSchedule(Request $request)
    {
        $this->repository->updateOrderScheduleData($request->all());
        //code for set event on google calender
        //$this->service->setOrderSchedule($request->order_id);

        $order = Order::find($request->order_id);
        $user = auth()->user();
        if ($request->schedule_id > 0) {
            $message = 'Schedule updated successfully';
            $historyTitle = 'Schedule updated By ' . auth()->user()->name;
        } else {
            $message = 'Schedule createded successfully';
            $historyTitle = 'Schedule created By ' . auth()->user()->name;
        }

        $this->addHistory($order, $user, $historyTitle, 'scheduling');

        $orderData = $this->orderDetails($request->order_id);
        return [
            'message' => $message,
            'data' => $orderData
        ];
    }

    public function checkEvent()
    {
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


    public function uploadInspectionFiles(Request $request, $inspection_id)
    {
        $order_w_inspection = OrderWInspection::find($inspection_id);
        $data = $this->saveInspectionFiles($request->all(), $inspection_id);
        $order = Order::find($order_w_inspection->order_id);
        $user = auth()->user();
        $historyTitle = 'Inspection files uploaded by ' . auth()->user()->name;

        $this->addHistory($order, $user, $historyTitle, 'inspection');

        $orderData = $this->orderDetails($order->id);

        $order->status = 3;
        $order->save();

        return response([
            "file" => $data['media'],
            "data" => $orderData,
            "message" => "inspection file uploaded successfully"
        ]);
    }

    public function saveInspectionFiles($data, $inspection_id)
    {
        $inspection = OrderWInspection::find($inspection_id);
        if (!$inspection) {
            return false;
        }
        foreach ($data['files'] as $file) {
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

    public function storeAdminReportPreparation(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }
        $report = OrderWReport::where('order_id', $id)->first();
        if ($report) {
            $report->reviewed_by = $request->reviewed_by;
            $report->creator_id = $request->creator_id;
            $report->save();
            $historyTitle = "Report preparation updated by " . $user->name . ' on Report preparation section.';
        } else {
            $newReport = new OrderWReport();
            $newReport->order_id = $id;
            $newReport->reviewed_by = $request->reviewed_by;
            $newReport->creator_id = $request->creator_id;
            $newReport->created_by = $user->id;
            $newReport->save();
            $historyTitle = "Report preparation created by " . $user->name . ' on Report preparation section.';
        }

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reportPreparation'] = 1;
        $order->status = 4;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'report-preparation');
        $orderData = $this->orderDetails($id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function storeAssigneeReportPreparation(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $report = OrderWReport::where('order_id', $id)->first();
        if ($report) {
            $report->assigned_to = $request->assigned_to;
            $report->trainee_id = $request->trainee_id;
            $report->note = $request->note;
            $report->updated_by = auth()->user()->id;
            $report->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->savePreparationFiles($request->all(), $report->id);
            }

            $historyTitle = "Report preparation updated data by " . $user->name . ' on Report preparation section.';

            $workStatus = json_decode($order->workflow_status, true);
            $workStatus['reportPreparation'] = 1;
            $order->status = 4;
            $order->workflow_status = json_encode($workStatus);
            $order->save();

            $this->addHistory($order, $user, $historyTitle, 'report-preparation');
            $orderData = $this->orderDetails($id);
            return [
                'status' => 'success',
                'data' => $orderData
            ];
        }

        return response()->json([
            'error' => true,
            'message' => 'Report not available'
        ]);
    }

    public function savePreparationFiles($data, $id)
    {
        $report = OrderWReport::find($id);
        if (!$report) {
            return false;
        }
        foreach ($data['files'] as $file) {
            $report->find($id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('preparation');
        }

        return true;
    }

    public function storeReportAnalysis(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $analysis = OrderWReportAnalysis::where('order_id', $id)->first();
        if ($analysis) {
            if ($request->noteCheck == '1') {
                $analysis->is_review_send_back = 1;
                $analysis->is_check_upload = 0;
                $analysis->rewrite_note = $request->note;
            } else {
                $analysis->is_review_send_back = 0;
                $analysis->is_check_upload = 1;
                $analysis->note = $request->note;
            }
            $analysis->assigned_to = $request->assigned_to;
            $analysis->updated_by = auth()->user()->id;
            $analysis->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->saveAnalysisFiles($request->all(), $analysis->id);
            }

            $historyTitle = "Report analysis updated data by " . $user->name . ' on Report analysis and reviewed section.';
        } else {
            $newAnalysis = new OrderWReportAnalysis();
            $newAnalysis->order_id = $id;
            if ($request->noteCheck == '1') {
                $newAnalysis->is_review_send_back = 1;
                $newAnalysis->is_check_upload = 0;
                $newAnalysis->rewrite_note = $request->note;
            } else {
                $newAnalysis->is_review_send_back = 0;
                $newAnalysis->is_check_upload = 1;
                $newAnalysis->note = $request->note;
            }
            $newAnalysis->assigned_to = $request->assigned_to;
            $newAnalysis->created_by = auth()->user()->id;
            $newAnalysis->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->saveAnalysisFiles($request->all(), $id);
            }

            $historyTitle = "Report analysis created data by " . $user->name . ' on Report analysis and reviewed section.';
        }

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reportAnalysisReview'] = 1;
        $order->status = 9;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'report-analysis-review');
        $orderData = $this->orderDetails($id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function saveAnalysisFiles($data, $id)
    {
        $analysis = OrderWReportAnalysis::find($id);
        if (!$analysis) {
            return false;
        }
        foreach ($data['files'] as $file) {
            $analysis->find($id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('analysis');
        }
        return true;
    }

    public function saveInitialReview(Request $request)
    {
        $this->repository->updateInitialReviewData($request->all());
        $order = Order::find($request->order_id);
        $user = auth()->user();
        if ($request->initial_review_id > 0) {
            $message = 'Initial Review updated successfully';
            $historyTitle = 'Initial Review updated By ' . auth()->user()->name;
        } else {
            $message = 'Initial Review createded successfully';
            $historyTitle = 'Initial Review created By ' . auth()->user()->name;
        }

        $this->addHistory($order, $user, $historyTitle, 'initial-review');
        if ($request->is_review_done == 1){
            $order->status = 5;
        }
        if($request->is_check_upload == 1){
            $order->status = 6;
        }

        $orderData = $this->orderDetails($request->order_id);
        return response()->json([
            'message' => $message,
            'data' => $orderData
        ]);
    }

    public function saveQualityAssurance(Request $request)
    {
        $this->repository->saveQualityAssurance($request->all());
        return response()->json(['message' => 'Quality Assurance saved successfully']);
    }

    public function updateQualityAssurance(Request $request)
    {
        $this->repository->updateQualityAssurance($request->all());
        return response()->json(['message' => 'Quality Assurance updated successfully']);
    }

    public function rewriteReport(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
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
            $historyTitle = "New assignee assiged by " . $user->name . ' on the Re-writing the report section.';
        } else {
            $reWrite->updated_by = $user->id;
            $reWrite->updated_at = Carbon::now();
            $historyTitle = "Re-writing the report section updated by " . $user->name;
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

    public function revissinAdd(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
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
        $historyTitle = "New revission created by " . $user->name;

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

    public function revissinEdit(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $deliveredDate = Carbon::parse($get->date);

        $reWrite = OrderWRevision::where('order_id', $get->order_id)->where('id', $get->id)->first();
        if (!$order) {
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
        $historyTitle = "Revission has been updated by " . $user->name;

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

    public function revissinSolutionAdd(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
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

        $historyTitle = "Solution added for revission. Solution added by " . $user->name;

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

    public function revissinSolutionMarked(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
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

        $historyTitle = "Revission marked as delivered by " . $user->name;

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

    public function revissinSolutionDelete(Request $get)
    {
        $order = Order::find($get->order_id);
        $user = auth()->user();

        if (!$order) {
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

        $historyTitle = "Revission has been deleted by " . $user->name;
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

    public function storeSubmission(Request $request, $id)
    {
        logger($request->all());
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $submission = OrderWSubmission::where('order_id', $id)->first();
        if ($submission) {
            $submission->trainee_id = $request->trainee_id;
            $submission->delivery_man_id = $request->delivery_man_id;
            $submission->delivery_date = $request->delivery_date;
            $submission->is_trainee_signed = $request->is_trainee_signed ? 1 : 0;
            $submission->updated_by = auth()->user()->id;
            $submission->save();

            $historyTitle = "Workflow submission updated data by " . $user->name . ' on Workflow submission section.';
        } else {
            $newSubmission = new OrderWSubmission();
            $newSubmission->order_id = $order->id;
            $newSubmission->trainee_id = $request->trainee_id;
            $newSubmission->delivery_man_id = $request->delivery_man_id;
            $newSubmission->delivery_date = $request->delivery_date;
            $newSubmission->is_trainee_signed = $request->is_trainee_signed ? 1 : 0;
            $newSubmission->created_by = auth()->user()->id;
            $newSubmission->save();

            $historyTitle = "Workflow submission created data by " . $user->name . ' on Workflow submission section.';
        }

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['submission'] = 1;
        $order->status = 11;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'submission');
        $orderData = $this->orderDetails($id);
        return [
            'status' => 'success',
            'data' => $orderData
        ];
    }
}
