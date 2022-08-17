<?php

namespace App\Repositories;

use App\Models\AppraisalType;

class AppraisalTypeRepository extends BaseRepository
{
    /**
     * @param AppraisalType $model
     */
    public function __construct(AppraisalType $model)
    {
        parent::__construct($model);
    }

    public function allAppraisalTypes($company_id)
    {
        return $this->model->where('company_id', $company_id)->paginate(10);
    }

    public function allAppraisalTypesRaw($company_id)
    {
        return $this->model->where('company_id', $company_id)->get();
    }
}
