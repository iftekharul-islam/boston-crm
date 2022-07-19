<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketingClient;
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
        return view('marketing.index',compact('clients'));
    }

    public function saveMarketingClient(Request $request)
    {
        $this->repository->saveMarketingClient($request->all());
        $clients = MarketingClient::all();
        return [
            "data" => $clients,
            "message" => "Marketing client saved successfully"
        ];
    }
}
