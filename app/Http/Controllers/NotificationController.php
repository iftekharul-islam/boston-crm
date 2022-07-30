<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return Notification::with('sender')->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
    }
}
