<?php

namespace App\Imports;

use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HolidayImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function model(array $row)
    {
        dd($row);
        return new Holiday([
            'occasion'     => $row['occasion'],
            'start_date'    => date('Y-m-d', strtotime($row['start_date'])),
            'end_date'    => date('Y-m-d', strtotime($row['end_date'])),
            'created_by' => \Auth::user()->id,
        ]);
    }
}
