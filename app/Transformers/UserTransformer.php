<?php

namespace App\Transformers;

use App\Models\User;
use JetBrains\PhpStorm\Pure;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {
	protected string $authToken;
	protected array $permissions;
	protected array $activeCompany;
	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected array $availableIncludes = [
		'userConfig',
		'meetingTypes',
		'meetings',
		'appointments',
		'meetingMembers',
		'companies',
	];

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	#[Pure] public function transform( User $user ): array {
		return [
			'id'                 => $user->id,
			'name'               => $user->name,
			'email'              => $user->email,
			'profile_photo_path' => $user->profile_photo_path,
			'profile_photo_url'  => $user->profile_photo_url,
			'mobile_number'      => $user->mobile_number,
			'about_me'           => $user->about_me,
			'active_company'     => $this->activeCompany,
			'token'              => $this->authToken ?? false ? $this->authToken : null,
			'permissions'        => $this->permissions ?? false ? $this->permissions : null,
			'is_verified'        => $user->hasVerifiedEmail(),
		];
	}

	/**
	 * Set User Auth token to response.
	 *
	 * @param $auth_token
	 */
	public function setAuthToken( $auth_token ) {
		$this->authToken = $auth_token;
	}

    /**
     * @param $permissions
     *
     * @return void
     */
	public function setPermissions( $permissions ) {
		$this->permissions = $permissions;
	}

    /**
     * @param $activeCompany
     *
     * @return void
     */
	public function setActiveCompany( $activeCompany ) {
		$this->activeCompany = [
			'id'          => $activeCompany->id,
			'name'        => $activeCompany->name,
			'description' => $activeCompany->description,
			'is_owner'    => $activeCompany->pivot->user_id === $activeCompany->owner_id,
		];
	}

	/**
	 * Include Companies
	 *
	 * @param User $user
	 *
	 * @return Collection
	 */
	public function includeCompanies( User $user ): Collection {
		return $this->collection( $user->companies, new CompanyTransformer() );
	}
}
