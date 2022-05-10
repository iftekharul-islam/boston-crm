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
        return new Client([
            "name" => trim($row["amc"]),
            "email" => trim($row["email"]),
            "phone" => trim($row["phone"]),
            "client_type" => 'amc',
            "deducts_technology_fee" => (trim($row["deducts_technology_fee"]) == '' || trim(strtolower($row["deducts_technology_fee"]) == "No")) ? 0 : 1,
            "fee_for_1004uad" => (trim($row['1004uad']) == '' || (int) trim($row['1004uad'] == 0)) ? 0 : (int) trim($row['1004uad']),
            "fee_for_1004d" => (trim($row['1004d']) == '' || (int) trim($row['1004d'] == 0)) ? 0 : (int) trim($row['1004d']),
            "can_sign" => (trim($row['trainee_can_sign']) == '' || trim(strtolower($row['trainee_can_sign']) == 'no')) ? 0 : 1,
            "can_inspect" => (trim($row['trainee_can_inspect']) == '' || trim(strtolower($row['trainee_can_inspect']) == 'no')) ? 0 : 1,
            "company_id" => auth()->user()->companies()->first()->id
        ]);
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
