<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HolidayExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Holiday::get();
        foreach($data as $k=>$holidays)
        {
            $data[$k]["created_by"]=Employee::login_user($holidays->created_by); 
            unset($holidays->created_at,$holidays->updated_at);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "ID",
            "Date",
            "Occasion",
            "Created By"
        ];
    }
}
