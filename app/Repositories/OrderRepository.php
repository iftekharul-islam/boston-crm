<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use App\Models\AppraisalDetail;
use App\Models\AppraisalType;
use App\Models\BorrowerInfo;
use App\Models\Client;
use App\Models\CompanyUser;
use App\Models\ContactInfo;
use App\Models\LoanType;
use App\Models\Order;
use App\Models\PropertyInfo;
use App\Models\OrderWInspection;
use App\Models\ProvidedService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use JetBrains\PhpStorm\NoReturn;
use PhpParser\Node\Scalar\String_;
use Spatie\Permission\Models\Role;

class OrderRepository extends BaseRepository
{
    protected object $company;
    protected object $role;
    protected object $users;

    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->users = collect();
    }

    /**
     * @param string $role
     *
     * @return Collection|\Illuminate\Support\Collection|array
     */
    public function getUserByRoleWise(string $role)//: Collection|\Illuminate\Support\Collection|array
    {
        $this->company = $this->getAuthUserCompany();
        $role = $this->getRoleByName($role);
        if ($role) {
            $this->users = $this->getCompanyUsers($role);
        }
        return $this->users;
    }

    public function getUserExpectRole(string $role): Collection|\Illuminate\Support\Collection|array
    {
        $this->company = $this->getAuthUserCompany();
        $role = $this->getRoleByName($role);
        if ($role) {
            $this->users = $this->getCompanyUsersWithoutAdmin($role);
        }
        return $this->users;
    }

    /**
     * @param $order_id
     * @return mixed
     */
    public function getOrderFileTypes($order_id): mixed
    {
        return $this->model->find($order_id)->order_file_types;
    }

    /**
     * @param $order_id
     * @return mixed
     */
    public function getOrderDueDate($order_id): mixed
    {
        return $this->model->where('id', $order_id)->select('due_date')->first();
    }

    /**
     * @param $order_id
     * @return mixed
     */
    public function getDurations($order_id): mixed
    {
        return OrderWInspection::where('order_id', $order_id)->durations->first();
    }

    /**
     * @param object $role
     *
     * @return Builder[]|Collection
     */
    #[NoReturn] public function getCompanyUsers(object $role): Collection|array
    {
        $array = ['role_id', '=', $role->id];
        if ($role->name == 'appraiser') {
            $array = ['role_name', '=', 'appraiser'];
        }
        $company_user_ids = CompanyUser::query()?->where([
            ['company_id', '=', $this->company->id],
            $array,
            ['status', 1]
        ])->pluck('user_id');

        return User::query()->whereIn('id', $company_user_ids)->get(['id', 'name', 'email']);
    }

    #[NoReturn] public function getCompanyUsersWithoutAdmin(object $role): Collection|array
    {
        if ($role->name == 'appraiser') {
            $array = ['role_name', 'appraiser'];
        }
        $company_user_ids = CompanyUser::query()?->where([
            ['company_id', '=', $this->company->id],
            ['status', 1]
        ])->where('role_id', '!=', $role->id)->pluck('user_id');

        return User::query()->whereIn('id', $company_user_ids)->get(['id', 'name', 'email']);
    }

    /**
     * @return mixed
     */
    public function getAuthUserCompany(): mixed
    {
        return auth()->user()->companies()->first();
    }

    /**
     * @param string $name
     *
     * @return Model|Builder|null
     */
    public function getRoleByName(string $name): Model|Builder|null
    {
        return Role::query()->where('name', $name)->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAppraisalTypes(): Collection|array
    {
        return AppraisalType::query()->where('company_id', $this->company->id)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getLoanTypes(): Collection|array
    {
        return LoanType::query()->where('company_id', $this->company->id)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getClients(): Collection|array
    {
        return Client::query()->where('company_id', $this->company->id)->get();
    }

    /**
     * @param $order_id
     * @return Builder|Model
     */
    public function getPropertyInfo($order_id): Builder|Model
    {
        return PropertyInfo::query()->where('order_id', $order_id)->first();
    }

    /**
     * @param $order_id
     * @param $data
     * @return bool
     */
    public function updateBasicInfo($order_id, $data): bool
    {
        return Order::query()->where('id', $order_id)->update([
            "client_order_no" => $data["client_order_no"],
            "received_date" => Carbon::parse($data["received_date"])->format('Y-m-d'),
            "due_date" => Carbon::parse($data["due_date"])->format('Y-m-d')
        ]);
    }

    public function updatePropertyInfo($order_id,$data): bool
    {
        return PropertyInfo::query()->where('order_id', $order_id)->update([
            "search_address" => $data['search_address'],
            "street_name" => $data['street_name'],
            "city_name" => $data['city_name'],
            "state_name" => $data['state_name'],
            "zip" => $data['zip'],
            "country" => $data['country'],
            "unit_no" => $data['unit_no'],
        ]);
    }

    /**
     * @param $order_id
     * @param $data
     * @return bool
     */
    public function updateAppraisalInfo($order_id, $data): bool
    {
        return AppraisalDetail::query()->where('order_id', $order_id)->update([
            "appraiser_id" => $data['appraiser_id'],
            "loan_type" => $data['loan_type'],
            "fha_case_no" => $data['fha_case_no'],
            "loan_no" => $data['loan_no'],
        ]);
    }


    /**
     * @param $type
     * @return Builder|Collection
     */
    public function getAllClientByType($type): Builder|Collection
    {
        return Client::where('client_type',$type)->orWhere('client_type','both')->get();
    }



    /**
     * @param $client_id
     * @return String
     */
    public function getClientFile($client_id): String
    {
        $client_file = Client::find($client_id)->getMedia('clients');
        if (isset($client_file[0])) {
            return $client_file[0]->getFullUrl();
        }
        return '';
    }

    public function getOrderFile($order_id){
        $files = $this->model->find($order_id)->getMedia('orders')->toArray();
        foreach ($files as $file){
            if($file['custom_properties']['type'] == 'Order'){
                return $file;
            }
        }
    }

    public function getOrderFiles($order_id)
    {
        return $this->model->find($order_id)->getMedia('orders')->groupBy('custom_properties')->toArray();
    }

    /**
     * @param $order_id
     * @param $data
     * @return bool
     */
    public function updateClientDetails($order_id,$data): bool
    {
        $order = Order::find($order_id)->update([
            "amc_id" => $data['amc_id'],
            "lender_id" => $data['lender_id']
        ]);

        $client = Client::where('id',$data['lender_id'])->update([
           'address' => $data['address']
        ]);

        if (isset($data['amc_file'])) {
            $amc = Client::find($data['amc_id']);
            if(isset($amc->getMedia('clients')[0])){
                $amc->getMedia('clients')[0]->delete();
            }
            $amc->addMedia($data['amc_file'])->toMediaCollection('clients');
        }

        if (isset($data['lender_file'])) {
            $lender = Client::find($data['lender_id']);
            if(isset($lender->getMedia('clients')[0])){
                $lender->getMedia('clients')[0]->delete();
            }
            $lender->addMedia($data['lender_file'])->toMediaCollection('clients');
        }
        return $order && $client;
    }

    /**
     * @param $data
     * @param $order_id
     * @return true
     */
    public function saveOrderFiles($data, $order_id): bool
    {
        foreach ($data['files'] as $file){
            $this->model->find($order_id)->addMedia($file)
                ->withCustomProperties(['type' => $data['file_type']])
                ->toMediaCollection('orders');
        }
        return true;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addActivity($data): mixed
    {
        return ActivityLog::create($data);
    }

    /**
     * @param $order_id
     * @return Builder|Model
     */
    public function getActivityLogData($order_id): Builder|Collection
    {
        return ActivityLog::query()->where('order_id', $order_id)->with([
            'user' => function ($query) {
                $query->select('id', 'name');
            }
        ])->get();
    }
}
