<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\CallLog;
use App\Helpers\CrmHelper;
use App\Models\LogTemplate;
use App\Models\PropertyInfo;
use App\Traits\GlobalHelper;
use Illuminate\Http\Request;
use App\Models\OrderWInspection;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use SebastianBergmann\Template\Template;

class CallLogController extends Controller
{
    use CrmHelper, GlobalHelper;
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

        if(!$order->completed_status){
            $order->completed_status = 1;
            $order->completed_date = Carbon::now();
            $order->save();
        }

        $msg = 'Call log updated successfully';

        if($request->message){
            $log = new CallLog();
            $log->order_id = $order->id;
            $log->caller_id = $request->caller_id ?? $user->id;
            $log->message = $request->message;
            $log->status = 1;
            $log->save();

            $historyTitle = 'Call log updated with text : '.$log->message;

            if($log->status){
                $msg = 'Call log completed successfully';
                $historyTitle = 'Call log completed with text : '. $log->message;
            }

            $this->addHistory($order, $user, $historyTitle, 'call-log');
        }

        if($request->template == 'true') {
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

        if(!$order->completed_status){
            $order->completed_status = 1;
            $order->completed_date = Carbon::now();
            $order->save();
        }


        if($request->message){
            $log = new CallLog();
            $log->order_id = $order->id;
            $log->caller_id = $user->id;
            $log->message = $request->message;
            $log->status = 1;
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

        $paginate = $request->paginate && $request->paginate > 0 ? $request->paginate : 10;
        $dateRange = null;
        $filterType = $request->filter ?? null;
        $data = $request->filtedarData ??  null;
        $order = $this->orderDataGlobal($data, $companyId, $paginate, $dateRange, $filterType);
        $myOrder = Order::with($this->order_list_relation())->where('id', $id)->first();
        $filterValue = $this->orderCounter();
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


    public function template(){
        return LogTemplate::all();
    }
}
