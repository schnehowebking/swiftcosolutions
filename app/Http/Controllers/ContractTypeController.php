<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(\Auth::user()->can('Manage Contract Types'))
        // {
            $contractTypes = ContractType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('contract_type.index')->with('contractTypes', $contractTypes);
        // }
        // else
        // {
            return redirect()->back()->with('error', __('Permission Denied.'));
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('Create Contract Type'))
        {
            return view('contract_type.create');
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Contract Type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('contract_type.index')->with('error', $messages->first());
            }

            $contractType             = new ContractType();
            $contractType->name       = $request->name;
            $contractType->created_by = \Auth::user()->creatorId();
            $contractType->save();

            return redirect()->route('contract_type.index')->with('success', __('Contract Type successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ContractType $contractType
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ContractType $contractType)
    {
        return redirect()->route('contract_type.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ContractType $contractType
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractType $contractType)
    {
        if(\Auth::user()->can('Edit Contract Type'))
        {
            if($contractType->created_by == \Auth::user()->creatorId())
            {
                return view('contract_type.edit', compact('contractType'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ContractType $contractType
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractType $contractType)
    {
        return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        if(\Auth::user()->can('Edit Contract Type'))
        {
            if($contractType->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('contract_type.index')->with('error', $messages->first());
                }

                $contractType->name = $request->name;
                $contractType->save();

                return redirect()->route('contract_type.index')->with('success', __('Contract Type successfully updated!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ContractType $contractType
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractType $contractType)
    {
        // return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));
        
        if(\Auth::user()->can('Delete Contract Type'))
        {
            if($contractType->created_by == \Auth::user()->creatorId())
            {
                $contractType->delete();

                return redirect()->route('contract_type.index')->with('success', __('Contract Type successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
