<?php

namespace App\Repositories;

use App\Models\MarketingClient;
use App\Models\MarketingStatus;

class MarketingRepository
{
    public function saveMarketingClient($data)
    {
        $client = new MarketingClient();
        $client->name = $data['name'];
        $client->address = $data['address'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->created_by = auth()->user()->id;
        $client->save();

        return $client;
    }

    public function saveStatus($data)
    {
        $status = new MarketingStatus();
        $status->status = $data['status'];
        $status->created_by = auth()->user()->id;
        $status->save();

        return $status;
    }

    public function changeClientStatus($data)
    {
        $client = MarketingClient::find($data['id']);
        $client->status_id = $data['status_id'];
        $client->save();

        return $client;
    }
}
