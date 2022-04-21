<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ClientRepository extends BaseRepository
{
    /**
     * @param Client $model
     */
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $result = $this->query->create($attributes);

        if (isset($attributes['instruction'])) {
            $this->model->find($result->id)->addMedia($attributes['instruction'])->toMediaCollection('clients');
        }
        return $result;
    }

    /**
     * @param string $type
     * @param int $pageNumber
     * @return array
     */
    public function getClientsData(string $type,int $pageNumber): array
    {
        $data = [];
        $data['all'] = $this->model->count();
        $data['amc'] = $this->model->where('client_type', 'amc')->count();
        $data['lender'] = $this->model->where('client_type', 'lender')->count();

        if ($type == 'all') {
            $data['clients'] = $this->model->paginate(1,['*'], 'page', $pageNumber);
            $data['pageNumber'] = $pageNumber;
        } else {
            $data['clients'] = $this->model->where('client_type', $type)->paginate(1,['*'], 'page', $pageNumber);
        }

        return $data;
    }
}
