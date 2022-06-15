<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorIdToOrderWReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_w_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_w_reports', function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->unsignedBigInteger('assigned_to')->nullable(false)->change();
        });
    }
}
