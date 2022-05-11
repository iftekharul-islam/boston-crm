<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends BaseController
{
	 protected OrderService $service;
	 protected OrderRepository $repository;
	 
	 public function __construct(OrderService $order_service, OrderRepository $order_repository)
	 {
			parent::__construct();
			$this->service    = $order_service;
			$this->repository = $order_repository;
	 }
	 
	 /**
		* Display a listing of the resource.
		*
		* @return Application|Factory|View
		*/
	 public function index(): View|Factory|Application
	 {
			return view( 'order.index' );
	 }
	 
	 /**
		* Show the form for creating a new resource.
		*
		* @return Application|Factory|View
		*/
	 public function create(): Application|Factory|View
	 {
			$system_order_no = 'BAS-' . uniqid();
			$appraisal_users = $this->repository->getUserByRoleWise( role: 'appraiser' );
			$appraisal_types = $this->repository->getAppraisalTypes();
			$loan_types      = $this->repository->getLoanTypes();
			
			return view( 'order.create', compact( 'system_order_no', 'appraisal_users', 'appraisal_types', 'loan_types' ) );
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
			return view( 'order.show' );
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
			//
	 }
	 
	 /**
		* Update the specified resource in storage.
		*
		* @param \Illuminate\Http\Request $request
		* @param Order                    $order
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
}
