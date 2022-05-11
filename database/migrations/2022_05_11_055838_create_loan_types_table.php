<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTypesTable extends Migration
{
	 /**
		* Run the migrations.
		*
		* @return void
		*/
	 public function up()
	 {
			Schema::create( 'loan_types', function (Blueprint $table) {
				 $table->id();
				 $table->foreignId( 'company_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
				 $table->string( 'name' );
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
			Schema::dropIfExists( 'loan_types' );
	 }
}
