<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\CallLog;
use App\Models\OrderWInspection;

trait GlobalHelper {

    protected function orderCounter() {
        $user = auth()->user();
        $companyId = $user->getCompanyProfile()->company_id;

        $all = Order::count();
        $toBeSchedule = Order::where('status', 0)->where('completed_status', null)->where('company_id', $companyId)->count();
        $schedule = Order::where('status', 1)->where('company_id', $companyId)->count();
        $completed_today = Order::whereDate('completed_date', "=", Carbon::today())->where('completed_status', 1)->where('company_id', $companyId)->count();
        $today_call = 0;

        $data = [
            "all" => $all,
            "to_schedule" => $toBeSchedule,
            "schedule" => $schedule,
            "completed" => $completed_today,
            "today_call" => $today_call
        ];
        return $data;
    }

}
