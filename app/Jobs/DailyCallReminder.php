<?php

namespace App\Jobs;

use App\Events\Notify;
use App\Models\Notification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psy\Readline\Hoa\Console;

class DailyCallReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::whereDate('call_date', Carbon::today())->get();
        foreach($orders ?? [] as $order){
            $notification = new Notification();
            $notification->user_id = $order['call_by'];
            $notification->message = 'Call Reminder to order no: '.$order['client_order_no'] .' at : '. $order['call_date_formatted'] ;
            $notification->created_by = 1;
            $notification->save();

            event(new Notify($notification->message, $notification->user_id));
        }
    }
}
