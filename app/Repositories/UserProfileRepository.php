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
	public function __construct(UserProfile $model) {
		parent::__construct($model);
	}
	
	/**
	 * @param $user_id
	 *
	 * @return Model|Builder|null
	 */
	public function getUserProfileByUserId($user_id): Model|Builder|null {
		return $this->query->where('user_id', $user_id)->first();
	}
	
	/**
	 * @return Model|Builder|null
	 */
	public function getAuthUserProfile(): Model|Builder|null {
		return UserProfile::query()->where('user_id', auth()->user()->id)->first();
	}
	
	/**
	 * @param array $attributes
	 * @param int   $user_id
	 *
	 * @return Builder|Model
	 */
	public function updateProfile(array $attributes, int $user_id): Builder|Model {
		return $this->query->updateOrCreate([ 'user_id' => $user_id ], $attributes);
	}
}
