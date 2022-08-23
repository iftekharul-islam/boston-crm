<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Console\Command;

class CompleteOrderRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boston:orderRefresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh completed order lists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::whereDate('completed_date', Carbon::today())->get();
        foreach ($orders as $item) {
            $item->completed_date = null;
            $item->save();
            $this->info("Order no ".$item->client_order_no." has been freshed");
        }
    }
}
