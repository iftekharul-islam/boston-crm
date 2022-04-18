<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'companies', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'address' )->nullable();
            $table->string( 'contact' )->nullable();
            $table->integer( 'status' )->default( 1 );
            $table->integer( 'owner_id' );
            $table->string( 'description' )->nullable();
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'companies' );
    }
};
