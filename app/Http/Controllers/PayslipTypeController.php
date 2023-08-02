<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayslipType;
use Illuminate\Http\Request;

class PayslipTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Payslip Type'))
        {
            $paysliptypes = PayslipType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('paysliptype.index', compact('paysliptypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Payslip Type'))
        {
            return view('paysliptype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Payslip Type'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $paysliptype             = new PayslipType();
            $paysliptype->name       = $request->name;
            $paysliptype->created_by = \Auth::user()->creatorId();
            $paysliptype->save();

            return redirect()->route('paysliptype.index')->with('success', __('PayslipType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(PayslipType $paysliptype)
    {
        return redirect()->route('paysliptype.index');
    }

    public function edit(PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Edit Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {

                return view('paysliptype.edit', compact('paysliptype'));
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

    public function update(Request $request, PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Edit Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',

                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $paysliptype->name = $request->name;
                $paysliptype->save();

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully updated.'));
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

    public function destroy(PayslipType $paysliptype)
    {
        if(\Auth::user()->can('Delete Payslip Type'))
        {
            if($paysliptype->created_by == \Auth::user()->creatorId())
            {
                $employee     = Employee::where('salary_type',$paysliptype->id)->get();
                if(count($employee) == 0)
                {
                    $paysliptype->delete();
                }
                else
                {
                    return redirect()->route('paysliptype.index')->with('error', __('This Payslip Type has Set Salary. Please remove the Set Salary from this Payslip Type.'));
                }

                return redirect()->route('paysliptype.index')->with('success', __('PayslipType successfully deleted.'));
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
