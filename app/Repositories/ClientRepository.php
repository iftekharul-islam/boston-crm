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

    public function update( array $attributes, int $id ): Model {
        $update_model = $this->find( $id );
        $update_model->update( $attributes );

        if (isset($attributes['instruction'])) {
            $this->model->find($id)->addMedia($attributes['instruction'])->toMediaCollection('clients');
        }

        return $update_model;
    }

    public function getClientsData(string $type, int $page_number, string $search_key,int $company_id): array
    {
        if ($search_key == '') {
            $data = [];
            $data['all'] = $this->model->filterByCompany($company_id)->count();
            $data['amc'] = $this->model->filterByCompany($company_id)->where('client_type', 'amc')->count();
            $data['lender'] =$this->model->filterByCompany($company_id)->where('client_type', 'lender')->count();

            if ($type == 'all') {
                $data['clients'] = $this->model->filterByCompany($company_id)->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            } else {
                $data['clients'] = $this->model->filterByCompany($company_id)->where('client_type', $type)->paginate(10, ['*'], 'page', $page_number);
            }
        } else {
            $data = [];

            $data['all'] = $this->model->searchFilters($search_key)->filterByCompany($company_id)->count();
            $data['amc'] = $this->model->searchFilters($search_key)->filterByCompany($company_id)->amc()->count();
            $data['lender'] = $this->model->searchFilters($search_key)->filterByCompany($company_id)->lender()->count();
            if ($type == 'all') {
                $data['clients'] = $this->model->searchFilters($search_key)->filterByCompany($company_id)->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            } else {
                $data['clients'] = $this->model->searchFilters($search_key)->filterByCompany($company_id)->where('client_type', $type)->get();
            }
        }
        return $data;
    }
}
