<?php

namespace App\Exports;

use App\Models\Deposit;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepositExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Deposit::get();
        foreach($data as $k=>$deposit)
        { 
            $data[$k]["account_id"]= !empty($deposit->account($deposit->account_id))?$deposit->account($deposit->account_id)->account_name:'';
            $data[$k]["income_category_id"]=!empty($deposit->income_category($deposit->income_category_id))?$deposit->income_category($deposit->income_category_id)->name:'';
            $data[$k]["payer_id"]= Deposit::payer($deposit->payer_id)->payer_name;
            $data[$k]["payment_type_id"]=!empty($deposit->payment_type($deposit->payment_type_id))?$deposit->payment_type($deposit->payment_type_id)->name:'';
            $data[$k]["created_by"]=Employee::login_user($deposit->created_by);
            unset($deposit->created_at,$deposit->updated_at);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "ID",
            "Account Name",
            "Amount",
            "Date",
            "Income Category",
            "Payer",
            "Payment type",
            "Referal Id",
            "Description",
            "Created By"
        ];
    }
}
