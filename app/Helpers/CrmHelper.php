<?php

namespace App\Helpers;
use App\Models\Order;

trait CrmHelper {

    public function getSystemOrderNumber() {
        $order = Order::latest()->first();
        $length = 8;
        if ($order) {
            $orderLength = $order->id+1;
            $length = strlen($orderLength) < 8 ? 8 - strlen($orderLength) : 0;
        }
        if ($length > 0) {
            return "BAS-".str_pad($order->id+1, $length, 0, STR_PAD_LEFT);
        } else {
            return "BAS-".$order->id+1;
        }
    }
}