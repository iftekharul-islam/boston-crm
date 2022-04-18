<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Support\Facades\DB;
use Throwable;

class CompanyRepository extends BaseRepository {
	protected CompanyService $service;

	/**
	 * @param Company        $model
	 * @param CompanyService $company_service
	 */
	public function __construct( Company $model, CompanyService $company_service ) {
		parent::__construct( $model );
		$this->service = $company_service;
	}

    /**
     * create company
     * create role
     * attach permission
     * attach role
     * get company details
     *
     * @param User   $user
     * @param string $company_name
     *
     * @return mixed
     */
	public function setAndGetCompanyDetails( User $user, string $company_name ): mixed {
		return DB::transaction( function () use ( $user, $company_name ) {
			return $this->service->createRole()->attachPermissions()->createCompany( $user, $company_name )->attachRole()->setCompanyUserRole( $user )->setCompanyUserJoinDate( $user )
				->getCompanyAndRole();
		} );
	}
}
