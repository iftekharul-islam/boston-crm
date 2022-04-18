<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface EloquentRepositoryInterface
 *
 * @package App\Repositories
 */
interface EloquentRepositoryInterface {
	/**
	 * @return Collection
	 */
	public function all(): Collection;
	
	/**
	 * @param array $attributes
	 *
	 * @return Model
	 */
	public function create( array $attributes ): Model;
	
	/**
	 * @param array $attributes
	 * @param int   $id
	 *
	 * @return Model
	 */
	public function update( array $attributes, int $id ): Model;
	
	/**
	 * @param int $id
	 *
	 * @return Model
	 */
	public function find( int $id ): ?Model;
	
	/**
	 * @param int $id
	 *
	 * @return bool|null
	 */
	public function delete( int $id ): ?bool;
}
