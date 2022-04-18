<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreatedEvent;
use App\Events\UserMailVerificationEvent;
use App\Helpers\Helper;
use App\Http\Requests\AuthRegistrationRequest;
use App\Repositories\CompanyRepository;
use App\Transformers\UserTransformer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use League\Fractal\Serializer\ArraySerializer;
use Throwable;
use Illuminate\Support\Facades\DB;

class RegistrationController extends BaseController {
	private UserTransformer $transformer;
	private CompanyRepository $companyRepository;

	/**
	 * @param UserTransformer   $user_transformer
	 * @param CompanyRepository $company_repository
	 */
	public function __construct( UserTransformer $user_transformer, CompanyRepository $company_repository) {
		parent::__construct();
		$this->transformer = $user_transformer;
		$this->companyRepository = $company_repository;
	}

	/**
	 * New User registration.
	 *
	 * @param AuthRegistrationRequest $request
	 *
	 * @return Application|ResponseFactory|Response
	 * @throws Throwable
	 */
	public function registration( AuthRegistrationRequest $request ): Response|Application|ResponseFactory {
		return DB::transaction(function () use ($request){
			$user = $request->commit();
			if ( $user ) {

				$company_details = $this->companyRepository->setAndGetCompanyDetails($user);

				event( new UserCreatedEvent ( $user ) );
				event( new UserMailVerificationEvent( $user ) );

				$user_company = $user->companies()->where( 'active_company', 1 )->first();

				$this->transformer->setAuthToken( $user->createToken( 'auth_token' )->plainTextToken );
				$this->transformer->setPermissions( $company_details['role']->permissions()->pluck('name') );
				$this->transformer->setActiveCompany( $user_company );

				$user_data = fractal()->item( $user, $this->transformer )->serializeWith( new ArraySerializer )->toArray();

				return response( Helper::responseMessage( true, 201, trans( 'lang.success_registration' ), $user_data ),
					201 );
			}

			return response( Helper::responseMessage( false, 500, trans( 'lang.server_error' ) ), 500 );
		});
	}
}
