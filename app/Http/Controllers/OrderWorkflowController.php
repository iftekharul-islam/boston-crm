<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\CrmHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\OrderWorkflowService;
use App\Repositories\OrderWorkflowRepository;


class OrderWorkflowController extends BaseController
{
    protected OrderWorkflowService $service;
    protected OrderWorkflowRepository $repository;
    use CrmHelper;

    public function __construct(OrderWorkflowService $order_w_service, OrderWorkflowRepository $order_w_repository)
    {
        parent::__construct();
        $this->service = $order_w_service;
        $this->repository = $order_w_repository;
    }

    public function updateOrderSchedule(Request $request){
        $this->repository->updateOrderScheduleData($request->all());
        //work for set event on google calender
        //$this->service->setOrderSchedule($request->all());

        return response()->json(['message' => 'Schedule has been updated successfully']);
    }
}
