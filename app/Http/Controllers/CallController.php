<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\CallLog;
use App\Helpers\CrmHelper;
use App\Models\PropertyInfo;
use Illuminate\Http\Request;
use App\Jobs\TaskBasedReport;
use App\Services\CallService;
use App\Models\OrderWInspection;
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
        $timezone = $this->getTimeZone();
        $user = auth()->user();
        $appraisers = $this->repository->getUserByRoleWise(role: 'appraiser');
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $filterType = $get->filterType ?: 'to_schedule';
        $order = $this->orderData($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->getFilterType();
        return view('call.index', compact('order','appraisers', 'filterValue'));
    }

    public function orderData($data, $companyId, $paginate, $dateRange, $filterType) {
        $orderId = null;
        $dataPropertyClient = false;
        if ($filterType == "completed") {
            $orderId = CallLog::where('status', 1)->get()->pluck('order_id')->toArray();
        } else if($filterType == "today_call") {
            $orderId = OrderWInspection::whereDate('inspection_date_time', '=', Carbon::today())->get()->pluck('order_id')->toArray();
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
        ->when($filterType, function($qry) use ($filterType) {
            if ($filterType == "to_schedule") {
                return $qry->where("status", 0);
            } else if($filterType == "schedule") {
                return $qry->where("status", 1);
            } else if($filterType == "today_call") {
                return $qry->where("status", "<", 3);
            }
        })
        ->with($this->order_call_list_relation())
        ->where('company_id', $companyId)
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
        $todaysCallId = OrderWInspection::whereDate('inspection_date_time', '=', Carbon::today())->orderBy('id', 'desc')->get()->pluck('order_id');
        // dd($todaysCallId);
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
            "message" => "Message sent successfully !"
        ];
    }

}
