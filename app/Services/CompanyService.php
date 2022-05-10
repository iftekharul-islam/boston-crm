<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\UserInvite;
use App\Notifications\CompanyNewUserCreateNotification;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CompanyService
{
	 protected object $company;
	 protected object $role;
	 protected $user;
	 protected UserRepository $repository;
	 protected array $permissions = [];
	 
	 /**
		* @param UserRepository $user_repository
		*/
	 public function __construct(UserRepository $user_repository)
	 {
			$this->repository = $user_repository;
	 }
	 
	 /**
		* Create company and add company owner
		*
		* @param $user
		* @param $company_name
		*
		* @return $this
		*/
	 public function createCompany($user, $company_name): CompanyService
	 {
			$this->company = Company::query()->create( [
				'name'     => $company_name,
				'owner_id' => $user->id,
			] );
			
			return $this;
	 }
	 
	 /**
		* Set Company for assign role.
		*
		* @param $company
		*
		* @return CompanyService
		*/
	 public function setCompany($company): static
	 {
			$this->company = $company;
			
			return $this;
	 }
	 
	 /**
		* Company will attach with role
		*
		* @return $this
		*/
	 public function attachRole(): CompanyService
	 {
			$this->company->assignRole( $this->role );
			
			return $this;
	 }
	 
	 /**
		* user will attach with company
		* role will attach with user and company
		*
		* @param $user
		*
		* @return $this
		*/
	 public function setCompanyUserRole($user): CompanyService
	 {
			$user->companies()->attach( $this->company->id );
			CompanyUser::query()->where( 'company_id', $this->company->id )->where( 'user_id',
				$user->id )->first()->update( [ 'role_id' => $this->role->id ] );
			
			return $this;
	 }
	 
	 /**
		* Set User join date to company.
		*
		* @param $user
		*
		* @return $this
		*/
	 public function setCompanyUserJoinDate($user): CompanyService
	 {
			CompanyUser::query()->where( 'company_id', $this->company->id )->where( 'user_id',
				$user->id )->first()->update( [ 'join_date' => Carbon::now() ] );
			
			return $this;
	 }
	 
	 /**
		* @param $role
		*
		* @return $this
		*/
	 public function setRole($role): static
	 {
			$this->role = $role;
			
			return $this;
	 }
	 
	 /**
		* Create role
		* name will default admin
		* guard will default web
		*
		* @return $this
		*/
	 public function createRole($name = 'admin', $description = ''): CompanyService
	 {
			$this->role = Role::query()->create( [
				'name'        => strtolower( $name ),
				'description' => $description,
				'guard_name'  => 'web',
			] );
			
			return $this;
	 }
	 
	 /**
		* @param string $name
		* @param string $description
		*
		* @return $this
		*/
	 public function updateRole(string $name, string $description = ''): CompanyService
	 {
			$this->role->update( [ 'name' => strtolower( $name ), 'description' => $description ] );
			
			return $this;
	 }
	 
	 /**
		* Role will attach with permissions
		*
		* @return $this
		*/
	 public function attachPermissions(): CompanyService
	 {
			$this->role->syncPermissions( $this->getAllPermissions() );
			
			return $this;
	 }
	 
	 /**
		* @param $permission_names
		*
		* @return CompanyService
		*/
	 public function getPermissions($permission_names): static
	 {
			foreach ( $permission_names as $name ) {
				 $permission_data = Permission::query()->where( 'name', '=', $name )->first();
				 if ( $permission_data ) {
						$this->permissions[] = $permission_data;
				 } else {
						$this->permissions[] = Permission::query()->create( [
							"name"       => $name,
							"guard_name" => "web",
						] );
				 }
			}
			
			return $this;
	 }
	 
	 /**
		* @return CompanyService
		*/
	 public function attachSelectedPermissions(): static
	 {
			$this->role->syncPermissions( $this->permissions );
			
			return $this;
	 }
	 
	 /**
		* Return company details
		* Return Role
		* @return array
		*/
	 #[ArrayShape([ 'company' => "", 'role' => "" ])] public function getCompanyAndRole(): array
	 {
			return [
				'company' => $this->company,
				'role'    => $this->role,
			];
	 }
	 
	 /**
		* Get all permissions
		*
		* @return Builder[]|Collection
		*/
	 public function getAllPermissions(): Collection|array
	 {
			return Permission::query()->get();
	 }
	 
	 /**
		* Get Company all roles.
		*
		* @return mixed
		*/
	 public function getCompanyAllRoles(): mixed
	 {
			$user_company = auth()->user()->companies()->first();
			
			return $user_company->roles()->with( 'permissions', function ($query) {
				 return $query->get( [ 'name' ] );
			} )->get();
	 }
	 
	 /**
		* @param int $id
		*
		* @return Model|Collection|Builder|array|null
		*/
	 public function getRoleById(int $id): Model|Collection|Builder|array|null
	 {
			return Role::query()->with( 'permissions' )->findOrFail( $id );
	 }
	 
	 /**
		* Get Company all user list.
		*
		* @return array
		*/
	 #[ArrayShape([ 'company' => "mixed", 'users' => "mixed" ])] public function getCompanyAllUsers(): array
	 {
			$user_company = auth()->user()->companies()->first();
			
			return [
				'company' => $user_company,
				'users'   => $user_company->users()->with( 'userProfile' )->paginate( 10 ),
			];
	 }
	 
	 /**
		* Get auth user company.
		*
		* @return mixed
		*/
	 public function getAuthUserCompany(): mixed
	 {
			return auth()->user()->companies()->first();
	 }
	 
	 /**
		* @param array $data
		*
		* @return CompanyService
		*/
	 public function createUser(array $data): CompanyService
	 {
			$this->user = $this->repository->create( $data );
			
			return $this;
	 }
	 
	 /**
		* @param $company
		* @param $role_id
		*
		* @return $this
		*/
	 public function syncWithCompany($company, $role_id): static
	 {
			CompanyUser::query()->create( [
				'company_id' => $company->id,
				'user_id'    => $this->user->id,
				'role_id'    => $role_id,
				'status'     => 0,
			] );
			
			return $this;
	 }
	 
	 /**
		* @param $code
		*
		* @return void
		*/
	 public function sendMailToUser($code): void
	 {
			Notification::route( 'mail',
				$this->user->email )->notify( new CompanyNewUserCreateNotification( email: $this->user->email, code: $code ) );
	 }
	 
	 /**
		* @param $email
		* @param $code
		*
		* @return CompanyService
		*/
	 public function createInvite($email, $code): CompanyService
	 {
			UserInvite::query()->create( [ 'email' => $email, 'code' => $code ] );
			
			return $this;
	 }
}
