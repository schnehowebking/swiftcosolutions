<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\TimeSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimesheetExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=TimeSheet::get();
       
        foreach($data as $k=>$timesheet)
        {
            $data[$k]["employee_id"]=!empty($timesheet->employee) ? $timesheet->employee->name : '';
            $data[$k]["created_by"]=Employee::login_user($timesheet->created_by); 
            unset($timesheet->created_at,$timesheet->updated_at);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "ID",
            "Employee Name",
            "Date",
            "Hour",
            "Remark",
            "Created By"
        ];
    }
}
