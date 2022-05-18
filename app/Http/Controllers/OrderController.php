<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\AppraisalDetail;
use App\Models\BorrowerInfo;
use App\Models\ContactInfo;
use App\Models\Order;
use App\Models\ProvidedService;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

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
    public function index(): View|Factory|Application
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        $system_order_no = 'BAS-' . uniqid();
        $appraisal_users = $this->repository->getUserByRoleWise(role: 'appraiser');
        $appraisal_types = $this->repository->getAppraisalTypes();
        $loan_types = $this->repository->getLoanTypes();
        $client_users = Helper::getClientsGroupBy($this->repository->getClients());
        $amc_clients = $client_users[0];
        $lender_clients = $client_users[1];

        return view('order.create',
            compact('system_order_no', 'appraisal_users', 'appraisal_types', 'loan_types', 'amc_clients',
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
        return view('order.show');
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

    public function getBasicInfo($order_id)
    {

    }

    public function saveOrderData(){
//        Order::create([
//            "amc_id" => 3,
//            "lender_id" => 2,
//            "status" => 1
//        ]);
//        AppraisalDetail::create([
//           "order_id" => 1,
//           "client_order_no" => "CLIORD1",
//           "system_order_no" => "BAS-1212",
//           "appraiser_type_id" => 1,
//            "loan_type_id" => 1,
//            "loan_no" => "LoanNumber",
//            "fha_case_no" => "FHACN12",
//            "received_date" => Carbon::parse('05/18/2022')->format('Y-m-d'),
//            "due_date" => Carbon::parse('05/20/2022')->format('Y-m-d'),
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
    }
}
