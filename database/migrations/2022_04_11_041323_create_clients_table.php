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
	 public function up()
	 {
			Schema::create( 'clients', function (Blueprint $table) {
				 $table->id();
				 $table->string( 'name' );
				 $table->string( 'email' )->nullable();
				 $table->string( 'phone' )->nullable();
				 $table->enum( 'client_type', [ 'amc', 'lender' ] )->comment( 'can be of two types' );
				 $table->string( 'address' )->nullable();
				 $table->string( 'city' )->nullable();
				 $table->string( 'state' )->nullable();
				 $table->string( 'country' )->nullable();
				 $table->string( 'zip' )->nullable();
				 $table->string( 'deducts_technology_fee' )->nullable();
				 $table->string( 'fee_for_1004uad' )->nullable();
				 $table->string( 'fee_for_1004d' )->nullable();
				 $table->tinyInteger( 'can_sign' )->nullable();
				 $table->tinyInteger( 'can_inspect' )->nullable();
				 $table->integer( 'company_id' );
				 $table->softDeletes();
				 $table->timestamps();
			} );
	 }
	 
	 /**
		* Reverse the migrations.
		*
		* @return void
		*/
	 public function down()
	 {
			Schema::dropIfExists( 'clients' );
	 }
};
