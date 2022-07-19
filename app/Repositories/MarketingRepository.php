<?php

namespace App\Repositories;

use App\Models\MarketingClient;

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
}
