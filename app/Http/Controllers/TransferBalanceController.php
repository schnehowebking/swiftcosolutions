<?php

namespace App\Http\Controllers;

use App\Exports\TransferBalanceExport;
use App\Models\AccountList;
use App\Models\IncomeType;
use App\Models\PaymentType;
use App\Models\TransferBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransferBalanceController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Transfer Balance'))
        {
            $transferbalances = TransferBalance::where('created_by', '=', Auth::user()->creatorId())->get();

            return view('transferbalance.index', compact('transferbalances'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Transfer Balance'))
        {
            $transferbalances = TransferBalance::where('created_by', '=', \Auth::user()->creatorId())->get();
            $accounts         = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
            $paymentTypes     = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('transferbalance.create', compact('transferbalances', 'accounts', 'paymentTypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Transfer Balance'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'from_account_id' => 'required',
                                   'to_account_id' => 'required',
                                   'date' => 'required',
                                   'amount' => 'required',
                                   'payment_type_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $transferbalance                  = new TransferBalance();
            $transferbalance->from_account_id = $request->from_account_id;
            $transferbalance->to_account_id   = $request->to_account_id;
            $transferbalance->date            = $request->date;
            $transferbalance->amount          = $request->amount;
            $transferbalance->payment_type_id = $request->payment_type_id;
            $transferbalance->referal_id      = $request->referal_id;
            $transferbalance->description     = $request->description;
            $transferbalance->created_by      = \Auth::user()->creatorId();
            $transferbalance->save();

            AccountList::transfer_Balance($request->from_account_id, $request->to_account_id, $request->amount);


            return redirect()->route('transferbalance.index')->with('success', __('TransferBalance  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(TransferBalance $transferbalance)
    {
        return redirect()->route('transferbalance.index');
    }

    public function edit(TransferBalance $transferbalance)
    {
        if(\Auth::user()->can('Edit Transfer Balance'))
        {
            if($transferbalance->created_by == \Auth::user()->creatorId())
            {
                $transferbalances = TransferBalance::where('created_by', '=', \Auth::user()->creatorId())->get();
                $accounts         = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
                $incomeCategory   = IncomeType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $paymentTypes     = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('transferbalance.edit', compact('transferbalance', 'accounts', 'incomeCategory', 'paymentTypes'));
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

    public function update(Request $request, TransferBalance $transferbalance)
    {
        if(\Auth::user()->can('Edit Transfer Balance'))
        {
            if($transferbalance->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'from_account_id' => 'required',
                                       'to_account_id' => 'required',
                                       'date' => 'required',
                                       'amount' => 'required',
                                       'payment_type_id' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $transferbalance->from_account_id = $request->from_account_id;
                $transferbalance->to_account_id   = $request->to_account_id;
                $transferbalance->date            = $request->date;
                $transferbalance->amount          = $request->amount;
                $transferbalance->payment_type_id = $request->payment_type_id;
                $transferbalance->referal_id      = $request->referal_id;
                $transferbalance->description     = $request->description;
                $transferbalance->save();

                return redirect()->route('transferbalance.index')->with('success', __('TransferBalance successfully updated.'));
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

    public function destroy(TransferBalance $transferbalance)
    {
        if(\Auth::user()->can('Delete Transfer Balance'))
        {
            if($transferbalance->created_by == \Auth::user()->creatorId())
            {
                $transferbalance->delete();

                return redirect()->route('transferbalance.index')->with('success', __('TransferBalance successfully deleted.'));
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
        $name = 'TransferBalance_' . date('Y-m-d i:h:s');
        $data = Excel::download(new TransferBalanceExport(), $name . '.xlsx');

        return $data;
    }
}
