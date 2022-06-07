<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Psy\Util\Json;
use App\Helpers\Helper;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Order;
use App\Helpers\CrmHelper;
use Illuminate\Support\Js;
use App\Models\ContactInfo;
use App\Models\BorrowerInfo;
use App\Models\PropertyInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\OrderService;
use App\Models\AppraisalDetail;
use App\Models\ProvidedService;
use Illuminate\Http\JsonResponse;
use Ramsey\Collection\Collection;
use Illuminate\Contracts\View\View;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Foundation\Application;

use Illuminate\Support\Facades\Auth;


class OrderController extends BaseController
{
    protected OrderService $service;
    protected OrderRepository $repository;
    use CrmHelper;

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
    public function index(Request $get) : View|Factory|Application
    {
        $orderData = $this->searchOrderData($get);
        return view('order.index', compact('orderData'));
    }

    /**
     * Searching Order Data Request
     *
     * @return JSON
     */

    public function searchOrderData(Request $get){
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $order = Order::where(function($qry) use ($data) {
            return $qry->where('system_order_no', "LIKE", "%$data%")
                       ->orWhere("client_order_no", "LIKE", "%$data%")
                       ->orWhere("received_date", "LIKE", "%$data%")
                       ->orWhere("amc_id", "LIKE", "%$data%")
                       ->orWhere("lender_id", "LIKE", "%$data%")
                       ->orWhere("company_id", "LIKE", "%$data%")
                       ->orWhere("due_date", "LIKE", "%$data%")
                       ->orWhere("created_at", "LIKE", "%$data%");
        })->with('user', 'amc', 'lender', 'propertyInfo')->orderBy('id', 'desc')->paginate($paginate);
        return $order;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create() //: View|Factory|Application
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
    public function show($id, Request $get)
    {
        $appraisers = $this->repository->getUserByRoleWise(role: 'appraiser');
        $appraisal_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();
        $all_amc = $this->repository->getAllClientByType('amc');
        $all_lender = $this->repository->getAllClientByType('lender');
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
            'activityLog.user'
        )->where('id', $id)->first();

        $order->amc_file = $this->repository->getClientFile($order->amc_id);
        $order->lender_file = $this->repository->getClientFile($order->lender_id);
        $order->user_role = User::find($order->created_by)->getUserRole($order->created_by,$order->company_id);
        $order_files = $this->repository->getOrderFiles($id);
        $order_file_types = $this->repository->getOrderFileTypes($id);
        $order_due_date = $this->repository->getOrderDueDate($id);
        $diff_in_days = Carbon::parse($order_due_date->due_date)->diffInDays();

        return view('order.show', compact('order_file_types','order_files', 'order', 'diff_in_days','appraisers','appraisal_types','loan_types','all_amc','all_lender'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function edit(Order $order, $id)
    {
        $company = auth()->user()->companies()->first();
        $userID = auth()->user()->id;
        $appraisal_users = $this->repository->getUserByRoleWise(role: 'appraiser');
        $appraisal_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();
        $client_users = Helper::getClientsGroupBy($this->repository->getClients());
        $amc_clients = $client_users[0];
        $lender_clients = $client_users[1];

        $order = Order::with(
                'amc',
                'lender',
                'user',
                'appraisalDetail',
                'providerService',
                'propertyInfo',
                'borrowerInfo',
                'contactInfo'
            )->where('id', $id)->first();
        return view('order.edit',compact('order', 'appraisal_users', 'amc_clients', 'lender_clients', 'appraisal_types', 'loan_types', 'client_users', 'company', 'userID'));
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
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updateBasicInfo(Request $request, $order_id): JsonResponse
    {
        $this->repository->updateBasicInfo($order_id, $request->all());

        $data = [
          "activity_text" => "Basic info updated",
          "activity_by" => Auth::id(),
          "order_id" => $order_id
        ];

        $this->repository->addActivity($data);
        return response()->json(["message" => "Basic info updated successfully !"]);
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updatePropertyInfo(Request $request,$order_id): JsonResponse
    {
        $info = $this->repository->updatePropertyInfo($order_id, $request->all());

        $data = [
            "activity_text" => "Order properties information has been updated",
            "activity_by" => Auth::id(),
            "order_id" => $order_id
        ];

        $this->repository->addActivity($data);
        return response()->json(["message" => "Property info updated successfully !"]);
    }


    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updateAppraisalInfo(Request $request, $order_id): JsonResponse
    {
        $this->repository->updateAppraisalInfo($order_id, $request->all());
        $data = [
            "activity_text" => "Order appraisal information has been updated",
            "activity_by" => Auth::id(),
            "order_id" => $order_id
        ];

        $this->repository->addActivity($data);
        return response()->json(["message" => "Appraisal info updated successfully"]);
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
        $order = Order::find(base64_decode($order_id));
        if(!$order){
            abort(404);
        }
        $order_types = $this->repository->getOrderFileTypes(base64_decode($order_id));
        return view('order.public-order', compact('order', 'order_types'));
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function uploadOrderFiles(Request $request, $order_id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if($request->has('public')){
            $order_id = base64_decode($order_id);
        }
        $this->repository->saveOrderFiles($request->all(), $order_id);
        if ($request->ajax()) {
            return response()->json(["message" => "Order file uploaded successfully"]);
        }
        return redirect()
            ->to('public-order/' . base64_encode($order_id))
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

    }

    public function orderUpdate($type, Request $get) {
        $errorChecking = $this->getOrderError($get, $type);
        $error = $errorChecking['error'];
        $errorMessage = $errorChecking['message'];
        if ($error == true) {
            return response()->json(['error' => $error, 'messages' => $errorMessage]);
        }

        $order = Order::where('id', $get->order['id'])->first();
        if (!$order) {
            return response()->json(['error' => true, 'messages' => "Order Information Not Found"]);
        }

        $returnMessage = null;

        if ($type == "borrower") {
            $borrower_contact = $get->borrower_contact;
            $borrower_contact_s = $get->borrower_contact_s;
            $borrower_email = $get->borrower_email;
            $borrower_email_s = $get->borrower_email_s;
            $borrower_name = $get->borrower_name;
            $co_borrower_name = $get->co_borrower_name;


            // create borrower type
            $borrowerType = BorrowerInfo::where('order_id', $order->id)->first();
            $borrowerType->updated_at = Carbon::now();
            $borrowerType->borrower_name = $borrower_name;
            $borrowerType->co_borrower_name = $co_borrower_name;
            $borrowerType->contact_email = json_encode([
                'email' => $borrower_email_s,
                'phone' => $borrower_contact_s
            ]);
            $borrowerType->save();
            $returnMessage = "Borrower Information Has Been Updated";
        } elseif ($type == "contactInfo") {
            $contact_info = $get->contact_info;
            $contact_number_s = $get->contact_number_s;
            $email_address_s = $get->email_address_s;

            $contactInfo = ContactInfo::where('order_id', $order->id)->first();
            $contactInfo->updated_at = Carbon::now();
            $contactInfo->is_borrower = count($contact_number_s) > 0 ? 1 : 0;
            $contactInfo->contact = $contact_info;
            $contactInfo->contact_email = json_encode([
                'email' => $email_address_s,
                'phone' => $contact_number_s
            ]);
            $contactInfo->save();
            $returnMessage = "Contact Information Has Been Updated";
        } elseif ($type == "status") {
            $order->status = $get->status;
            $order->save();
            $returnMessage = "Order Status Has Been Updated";
        } elseif ($type == "providerService") {
            $fee = $get->data;
            $note = $get->note;

            $providerType = ProvidedService::where('order_id', $order->id)->first();
            $providerType->updated_at = Carbon::now();
            $providerType->appraiser_type_fee = json_encode($fee);
            $providerType->note = $note;
            $providerType->total_fee = collect($fee)->sum('fee');
            $providerType->save();

            $returnMessage = "Order Provider Data Has Been Updated";
        }

        $data = [
            "activity_text" => $returnMessage,
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];
        $this->repository->addActivity($data);
    }
}
