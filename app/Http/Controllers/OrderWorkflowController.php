<?php

namespace App\Http\Controllers;

use Zip;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWQa;
use App\Models\OrderWcom;
use App\Helpers\CrmHelper;
use App\Models\OrderWReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OrderWRevision;
use App\Models\OrderWRewrite;
use App\Models\OrderWSubmission;
use App\Models\OrderWInspection;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\JsonResponse;
use App\Models\OrderWReportAnalysis;
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
            'error' => false,
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
        if (!$order_w_inspection) {
            return response([
                "error" => true,
                "message" => "Please Create schedule first ! No schedule is set."
            ]);
        }
        $data = $this->saveInspectionFiles($request->all(), $inspection_id);
        $order = Order::find($order_w_inspection->order_id);
        $user = auth()->user();
        $historyTitle = 'Inspection files uploaded by ' . auth()->user()->name;

        $this->addHistory($order, $user, $historyTitle, 'inspection');

        $order->forceFill([
            'workflow_status->inspection' => 1,
            'status' => 3
        ])->save();

        $orderData = $this->orderDetails($order->id);

        return [
            "file" => $data['media'],
            "data" => $orderData,
            'error' => false,
            "message" => "Inspection file uploaded successfully"
        ];
    }

    public function saveInspectionFiles($data, $inspection_id)
    {
        $inspection = OrderWInspection::find($inspection_id);
        if (!$inspection) {
            return false;
        }
        $image_types = ['jpeg', 'jpg', 'png'];
        $zip_file = 'inspection-files.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($data['files'] as $key => $file) {
            if (in_array($file->getClientOriginalExtension(), $image_types)) {
                $zip->addFile($file);
            } else {
                $inspection->find($inspection_id)->addMedia($file)
                    ->toMediaCollection('inspection');
            }
        }
        $zip->close();

        $inspection->find($inspection_id)->addMedia($zip_file)->toMediaCollection('inspection');
        $inspection = OrderWInspection::with('attachments')->where('id', $inspection_id)->first();
        $historyTitle = "Order Inspection File Has Been Saved";

        return [
            'error' => false,
            'message' => $historyTitle,
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
            'error' => false,
            'message' => $historyTitle,
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
            $report->reviewed_by = $request->reviewed_by;
            $report->creator_id = $request->creator_id;
            $report->assigned_to = $request->assigned_to;
            $report->trainee_id = $request->trainee_id;
            $report->note = $request->note;
            $report->updated_by = auth()->user()->id;
            $report->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->savePreparationFiles($request->all(), $report->id);
            }

            $historyTitle = "Report preparation updated by " . $user->name . ' on Report preparation section.';
        } else {
            $newReport = new OrderWReport();
            $newReport->order_id = $order->id;
            $newReport->reviewed_by = $request->reviewed_by;
            $newReport->creator_id = $request->creator_id;
            $newReport->assigned_to = $request->assigned_to;
            $newReport->trainee_id = $request->trainee_id;
            $newReport->note = $request->note;
            $newReport->created_by = $user->id;
            $newReport->save();

            $historyTitle = "Report preparation updated data by " . $user->name . ' on Report preparation section.';

            $historyTitle = "Report preparation created by " . $user->name . ' on Report preparation section.';

            if (isset($request['files']) && count($request['files'])) {
                $this->savePreparationFiles($request->all(), $newReport->id);
            }
        }
        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reportPreparation'] = 1;
        $order->status = 4;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'report-preparation');
        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'status' => 'success',
            'data' => $orderData
        ];
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
            $analysis->updated_by = $user->id;
            $analysis->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->saveAnalysisFiles($request->all(), $analysis->id);
            }

            $historyTitle = "Report analysis updated by " . $user->name . ' on Report analysis and reviewed section.';
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
            $newAnalysis->created_by = $user->id;
            $newAnalysis->updated_by = $user->id;
            $newAnalysis->save();

            if (isset($request['files']) && count($request['files'])) {
                $this->saveAnalysisFiles($request->all(), $newAnalysis->id);
            }

            $historyTitle = "Report analysis created by " . $user->name;
        }

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reportAnalysisReview'] = 1;
        $order->status = 9;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'report-analysis-review');
        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'data' => $orderData
        ];
    }

    public function saveRewriteFiles($data, $id)
    {
        $rewrite = OrderWRewrite::find($id);
        if (!$rewrite) {
            return false;
        }
        foreach ($data['files'] as $file) {
            $rewrite->find($id)->addMedia($file)
                ->toMediaCollection('report-rewrite');
        }
        return true;
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
        $order = Order::find($request->order_id);
        $this->repository->updateInitialReviewData($request->all());
        $user = auth()->user();
        if ($request->initial_review_id > 0) {
            $message = 'Initial Review updated successfully';
            $historyTitle = 'Initial Review updated By ' . auth()->user()->name;
        } else {
            $message = 'Initial Review createded successfully';
            $historyTitle = 'Initial Review created By ' . auth()->user()->name;
        }

        $this->addHistory($order, $user, $historyTitle, 'initial-review');
        if ($request->is_review_done == 1) {
            $order->status = 5;
        }
        if ($request->is_check_upload == 1) {
            $order->status = 6;
        }

        $orderData = $this->orderDetails($request->order_id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'message' => $message,
            'data' => $orderData
        ];
    }

    public function saveQualityAssurance(Request $request)
    {
        $this->repository->saveQualityAssurance($request->all());

        $order = Order::find($request->order_id);
        $user = auth()->user();
        if ($request->qa_id > 0) {
            $message = 'Quality Assurance updated successfully';
            $historyTitle = 'Quality Assurance updated By ' . auth()->user()->name;
        } else {
            $message = 'Quality Assurance createded successfully';
            $historyTitle = 'Quality Assurance created By ' . auth()->user()->name;
        }

        $this->addHistory($order, $user, $historyTitle, 'quality-assurance');

        $order->forceFill([
            'workflow_status->qualityAssurance' => 1,
            'status' => 10
        ])->save();

        $orderData = $this->orderDetails($request->order_id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'message' => $message,
            'data' => $orderData
        ];
    }

    public function updateQualityAssurance(Request $request)
    {
        $this->repository->updateQualityAssurance($request->all());
        $order_qa = OrderWQa::find($request->qa_id);

        if (!$order_qa) {
            return response()->json([
                'error' => true,
                'message' => "There are no existing qa, or please reload once"
            ]);
        }

        $order = Order::find($order_qa->order_id);
        $user = auth()->user();
        if ($request->qa_id > 0) {
            $message = 'Quality Assurance updated successfully';
            $historyTitle = 'Quality Assurance updated By ' . auth()->user()->name;
        } else {
            $message = 'Quality Assurance createded successfully';
            $historyTitle = 'Quality Assurance created By ' . auth()->user()->name;
        }

        $this->addHistory($order, $user, $historyTitle, 'quality-assurance');

        $order->forceFill([
            'workflow_status->qualityAssurance' => 1,
            'status' => 10
        ])->save();

        $orderData = $this->orderDetails($order->id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'message' => $message,
            'data' => $orderData
        ];
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
        if (isset($get['files']) && count($get['files'])) {
            $this->saveRewriteFiles($get->all(), $reWrite->id);
        }

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['reWritingReport'] = 1;

        $order->status = 8;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'rewriting-report');
        $orderData = $this->orderDetails($get->order_id);

        return [
            'error' => false,
            'message' => $historyTitle,
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
            'error' => false,
            'message' => $historyTitle,
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
        $historyTitle = "Revision has been updated by " . $user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 12;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);
        return [
            'error' => false,
            'message' => $historyTitle,
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
                'message' => 'Order Revision Information Not Found'
            ]);
        }
        $reWrite->updated_at = Carbon::now();
        $reWrite->updated_by = $user->id;
        $reWrite->completed_by = $user->id;
        $reWrite->delivered_by = $user->id;
        $reWrite->status = 1;
        $reWrite->delivery_date = Carbon::now();
        $reWrite->solution_details = $get->revission['solution_details_edited'];
        $reWrite->save();

        $historyTitle = "Solution added for revision. Solution added by " . $user->name;

        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 13;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);

        return [
            'error' => false,
            'message' => $historyTitle,
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
                'message' => 'Order Revision Information Not Found'
            ]);
        }
        $reWrite->updated_at = Carbon::now();
        $reWrite->updated_by = $user->id;
        $reWrite->completed_by = $get->completed_by;
        $reWrite->status = 1;
        $reWrite->delivered_by = $get->delivered_by;
        $reWrite->delivery_date = Carbon::parse($get->delivery_date);
        $reWrite->solution_details = $get->solution_details;
        $reWrite->save();

        $historyTitle = "Revision marked as delivered by " . $user->name;


        $workStatus = json_decode($order->workflow_status, true);
        $workStatus['revision'] = 1;

        $order->status = 13;
        $order->workflow_status = json_encode($workStatus);
        $order->save();

        $this->addHistory($order, $user, $historyTitle, 'revision');
        $orderData = $this->orderDetails($get->order_id);

        return [
            'error' => false,
            'message' => $historyTitle,
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
                'message' => 'Order Revision Information Not Found'
            ]);
        }
        $reWrite->delete();

        $historyTitle = "Revision has been deleted by " . $user->name;

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
            'error' => false,
            'message' => $historyTitle,
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function storeSubmission(Request $request, $id)
    {
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
            'error' => false,
            'message' => $historyTitle,
            'status' => 'success',
            'data' => $orderData
        ];
    }

    public function saveCom(Request $request, $id)
    {
        $this->repository->saveCom($request->all(), $id);
        $orderData = $this->orderDetails($id);

        $order = Order::find($id);
        $user = auth()->user();
        $historyTitle = "Com list added by " . auth()->user()->name;
        $this->addHistory($order, $user, $historyTitle, 'quality-assurance');
        return [
            "message" => "Com list added successfully",
            "data" => $orderData
        ];
    }

    public function addCom(Request $request)
    {
        $this->repository->addCom($request->all());
        $orderData = $this->orderDetails($request->order_id);
        return [
            "message" => 'Destination updated',
            "data" => $orderData
        ];
    }

    public function checkClientOrderNo(Request $get)
    {
        $old = Order::where('client_order_no', $get->client_no)->first();
        if ($old) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
