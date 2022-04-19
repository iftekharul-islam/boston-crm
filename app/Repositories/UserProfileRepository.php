<?php

namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserProfileRepository extends BaseRepository
{
	 /**
		* UserProfileRepository constructor.
		*
		* @param UserProfile $model
		*/
	 public function __construct(UserProfile $model)
	 {
			parent::__construct( $model );
	 }
	 
	 /**
		* @param $user_id
		*
		* @return Model|Builder|null
		*/
	 public function getUserProfileByUserId($user_id): Model|Builder|null
	 {
			return $this->query->where('user_id', $user_id)->first();
	 }
	 
	 /**
		* @return mixed
		*/
	 public function getAuthUserProfile(): mixed
	 {
			return auth()->user()->userProfile();
	 }
}
