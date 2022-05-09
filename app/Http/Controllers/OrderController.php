<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends BaseController
{
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
			return view('order.create');
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
