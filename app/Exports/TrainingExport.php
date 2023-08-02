<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\TrainingType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainingExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Training::get();

        foreach ($data as $k => $training) {
            unset($training->created_at,$training->updated_at);
            $data[$k]["branch"] = Branch::where('id', $training->branch)->pluck('name')->first();
            
            $trainer_option     = $training->trainer_option;
            if ($trainer_option == 0) {
                $data[$k]["trainer_option"] = 'Internal';
            } else {
                $data[$k]["trainer_option"] = 'External';
            }
            $data[$k]["training_type"]     = TrainingType::where('id', $training->training_type)->pluck('name')->first();
            $data[$k]["trainer"]     = Trainer::where('id', $training->trainer)->pluck('firstname')->first();
            $data[$k]["employee"]     = Employee::where('id', $training->employee)->pluck('name')->first();
            $data[$k]["status"]=Training::status($training->status);
            $data[$k]["created_by"]=Employee::login_user($training->created_by); 

            
            $data[$k]["performance"]     = Employee::where('id', $training->employee)->pluck('name')->first();
            $performance     = $training->performance;
            if ($performance == 0) {
                $data[$k]["performance"] = 'Not Concluded';
            } else if ($performance == 1) {
                $data[$k]["performance"] = 'Satisfactory';
            } elseif ($performance == 2) {
                $data[$k]["performance"] = 'Average';
            } elseif ($performance == 3) {
                $data[$k]["performance"] = 'Poor';
            } else {
                $data[$k]["performance"] = 'Excellent';
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Branch Name",
            "Trainer Option",
            "Trainer Type",
            "Trainer",
            "Trainer Cost",
            "Employee Name",
            "Start Date",
            "End Date",
            "Description",
            "Performance",
            "status",
            "Remarks",
            "Created By"
        ];
    }
}
