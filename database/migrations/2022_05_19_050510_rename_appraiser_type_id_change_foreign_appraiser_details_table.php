<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAppraiserTypeIdChangeForeignAppraiserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisal_details', function (Blueprint $table) {
            $table->dropForeign(['appraiser_type_id']);
            $table->renameColumn('appraiser_type_id','appraiser_id');
            $table->foreign('appraiser_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
