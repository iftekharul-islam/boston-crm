<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
	 /**
		* @return Application|Factory|View
		*/
	 public function index(): View|Factory|Application
	 {
			$role = $this->getAuthUserRole();
			
			return view( 'dashboard', compact( 'role' ) );
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
}
