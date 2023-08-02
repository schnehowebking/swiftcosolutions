<?php

namespace App\Http\Controllers;

use App\Models\Payer;
use Illuminate\Http\Request;

class PayerController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('Manage Payer'))
        {
            $payers = Payer::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('payer.index', compact('payers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Payer'))
        {
            return view('payer.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Payer'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'payer_name' => 'required',
                                   'contact_number' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $payer                 = new Payer();
            $payer->payer_name     = $request->payer_name;
            $payer->contact_number = $request->contact_number;
            $payer->created_by     = \Auth::user()->creatorId();
            $payer->save();

            return redirect()->route('payer.index')->with('success', __('Payer  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Payer $payer)
    {
        return redirect()->route('payer.index');
    }

    public function edit(Payer $payer)
    {
        if(\Auth::user()->can('Edit Payer'))
        {
            if($payer->created_by == \Auth::user()->creatorId())
            {
                return view('payer.edit', compact('payer'));
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

    public function update(Request $request, $payer)
    {
        $payer = Payer::find($payer);
        if(\Auth::user()->can('Edit Payer'))
        {
            if($payer->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'payer_name' => 'required',
                                       'contact_number' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $payer->payer_name     = $request->payer_name;
                $payer->contact_number = $request->contact_number;
                $payer->save();

                return redirect()->route('payer.index')->with('success', __('Payer successfully updated.'));
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

    public function destroy(Payer $payer)
    {
        if(\Auth::user()->can('Delete Payer'))
        {
            if($payer->created_by == \Auth::user()->creatorId())
            {
                $payer->delete();

                return redirect()->route('payer.index')->with('success', __('Payer successfully deleted.'));
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
