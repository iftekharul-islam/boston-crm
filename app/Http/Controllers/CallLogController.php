<?php

namespace App\Http\Controllers;

use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\Order;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    use CrmHelper;
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
                'message' => 'Order Information Not Found'
            ]);
        }

        $log = new CallLog();
        $log->order_id = $order->id;
        $log->caller_id = $user->id;
        $log->message = $request->message;
        $log->save();

        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => 'Call log created successfully',
            'status' => 'success',
            'data' => $orderData
        ];
    }
}
