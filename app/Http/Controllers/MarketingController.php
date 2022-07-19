<?php

namespace App\Http\Controllers;


use App\Models\MarketingClient;
use Illuminate\Http\Request;

class MarketingController extends BaseController
{
    public function index()
    {
        $clients = MarketingClient::all();
        return view('marketing.index',compact('clients'));
    }
}
