<?php

namespace App\Console\Commands;

use App\Jobs\StatusBasedDailyReport;
use Illuminate\Console\Command;

class DailyStatusReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyReport:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily order report based on status';

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
        dispatch(new StatusBasedDailyReport());
    }
}
