<?php

namespace App\Http\Controllers;

use App\Models\DeductionOption;
use App\Models\Employee;
use App\Models\SaturationDeduction;
use Illuminate\Http\Request;

class SaturationDeductionController extends Controller
{
    public function saturationdeductionCreate($id)
    {
        $employee          = Employee::find($id);
        $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $saturationdeduc = SaturationDeduction::$saturationDeductiontype;

        return view('saturationdeduction.create', compact('employee', 'deduction_options','saturationdeduc'));
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Saturation Deduction'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'deduction_option' => 'required',
                                   'title' => 'required',
                                   'amount' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $saturationdeduction                   = new SaturationDeduction;
            $saturationdeduction->employee_id      = $request->employee_id;
            $saturationdeduction->deduction_option = $request->deduction_option;
            $saturationdeduction->title            = $request->title;
            $saturationdeduction->type            = $request->type;
            $saturationdeduction->amount           = $request->amount;
            $saturationdeduction->created_by       = \Auth::user()->creatorId();
            $saturationdeduction->save();

            if($saturationdeduction->type == 'percentage')
            {
                $employee          = Employee::find($saturationdeduction->employee_id);
                $saturationdeductionsal  = $saturationdeduction->amount * $employee->salary / 100;
            }

            return redirect()->back()->with('success', __('SaturationDeduction  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(SaturationDeduction $saturationdeduction)
    {
        return redirect()->route('commision.index');
    }

    public function edit($saturationdeduction)
    {
        $saturationdeduction = SaturationDeduction::find($saturationdeduction);
        if(\Auth::user()->can('Edit Saturation Deduction'))
        {
            if($saturationdeduction->created_by == \Auth::user()->creatorId())
            {
                $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $saturationdeduc = SaturationDeduction::$saturationDeductiontype;

                return view('saturationdeduction.edit', compact('saturationdeduction', 'deduction_options','saturationdeduc'));
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

    public function update(Request $request, SaturationDeduction $saturationdeduction)
    {
        if(\Auth::user()->can('Edit Saturation Deduction'))
        {
            if($saturationdeduction->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [

                                       'deduction_option' => 'required',
                                       'title' => 'required',
                                       'amount' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $saturationdeduction->deduction_option = $request->deduction_option;
                $saturationdeduction->title            = $request->title;
                $saturationdeduction->type            = $request->type;
                $saturationdeduction->amount           = $request->amount;
                $saturationdeduction->save();

                if($saturationdeduction->type == 'percentage')
                    {
                        $employee          = Employee::find($saturationdeduction->employee_id);
                        $saturationdeductionsal  = $saturationdeduction->amount * $employee->salary / 100;
                    }

                return redirect()->back()->with('success', __('SaturationDeduction successfully updated.'));
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

    public function destroy(SaturationDeduction $saturationdeduction)
    {
        if(\Auth::user()->can('Delete Saturation Deduction'))
        {
            if($saturationdeduction->created_by == \Auth::user()->creatorId())
            {
                $saturationdeduction->delete();

                return redirect()->back()->with('success', __('SaturationDeduction successfully deleted.'));
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
