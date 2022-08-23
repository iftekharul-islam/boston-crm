<?php

namespace App\Console\Commands;

use App\Helpers\CrmHelper;
use Illuminate\Console\Command;

class CreateOrder extends Command
{
    use CrmHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boston:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new random order';

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
        $orderInfor = $this->createRandomOrder(false);
        $this->info($orderInfor);
    }
}
