<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallController extends BaseController
{
    public function index()
    {
        return view('call.index');
    }
}
