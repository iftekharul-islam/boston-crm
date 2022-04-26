<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidedServiceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provided_service_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provided_service_id');
            $table->string('appraisal_type');
            $table->integer('fee');
            $table->timestamps();

            $table->foreign('provided_service_id')->references('id')->on('provided_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provided_service_lists');
    }
}
