<?php

namespace App\Http\Controllers;

use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->addHistory($order, $user, $historyTitle, 'quality-assurance');

        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => 'Call log created successfully',
            'status' => 'success',
            'data' => $orderData
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

//        $logCompleted = CallLog::where('order_id', $id)->where('status', 1)->count();
//        $logData = CallLog::with('caller')->where('order_id', $id)->get();
//        if($logCompleted){
//            return response()->json([
//                'error' => true,
//                'message' => 'Call log already completed',
//                'data' => $logData
//            ]);
//        }

        $log = new CallLog();
        $log->order_id = $order->id;
        $log->caller_id = $user->id;
        $log->message = $request->message;
        $log->status = $request->status;
        $log->save();

        $msg = 'Call log updated successfully';
        $historyTitle = 'Call log updated with text : '. $log->message;
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
        $this->addHistory($order, $user, $historyTitle, 'quality-assurance');

        $logData = CallLog::with('caller')->where('order_id', $id)->get();
        return [
            'error' => false,
            'message' => 'Call log updated successfully',
            'status' => 'success',
            'data' => $logData
        ];
    }
}
