<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\TransferBalance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransferBalanceExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=TransferBalance::get();
        foreach($data as $k=>$transfer_balance)
        {
            $data[$k]["from_account_id"]=!empty($transfer_balance->account($transfer_balance->from_account_id))?$transfer_balance->account($transfer_balance->from_account_id)->account_name:'';
            $data[$k]["to_account_id"]=!empty($transfer_balance->account($transfer_balance->to_account_id))?$transfer_balance->account($transfer_balance->to_account_id)->account_name:'';
            $data[$k]["payment_type_id"]=!empty($transfer_balance->payment_type($transfer_balance->payment_type_id))?$transfer_balance->payment_type($transfer_balance->payment_type_id)->name:'';
            $data[$k]["created_by"]=Employee::login_user($transfer_balance->created_by);
            unset($transfer_balance->created_at,$transfer_balance->updated_at);
        }
        return $data;        
    }

    public function headings(): array
    {
        return [
            "ID",
            "From Account",
            "To Account",
            "Date",
            "Amount",
            "Payment Type",
            "Referal ID",
            "Description",
            "Created BY"
        ];
    }
}
