<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCondoEnableToAppraisalTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisal_types', function (Blueprint $table) {
            $table->integer('condo_type')->default(0)->after('modified_form');
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
            $table->dropColumn('condo_type');
        });
    }
}
