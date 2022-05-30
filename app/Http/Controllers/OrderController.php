<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ActivityLog;
use App\Models\AppraisalDetail;
use App\Models\BorrowerInfo;
use App\Models\ContactInfo;
use App\Models\Order;
use App\Models\PropertyInfo;
use App\Models\ProvidedService;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Js;
use Psy\Util\Json;
use Ramsey\Collection\Collection;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    protected OrderService $service;
    protected OrderRepository $repository;

    public function __construct(OrderService $order_service, OrderRepository $order_repository)
    {
        parent::__construct();
        $this->service = $order_service;
        $this->repository = $order_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index() : View|Factory|Application
    {
        $orderData = Order::take(20)->get();
        return view('order.index', compact('orderData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $system_order_no = $this->generateSystemOrderNo();
        $appraisal_users = $this->repository->getUserByRoleWise(role: 'appraiser');
        $appraisal_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();
        $client_users = Helper::getClientsGroupBy($this->repository->getClients());
        $amc_clients = $client_users[0];
        $lender_clients = $client_users[1];
        $company = auth()->user()->companies()->first();

        $userID = auth()->user()->id;


        return view('order.create',
            compact('system_order_no', 'userID', 'company', 'appraisal_users', 'appraisal_types', 'loan_types', 'amc_clients',
                'lender_clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param Order $order
     *
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $order_types = $this->repository->getOrderTypes($id);
        $order_due_date = $this->repository->getOrderDueDate($id);
        $diff_in_days = Carbon::parse($order_due_date->due_date)->diffInDays();
        return view('order.show', compact('order_types','diff_in_days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function edit(Order $order)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Order $order
     *
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getBasicInfo($order_id): JsonResponse
    {
        $order_details = $this->repository->getOrderDetails($order_id);
        $property_info = $this->repository->getPropertyInfo($order_id);
        return response()->json(["orderDetails" => $order_details, "propertyInfo" => $property_info]);
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updateBasicInfo(Request $request, $order_id): JsonResponse
    {
        $this->repository->updatePropertyInfo($order_id, $request->all());

        $data = [
          "activity_text" => "Basic info updated",
          "activity_by" => Auth::id(),
          "order_id" => $order_id
        ];

        $this->repository->addActivity($data);
        return response()->json(["message" => "Basic info updated successfully !"]);
    }


    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getAppraisalInfo($order_id): JsonResponse
    {
        $order_details = $this->repository->getOrderDetails($order_id);
        $appraisal_details = $this->repository->getAppraisalDetails($order_id);
        $provided_service = $this->repository->getProvidedService($order_id);
        $appraisal_users = $this->repository->getUserByRoleWise(role: 'appraiser');
        $appraisal_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();

        return response()->json([
            "orderDetails" => $order_details,
            "appraisalDetails" => $appraisal_details,
            "providedService" => $provided_service,
            "appraiserTypes" => $appraisal_types,
            "loanTypes" => $loan_types,
            "appraisers" => $appraisal_users
        ]);
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updateAppraisalInfo(Request $request, $order_id): JsonResponse
    {
        $this->repository->updateAppraisalDetails($order_id, $request->all());
        return response()->json(["message" => "Appraisal info updated successfully"]);
    }

    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getBorrowerInfo($order_id): JsonResponse
    {
        $borrower = $this->repository->getBorrowerDetails($order_id);
        return response()->json(["borrower" => $borrower]);
    }

    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getContactInfo($order_id): JsonResponse
    {
        $contact = $this->repository->getContactDetails($order_id);
        return response()->json(["contact" => $contact]);
    }

    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getClientsInfo($order_id): JsonResponse
    {
        $clients = $this->repository->getClientDetails($order_id);
        $all_amc = $this->repository->getAllClientByType('amc');
        $all_lender = $this->repository->getAllClientByType('lender');
        $amc_file = $this->repository->getClientFile($clients->amc_id);
        $lender_file = $this->repository->getClientFile($clients->lender_id);
        return response()->json(["clients" => $clients,'amc_file' => $amc_file,'lender_file' => $lender_file,'allAmc' => $all_amc,'allLender' => $all_lender]);
    }

    public function updateClientInfo(Request $request,$order_id): JsonResponse
    {
        $this->repository->updateClientDetails($order_id,$request->all());
        return response()->json(['message' => 'Client info updated successfully']);
    }

    /**
     * @param $order_id
     * @return Application|Factory|View
     */
    public function publicOrder($order_id): View|Factory|Application
    {
        $order = AppraisalDetail::where('order_id', $order_id)->select("system_order_no")->first();
        $order_types = $this->repository->getOrderTypes($order_id);
        return view('order.public-order', compact('order', 'order_types'));
    }

    public function uploadOrderFiles(Request $request, $order_id)
    {
        $this->repository->saveOrderFiles($request->all(), $order_id);
        if ($request->ajax()) {
            return response()->json(["message" => "Order file uploaded successfully"]);
        }
        return redirect()
            ->to('public-order/' . $order_id)
            ->with(['success' => 'Order file uploaded successfully']);

    }


    /**
     * @param $order_id
     * @return JsonResponse
     */
    public function getActivityLog($order_id): JsonResponse
    {
        $activity_log = $this->repository->getActivityLogData($order_id);
        return response()->json(["activityLog" => $activity_log]);
    }

    /**
     * @return int|string
     */
    public function generateSystemOrderNo(): int|string
    {
        $string_format = "BAS-000001";
        $check_last_string = Order::latest()->first();
        if($check_last_string){
            $system_order_no = ++$check_last_string->system_order_no;
        }else{
            $system_order_no = $string_format;
        }
        return $system_order_no;
    }
    public function saveOrderData()
    {
//        Order::create([
//            "amc_id" => 1,
//            "lender_id" => 2,
//            "status" => 1,
//            "client_order_no" => "CLORD-1",
//            "system_order_no" => "BAS-1212",
//            "received_date" => Carbon::parse('05/18/2022')->format('Y-m-d'),
//            "due_date" => Carbon::parse('05/30/2022')->format('Y-m-d'),
//        ]);
//        AppraisalDetail::create([
//           "order_id" => 1,
//           "appraiser_id" => 1,
//            "loan_type" => 1,
//            "loan_no" => "LoanNumber",
//            "fha_case_no" => "FHACN12",
//            "technology_fee" => 1000
//        ]);
//        ProvidedService::create([
//            "order_id" => 1,
//            "appraiser_type_fee" => json_encode([
//                ['type' => "test", 'fee' => '100'],['type' => "test", 'fee' => '100']
//            ]),
//            "total_fee" => 200,
//            "note" => "Test"
//        ]);
//        BorrowerInfo::create([
//            "order_id" => 1,
//            "borrower_name" => "Borrower",
//            "co_borrower_name" => "Co Borrower",
//            "contact_email" => json_encode(["contact"=>"01988812097","email"=>"test@gmail.com"])
//        ]);
//        ContactInfo::create([
//           "order_id" => 1,
//            "is_borrower" => 1,
//            "contact"=> "new york",
//            "contact_email" => json_encode(["contact"=>"01988812097","email"=>"test@gmail.com"])
//        ]);
//        PropertyInfo::create([
//            "order_id" => 1,
//            "search_address" => "Mirpur",
//            "street_name" => "2",
//            "city_name" => "Dhaka",
//            "state_name" => "Dhaka",
//            "zip" => "1207",
//            "unit_no" => "F-2A",
//            "country"=> "Bangladesh",
//            "latitude" => 23.21211,
//            "longitude" => 21.23333
//        ]);
    }
}
