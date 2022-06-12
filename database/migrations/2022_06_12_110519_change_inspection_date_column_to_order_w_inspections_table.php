<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInspectionDateColumnToOrderWInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_w_inspections', function (Blueprint $table) {
            $table->dropColumn('inspection_date');
            $table->dropColumn('inspection_time');
            $table->timestamp('inspection_date_time')->after('inspector_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_w_inspections', function (Blueprint $table) {
            //
        });
    }
}
