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
			Schema::create( 'company_users', function (Blueprint $table) {
				 $table->id();
				 $table->unsignedBigInteger( 'company_id' );
				 $table->unsignedBigInteger( 'user_id' );
				 $table->unsignedBigInteger( 'role_id' )->nullable();
				 $table->integer( 'status' )->default( 1 );
				 $table->integer( 'active_company' )->default( 1 );
				 $table->date( 'join_date' )->nullable();
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
			Schema::dropIfExists( 'company_users' );
	 }
};
