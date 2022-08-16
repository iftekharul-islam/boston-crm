<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;

class BaseController extends Controller {
	protected Manager $fractal;

	/**
	 * Load Fractal manager
	 */
	public function __construct() {
		$this->fractal = ( new Manager() )->setSerializer( new ArraySerializer() );
	}
}
