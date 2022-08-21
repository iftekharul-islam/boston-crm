<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\CallLog;
use App\Helpers\CrmHelper;
use App\Models\PropertyInfo;
use App\Models\OrderWInspection;

trait GlobalHelper {

    use CrmHelper;

    protected function orderCounter() {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;

        $all = Order::count();
        $toBeSchedule = Order::where('status', 0)->where('completed_status', null)->where('company_id', $companyId)->count();
        $schedule = Order::where('status', 1)->where('company_id', $companyId)->count();
        $completed_today = Order::whereDate('completed_date', "=", Carbon::today())->where('completed_status', 1)->where('company_id', $companyId)->count();
        $today_call = 0;

        $data = [
            "all" => $all,
            "to_schedule" => $toBeSchedule,
            "schedule" => $schedule,
            "completed" => $completed_today,
            "today_call" => $today_call
        ];
        return $data;
    }

    public function orderDataGlobal($data, $companyId, $paginate, $dateRange, $filterType) {
        $orderId = null;
        $dataPropertyClient = false;

        if ($data) {
            $orderIds = PropertyInfo::where('formatedAddress', 'LIKE', "%$data%")->get()->pluck('order_id')->toArray();
            $clientIds = Client::where("name", "LIKE", "%$data%")->get()->pluck('id')->toArray();
            $getAmcIds = Order::whereIn('amc_id', $clientIds)->pluck('id')->toArray();
            $getLenderIds = Order::whereIn('lender_id', $clientIds)->pluck('id')->toArray();
            $mergeOrder = array_merge($getAmcIds, $getLenderIds);
            $orderIds = array_unique(array_merge($orderIds, $mergeOrder));
            $newOrders = $orderIds;
            if (count($newOrders) > 0) {
                $orderId = $newOrders;
                $dataPropertyClient = true;
            }
        }

        if ($dataPropertyClient == false && ($data == null || $data == "") && $filterType == null) {
            $filterType = "to_schedule";
        }

        $order = Order::where(function($qry) use ($data, $orderId, $filterType, $dataPropertyClient) {
            if ($data) {
                return $qry->when($orderId, function($qrys) use ($orderId){
                                return $qrys->whereIn('id', $orderId);
                            })
                           ->orWhere(function($qry2) use ($data, $dataPropertyClient) {
                                if ($dataPropertyClient == false) {
                                    return $qry2->where('client_order_no', "LIKE", "%$data%")
                                                ->orWhere("system_order_no", "LIKE", "%$data%");
                                }
                           });
            } else {
                if ($orderId) {
                    $searchOrderId = $orderId;
                    return $qry->whereIn('id', $searchOrderId);
                }
            }
        })
        ->when($dateRange, function($qry) use ($dateRange) {
            $start = $dateRange['start'];
            $end = $dateRange['end'];
            if ($start && $end) {
                $startTime = Carbon::parse($start);
                $endTime = Carbon::parse($end);
                return $qry->whereDate('created_at', ">=", $startTime)->whereDate('created_at', "<=", $endTime);
            }
        })
        ->when($filterType, function($qry) use ($filterType, $orderId) {
            if ($filterType == "to_schedule") {
                return $qry->where("status", 0)->where("completed_status", null);
            } else if($filterType == "schedule") {
                return $qry->where("status", 1);
            } else if($filterType == "completed") {
                return $qry->where("completed_status", 1)->whereDate("completed_date", "=", Carbon::today());
            }
        })
        ->with($this->order_call_list_relation())
        ->where('company_id', $companyId)
        ->orderBy('id', 'desc')
        ->paginate($paginate);
        return $order;
    }

    public function completedOrders($data, $companyId, $paginate, $dateRange, $filterType){
        $orderId = null;
        $dataPropertyClient = false;

        $todaysOrder = OrderWInspection::whereDate('inspection_date_time', '=', Carbon::today())->get();
        $orderId = [];
        foreach ($todaysOrder as $item) {
            $t_logs = CallLog::where('order_id', $item->order_id)->where('status', 1)->first();
            if ($t_logs) {
                array_push($orderId, $item->order_id);
            }
        }
        if (count($orderId) == 0) {
            $orderId = null;
        }

        if ($data) {
            $orderIds = PropertyInfo::where('formatedAddress', 'LIKE', "%$data%")->get()->pluck('order_id')->toArray();
            $clientIds = Client::where("name", "LIKE", "%$data%")->get()->pluck('id')->toArray();
            $getAmcIds = Order::whereIn('amc_id', $clientIds)->pluck('id')->toArray();
            $getLenderIds = Order::whereIn('lender_id', $clientIds)->pluck('id')->toArray();
            $mergeOrder = array_merge($getAmcIds, $getLenderIds);
            $orderIds = array_unique(array_merge($orderIds, $mergeOrder));
            $newOrders = $orderIds;
            if (count($newOrders) > 0) {
                $orderId = $newOrders;
                $dataPropertyClient = true;
            }
        }

        if ($orderId == null) {
            return [];
        }

        $order = Order::where(function($qry) use ($data, $orderId, $filterType, $dataPropertyClient) {
            if ($data) {
                return $qry->when($orderId, function($qrys) use ($orderId){
                                return $qrys->whereIn('id', $orderId);
                            })
                           ->orWhere(function($qry2) use ($data, $dataPropertyClient) {
                                if ($dataPropertyClient == false) {
                                    return $qry2->where('client_order_no', "LIKE", "%$data%")
                                                ->orWhere("system_order_no", "LIKE", "%$data%");
                                }
                           });
            } else {
                if ($orderId) {
                    $searchOrderId = $orderId;
                    return $qry->whereIn('id', $searchOrderId);
                } else if($filterType == "today_call") {
                    $searchOrderId = $orderId ?? [];
                    return $qry->whereIn('id', $searchOrderId);
                }
            }
        })
        ->when($dateRange, function($qry) use ($dateRange) {
            $start = $dateRange['start'];
            $end = $dateRange['end'];
            if ($start && $end) {
                $startTime = Carbon::parse($start);
                $endTime = Carbon::parse($end);
                return $qry->whereDate('created_at', ">=", $startTime)->whereDate('created_at', "<=", $endTime);
            }
        })
        ->with($this->order_call_list_relation())
        ->where('company_id', $companyId)
        ->orderBy('id', 'desc')
        ->paginate($paginate);
        return $order;
    }

}
