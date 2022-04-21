<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Services\CompanyService;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
	 protected CompanyService $service;
	 
	 /**
		* Company Services.
		*
		* @param CompanyService $company_service
		*/
	 public function __construct(CompanyService $company_service)
	 {
			$this->service = $company_service;
	 }
	 
	 /**
		* Display a listing of the resource.
		*
		* @return Application|Factory|View
		*/
	 public function index(): Application|Factory|View
	 {
			$roles = $this->service->getCompanyAllRoles();
			
			return view( 'role.index', compact( 'roles' ) );
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
		* @return RedirectResponse
		*/
	 public function store(RoleCreateRequest $request): RedirectResponse
	 {
			$user    = auth()->user();
			$company = $user->companies()->first();
			DB::transaction( function () use ($request, $company) {
				 $this->service->createRole( $request->get( 'name' ) )->getPermissions( $request->get( 'permissions' ) )->attachSelectedPermissions()->setCompany( $company )->attachRole();
			} );
			
			return redirect()->route( 'roles.index' );
	 }
	 
	 /**
		* Display the specified resource.
		*
		* @param int $id
		*
		* @return Response
		*/
	 public function show(int $id)
	 {
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
		* @return RedirectResponse
		*/
	 public function update(RoleUpdateRequest $request, int $id): RedirectResponse
	 {
			$role = $this->service->getRoleById( $id );
			DB::transaction( function () use ($request, $role) {
				 $this->service->setRole( $role )->updateRole( $request->get( 'name' ) )->getPermissions( $request->get( 'permissions' ) )->attachSelectedPermissions();
			} );
			
			return redirect()->route( 'roles.index' );
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
			$all_models   = $models->values()->map( function ($model) {
				 $model_name = strtolower( explode( utf8_encode( "\\" ), $model )[3] ?? '' );
				 if ( ! in_array( $model_name, [ '', 'companyuser', 'company' ] ) ) {
						return $model_name;
				 }
			} )->toArray();
			$all_models[] = 'role';
			
			return array_filter( $all_models );
	 }
}
