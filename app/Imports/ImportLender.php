<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportLender implements ToModel,WithChunkReading,WithBatchInserts,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Client
     */
    public function model(array $row)
    {
        return new Client([
            "name" => trim($row["lender"]),
            "email" => trim($row["email"]),
            "phone" => trim($row["phone"]),
            "client_type" => 'lender',
            "address" => trim($row["address"]),
            "country" => 'USA',
            "city" => trim($row["city"]),
            "zip" => trim($row["zip"]),
            "state" => trim($row["state"]),
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
