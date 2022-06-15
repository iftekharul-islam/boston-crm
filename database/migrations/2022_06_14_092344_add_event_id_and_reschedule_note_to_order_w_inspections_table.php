<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventIdAndRescheduleNoteToOrderWInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_w_inspections', function (Blueprint $table) {
            $table->string('event_id')->after('note')->nullable();
            $table->text('reschedule_note')->after('note')->nullable();
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
