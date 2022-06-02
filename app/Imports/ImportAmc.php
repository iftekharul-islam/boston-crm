<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAmc implements ToModel,WithChunkReading,WithBatchInserts,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Client
     */
    public function model(array $row)
    {
        $client = new Client();
        $client->name = $row['amc'];
        // if(trim($row["email"]) != ""){
        //     $client->email = json_encode(trim($row["email"]));
        // }else{
        //     $client->email = '';
        // }
        // if(trim($row["phone"]) != ""){
        //     $client->phone = json_encode(trim($row["phone"]));
        // }else{
        //     $client->phone = '';
        // }
        $client->client_type = 'amc';
        $client->deducts_technology_fee = $row["deducts_technology_fee"] == '' || strtolower($row["deducts_technology_fee"] == "No") ? 0 : 1;
        $client->fee_for_1004uad = $row['1004uad'] == '' || (int) ($row['1004uad'] == 0) ? 0 : (int) $row['1004uad'];
        $client->fee_for_1004d = $row['1004d'] == '' || (int) ($row['1004d'] == 0) ? 0 : (int) $row['1004d'];
        $client->can_sign = $row['trainee_can_sign'] == '' || strtolower($row['trainee_can_sign']) == 'no' ? 0 : 1;
        $client->can_inspect = $row['trainee_can_inspect'] == '' || strtolower($row['trainee_can_inspect'] == 'no') ? 0 : 1;
        $client->created_by = auth()->user()->id;
        $client->company_id = auth()->user()->companies()->first()->id;
        $client->save();
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
