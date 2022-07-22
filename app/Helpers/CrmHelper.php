<?php

namespace App\Helpers;
use App\Models\OrderWInspection;
use App\Models\OrderWReport;
use App\Models\OrderWReportAnalysis;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderWHistory;

trait CrmHelper {

    public function flowMenu(){
        return [
            "scheduling" => "scheduling",
            "inspection" => "inspection",
            "reportPreparation" => "report-preparation",
            "initialReview" => "initial-review",
            "reportAnalysisReview" => "report-analysis-review",
            "reWritingReport" => "rewriting-report",
            "qualityAssurance" => "quality-assurance",
            "submission" => "submission",
            "revision" => "revision"
        ];
    }

    public function getSystemOrderNumber() {
        $order = Order::latest()->first();
        $length = 8;
        if ($order) {
            $orderLength = $order->id+1;
            $length = strlen($orderLength) < 8 ? 8 - strlen($orderLength) : 0;
            if ($length > 0) {
                return "BAS-".str_pad($order->id+1, $length, 0, STR_PAD_LEFT);
            } else {
                return "BAS-".$order->id+1;
            }
        } else {
            return "BAS-000001";
        }
    }

    protected function getOrderError($get, $type) {
        $error = false;
        $errorMessage = [];

        if ($type == "borrower") {
            $array_filter2 = [
                "borrower_name",
                // "co_borrower_name"
            ];
            foreach ($array_filter2 as $item) {
                if ($get->{$item} == null) {
                    $error = true;
                    array_push($errorMessage, $this->getTitleReplace($item)." is missing");
                }
            }
            if ($get->borrower_contact == false) {
                $error = true;
                array_push($errorMessage, $this->getTitleReplace('borrower_contact')." is missing");
            }
            if ($get->borrower_email == false) {
                $error = true;
                array_push($errorMessage, $this->getTitleReplace('borrower_email')." is missing");
            }
        } elseif ($type == "contactInfo") {
            $array_filter3 = [
                "contact_info",
                "contact_number",
                "email_address"
            ];
            if ($get->contact_info == null) {
                $error = true;
                array_push($errorMessage, "Enter contact Info");
            }
            if ($get->contact_number == false) {
                $error = true;
                array_push($errorMessage, "Choose contact number");
            }
            if ($get->email_address == false) {
                $error = true;
                array_push($errorMessage, "Choose email address");
            }
        } elseif ($type == "providerService") {
            // if ($get->note ==  null ) {
            //     $error = true;
            //     array_push($errorMessage, "Enter provider service note");
            // }
            if (count($get->data) == 0) {
                $error = true;
                array_push($errorMessage, "Please add services and fee");
            }
        }

        return [
            "error" => $error,
            "message" => $errorMessage,
        ];
    }

    protected function getTitleReplace($item) {
        return ucwords(str_replace("_", " ", $item));
    }

    protected function addHistory( $order, $user, $title, $type ) {
        $wkHistory = new OrderWHistory();
        $wkHistory->order_id = $order->id;
        $wkHistory->created_by = $user->id;
        $wkHistory->history = $title;
        $wkHistory->type = $type;
        $wkHistory->created_at = Carbon::now();
        $wkHistory->save();
    }

    protected function orderCallDetails($id) {
        $order = Order::with(
            'amc',
            'lender',
            'user',
            'appraisalDetail',
            'appraisalDetail.appraiser',
            'appraisalDetail.getLoanType',
            'providerService',
            'propertyInfo',
            'borrowerInfo',
            'contactInfo',
            'activityLog.user',
            'inspection.user',
            'inspection.attachments',
            'inspection.createBy',
            'analysis.assignee',
            'analysis.attachments',
            'analysis.updatedBy',
            'analysis.updateBy',
            'callLog.caller'
        )->where('id', $id)->first();

        return $order;
    }

