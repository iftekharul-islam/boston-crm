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

     public function allLoanTypes($company_id){
         return $this->model->where('company_id',$company_id)->paginate(10);
     }
}
