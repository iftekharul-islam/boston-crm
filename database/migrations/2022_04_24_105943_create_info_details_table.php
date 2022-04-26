<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrower_info_id')->nullable();
            $table->unsignedBigInteger('contact_info_id')->nullable();
            $table->integer('contact_no');
            $table->string('email');
            $table->timestamps();

            $table->foreign('borrower_info_id')->references('id')->on('borrower_infos')->onDelete('cascade');
            $table->foreign('contact_info_id')->references('id')->on('contact_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_details');
    }
}
