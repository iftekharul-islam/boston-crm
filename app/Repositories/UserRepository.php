<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
	 /**
		* UserRepository constructor.
		*
		* @param User $model
		*/
	 public function __construct(User $model)
	 {
			parent::__construct( $model );
	 }

	 /**
		* Get user by email
		*
		* @param $email
		*
		* @return Model|Builder|null
		*/
	 public function findByEmail($email): Model|Builder|null
	 {
			return $this->query->with('userProfile')->where( 'email', $email )->first();
	 }
}
