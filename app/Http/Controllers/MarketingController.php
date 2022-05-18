<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketingController extends BaseController
{
    public function index()
    {
        return view('marketing.index');
    }
}
