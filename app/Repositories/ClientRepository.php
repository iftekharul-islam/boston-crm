<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends BaseRepository {
    /**
     * @param Client $model
     */
    public function __construct( Client $model ) {
        parent::__construct( $model );
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create( array $attributes ): Model {
        $result = $this->query->create( $attributes );

        if($attributes['instruction']){
            $this->model->find($result->id)->addMedia($attributes['instruction'])->toMediaCollection();
        }
        return $result;
    }
}
