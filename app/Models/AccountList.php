<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountList extends Model
{
    protected $fillable = [
        'company_id',
        'account_name',
        'initial_balance',
        'account_number',
        'branch_code',
        'bank_branch',
        'created_by',
    ];

    public static function add_Balance($id, $amount)
    {
        $accountBalance = \App\Models\AccountList::where('id', '=', $id)->first();
        $accountBalance->initial_balance = $amount + $accountBalance->initial_balance;
        $accountBalance->save();
    }
    public static function remove_Balance($id, $amount)
    {
        $accountBalance = \App\Models\AccountList::where('id', '=', $id)->first();
        $accountBalance->initial_balance =  $accountBalance->initial_balance - $amount;
        $accountBalance->save();
    }

    public static function transfer_Balance($from_account,$to_account,$amount)
    {
        $fromAccount = \App\Models\AccountList::where('id', '=', $from_account)->first();
        $fromAccount->initial_balance = $fromAccount->initial_balance - $amount;
        $fromAccount->save();
        $toAccount = \App\Models\AccountList::where('id', '=', $to_account)->first();
        $toAccount->initial_balance = $toAccount->initial_balance + $amount;
        $toAccount->save();

    }


}
