<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $order = $this->orderData($data, $companyId, $paginate, $dateRange);
        return view('call.index', compact('order'));
    }

    public function orderData($data, $companyId, $paginate, $dateRange) {
        $dateSearch = (isset($dateRange['search']) && $dateRange['search'] == true) ? true : false;
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
        ->when($dateSearch, function($qry) use ($dateRange) {
            $start = Carbon::parse($dateRange['start']);
            $end = Carbon::parse($dateRange['end']);
            return $qry->whereDate("created_at", ">=", $start)->whereDate("created_at", "<=", $end);
        })
        ->where('company_id', $companyId)
        ->orderBy('id', 'desc')
        ->paginate($paginate);
        return $order;
    }

    public function searchCallOrder(Request $get) {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;
        $data = $get->data;
        $paginate = $get->paginate && $get->paginate > 0 ? $get->paginate : 10;
        $dateRange = $get->dateRange;
        $order = $this->orderData($data, $companyId, $paginate, $dateRange);
        return $order;
    }

}
