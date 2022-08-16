<?php

namespace App\Services;

use App\Events\Notify;
use App\Models\Notification;

class MarketingService
{
    public function sendNotification($user_id,$message,$created_by)
    {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->message = $message;
        $notification->created_by = $created_by;
        $notification->save();

        return event(new Notify($message, $user_id));
    }
}
