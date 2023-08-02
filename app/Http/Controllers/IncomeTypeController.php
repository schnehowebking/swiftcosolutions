<?php

namespace App\Http\Controllers;

use App\Models\IncomeType;
use Illuminate\Http\Request;

class IncomeTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Income Type'))
        {
            $incometypes = IncomeType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('incometype.index', compact('incometypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Income Type'))
        {
            return view('incometype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Income Type'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $incometype             = new IncomeType();
            $incometype->name       = $request->name;
            $incometype->created_by = \Auth::user()->creatorId();
            $incometype->save();

            return redirect()->route('incometype.index')->with('success', __('IncomeType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(IncomeType $incometype)
    {
        return redirect()->route('incometype.index');
    }

    public function edit(IncomeType $incometype)
    {
        if(\Auth::user()->can('Edit Income Type'))
        {
            if($incometype->created_by == \Auth::user()->creatorId())
            {

                return view('incometype.edit', compact('incometype'));
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

    public function update(Request $request, IncomeType $incometype)
    {
        if(\Auth::user()->can('Edit Income Type'))
        {
            if($incometype->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',

                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $incometype->name = $request->name;
                $incometype->save();

                return redirect()->route('incometype.index')->with('success', __('IncomeType successfully updated.'));
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

    public function destroy(IncomeType $incometype)
    {
        if(\Auth::user()->can('Delete Income Type'))
        {
            if($incometype->created_by == \Auth::user()->creatorId())
            {
                $incometype->delete();

                return redirect()->route('incometype.index')->with('success', __('IncomeType successfully deleted.'));
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