    protected function orderDetails($id) {
        $order = Order::with(
            'amc',
            'lender',
            'user',
            'appraisalDetail',
            'appraisalDetail.appraiser',
            'appraisalDetail.getLoanType',
            'providerService',
            'propertyInfo',
            'borrowerInfo',
            'contactInfo',
            'activityLog.user',
            'inspection.user',
            'inspection.attachments',
            'inspection.createBy',
            'report.reviewer',
            'report.trainee',
            'report.createBy',
            'report.assignee',
            'report.creator',
            'report.attachments',
            'reportRewrite.assignee',
            'reportRewrite.updateBy',
            'reportRewrite.attachments',
            'analysis.assignee',
            'analysis.attachments',
            'analysis.updatedBy',
            'analysis.updateBy',
            'initialReview.assignee',
            'initialReview.createBy',
            'workHisotry.user',
            'revission',
            'submission.trainee',
            'submission.deliveryMan',
            'qualityAssurance.assignee',
            'qualityAssurance.attachments',
            'qualityAssurance.updatedBy',
            'comlist',
            'callLog.caller',
            'tickets.assignee',
            'tickets.solver',
            'tickets.creator',
            'tickets.updater',
        )->where('id', $id)->first();

        $order['inspection_files'] = isset($order['inspection']) && count($order['inspection']['attachments'])  ? OrderWInspection::where('order_id', $id)->first()->getMedia('inspection')->toArray() : [];
        $order['preparation_files'] = isset($order['report']) && count($order['report']['attachments']) ? OrderWReport::where('order_id', $id)->first()->getMedia('preparation')->toArray() : [];
        $order['analysis_files'] = isset($order['analysis']) && count($order['analysis']['attachments']) ? OrderWReportAnalysis::where('order_id', $id)->first()->getMedia('analysis')->toArray() : [];
        $order['diff_in_days'] = Carbon::now()->diffInDays($order->due_date,false);
        $order['diff_in_hours'] = Carbon::now()->diffInHours($order->due_date,false);

        return $this->checkActiveStep($order);
    }

    protected function checkActiveStep($order) {
        $orderStatus = [
            "orderCreate",
            "scheduling",
            "inspection",
            "reportPreparation",
            "initialReview",
            "reportAnalysisReview",
            "reWritingReport",
            "qualityAssurance",
            "submission",
            "revision"
        ];
        $currentStep = 'scheduling';
        $wkFlow = json_decode($order->workflow_status, true);

        foreach($orderStatus as $item) {
            if ($wkFlow[$item] == 0){
                $currentStep = $this->flowMenu()[$item];
                break;
            } else if ($wkFlow[$item] == 1 && $item == "scheduling") {
                $currentStep = "inspection";
            } else if($wkFlow[$item] == 1 && $item == "inspection") {
                $currentStep = "report-preparation";
            } else if($wkFlow[$item] == 1 && $item == "report-preparation") {
                $currentStep = "initial-review";
            } else if($wkFlow[$item] == 1 && $item == "initial-review") {
                $currentStep = "report-analysis-review";
            } else if($wkFlow[$item] == 1 && $item == "report-analysis-review") {
                $currentStep = "rewriting-report";
            } else if($wkFlow[$item] == 1 && $item == "rewriting-report") {
                $currentStep = "quality-assurance";
            } else if($wkFlow[$item] == 1 && $item == "quality-assurance") {
                $currentStep = "submission";
            } else if($wkFlow[$item] == 1 && $item == "submission") {
                $currentStep = "revision";
            }
        }
        $order['currentStep'] = $currentStep;
        if ($currentStep == "revision" && $order->revission->count() > 0) {
            $order['currentStep'] = false;
        }
        return $order;
    }

    protected function order_list_relation() {
        return [
            'user',
            'amc',
            'amc.attachments',
            'appraisalDetail',
            'appraisalDetail.appraiser',
            'appraisalDetail.getLoanType',
            'lender',
            'lender.attachments',
            'propertyInfo',
            'inspection.user',
            'callLog.caller',
            'contactInfo',
            'providerService'
        ];
    }

    protected function order_call_list_relation() {
        return [
            'user',
            'amc',
            'amc.attachments',
            'appraisalDetail',
            'appraisalDetail.appraiser',
            'appraisalDetail.getLoanType',
            'lender',
            'lender.attachments',
            'propertyInfo',
            'pendingTickets',
            'inspection.user',
            'callLog.caller',
            'providerService',
            'contactInfo',
            'borrowerInfo'
        ];
    }

}
