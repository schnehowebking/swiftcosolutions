<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Mail\WarningSend;
use App\Models\Utility;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WarningController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Warning'))
        {
            if(Auth::user()->type == 'employee')
            {
                $emp      = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $warnings = Warning::where('warning_by', '=', $emp->id)->get();
            }
            else
            {
                $warnings = Warning::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('warning.index', compact('warnings'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Warning'))
        {
            if(Auth::user()->type == 'employee')
            {
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('user_id', '!=', $user->id)->get()->pluck('name', 'id');
            }
            else
            {
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }

            return view('warning.create', compact('employees', 'current_employee'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Warning'))
        {
            if(\Auth::user()->type != 'employee')
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'warning_by' => 'required',
                                   ]
                );
            }

            $validator = \Validator::make(
                $request->all(), [
                                   'warning_to' => 'required',
                                   'subject' => 'required',
                                   'warning_date' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $warning = new Warning();
            if(\Auth::user()->type == 'employee')
            {
                $emp                 = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $warning->warning_by = $emp->id;
            }
            else
            {
                $warning->warning_by = $request->warning_by;
            }
            $warning->warning_to   = $request->warning_to;
            $warning->subject      = $request->subject;
            $warning->warning_date = $request->warning_date;
            $warning->description  = $request->description;
            $warning->created_by   = \Auth::user()->creatorId();
            $warning->save();

            $setings = Utility::settings();
            if($setings['employee_warning'] == 1)
            {
                $employee       = Employee::find($warning->warning_to);
                $uArr = [
                 'employee_warning_name'=>$employee->name, 
                 'warning_subject'=>$request->subject, 
                 'warning_description'=>$request->description, 
 
 
              ];
           $resp = Utility::sendEmailTemplate('employee_warning', [$employee->email], $uArr);
           return redirect()->route('warning.index')->with('success', __('Warning  successfully created.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

            return redirect()->route('warning.index')->with('success', __('Warning  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Warning $warning)
    {
        return redirect()->route('warning.index');
    }

    public function edit(Warning $warning)
    {

        if(\Auth::user()->can('Edit Warning'))
        {
            if(Auth::user()->type == 'employee')
            {
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('user_id', '!=', $user->id)->get()->pluck('name', 'id');
            }
            else
            {
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }
            if($warning->created_by == \Auth::user()->creatorId())
            {
                return view('warning.edit', compact('warning', 'employees', 'current_employee'));
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

    public function update(Request $request, Warning $warning)
    {
        if(\Auth::user()->can('Edit Warning'))
        {
            if($warning->created_by == \Auth::user()->creatorId())
            {
                if(\Auth::user()->type != 'employee')
                {
                    $validator = \Validator::make(
                        $request->all(), [
                                           'warning_by' => 'required',
                                       ]
                    );
                }

                $validator = \Validator::make(
                    $request->all(), [
                                       'warning_to' => 'required',
                                       'subject' => 'required',
                                       'warning_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                if(\Auth::user()->type == 'employee')
                {
                    $emp                 = Employee::where('user_id', '=', \Auth::user()->id)->first();
                    $warning->warning_by = $emp->id;
                }
                else
                {
                    $warning->warning_by = $request->warning_by;
                }

                $warning->warning_to   = $request->warning_to;
                $warning->subject      = $request->subject;
                $warning->warning_date = $request->warning_date;
                $warning->description  = $request->description;
                $warning->save();

                return redirect()->route('warning.index')->with('success', __('Warning successfully updated.'));
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

    public function destroy(Warning $warning)
    {
        if(\Auth::user()->can('Delete Warning'))
        {
            if($warning->created_by == \Auth::user()->creatorId())
            {
                $warning->delete();

                return redirect()->route('warning.index')->with('success', __('Warning successfully deleted.'));
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
