<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Helpers\CrmHelper;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;

class CallController extends BaseController
{
    protected OrderRepository $repository;
    use CrmHelper;

    public function __construct(OrderRepository $order_repository)
    {
        parent::__construct();
        $this->repository = $order_repository;
    }

    public function index(Request $get)
    {
        $user = auth()->user();
        $appraisers = $this->repository->getUserByRoleWise(role: 'appraiser');
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 5;
        $order = $this->orderData($data, $companyId, $paginate);
        
        return view('call.index', compact('order','appraisers'));
    }

    public function orderData($data, $companyId, $paginate) {
        $order = Order::where(function($qry) use ($data) {
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


}
