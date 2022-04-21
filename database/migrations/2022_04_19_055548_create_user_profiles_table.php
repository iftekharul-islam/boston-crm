<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
	 /**
		* Run the migrations.
		*
		* @return void
		*/
	 public function up()
	 {
			Schema::create( 'user_profiles', function (Blueprint $table) {
				 $table->id();
				 $table->foreignId( 'user_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
				 $table->string( 'address' )->nullable();
				 $table->string( 'city' )->nullable();
				 $table->string( 'state' )->nullable();
				 $table->string( 'zip_code' )->nullable();
				 $table->string( 'phone' )->nullable();
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
			Schema::dropIfExists( 'user_profiles' );
	 }
}
