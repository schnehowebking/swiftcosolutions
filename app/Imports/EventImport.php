<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;


class EventImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        
        
    }
}
