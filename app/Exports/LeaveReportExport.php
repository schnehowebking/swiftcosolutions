<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveReportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $data    = Leave::all();
        $employees = Employee::where('created_by', \Auth::user()->creatorId());
        $employees = $employees->get();

        foreach ($employees as $employee) {

            $approved = Leave::where('employee_id', $employee->id)->where('status', 'Approved');
            $reject   = Leave::where('employee_id', $employee->id)->where('status', 'Reject');
            $pending  = Leave::where('employee_id', $employee->id)->where('status', 'Pending');
            $totalApproved = $totalReject = $totalPending = 0;

            $approved = $approved->count();
            $reject   = $reject->count();
            $pending  = $pending->count();

            $totalApproved += $approved;
            $totalReject   += $reject;
            $totalPending  += $pending;

            $employeeLeave['approved'] = $approved;
            $employeeLeave['reject']   = $reject;
            $employeeLeave['pending']  = $pending;


            $leaves[] = $employeeLeave;
        }
        foreach ($data as $k => $leave) {
            
            $user_id = $leave->employees->user_id;
            $user = User::where('id', $user_id)->first();
            $data[$k]["employee_id"] = !empty($leave->employees) ? User::employeeIdFormat($leave->employees->employee_id) : '';
            $data[$k]["employee"] = (!empty($leave->employees->name)) ? $leave->employees->name : '';

            $data[$k]["approved_leaves"] = $leaves[$k]['approved'] == 0 ? '0' : $leaves[$k]['approved'];
            $data[$k]["rejected_leaves"] = $leaves[$k]['reject'] == 0 ? '0' : $leaves[$k]['reject'];
            $data[$k]["pending_leaves"] = $leaves[$k]['pending'];
            // dd($leave['approved'],$leave['reject'] , $leave['pending']);
            

            unset($data[$k]['id'], $data[$k]['leave_type_id'], $data[$k]['start_date'], $data[$k]['end_date'], $data[$k]['applied_on'], $data[$k]['total_leave_days'], $data[$k]['leave_reason'], $data[$k]['created_at'], $data[$k]['created_by'], $data[$k]['remark'], $data[$k]['status'], $data[$k]['updated_at'], $data[$k]['account_id']);
        }

        return $data;
    }


    public function headings(): array
    {
        return [
            "Employee ID",
            "Employee",
            "Approved Leaves ",
            "Rejected Leaves",
            "Pending Leaves",
        ];
    }
}
