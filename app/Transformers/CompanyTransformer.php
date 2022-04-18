<?php

namespace App\Transformers;

use App\Models\Company;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract {
	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected array $availableIncludes = [
		'meetings',
		'users',
	];

	/**
	 * @param Company $company
	 *
	 * @return array
	 */
	#[ArrayShape( [ 'id'            => "mixed",
                    'name'          => "mixed",
                    'address'       => "mixed",
                    'contact'       => "mixed",
                    'status'        => "mixed",
                    'owner_id'      => "mixed",
                    'active_status' => "mixed",
                    'join_date'     => "mixed"
    ] )] public function transform( Company $company ): array {
		return [
			'id'            => $company->id,
			'name'          => $company->name,
			'address'       => $company->address,
			'contact'       => $company->contact,
			'status'        => $company->status,
			'owner_id'      => $company->owner_id,
			'active_status' => $company->pivot->active_company ?? null,
			'join_date'     => $company->pivot->join_date ?? '',
		];
	}

	/**
	 * Include User
	 *
	 * @param Company $company
	 *
	 * @return Collection
	 */
	public function includeUsers( Company $company ): Collection {
		return $this->collection( $company->users, new UserTransformer() );
	}
}
