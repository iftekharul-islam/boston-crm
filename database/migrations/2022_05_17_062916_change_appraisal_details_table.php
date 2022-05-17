<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAppraisalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appraisal_details', function(Blueprint $table)
        {
            $table->renameColumn('appraiser_id','appraiser_type_id');
            $table->string('system_order_no')->after('client_order_no');
            $table->renameColumn('loan_type','loan_type_id');
        });

        Schema::table('appraisal_details',function (Blueprint $table)
        {
            $table->unsignedBigInteger('loan_type_id')->nullable()->change();
            $table->string('fha_case_no')->nullable()->change();

            $table->dropForeign(['appraiser_id']);

            $table->foreign('loan_type_id')->references('id')->on('loan_types')->onDelete('cascade');
            $table->foreign('appraiser_type_id')->references('id')->on('appraisal_types')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appraisal_details', function (Blueprint $table) {
            $table->renameColumn('appraiser_type_id','appraiser_id');
            $table->dropColumn('system_order_no');
            $table->renameColumn('loan_type_id','loan_type');

            $table->string('loan_type');
            $table->string('fha_case_no');

            $table->dropForeign(['loan_type_id']);
            $table->dropForeign(['appraiser_type_id']);
        });
    }
}
