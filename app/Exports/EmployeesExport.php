<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Employee::get();
        foreach($data as $k => $employees)
        {
            unset($employees->id,$employees->user_id,$employees->documents,$employees->tax_payer_id,$employees->is_active,$employees->created_at,$employees->updated_at);

            $data[$k]["branch_id"]=!empty($employees->branch->name);
            $data[$k]["department_id"]=!empty($employees->department->name);
            $data[$k]["designation_id"]= !empty($employees->designation) ? $employees->designation->name : '-';
            $data[$k]["salary_type"]=!empty($employees->salary_type) ? $employees->salaryType->name :'-';
            $data[$k]["salary"]=Employee::employee_salary($employees->salary);
            $data[$k]["created_by"]=Employee::login_user($employees->created_by);
            
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Date of Birth",
            "Gender",
            "Phone Number",
            "Address",
            "Email ID",
            "Password",
            "Employee ID",
            "Branch",
            "Department",
            "Designation",
            "Date of Join",
            "Account Holder Name",
            "Account Number",
            "Bank Name",
            "Bank Identifier Code",
            "Branch Location",
            "Salary Type",
            "Salary",
            "Created By"
        ];
    }
}
