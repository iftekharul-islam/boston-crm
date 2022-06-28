<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Helpers\CrmHelper;
use Illuminate\Http\Request;

class CallController extends BaseController
{
    use CrmHelper;
    
    public function index(Request $get)
    {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 5;        
        $order = $this->orderData($data, $companyId, $paginate);
        return view('call.index', compact('order'));
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
