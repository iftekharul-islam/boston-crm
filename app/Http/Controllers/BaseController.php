<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
	 protected string $user_role;
	 
	 public function __construct()
	 {
			$this->middleware(function ($request, $next) {
				 if ( Auth::check() ) {
						$user            = Auth::user();
						$company         = $user->companies()->first();
						$this->user_role = $user->getUserRole( $user->id, $company->id );
				 }
				 View::share( 'user_role', $this->user_role ?? '' );
				
				 return $next($request);
			});
	 }
}
