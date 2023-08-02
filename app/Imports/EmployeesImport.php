<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Employee;
class EmployeesImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        
    }
}
