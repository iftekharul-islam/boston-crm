<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesTime extends Migration
{
    protected $tables = [
        "order_w_initial_reviews",
        "order_w_inspections",
        "order_w_qas",
        "order_w_reports",
        "order_w_report_analyses",
        "order_w_rewrites"
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $item) {
            Schema::table($item, function(Blueprint $table){
                $table->timestamp('note_time')->nullable()->after("created_at");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $item) {
            Schema::table($item, function(Blueprint $table){
                $table->dropColumn(['note_time']);
            });
        }
    }
}
