<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebApiController extends Controller
{
    public function home() {
        return view('home');
    }
}
