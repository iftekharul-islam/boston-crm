<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\MarketingClient;
use App\Models\MarketingStatus;
use App\Models\MarketingTask;
use App\Models\MarketingClientCategory;

class MarketingRepository
{
    public function saveMarketingClient($data)
    {
        $client = new MarketingClient();
        $client->name = $data['name'];
        $client->address = $data['address'];
        $client->category_id = $data['category_id'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->created_by = auth()->user()->id;
        $client->save();

        return $client;
    }

    public function saveMarketingClientCategory($data)
    {
        $category = new MarketingClientCategory();
        $category->name = $data['name'];
        $category->save();

        return $category;
    }

    public function saveStatus($data)
    {
        $status = new MarketingStatus();
        $status->status = $data['status'];
        $status->created_by = auth()->user()->id;
        $status->save();

        return $status;
    }

    public function updateStatus($data)
    {
        $status = MarketingStatus::find($data['id']);
        $status->status = $data['status'];
        $status->updated_by = auth()->user()->id;
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

    public function saveTask($data)
    {
        $task = new MarketingTask();
        $task->client_id = $data['client_id'];
        $task->subject = $data['subject'];
        $task->description = $data['description'];

        //formated from js date object
        $formated_due_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $data['due_date']);
        $task->due_date = Carbon::parse($formated_due_date)->format('Y-m-d H:i:s');

        //formated from js date object
        $formated_reminder = \DateTime::createFromFormat('D M d Y H:i:s e+', $data['reminder']);
        $task->reminder = Carbon::parse($formated_reminder)->format('Y-m-d H:i:s');
        $task->save();

        return $task;
    }
}
