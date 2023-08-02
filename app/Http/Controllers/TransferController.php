<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Mail\TransferSend;
use App\Models\Transfer;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Transfer'))
        {
            if(Auth::user()->type == 'employee')
            {
                $emp       = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $transfers = Transfer::where('created_by', '=', \Auth::user()->creatorId())->where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $transfers = Transfer::where('created_by', '=', \Auth::user()->creatorId())->get();
            }   

            return view('transfer.index', compact('transfers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Transfer'))
        {
            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $branches    = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('transfer.create', compact('employees', 'departments', 'branches'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Transfer'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'branch_id' => 'required',
                                   'department_id' => 'required',
                                   'transfer_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $transfer                = new Transfer();
            $transfer->employee_id   = $request->employee_id;
            $transfer->branch_id     = $request->branch_id;
            $transfer->department_id = $request->department_id;
            $transfer->transfer_date = $request->transfer_date;
            $transfer->description   = $request->description;
            $transfer->created_by    = \Auth::user()->creatorId();
            $transfer->save();

            $setings = Utility::settings();
            if($setings['employee_transfer'] == 1)
            {
                $branch  = Branch::find($transfer->branch_id);
                $department = Department::find($transfer->department_id);
                $employee= Employee::find($transfer->employee_id);
                $uArr = [
                    'transfer_name'=>$employee->name,
                    'transfer_date'=>$request->transfer_date,
                    'transfer_department'=>$department->name,
                    'transfer_branch'=>$branch->name,
                    'transfer_description'=>$request->description,
                    
                    
                ];
        $resp = Utility::sendEmailTemplate('employee_transfer', [$employee->email], $uArr);
        return redirect()->route('transfer.index')->with('success', __('Transfer  successfully created.'). ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            }

            return redirect()->route('transfer.index')->with('success', __('Transfer  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Transfer $transfer)
    {
        return redirect()->route('transfer.index');
    }

    public function edit(Transfer $transfer)
    {
        if(\Auth::user()->can('Edit Transfer'))
        {
            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $branches    = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            if($transfer->created_by == \Auth::user()->creatorId())
            {
                return view('transfer.edit', compact('transfer', 'employees', 'departments', 'branches'));
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

    public function update(Request $request, Transfer $transfer)
    {
        if(\Auth::user()->can('Edit Transfer'))
        {
            if($transfer->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'employee_id' => 'required',
                                       'branch_id' => 'required',
                                       'department_id' => 'required',
                                       'transfer_date' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $transfer->employee_id   = $request->employee_id;
                $transfer->branch_id     = $request->branch_id;
                $transfer->department_id = $request->department_id;
                $transfer->transfer_date = $request->transfer_date;
                $transfer->description   = $request->description;
                $transfer->save();

                return redirect()->route('transfer.index')->with('success', __('Transfer successfully updated.'));
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

    public function destroy(Transfer $transfer)
    {
        if(\Auth::user()->can('Delete Transfer'))
        {
            if($transfer->created_by == \Auth::user()->creatorId())
            {
                $transfer->delete();

                return redirect()->route('transfer.index')->with('success', __('Transfer successfully deleted.'));
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
}
