<?php

namespace App\Services;

use App\Models\CompanyUser;
use App\Models\UserInvite;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class UserService
{
	 protected object $user;
	 protected object $profile;
	 protected UserRepository $repository;
	 protected UserProfileRepository $profileRepository;
	 
	 /**
		* @param UserRepository        $user_repository
		* @param UserProfileRepository $profile_repository
		*/
	 public function __construct(UserRepository $user_repository, UserProfileRepository $profile_repository)
	 {
			$this->repository        = $user_repository;
			$this->profileRepository = $profile_repository;
	 }
	 
	 /**
		* @param $attributes
		* @param $user
		*
		* @return $this
		*/
	 public function updateUser($attributes, $user): static
	 {
			$this->user = $user;
			$this->user->update( $attributes );
			
			return $this;
	 }
	 
	 /**
		* @param $attributes
		* @param $user_id
		*
		* @return UserService
		*/
	 public function updateProfile($attributes, $user_id): static
	 {
			$this->profileRepository->updateProfile( attributes: $attributes, user_id: $user_id );
			
			return $this;
	 }
	 
	 /**
		* @param $company_id
		* @param $user_id
		*
		* @return $this
		*/
	 public function activeUser($company_id, $user_id): static
	 {
			$company_user = CompanyUser::query()->where( 'company_id', $company_id )->where( 'user_id', $user_id )->first();
			if ( ! $company_user->status ) {
				 $company_user->update( [ 'status' => 1, 'join_date' => Carbon::now()->format( 'Y-m-d' ) ] );
			}
			
			return $this;
	 }
	 
	 public function updateProfileImage($image)
	 {
			if ($image) {
			
			}
			return $this;
			
	 }
	 
	 /**
		* @param string $email
		*
		* @return $this
		*/
	 public function deleteInvite(string $email): static
	 {
			UserInvite::query()->where('email', $email)->delete();
			return $this;
	 }
}
