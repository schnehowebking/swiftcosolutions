<?php

namespace App\Http\Controllers;

use App\Models\Payees;
use Illuminate\Http\Request;

class PayeesController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Payee'))
        {
            $payees = Payees::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('payees.index', compact('payees'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Payee'))
        {
            return view('payees.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Payee'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'payee_name' => 'required',
                                   'contact_number' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $payee                 = new Payees();
            $payee->payee_name     = $request->payee_name;
            $payee->contact_number = $request->contact_number;
            $payee->created_by     = \Auth::user()->creatorId();
            $payee->save();

            return redirect()->route('payees.index')->with('success', __('Payees  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Payees $payee)
    {
        return redirect()->route('payees.index');
    }

    public function edit(Payees $payee)
    {
        if(\Auth::user()->can('Edit Payee'))
        {
            if($payee->created_by == \Auth::user()->creatorId())
            {
                return view('payees.edit', compact('payee'));
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

    public function update(Request $request, $payee)
    {
        $payee = Payees::find($payee);
        if(\Auth::user()->can('Edit Payee'))
        {
            if($payee->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'payee_name' => 'required',
                                       'contact_number' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $payee->payee_name     = $request->payee_name;
                $payee->contact_number = $request->contact_number;
                $payee->save();

                return redirect()->route('payees.index')->with('success', __('Payees successfully updated.'));
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

    public function destroy(Payees $payee)
    {
        if(\Auth::user()->can('Delete Payee'))
        {
            if($payee->created_by == \Auth::user()->creatorId())
            {
                $payee->delete();

                return redirect()->route('payees.index')->with('success', __('Payees successfully deleted.'));
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
