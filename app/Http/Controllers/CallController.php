<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
use App\Models\CallLog;
use Prophecy\Call\Call;
use App\Helpers\CrmHelper;
use App\Models\PropertyInfo;
use App\Traits\GlobalHelper;
use Illuminate\Http\Request;
use App\Jobs\TaskBasedReport;
use App\Services\CallService;
use App\Models\OrderWInspection;
use App\Repositories\OrderRepository;

class CallController extends BaseController
{
    protected OrderRepository $repository;
    protected CallService $callService;
    use CrmHelper, GlobalHelper;

    public function __construct(OrderRepository $order_repository,CallService $callService)
    {
        parent::__construct();
        $this->repository = $order_repository;
        $this->service = $callService;
    }

    public function index(Request $get)
    {
//        return CallLog::where('order_id', 21)->get();
        $timezone = $this->getTimeZone();
        $user = auth()->user();
        $appraisers = $this->repository->getUserExpectRole(role: 'admin');
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $filterType = $get->filterType ?: 'to_schedule';
        $order = $this->orderDataGlobal($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->orderCounter();
//        return $order;
        return view('call.index', compact('order','appraisers', 'filterValue'));
    }


    public function searchCallOrder(Request $get) {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $filterType = $get->filterType;
        $order = $this->orderDataGlobal($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->orderCounter();
        return response()->json([
            'order' => $order,
            'filterValue' => $filterValue
        ]);
    }


    public function sendMessage(Request $request)
    {
        $this->service->sendMessage($request->all());
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;
        $data = '';
        $paginate = 10;
        $dateRange = '';
        $filterType = $request->filter ?? 'all';
        $order = $this->orderDataGlobal($data, $companyId, $paginate, $dateRange, $filterType);
        $filterValue = $this->orderCounter();
        return [
            "message" => "Message sent successfully !",
            'order' => $order,
            'filterValue' => $filterValue
        ];
    }

}
