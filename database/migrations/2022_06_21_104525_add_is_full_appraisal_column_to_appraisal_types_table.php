<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFullAppraisalColumnToAppraisalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisal_types', function (Blueprint $table) {
            $table->tinyInteger('is_full_appraisal')->after('condo_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appraisal_types', function (Blueprint $table) {
            $table->dropColumn('is_full_appraisal');
        });
    }
}
