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

    public function getClientsData(string $type, int $page_number, string $search_key,int $company_id): array
    {
        if ($search_key == '') {
            $data = [];
            $data['all'] = $this->model->where('company_id',$company_id)->count();
            $data['amc'] = $this->model->where('company_id',$company_id)->where('client_type', 'amc')->count();
            $data['lender'] = $this->model->where('company_id',$company_id)->where('client_type', 'lender')->count();

            if ($type == 'all') {
                $data['clients'] = $this->model->where('company_id',$company_id)->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            } else {
                $data['clients'] = $this->model->where('company_id',$company_id)->where('client_type', $type)->paginate(10, ['*'], 'page', $page_number);
            }
        } else {
            $data = [];
//            dd($searchKey);
            $data['all'] = $this->model
                ->where(function ($query) use($search_key){
                    $query->where('name', 'like', '%' . $search_key . '%')
                        ->orWhere('email','like','%' . $search_key . '%')
                        ->orWhere('phone','like','%' . $search_key . '%');
                })
                ->where('company_id',$company_id)
                ->count();
            $data['amc'] = $this->model
                ->where('client_type', 'amc')
                ->where(function ($query) use($search_key){
                    $query->where('name', 'like', '%' . $search_key . '%')
                        ->orWhere('email','like','%' . $search_key . '%')
                        ->orWhere('phone','like','%' . $search_key . '%');
                })
                ->where('company_id',$company_id)
                ->count();
            $data['lender'] = $this->model
                ->where('client_type', 'lender')
                ->where(function ($query) use($search_key){
                    $query->where('name', 'like', '%' . $search_key . '%')
                        ->orWhere('email','like','%' . $search_key . '%')
                        ->orWhere('phone','like','%' . $search_key . '%');
                })
                ->where('company_id',$company_id)
                ->count();

            if ($type == 'all') {
                $data['clients'] = $this->model
                    ->where(function ($query) use($search_key){
                        $query->where('name', 'like', '%' . $search_key . '%')
                            ->orWhere('email','like','%' . $search_key . '%')
                            ->orWhere('phone','like','%' . $search_key . '%');
                    })
                    ->where('company_id',$company_id)
                    ->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            } else {
                $data['clients'] = $this->model->where('client_type', $type)
                    ->where(function ($query) use($search_key){
                        $query->where('name', 'like', '%' . $search_key . '%')
                            ->orWhere('email','like','%' . $search_key . '%')
                            ->orWhere('phone','like','%' . $search_key . '%');
                    })
                    ->where('company_id',$company_id)
                    ->paginate(10, ['*'], 'page', $page_number);
            }
        }
        return $data;
    }
}
