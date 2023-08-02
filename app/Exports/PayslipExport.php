<?php

namespace App\Exports;


use App\Models\Employee;
use App\Models\PaySlip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayslipExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function collection()
    {
        $request=$this->data;

        $data = PaySlip::where('created_by', \Auth::user()->creatorId());

        if(isset($request->filter_month) && !empty($request->filter_month)){
            $month=$request->filter_month;
        }else{
            $month=date('m', strtotime('last month'));
        }

        if(isset($request->filter_year) && !empty($request->filter_year)){
            $year=$request->filter_year;
        }else{
            $year=date('Y');
        }
        $formate_month_year = $year . '-' . $month;
        $data->where('salary_month', '=', $formate_month_year);
        $data=$data->get();
        $result = array();
        foreach($data as $k => $payslip)
        {
            $result[] = array(
                'employee_id'=> !empty($payslip->employees) ? \Auth::user()->employeeIdFormat($payslip->employees->employee_id) : '',
                'employee_name' => (!empty($payslip->employees)) ? $payslip->employees->name : '',
                'basic_salary' => \Auth::user()->priceFormat($payslip->basic_salary),
                'net_salary' =>  \Auth::user()->priceFormat($payslip->net_payble),
                'status' =>  $payslip->status == 0 ? 'UnPaid' :  'Paid',
                'account_holder_name' =>  (!empty($payslip->employees)) ? $payslip->employees->account_holder_name : '',
                'account_number' =>  (!empty($payslip->employees)) ? $payslip->employees->account_number : '',
                'bank_name' =>  (!empty($payslip->employees)) ? $payslip->employees->bank_name : '',
                'bank_identifier_code' => (!empty($payslip->employees)) ? $payslip->employees->bank_identifier_code : '',
                'branch_location' =>   (!empty($payslip->employees)) ? $payslip->employees->branch_location : '',
                'tax_payer_id' =>  (!empty($payslip->employees)) ? $payslip->employees->tax_payer_id : '',

            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            "EMP ID",
            "Name",
//            "Payroll Type",
            "Salary",
            "Net Salary",
            "Status",
            "Account Holder Name",
            "Account Number",
            "Bank Name",
            "Bank Identifier Code",
            "Branch Location",
            "Tax Payer Id",

        ];
    }
}
