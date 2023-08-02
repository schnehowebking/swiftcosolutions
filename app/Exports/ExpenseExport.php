<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpenseExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Expense::all();
        foreach($data as $k=>$expense)
        {
            $data[$k]["account_id"]=!empty($expense->account($expense->account_id))?$expense->account($expense->account_id)->account_name:'';
            $data[$k]["expense_category_id"]= !empty($expense->expense_category($expense->expense_category_id))?$expense->expense_category($expense->expense_category_id)->name:'';
            $data[$k]["payee_id"]=Expense::payee($expense->payee_id)->payee_name;
            $data[$k]["payment_type_id"]=!empty($expense->payment_type($expense->payment_type_id))?$expense->payment_type($expense->payment_type_id)->name:'';
            $data[$k]["created_by"]=Employee::login_user($expense->created_by);
            unset($expense->created_at,$expense->updated_at);
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
            "Expense Category",
            "Payee",
            "Payment Type",
            "Referal Id",
            "Description",
            "Created By",
        ];
    }
}
