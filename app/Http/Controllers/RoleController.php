<?php

namespace App\Http\Controllers;

use App\Helpers\CrmHelper;
use App\Models\CompanyUser;
use Illuminate\Http\Response;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Contracts\Foundation\Application;

class RoleController extends BaseController
{
	 protected CompanyService $service;
	 use CrmHelper;

	 /**
		* Company Services.
		*
		* @param CompanyService $company_service
		*/
	 public function __construct(CompanyService $company_service)
	 {
			parent::__construct();
			$this->service = $company_service;
	 }

	 /**
		* Display a listing of the resource.
		*
		* @return Application|Factory|View
		*/
	 public function index() //: Application|Factory|View
	 {
			$roles       = $this->service->getCompanyAllRoles();
			$permissions = $this->getModels();

			return view( 'role.index', compact( 'roles', 'permissions' ) );
	 }

	 /**
		* Show the form for creating a new resource.
		*
		* @return Application|Factory|View
		*/
	 public function create(): View|Factory|Application
	 {
			$permissions = $this->getModels();

			return view( 'role.create', compact( 'permissions' ) );
	 }

	 /**
		* Store a newly created resource in storage.
		*
		* @param RoleCreateRequest $request
		*
		* @return JsonResponse
		*/
	 public function store(RoleCreateRequest $request): JsonResponse
	 {
			$user    = auth()->user();
			$company = $user->companies()->first();
			DB::transaction( function () use ($request, $company, $user) {
				 $this->service->createRole( $request->get( 'name' ), $company, $request->get( 'description' ), $user )->getPermissions( $request->get( 'permissions', [] ) )->attachSelectedPermissions()->setCompany( $company )->attachRole();
			} );

			return response()->json( [ 'success' => true, 'message' => 'Successfully create role' ] );
	 }

	 /**
		* Show the form for editing the specified resource.
		*
		* @param int $id
		*
		* @return Application|Factory|View
		*/
	 public function edit(int $id): View|Factory|Application
	 {
			$role                   = $this->service->getRoleById( $id );
			$permissions            = $this->getModels();
			$role_permissions_names = $role->permissions()->pluck( 'name' )->toArray();

			return view( 'role.edit', compact( 'role', 'permissions', 'role_permissions_names' ) );
	 }

	 /**
		* Update the specified resource in storage.
		*
		* @param RoleUpdateRequest $request
		* @param int               $id
		*
		* @return JsonResponse
		*/
	 public function update(RoleUpdateRequest $request, int $id): JsonResponse
	 {
			$role = $this->service->getRoleById( $id );
			DB::transaction( function () use ($request, $role) {
				 $this->service->setRole( $role )->updateRole( name: $request->get( 'name' ),
					 description: $request->get( 'description' ) )->getPermissions( $request->get( 'permissions', [] ) )->attachSelectedPermissions();
			} );

			return response()->json( [ 'success' => true, 'message' => 'Successfully create role' ] );
	 }

	 /**
		* Remove the specified resource from storage.
		*
		* @param int $id
		*
		* @return JsonResponse
		*/
	 public function destroy(int $id): JsonResponse
	 {
			$role = Role::query()->findOrFail( $id );

			$role_user_exists = CompanyUser::query()->where('role_id', $role->id)->exists();
			if ($role_user_exists) {
				 return response()->json( [ 'success' => false, 'message' => 'Role has active users. You have to remove role from those users first.' ] );
			}

			return response()->json( [ 'success' => $role->delete() ] );
	 }

	 /**
		* Get All Model Name.
		*
		* @return array
		*/
	 public function getModels(): array
	 {
			$models       = collect( File::allFiles( app_path() ) )->map( function ($item) {
				 $path = $item->getRelativePathName();

				 return sprintf( '\%s%s', Container::getInstance()->getNamespace(),
					 strtr( substr( $path, 0, strrpos( $path, '.' ) ), '/', '\\' ) );
			} )->filter( function ($class) {
				 $valid = false;
				 if ( class_exists( $class ) ) {
						$reflection = new \ReflectionClass( $class );
						$valid      = $reflection->isSubclassOf( Model::class ) && ! $reflection->isAbstract();
				 }

				 return $valid;
			} );
			$ignore_model = [ '', 'companyuser', 'company', 'userprofile', 'userinvite' ];
			$all_models   = $models->values()->map( function ($model) use ($ignore_model) {
				 $model_name = strtolower( explode( utf8_encode( "\\" ), $model )[3] ?? '' );
				 if ( ! in_array( $model_name, $ignore_model ) ) {
						return $model_name;
				 }
			} )->toArray();
			$all_models[] = 'role';

			return array_filter( $all_models );
	 }
}
