<?php

namespace App\Repositories;

use App\Models\LoanType;

class LoanTypeRepository extends BaseRepository
{
	 /**
		* @param LoanType $model
		*/
	 public function __construct(LoanType $model)
	 {
			parent::__construct( $model );
	 }
}
