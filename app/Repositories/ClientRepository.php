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
    public function getClientsData(string $type, int $pageNumber, string $searchKey): array
    {
        if ($searchKey == '') {
            $data = [];
            $data['all'] = $this->model->count();
            $data['amc'] = $this->model->where('client_type', 'amc')->count();
            $data['lender'] = $this->model->where('client_type', 'lender')->count();

            if ($type == 'all') {
                $data['clients'] = $this->model->paginate(10, ['*'], 'page', $pageNumber);
                $data['pageNumber'] = $pageNumber;
            } else {
                $data['clients'] = $this->model->where('client_type', $type)->paginate(10, ['*'], 'page', $pageNumber);
            }
        } else {
            $data = [];
//            dd($searchKey);
            $data['all'] = $this->model
                ->where(function ($query) use($searchKey){
                    $query->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('email','like','%' . $searchKey . '%')
                        ->orWhere('phone','like','%' . $searchKey . '%');
                })
                ->count();
            $data['amc'] = $this->model
                ->where('client_type', 'amc')
                ->where(function ($query) use($searchKey){
                    $query->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('email','like','%' . $searchKey . '%')
                        ->orWhere('phone','like','%' . $searchKey . '%');
                })
                ->count();
            $data['lender'] = $this->model
                ->where('client_type', 'lender')
                ->where(function ($query) use($searchKey){
                    $query->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('email','like','%' . $searchKey . '%')
                        ->orWhere('phone','like','%' . $searchKey . '%');
                })
                ->count();

            if ($type == 'all') {
                $data['clients'] = $this->model
                    ->where(function ($query) use($searchKey){
                        $query->where('name', 'like', '%' . $searchKey . '%')
                            ->orWhere('email','like','%' . $searchKey . '%')
                            ->orWhere('phone','like','%' . $searchKey . '%');
                    })
                    ->paginate(10, ['*'], 'page', $pageNumber);
                $data['pageNumber'] = $pageNumber;
            } else {
                $data['clients'] = $this->model->where('client_type', $type)
                    ->where(function ($query) use($searchKey){
                        $query->where('name', 'like', '%' . $searchKey . '%')
                            ->orWhere('email','like','%' . $searchKey . '%')
                            ->orWhere('phone','like','%' . $searchKey . '%');
                    })
                    ->paginate(10, ['*'], 'page', $pageNumber);
            }
        }


        return $data;
    }
}
