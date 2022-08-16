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
            "name" => $row["lender"],
            "client_type" => 'lender',
            "address" => $row["address"],
            "city" => $row["city"],
            "zip" => $row["zip"],
            "state" => $row["state"],
            "created_by" => auth()->user()->id,
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
