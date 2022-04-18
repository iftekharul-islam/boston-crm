<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Traits\FileHandler;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use League\Fractal\Serializer\ArraySerializer;
use Throwable;
use Illuminate\Http\Request;

class ProfileController extends BaseController {
	use FileHandler;

	protected UserTransformer $transformer;
	protected UserRepository $repository;
	protected CompanyRepository $companyRepository;

	/**
	 * @param UserTransformer   $user_transformer
	 * @param UserRepository    $user_repository
	 * @param CompanyRepository $company_repository
	 */
	public function __construct(
		UserTransformer $user_transformer,
		UserRepository $user_repository,
		CompanyRepository $company_repository
	) {
		parent::__construct();
		$this->transformer       = $user_transformer;
		$this->repository        = $user_repository;
		$this->companyRepository = $company_repository;
	}

	/**
	 * @param ProfileUpdateRequest $request
	 *
	 * @return Application|ResponseFactory|Response
	 * @throws Throwable
	 */
	public function update( ProfileUpdateRequest $request ): Response|Application|ResponseFactory {
		$user_id = auth()->user()->id;

		return DB::transaction( function () use ( $request, $user_id ) {
			$user = $this->repository->findById( $user_id )->findByFirst();
			if ( $request->file( 'image' ) ) {
				$user->fill( [ 'profile_photo_path' => $this->storeFile( $request->file( 'image' ) ) ] );
			}
			$user->fill( $request->only( 'name', 'mobile_number' ) )->save();
			$user_company = $this->repository->getCurrentCompany();
			if ( $user_company->pivot->user_id === $user_company->owner_id ) {
				$company                  = $this->companyRepository->findById( $user_company->id )->findByFirst();
				$company_description_data = [
					'name'        => $request->get( 'company_name' ),
					'description' => $request->get( 'description', '' ),
				];
				$company->fill( $company_description_data )->save();
				$user_company->name        = $company->name;
				$user_company->description = $company->description;
				$this->transformer->setActiveCompany( $user_company );
			}
			$this->transformer->setActiveCompany( $user_company );
			$user_data = fractal()->item( $user,
				$this->transformer )->includeCompanies()->serializeWith( new ArraySerializer )->toArray();

			return response( Helper::responseMessage( true, 201, trans( 'lang.update' ), $user_data ), 201 );
		} );
	}

	/**
	 * Get auth user information
	 *
	 * @param Request $request
	 *
	 * @return Application|ResponseFactory|Response
	 */
	public function getUserInfo( Request $request ): Response|Application|ResponseFactory {
		$user            = $this->repository->relations( $request->get( 'include',
			'' ) )->findById( auth()->user()->id )->findByFirst();
		$current_company = $this->repository->getCurrentCompany();
		$this->transformer->setActiveCompany( $current_company );
		$user = fractal()->item( $user, $this->transformer )->serializeWith( new ArraySerializer )->toArray();

		return response( Helper::responseMessage( true, 200, trans( 'lang.update' ), $user ), 200 );
	}
}
