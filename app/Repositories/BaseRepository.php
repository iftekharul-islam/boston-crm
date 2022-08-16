<?php

namespace App\Repositories;

use App\Interfaces\EloquentRepositoryInterface;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class BaseRepository implements EloquentRepositoryInterface {
	/**
	 * @var Model
	 */
	protected $query;
	protected $model;

	/**
	 * BaseRepository constructor.
	 *
	 * @param Model $model
	 */
	public function __construct( Model $model ) {
		$this->query = $model->query();
		$this->model = $model;
	}

	/**
	 * @param array $attributes
	 *
	 * @return Model
	 */
	public function create( array $attributes ): Model {
		return $this->query->create( $attributes );
	}

    /**
     * @param int $id
     *
     * @return Model|null
     */
	public function find( int $id ): ?Model {
		return $this->query->find( $id );
	}

	/**
	 * @param array $attributes
	 * @param int   $id
	 *
	 * @return Model
	 */
	public function update( array $attributes, int $id ): Model {
		$update_model = $this->find( $id );
		$update_model->update( $attributes );

		return $update_model;
	}

	/**
	 * Get all data list.
	 * Get relation data if include relational name.
	 *
	 * @return Collection
	 */
	public function all(): Collection {
		return $this->query->get();
	}

	/**
	 * Get all data list with paginate.
	 * Get relation data if include relational name.
	 *
	 * @param int|null $per_page
	 *
	 * @return LengthAwarePaginator
	 */
	public function allPagination( ?int $per_page = 10 ): LengthAwarePaginator {
		return $this->query->paginate( $per_page );
	}

	/**
	 * @param int $id
	 *
	 * @return bool|null
	 */
	public function delete( int $id ): ?bool {
		$delete_model_data = $this->find( $id );
		if ( $delete_model_data ) {
			return $delete_model_data->delete();
		}

		return false;
	}

	/**
	 * @param int $id
	 *
	 * @return BaseRepository
	 */
	public function findById( int $id ): BaseRepository {
		$this->query->where( 'id', $id );

		return $this;
	}

	/**
	 * Get Auth user data by user id.
	 *
	 * @param int $user_id
	 *
	 * @return BaseRepository
	 */
	public function findByAuthUser( int $user_id ): BaseRepository {
		$this->query->where( 'user_id', $user_id );

		return $this;
	}

	/**
	 * Find By Company ID.
	 *
	 * @param int $company_id
	 *
	 * @return $this
	 */
	public function findByCompanyId( int $company_id ): BaseRepository {
		$this->query->where( 'company_id', $company_id );

		return $this;
	}

	/**
	 * Get first match data.
	 *
	 * @return Builder|Model|object|null
	 */
	public function findByFirst() {
		return $this->query->first();
	}

	/**
	 * Get All relational data.
	 *
	 * @param string|null $withRelationNames
	 *
	 * @return BaseRepository
	 */
	public function relations( ?string $withRelationNames = '' ): BaseRepository {
		$relations = $this->getRelationalName( $withRelationNames );
		$this->query->with( $relations );

		return $this;
	}

	/**
	 * Data order by attribute ASC or DESC
	 *
	 * @param string|null $attribute
	 * @param string|null $sort
	 *
	 * @return BaseRepository
	 */
	public function orderBy( ?string $attribute, ?string $sort = 'DESC' ): BaseRepository {
		$data_sort = $sort && in_array( $sort, [ 'asc', 'desc', 'ASC', 'DESC' ] ) ? $sort : 'DESC';
		$this->query->orderBy( $attribute, $data_sort );

		return $this;
	}

	/**
	 * Get data on status based.
	 *
	 * @param string|null $status
	 *
	 * @return BaseRepository
	 */
	public function status( ?string $status = '' ): BaseRepository {
		if ( $status ) {
			$this->query->whereIn( 'status', explode( ',', $status ) );
		}

		return $this;
	}

	/**
	 * Get list of model relation name array.
	 *
	 * @param $model_relation_name
	 *
	 * @return array|false|string[]
	 */
	public function getRelationalName( $model_relation_name ) {
		if ( $model_relation_name ) {
			return explode( ',', $model_relation_name );
		}

		return [];
	}

	/**
	 * Get current user active company.
	 *
	 * @return mixed|null
	 */
	public function getCurrentCompany() {
		return auth()->user()->companies()->where( 'active_company', 1 )->first();
	}
}
