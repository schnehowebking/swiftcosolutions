<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Models\AccountList;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Payees;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Expense'))
        {
            $expenses = Expense::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('expense.index', compact('expenses'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Expense'))
        {
            $expenses = Expense::where('created_by', '=', \Auth::user()->creatorId())->get();
            $accounts = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');

            $expenseCategory = ExpenseType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $payees          = Payees::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('payee_name', 'id');
            $paymentTypes    = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('expense.create', compact('expenses', 'accounts', 'expenseCategory', 'payees', 'paymentTypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Expense'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'account_id' => 'required',
                                   'amount' => 'required',
                                   'date' => 'required',
                                   'expense_category_id' => 'required',
                                   'payee_id' => 'required',
                                   'payment_type_id'=>'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $expense                      = new Expense();
            $expense->account_id          = $request->account_id;
            $expense->amount              = $request->amount;
            $expense->date                = $request->date;
            $expense->expense_category_id = $request->expense_category_id;
            $expense->payee_id            = $request->payee_id;
            $expense->payment_type_id     = $request->payment_type_id;
            $expense->referal_id          = $request->referal_id;
            $expense->description         = $request->description;
            $expense->created_by          = \Auth::user()->creatorId();
            $expense->save();

            AccountList::remove_Balance($request->account_id, $request->amount);

            return redirect()->route('expense.index')->with('success', __('Expense  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Expense $expense)
    {
        return redirect()->route('expense.index');
    }

    public function edit(Expense $expense)
    {
        if(\Auth::user()->can('Edit Expense'))
        {
            if($expense->created_by == \Auth::user()->creatorId())
            {
                $expenses        = Expense::where('created_by', '=', \Auth::user()->creatorId())->get();
                $accounts        = AccountList::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
                $expenseCategory = ExpenseType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $payees          = Payees::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('payee_name', 'id');
                $paymentTypes    = PaymentType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('expense.edit', compact('expense', 'accounts', 'expenseCategory', 'payees', 'paymentTypes'));
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

    public function update(Request $request, Expense $expense)
    {
        if(\Auth::user()->can('Edit Expense'))
        {
            if($expense->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'account_id' => 'required',
                                       'amount' => 'required',
                                       'date' => 'required',
                                       'expense_category_id' => 'required',
                                       'payee_id' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $expense->account_id          = $request->account_id;
                $expense->amount              = $request->amount;
                $expense->date                = $request->date;
                $expense->expense_category_id = $request->expense_category_id;
                $expense->payee_id            = $request->payee_id;
                $expense->payment_type_id     = $request->payment_type_id;
                $expense->referal_id          = $request->referal_id;
                $expense->description         = $request->description;
                $expense->save();

                return redirect()->route('expense.index')->with('success', __('Expense successfully updated.'));
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

    public function destroy(Expense $expense)
    {
        if(\Auth::user()->can('Delete Expense'))
        {
            if($expense->created_by == \Auth::user()->creatorId())
            {
                $expense->delete();

                return redirect()->route('expense.index')->with('success', __('Expense successfully deleted.'));
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
        $name = 'Expense_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ExpenseExport(), $name . '.xlsx');
        return $data;
    }
}
