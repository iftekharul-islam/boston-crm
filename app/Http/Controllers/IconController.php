<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IconController extends BaseController
{
	 /**
		* @return Application|Factory|View
		*/
	 public function index(): View|Factory|Application
	 {
			return view( 'icon' );
	 }
}
