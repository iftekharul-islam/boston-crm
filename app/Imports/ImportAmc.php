<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportAmc implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        for ($i = 0; $i < count($row); $i++) {
            print_r($row[$i] . '<br/>');
        }
    }
}
