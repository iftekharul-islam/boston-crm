<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketingClient;
use App\Models\MarketingStatus;
use App\Repositories\MarketingRepository;

class MarketingController extends BaseController
{
    protected MarketingRepository $repository;

    public function __construct(MarketingRepository $marketing_repository)
    {
        parent::__construct();
        $this->repository = $marketing_repository;
    }

    public function index()
    {
        $clients = MarketingClient::all();
        $statuses = MarketingStatus::withCount('client')->get();
        return view('marketing.index',compact('clients','statuses'));
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
