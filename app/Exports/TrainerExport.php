<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Trainer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainerExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Trainer::get();
        foreach($data as $k=>$trainer)
        {
            $data[$k]["branch"]=!empty($trainer->branches)?$trainer->branches->name:'';
            $data[$k]["created_by"]=Employee::login_user($trainer->created_by); 
            unset($trainer->created_at,$trainer->updated_at);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "ID",
            "Branch Name",
            "First Name",
            "Last Name",
            "Contact",
            "Email ID",
            "Address",
            "Expeience",
            "Created By"
        ];
    }
}
