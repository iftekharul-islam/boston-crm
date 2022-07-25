<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MarketingClient;
use App\Models\MarketingStatus;
use App\Services\CompanyService;
use App\Models\MarketingClientCategory;
use App\Repositories\MarketingRepository;

class MarketingController extends BaseController
{
    protected MarketingRepository $repository;
    protected CompanyService $service;

    public function __construct(MarketingRepository $marketing_repository, CompanyService $company_service,)
    {
        parent::__construct();
        $this->repository = $marketing_repository;
        $this->service = $company_service;
    }

    public function index()
    {
        $clients = MarketingClient::all();
        $statuses = MarketingStatus::withCount('client')->get();
        $categories = MarketingClientCategory::all();
        $company_users = $this->service->getAuthUserCompany();
        $users = $company_users->users()->get();
        return view('marketing.index',compact('clients','statuses','categories','users'));
    }

    public function filterUsers(Request $request)
    {
        if($request->has('search_key') && $request->search_key != ''){
            $users = User::where('name','like','%' . $request->search_key . '%')->get();
        }else{
            $company_users = $this->service->getAuthUserCompany();
            $users = $company_users->users()->get();
        }
        return [
            "data" => $users,
        ];
    }

    public function saveAssignedUsers(Request $request){
        $client = MarketingClient::find($request->id);
        $client->assigned_to = json_encode($request->users);
        $client->save();
        $clients = MarketingClient::all();
        return [
            'data' => $clients
        ];
    }


    public function saveMarketingClient(Request $request)
    {
        $this->repository->saveMarketingClient($request->all());
        $clients = MarketingClient::all();
        $statuses = MarketingStatus::withCount('client')->get();
        return [
            "data" => $clients,
            "statuses" => $statuses,
            "message" => "Marketing client saved successfully"
        ];
    }

    public function saveMarketingClientCategory(Request $request)
    {
        $this->repository->saveMarketingClientCategory($request->all());
        $categories = MarketingClientCategory::all();
        return [
            "data" => $categories,
            "message" => "Client category saved successfully"
        ];
    }


    public function saveStatus(Request $request)
    {
        $this->repository->saveStatus($request->all());
        $statuses = MarketingStatus::withCount('client')->get();

        return [
            "data" => $statuses,
            "message" => "New status added successfully"
        ];
    }

    public function updateStatus(Request $request){
        $this->repository->updateStatus($request->all());
        $statuses = MarketingStatus::withCount('client')->get();

        return [
            "data" => $statuses,
            "message" => "Status updated successfully"
        ];
    }

    public function changeClientStatus(Request $request){
        $this->repository->changeClientStatus($request->all());
        $clients = MarketingClient::all();
        $statuses = MarketingStatus::withCount('client')->get();
        return [
            "data" => $clients,
            "statuses" => $statuses,
            "message" => "Client status changed successfully"
        ];
    }
}
