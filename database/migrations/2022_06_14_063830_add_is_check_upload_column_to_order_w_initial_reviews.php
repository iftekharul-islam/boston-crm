<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCheckUploadColumnToOrderWInitialReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_w_initial_reviews', function (Blueprint $table) {
            $table->tinyInteger('is_check_upload')->after('is_review_done');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_w_intitial_reviews', function (Blueprint $table) {
            //
        });
    }
}
