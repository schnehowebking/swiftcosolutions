<?php

namespace App\Http\Controllers;

use App\Exports\DepositExport;
use App\Models\AccountList;
use App\Models\Deposit;
use App\Models\IncomeType;
use App\Models\Payer;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DepositController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Deposit'))
        {
            $deposits = Deposit::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('deposit.index', compact('deposits'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Deposit'))
        {
            $deposits       = Deposit::where('created_by', '=', \Auth::user()->creatorId())->get();
            $accounts       = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
            $incomeCategory = IncomeType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $payers         = Payer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('payer_name', 'id');
            $paymentTypes   = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('deposit.create', compact('deposits', 'accounts', 'incomeCategory', 'payers', 'paymentTypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Deposit'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'account_id' => 'required',
                                   'amount' => 'required|numeric',
                                   'date' => 'required',
                                   'income_category_id' => 'required',
                                   'payer_id' => 'required',
                                   'payment_type_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $deposit                     = new Deposit();
            $deposit->account_id         = $request->account_id;
            $deposit->amount             = $request->amount;
            $deposit->date               = $request->date;
            $deposit->income_category_id = $request->income_category_id;
            $deposit->payer_id           = $request->payer_id;
            $deposit->payment_type_id    = $request->payment_type_id;
            $deposit->referal_id         = $request->referal_id;
            $deposit->description        = $request->description;
            $deposit->created_by         = \Auth::user()->creatorId();
            $deposit->save();

            AccountList::add_Balance($request->account_id, $request->amount);


            return redirect()->route('deposit.index')->with('success', __('Deposit  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Deposit $deposit)
    {
        return redirect()->route('deposit.index');
    }

    public function edit(Deposit $deposit)
    {
        if(\Auth::user()->can('Edit Deposit'))
        {
            if($deposit->created_by == \Auth::user()->creatorId())
            {
                $deposits       = Deposit::where('created_by', '=', \Auth::user()->creatorId())->get();
                $accounts       = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
                $incomeCategory = IncomeType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $payers         = Payer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('payer_name', 'id');
                $paymentTypes   = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('deposit.edit', compact('deposit', 'accounts', 'incomeCategory', 'payers', 'paymentTypes'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Deposit $deposit)
    {
        if(\Auth::user()->can('Edit Deposit'))
        {
            if($deposit->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'account_id' => 'required',
                                       'amount' => 'required|numeric',
                                       'date' => 'required',
                                       'income_category_id' => 'required',
                                       'payer_id' => 'required',
                                       'payment_type_id' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $deposit->account_id         = $request->account_id;
                $deposit->amount             = $request->amount;
                $deposit->date               = $request->date;
                $deposit->income_category_id = $request->income_category_id;
                $deposit->payer_id           = $request->payer_id;
                $deposit->payment_type_id    = $request->payment_type_id;
                $deposit->referal_id         = $request->referal_id;
                $deposit->description        = $request->description;
                $deposit->save();

                return redirect()->route('deposit.index')->with('success', __('Deposit successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Deposit $deposit)
    {
        if(\Auth::user()->can('Delete Deposit'))
        {
            if($deposit->created_by == \Auth::user()->creatorId())
            {
                $deposit->delete();

                return redirect()->route('deposit.index')->with('success', __('Deposit successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function export(Request $request)
    {
        $name = 'Deposite' . date('Y-m-d i:h:s');
        $data = Excel::download(new DepositExport(), $name . '.xlsx'); 

        return $data;
    }
}
