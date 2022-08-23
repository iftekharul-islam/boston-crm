<?php

use App\Models\User;


function createRandomOrder($userType = true) {
    $user = auth()->user();
    if ($userType == false) {
        $user = User::inRandomOrder()->first();
    }
    $company = $user->companyProfile()->company;
    $randomDate = rand(5,7);
    $file = app_path("Helpers/CreateOrder.json");
    $json = json_decode(file_get_contents($file, true));
    $json->company = $company;
    $json->user_id = $user->id;
    $json->step1->fhaCaseNo = "FHA-".rand(123,654);
    $json->step1->clientOrderNo = "BAS-".rand(12378,65498);
    $json->step1->receiveDate = Carbon\Carbon::now()->subDays($randomDate)->format("Y-m-d");
    $json->step1->dueDate = Carbon\Carbon::now()->addDays(rand(3,5))->format("Y-m-d");
    $json->step2->contactSame = (rand(1,2) % 2) == 0 ? true : false;
    $json->step2->coordinate = (rand(1,2) % 2) == 0 ? "South" : "North";

    $url = url("api/store/order");
    $post = Http::post($url, json_decode(json_encode($json), true));
    if ($post->successful()) {
        return $post->json('message');
    } else {
        return "Failed to create order";
    }
}
