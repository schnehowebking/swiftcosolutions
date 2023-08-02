<?php

namespace App\Imports;

use App\Models\Trainer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class TrainerImport implements ToModel
{
    use Importable;
    public function model(array $row)
    {
      
    }
}
