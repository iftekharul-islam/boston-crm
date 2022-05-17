<?php

namespace App\Repositories;

use App\Models\AppraisalType;
use App\Models\Client;
use App\Models\CompanyUser;
use App\Models\LoanType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\NoReturn;
use Spatie\Permission\Models\Role;

class OrderRepository extends BaseRepository
{
	 protected object $company;
	 protected object $role;
	 protected object $users;
	 
	 public function __construct(Order $model)
	 {
			parent::__construct( $model );
			$this->users = collect();
	 }
	 
	 /**
		* @param string $role
		*
		* @return Collection|\Illuminate\Support\Collection|array
		*/
	 public function getUserByRoleWise(string $role): Collection|\Illuminate\Support\Collection|array
	 {
            $this->company          = $this->getAuthUserCompany();
			$role = $this->getRoleByName( $role );
			if ( $role ) {
				 $this->users = $this->getCompanyUsers( $role );
			}


         return $this->users;
	 }
	 
	 /**
		* @param object $role
		*
		* @return Builder[]|Collection
		*/
	 #[NoReturn] public function getCompanyUsers(object $role): Collection|array
	 {
			$company_user_ids = CompanyUser::query()?->where( [
				[ 'company_id', '=', $this->company->id ],
				[ 'role_id', $role->id ],
				['status', 1]
			] )->pluck( 'user_id' );
			
			return User::query()->whereIn( 'id', $company_user_ids )->get( [ 'id', 'name', 'email' ] );
	 }
	 
	 /**
		* @return mixed
		*/
	 public function getAuthUserCompany(): mixed
	 {
			return auth()->user()->companies()->first();
	 }
	 
	 /**
		* @param string $name
		*
		* @return Model|Builder|null
		*/
	 public function getRoleByName(string $name): Model|Builder|null
	 {
			return Role::query()->where( 'name', $name )->first();
	 }
	 
	 /**
		* @return Builder[]|Collection
		*/
	 public function getAppraisalTypes(): Collection|array
	 {
			return AppraisalType::query()->where('company_id', $this->company->id)->get();
	 }
	 
	 /**
		* @return Builder[]|Collection
		*/
	 public function getLoanTypes(): Collection|array
	 {
			return LoanType::query()->where('company_id', $this->company->id)->get();
	 }
	 
	 /**
		* @return Builder[]|Collection
		*/
	 public function getClients(): Collection|array
	 {
			return Client::query()->where('company_id', $this->company->id)->get();
	 }

     public function getBasicInfo() : Collection|array
     {

     }
}
