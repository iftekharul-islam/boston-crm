<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalTypesTable extends Migration
{
	 /**
		* Run the migrations.
		*
		* @return void
		*/
	 public function up()
	 {
			Schema::create( 'appraisal_types', function (Blueprint $table) {
				 $table->id();
				 $table->foreignId( 'company_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
				 $table->string( 'form_type' )->nullable();
				 $table->string( 'modified_form' )->nullable();
				 $table->integer('condo_type')->default(0);
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
			Schema::dropIfExists( 'appraisal_types' );
	 }
}
