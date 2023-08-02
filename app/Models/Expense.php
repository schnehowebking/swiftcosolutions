<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'date',
        'income_category_id',
        'payee_id',
        'payment_type_id',
        'transaction_id',
        'referal_id',
        'description',
        'created_by',
    ];

    public function account($account)
    {
        $account = AccountList::where('id','=',$account)->first();
        return $account;
    }
    public static function payee($payee)
    {
        $payee = Payees::where('id','=',$payee)->first();
        return $payee;
    }

    public function expense_category($category)
    {
        $category = ExpenseType::where('id', '=', $category)->first();

        return $category;
    }

    public function payment_type($payment)
    {
        $payment = PaymentType::where('id','=',$payment)->first();
        return $payment;
    }

    public function accounts()
    {
        return $this->hasOne('App\Models\AccountList', 'id', 'account_id');
    }
}
