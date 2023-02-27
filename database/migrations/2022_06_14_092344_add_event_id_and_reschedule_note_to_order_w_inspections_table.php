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
            if (!Schema::hasColumn('order_w_inspections', 'event_id')) {
                $table->string('event_id')->after('note')->nullable();
            }

            if (!Schema::hasColumn('order_w_inspections', 'reschedule_note')) {
                $table->text('reschedule_note')->after('note')->nullable();
            }
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
            $table->dropColumn(['event_id', 'reschedule_note']);
        });
    }
}
