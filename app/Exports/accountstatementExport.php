<?php

namespace App\Exports;

use App\Models\Deposit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class accountstatementExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data    = Deposit::all();

        // dd($data);
        foreach ($data as $k => $account) {
            $account["account_name"] = !empty($account->accounts) ? $account->accounts->account_name : '';
            $account["date"] = \Auth::user()->dateFormat($account->date);
            $account["amount"] = \Auth::user()->priceFormat($account->amount);

            unset($account->id, $account->income_category_id, $account->payer_id, $account->payment_type_id, $account->referal_id, $account->description, $account->created_by, $account->created_at, $account->updated_at,$account->account_id);
        }

        return $data;
        
    }

    public function headings(): array
    {
        return [
            "Amount",
            "Date",
            "Account Name",
        ];
    }
}
