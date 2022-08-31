<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CrmHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebApiController extends Controller
{
    use CrmHelper;

    public function home() {
        return view('home');
    }

    public function createNewOrder(Request $get) {
        $order = $this->createRandomOrder();
        return view("randomorder", ['message' => $order]);
    }

}
