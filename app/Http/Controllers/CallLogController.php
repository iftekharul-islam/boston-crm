<?php

namespace App\Http\Controllers;

use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\Client;
use App\Models\LogTemplate;
use App\Models\Order;
use App\Models\OrderWInspection;
use App\Models\PropertyInfo;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Template\Template;

class CallLogController extends Controller
{
    use CrmHelper;
    protected OrderRepository $repository;

    public function __construct(OrderRepository $order_repository)
    {
        $this->repository = $order_repository;
    }

    public function index($id)
    {
        return CallLog::where('order_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found',
                'data' => ''
            ]);
        }

//        $logCompleted = CallLog::where('order_id', $id)->where('status', 1)->count();
//        $orderData = $this->orderDetails($id);
//        if($logCompleted){
//            return response()->json([
//                'error' => true,
//                'message' => 'Call log already completed',
//                'data' => $orderData
//            ]);
//        }

        $log = new CallLog();
        $log->order_id = $order->id;
        $log->caller_id = $request->caller_id ?? $user->id;
        $log->message = $request->message;
        $log->status = $request->status;
        $log->save();

        if($request->template) {
            $template = new LogTemplate();
            $template->title = $request->title;
            $template->message = $request->message;
            $template->save();
        }

        $msg = 'Call log created successfully';
        $historyTitle = 'Call log created with text : '. $log->message;
        if($log->status){
            $msg = 'Call log completed successfully';
            $historyTitle = 'Call log completed with text : '. $log->message;
        }
        $data = [
            "activity_text" => $msg,
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];

        $this->repository->addActivity($data);
        $this->addHistory($order, $user, $historyTitle, 'call-log');

        $templates = LogTemplate::all();
        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => 'Call log created successfully',
            'status' => 'success',
            'data' => $orderData,
            "templates" => $templates
        ];
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found',
                'data' => ''
            ]);
        }
        $msg = 'Call log updated successfully';

        if($request->message){
            $log = new CallLog();
            $log->order_id = $order->id;
            $log->caller_id = $user->id;
            $log->message = $request->message;
            $log->status = $request->status ? 1 : 0;
            $log->save();

            $historyTitle = 'Call log updated with text : '.$log->message;

            if($log->status){
                $msg = 'Call log completed successfully';
                $historyTitle = 'Call log completed with text : '. $log->message;
            }

            $this->addHistory($order, $user, $historyTitle, 'call-log');
        }

        if($request->template  == 'true') {
            $template = new LogTemplate();
            $template->title = $request->title;
            $template->message = $request->message;
            $template->save();
        }
        if($request->schedule == 'true'){
            $formated_date_time = \DateTime::createFromFormat('D M d Y H:i:s e+', $request->date);
            $deliveredDate = Carbon::parse($formated_date_time)->format('Y-m-d H:i:s');

            $order->call_date = Carbon::parse($deliveredDate);
            $order->call_by = $user->id;
            $order->save();

            $historyTitle = 'Call log updated with reminder : '. $deliveredDate;

            $this->addHistory($order, $user, $historyTitle, 'call-log');
        }

        $templates = LogTemplate::all();

        $data = [
            "activity_text" => $msg,
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];

        $this->repository->addActivity($data);

        $logData = CallLog::with('caller')->where('order_id', $id)->get();

        $user = auth()->user();
        $appraisers = $this->repository->getUserExpectRole(role: 'admin');;
        $companyId = $user->getCompanyProfile()->company_id;
        $data = '';
        $paginate = 10;
        $dateRange = '';
        $filterType = $request->filter ?? 'all';
        $order = $this->orderData($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->getFilterType();
        $myOrder = Order::with($this->order_list_relation())->where('id', $id)->first();
        return [
            'error' => false,
            'message' => 'Call log updated successfully',
            'status' => 'success',
            'data' => $logData,
            'order' => $order,
            'filterValue' => $filterValue,
            "templates" => $templates,
            'myOrder' => $myOrder
        ];
    }

    public function orderData($data, $companyId, $paginate, $dateRange, $filterType) {
        $orderId = null;
        $dataPropertyClient = false;
        if ($filterType == "completed") {
            $orderId = CallLog::where('status', 1)->get()->pluck('order_id')->toArray();
        } else if($filterType == "today_call") {
            $orderId = OrderWInspection::whereDate('inspection_date_time', '=', date('Y-m-d'))->get()->pluck('order_id')->toArray();
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
    protected function getFilterType() {
        $orders = Order::query();
        $all = $orders->count();
        $toBeSchedule = $orders->where('status', 0)->count();
        $schedule = Order::where('status', 1)->count();
        $completed = CallLog::where('status', 1)->count();
        $todaysCallId = OrderWInspection::whereDate('inspection_date_time', '=', date('Y-m-d'))->get()->pluck('order_id');
        $today_call = Order::whereIn('id', $todaysCallId)->where('status', "<", 3)->count();
        return [
            "all" => $all,
            "to_schedule" => $toBeSchedule,
            "schedule" => $schedule,
            "completed" => $completed,
            "today_call" => $today_call
        ];
    }

    public function template()
    {
        return LogTemplate::all();
    }
}
