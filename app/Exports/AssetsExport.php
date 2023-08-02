<?php

namespace App\Exports;

use App\Models\Asset;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Asset::get();
        foreach($data as $k=>$assets)
        {
            $data[$k]["employee_id"]=Employee::employee_name($assets->employee_id);
            $data[$k]["created_by"]=Employee::login_user($assets->created_by);
            unset($assets->created_at,$assets->updated_at);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "ID",
            "employee",
            "Asset Name",
            "Purchase Date",
            "Supported Date",
            "Amount",
            "Description",
            "Created By"
        ];
    }
}
