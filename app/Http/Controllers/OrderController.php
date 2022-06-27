<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;
use App\Helpers\Helper;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\OrderWInspection;
use App\Models\Order;
use App\Helpers\CrmHelper;
use Illuminate\Support\Js;
use App\Models\ContactInfo;
use App\Models\PropertyType;
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
    public function index(Request $get) //: View|Factory|Application
    {
        $user = Auth::user();
        $company = $user->getCompanyProfile();
        $companyId = $company->company_id;

        $appraisal_users = $this->repository->getUserByRoleWise(role: 'appraiser');
        $property_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();
        $client_users = $this->repository->getClients();

        $filterType = [
            "appraisal_users" => $appraisal_users,
            "property_types" => $property_types,
            "loan_types" => $loan_types,
            "client_users" => $client_users,
        ];

        $orderData = $this->searchOrderData($get, $user, $companyId);
        $orderSummary = $this->orderSummary($user, $companyId);
        return view('order.index', compact('orderData', 'orderSummary', 'filterType'));
    }

    public function orderSummary($user = null, $companyId = null)
    {
        if ($user == null) {
            $user = Auth::user();
            $companyId = $user->getCompanyProfile()->company_id;
        }
        $orders = Order::where('company_id', $companyId)->orderBy('id', 'desc')->get();

        $dueToday = [
            'total' => 0,
            'name' => 'Due today',
            'ids' => [],
        ];
        $dueTomorrow = [
            'total' => 0,
            'name' => 'Due tomorrow',
            'ids' => [],
        ];
        $apptToday = [
            'total' => 0,
            'name' => 'Appt Today',
            'ids' => [],
        ];
        $apptTommorrow = [
            'total' => 0,
            'name' => 'Appt Tomorrow',
            'ids' => [],
        ];
        $overDue = [
            'total' => 0,
            'name' => 'Overdue',
            'ids' => [],
        ];

        $rush = [
            'total' => 0,
            'name' => 'Rush',
            'ids' => [],
        ];
        $deleted = [
            'total' => 0,
            'name' => 'Deleted',
            'ids' => [],
        ];
        $cancelled = [
            'total' => 0,
            'name' => 'Cancelled',
            'ids' => [],
        ];
        $unstarted = [
            'total' => 0,
            'name' => 'To be schedule',
            'ids' => [],
        ];
        $unassigned = [
            'total' => 0,
            'name' => 'Unassigned',
            'ids' => [],
        ];
        $accepted = [
            'total' => 0,
            'name' => 'Accepted',
            'ids' => [],
        ];
        $declined = [
            'total' => 0,
            'name' => 'Declined',
            'ids' => [],
        ];
        $unscheduled = [
            'total' => 0,
            'name' => 'Unscheduled',
            'ids' => [],
        ];
        $scheduled = [
            'total' => 0,
            'name' => 'Scheduled',
            'ids' => [],
        ];
        $inspected = [
            'total' => 0,
            'name' => 'Inspected',
            'ids' => [],
        ];
        $reportUploaded = [
            'total' => 0,
            'name' => 'Report uploaded',
            'ids' => [],
        ];
        $revisions = [
            'total' => 0,
            'name' => 'Revisions',
            'ids' => [],
        ];
        $revised = [
            'total' => 0,
            'name' => 'Revised',
            'ids' => [],
        ];
        foreach ($orders as $order) {
            $workStatus = json_decode($order->workflow_status, true);

            if ($order->status == 15) {
                $deleted['total'] += 1;
                $deleted['ids'][] = $order->id;
                continue;
            }
            if ($order->status == 14) {
                $cancelled['total'] += 1;
                $cancelled['ids'][] = $order->id;
                continue;
            }
            if ($order->status == 16) {
                $declined['total'] += 1;
                $declined['ids'][] = $order->id;
            }
            if ($order->rush) {
                $rush['total'] += 1;
                $rush['ids'][] = $order->id;
            }
            if ($order->status == 0) {
                $unstarted['total'] += 1;
                $unstarted['ids'][] = $order->id;
            }
            if (isset($workStatus['scheduling'])) {
                $unassigned['total'] += 1;
                $unassigned['ids'][] = $order->id;
            }
            if (isset($workStatus['scheduling']) && $workStatus['scheduling'] == 0) {
                $unscheduled['total'] += 1;
                $unscheduled['ids'][] = $order->id;
            }
            if (isset($workStatus['scheduling']) && $workStatus['scheduling'] == 1) {
                $scheduled['total'] += 1;
                $scheduled['ids'][] = $order->id;
            }
            if (isset($workStatus['inspection']) && $workStatus['inspection'] == 1) {
                $inspected['total'] += 1;
                $inspected['ids'][] = $order->id;
            }
            if (isset($workStatus['reportPreparation']) && $workStatus['reportPreparation'] == 1) {
                $reportUploaded['total'] += 1;
                $reportUploaded['ids'][] = $order->id;
            }
            if (isset($workStatus['revision']) && $workStatus['revision'] == 1) {
                $revisions['total'] += 1;
                $revisions['ids'][] = $order->id;
            }
            if (isset($workStatus['submission']) && $workStatus['submission'] == 1) {
                $revised['total'] += 1;
                $revised['ids'][] = $order->id;
            }
            if (Carbon::today()->format('Y-m-d') == Carbon::parse($order->due_date)->format('Y-m-d')) {
                $dueToday['total'] += 1;
                $dueToday['ids'][] = $order->id;
            }
            if (Carbon::today()->addDay(1)->format('Y-m-d') == Carbon::parse($order->due_date)->format('Y-m-d')) {
                $dueTomorrow['total'] += 1;
                $dueTomorrow['ids'][] = $order->id;
            }
            if (Carbon::today()->format('Y-m-d') > Carbon::parse($order->due_date)->format('Y-m-d')) {
                $overDue['total'] += 1;
                $overDue['ids'][] = $order->id;
            }
        }

        return [
            $apptToday,
            $apptTommorrow,
            $deleted,
            $cancelled,
            $accepted,
            $declined,
            $rush,
            $unstarted,
            $unassigned,
            $unscheduled,
            $scheduled,
            $inspected,
            $reportUploaded,
            $revisions,
            $revised,
            $dueToday,
            $dueTomorrow,
            $overDue
        ];
    }



    /**
     * Searching Order Data Request
     *
     * @return JSON
     */

    public function searchOrderData(Request $get, $user = null, $companyId = null)
    {
        if ($user == null) {
            $user = Auth::user();
            $companyId = $user->getCompanyProfile()->company_id;
        }
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $order = Order::where(function ($qry) use ($data) {
            return $qry->where('system_order_no', "LIKE", "%$data%")
                ->orWhere("client_order_no", "LIKE", "%$data%")
                ->orWhere("received_date", "LIKE", "%$data%")
                ->orWhere("amc_id", "LIKE", "%$data%")
                ->orWhere("lender_id", "LIKE", "%$data%")
                ->orWhere("company_id", "LIKE", "%$data%")
                ->orWhere("due_date", "LIKE", "%$data%")
                ->orWhere("created_at", "LIKE", "%$data%");
        })->with($this->order_list_relation())
            ->where('company_id', $companyId)
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $order;
    }

    /**
     * @param Request $get
     * @return mixed
     */
    public function filterOrderData(Request $get)
    {
        $ids = $get->item['ids'] ?? [];
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $order = Order::whereIn('id', $ids)->with($this->order_list_relation())
            ->orderBy('id', 'desc')
            ->paginate($paginate);

        return $order;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $get) //: View|Factory|Application
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
        $property_types = PropertyType::all();

        $data = compact('system_order_no', 'userID', 'company', 'appraisal_users', 'appraisal_types', 'loan_types', 'amc_clients', 'lender_clients', 'property_types');

        if ($get->array && $get->array == 'true') {
            return $data;
        }

        return view('order.create', $data);
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

        $order = $this->orderDetails($id);

        $noRewrite = 1;
        if (isset($order->analysis->is_review_send_back) && $order->analysis->is_review_send_back == 1) {
            $noRewrite = 0;
        } else if (!isset($order->analysis->is_review_send_back)) {
            $noRewrite = 0;
        } else if (isset($order->analysis->rewrite_note) && $order->analysis->rewrite_note != null) {
            $noRewrite = 0;
        }

        $order->amc_file = $this->repository->getClientFile($order->amc_id);
        $order->lender_file = $this->repository->getClientFile($order->lender_id);
        $order->user_role = User::find($order->created_by)->getUserRole($order->created_by, $order->company_id);
        $order_files = $this->repository->getOrderFiles($id);
        $order_file_types = $this->repository->getOrderFileTypes($id);
        $order_due_date = $this->repository->getOrderDueDate($id);
        $diff_in_days = Carbon::parse($order_due_date->due_date)->diffInDays();
        $diff_in_hours = Carbon::parse($order_due_date->due_date)->diffInHours();
        $all_users = $this->repository->getUserExpectRole(role: 'admin');
        $property_types = PropertyType::all();

        return view('order.show', compact('all_users', 'noRewrite', 'order_file_types', 'order_files', 'order', 'diff_in_days', 'diff_in_hours', 'appraisers', 'appraisal_types', 'loan_types', 'all_amc', 'all_lender', 'property_types'));
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
        $order->file = $this->repository->getOrderFile($id);
        $property_types = PropertyType::all();
        return view('order.edit', compact('order', 'appraisal_users', 'amc_clients', 'lender_clients', 'appraisal_types', 'loan_types', 'client_users', 'company', 'userID', 'property_types'));
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
    public function updateBasicInfo(Request $request, $order_id): JsonResponse|array
    {
        $orderClient = Order::where('id', '!=', $request->id)
            ->where('client_order_no', $request->client_order_no)
            ->first();
        if ($orderClient) {
            return response()->json([
                'error' => true,
                "message" => "This client order number already exists, change it."
            ]);
        }
        $this->repository->updateBasicInfo($order_id, $request->all());

        $data = [
            "activity_text" => "Basic info updated",
            "activity_by" => Auth::id(),
            "order_id" => $order_id
        ];

        $this->repository->addActivity($data);

        $orderData = $this->orderDetails($request->id);

        return [
            'error' => false,
            'message' => 'Basic info updated successfully !',
            'status' => 'success',
            'data' => $orderData
        ];
    }

    /**
     * @param Request $request
     * @param $order_id
     * @return JsonResponse
     */
    public function updatePropertyInfo(Request $request, $order_id): JsonResponse
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
    public function updateAppraisalInfo(Request $request, $order_id)
    {
        $this->repository->updateAppraisalInfo($order_id, $request->all());
        $data = [
            "activity_text" => "Order appraisal information has been updated",
            "activity_by" => Auth::id(),
            "order_id" => $order_id
        ];

        $this->repository->addActivity($data);
        $orderData = $this->orderDetails($order_id);
        return [
            "message" => "Appraisal info updated successfully",
            "data" => $orderData
        ];
    }

    public function updateClientInfo(Request $request, $order_id)
    {
        $this->repository->updateClientDetails($order_id, $request->all());

        $orderData = $this->orderDetails($order_id);
        $order= Order::find($order_id);
        $data = [
            "activity_text" => "Client info has been updated",
            "activity_by" => Auth::id(),
            "order_id" => $order_id
        ];
        $amc_file = $this->repository->getClientFile($order->amc_id);
        $lender_file = $this->repository->getClientFile($order->lender_id);
        $this->repository->addActivity($data);

        return [
            'error' => false,
            'message' => 'Client info updated successfully !',
            'status' => 'success',
            'data' => $orderData,
            'amc_file' => $amc_file,
            'lender_file' => $lender_file
        ];
    }

    /**
     * @param $order_id
     * @return Application|Factory|View
     */
    public function publicOrder($order_id): View|Factory|Application
    {
        $order = Order::find(base64_decode($order_id));
        if (!$order) {
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
    public function uploadOrderFiles(Request $request, $order_id): array | \Illuminate\Http\RedirectResponse
    {
        if ($request->has('public')) {
            $order_id = base64_decode($order_id);
        }
        if ($request->file_type == '') {
            if ($request->ajax()) {
                return ["message" => "File type is required"];
            }
        } else {
            return redirect()
                ->to('public-order/' . base64_encode($order_id))
                ->with(['error' => 'Order file type is required']);
        }
        $this->repository->saveOrderFiles($request->all(), $order_id);
        if ($request->ajax()) {
            $orderData = $this->orderDetails($order_id);
            $orderFiles = $this->repository->getOrderFiles($order_id);
            return [
                "message" => "Order file uploaded successfully",
                "data" => $orderData,
                "orderFiles" => $orderFiles
            ];
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
        if ($check_last_string) {
            $system_order_no = ++$check_last_string->system_order_no;
        } else {
            $system_order_no = $string_format;
        }
        return $system_order_no;
    }

    public function saveOrderData()
    {
    }

    public function orderUpdate($type, Request $get)
    {
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

            $returnMessage = "Order Provided Service Has Been Updated";
        }

        $data = [
            "activity_text" => $returnMessage,
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];
        $this->repository->addActivity($data);
    }

    public function searchOrderByFiltering(Request $get)
    {
        $id = $get->item['id'];
        $item = $get->item;
        if ($get->key == 'appraisal_users') {
            $orderId = AppraisalDetail::where('appraiser_id', $id)->latest()->get()->pluck("order_id");
            return $this->orderInformation($orderId);
        } else if ($get->key == 'client_users') {
            return Order::where(function ($qry) use ($item, $id) {
                if ($item['client_type'] == 'both') {
                    return $qry->where('amc_id', $id)->orWhere('lender_id', $id);
                } else if ($item['client_type'] === 'amc') {
                    return $qry->where('amc_id', $id);
                } else {
                    return $qry->where('lender_id', $id);
                }
            })->with($this->order_list_relation())->orderBy('id', 'desc')->paginate(100);
        } else if ($get->key == "loan_types") {
            $orderId = AppraisalDetail::where('loan_type', $id)->latest()->get()->pluck("order_id");
            return $this->orderInformation($orderId);
        } else if ($get->key == "reportType") {
        } else if ($get->key = "property_types") {
            $orderId = ProvidedService::whereJsonContains('appraiser_type_fee', ['typeId' => $id])->latest()->get()->pluck("order_id");
            return $this->orderInformation($orderId);
        }
    }

    protected function orderInformation($id)
    {
        return Order::whereIn('id', $id)->with($this->order_list_relation())->orderBy('id', 'desc')->paginate(100);
    }
}
