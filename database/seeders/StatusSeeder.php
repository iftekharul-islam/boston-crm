<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarketingStatus;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarketingStatus::create([
            "status" => 'Introduction Stage',
            "created_by" => 1
        ]);
    }
}
