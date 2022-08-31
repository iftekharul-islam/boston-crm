<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Foundation\Application;

class DashboardController extends BaseController
{
	 public function __construct()
	 {
			parent::__construct();
	 }

	 /**
		* @return Application|Factory|View
		*/
	 public function index(): View|Factory|Application
	 {
			$role = $this->getAuthUserRole();

			return view( 'dashboard', compact( 'role' ) );
	 }

	 public function userIndex()
	 {
         $data['all'] = Ticket::count();
         $data['open'] = Ticket::where('status', '!=', 1)->count();
         $data['my'] =Ticket::where('assigned_to', auth()->user()->id)->count();

			return view( 'user-dashboard', compact( 'data' ) );
	 }

	 /**
		* @return mixed
		*/
	 public function getAuthUserRole(): mixed
	 {
			$user    = auth()->user();
			$company = $user->companies()->where( 'active_company', 1 )->first();

			return $user->getUserRole( $user->id, $company->id );
	 }

     public function refreshOrder() {
        Artisan::call("boston:orderRefresh");
        return "Order has been refreshed";
     }
}
