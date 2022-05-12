<?php

namespace App\Repositories;

use App\Models\AppraisalType;

class AppraisalTypeRepository extends BaseRepository
{
	 /**
		* @param AppraisalType $model
		*/
	 public function __construct(AppraisalType $model)
	 {
			parent::__construct( $model );
	 }
}
