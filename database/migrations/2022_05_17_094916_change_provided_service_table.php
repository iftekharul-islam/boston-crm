<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProvidedServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provided_services', function (Blueprint $table) {
            $table->double('total_fee',10,2)->after('order_id')->nullable();
            $table->json('appraiser_type_fee')->after('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provided_services', function (Blueprint $table) {
            $table->dropColumn('appraiser_type_fee');
            $table->dropColumn('total_fee');
        });
    }
}
