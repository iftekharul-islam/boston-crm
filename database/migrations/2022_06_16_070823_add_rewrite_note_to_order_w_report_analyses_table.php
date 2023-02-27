<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRewriteNoteToOrderWReportAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_w_report_analyses', function (Blueprint $table) {
            $table->string('rewrite_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_w_report_analyses', function (Blueprint $table) {
            $table->dropColumn('rewrite_note');
        });
    }
}
