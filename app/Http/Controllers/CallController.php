<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\OrderWInspection;
use Illuminate\Http\Request;
use App\Services\CallService;
use App\Repositories\OrderRepository;

class CallController extends BaseController
{
    protected OrderRepository $repository;
    protected CallService $callService;
    use CrmHelper;

    public function __construct(OrderRepository $order_repository,CallService $callService)
    {
        parent::__construct();
        $this->repository = $order_repository;
        $this->service = $callService;
    }

    public function index(Request $get)
    {
        $user = auth()->user();
        $appraisers = $this->repository->getUserByRoleWise(role: 'appraiser');
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $filterType = $get->filterType;
        $order = $this->orderData($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->getFilterType();
        return view('call.index', compact('order','appraisers', 'filterValue'));
    }

    public function orderData($data, $companyId, $paginate, $dateRange, $filterType) {
        $orderId = null;
        if ($filterType == "completed") {
            $orderId = CallLog::where('status', 1)->get()->pluck('order_id');
        } else if($filterType == "today_call") {
            $today = Carbon::today();
            $orderId = OrderWInspection::whereDate('inspection_date_time', $today)->get()->pluck('order_id');
        }

        $order = Order::where(function($qry) use ($data) {
            return $qry->where('system_order_no', "LIKE", "%$data%")
                       ->orWhere("client_order_no", "LIKE", "%$data%");
                    //    ->orWhere("received_date", "LIKE", "%$data%")
                    //    ->orWhere("amc_id", "LIKE", "%$data%")
                    //    ->orWhere("lender_id", "LIKE", "%$data%")
                    //    ->orWhere("company_id", "LIKE", "%$data%")
                    //    ->orWhere("due_date", "LIKE", "%$data%")
                    //    ->orWhere("created_at", "LIKE", "%$data%");
        })->with($this->order_call_list_relation())
        ->where('company_id', $companyId)
        ->when($orderId, function($qry) use ($orderId){
            return $qry->whereIn('id', $orderId);
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
        ->when($filterType, function($qry) use ($filterType) {
            if ($filterType == "to_schedule") {
                return $qry->where("status", 0);
            } else if($filterType == "schedule") {
                return $qry->where("status", 1);
            } else if($filterType == "today_call") {
                return $qry->where("status", "<", 3);
            }
        })
        ->orderBy('id', 'desc')
        ->paginate($paginate);
        return $order;
    }


    public function searchCallOrder(Request $get) {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $filterType = $get->filterType;
        $order = $this->orderData($data, $companyId, $paginate, $dateRange, $filterType);
        return $order;
    }

    protected function getFilterType() {
        $orders = Order::query();
        $all = $orders->count();
        $toBeSchedule = $orders->where('status', 0)->count();
        $schedule = Order::where('status', 1)->count();
        $completed = CallLog::where('status', 1)->count();
        $todaysCallId = OrderWInspection::whereDate('inspection_date_time', Carbon::today())->get()->pluck('order_id');
        $today_call = Order::whereIn('id', $todaysCallId)->where('status', "<", 3)->count();
        return [
            "all" => $all,
            "to_schedule" => $toBeSchedule,
            "schedule" => $schedule,
            "completed" => $completed,
            "today_call" => $today_call
        ];
    }


    public function sendMessage(Request $request)
    {
        $this->service->sendMessage($request->all());
        return [
            "message" => "Successfully sent"
        ];
    }

}
