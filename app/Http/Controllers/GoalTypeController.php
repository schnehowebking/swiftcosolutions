<?php

namespace App\Http\Controllers;

use App\Models\GoalType;
use Illuminate\Http\Request;

class GoalTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Goal Type'))
        {
            $goaltypes = GoalType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('goaltype.index', compact('goaltypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('Create Goal Type'))
        {
            return view('goaltype.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Goal Type'))
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

            $goaltype             = new GoalType();
            $goaltype->name       = $request->name;
            $goaltype->created_by = \Auth::user()->creatorId();
            $goaltype->save();

            return redirect()->route('goaltype.index')->with('success', __('GoalType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(GoalType $goalType)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('Edit Goal Type'))
        {
            $goalType = GoalType::find($id);

            return view('goaltype.edit', compact('goalType'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('Edit Goal Type'))
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
            $goalType       = GoalType::find($id);
            $goalType->name = $request->name;
            $goalType->save();

            return redirect()->route('goaltype.index')->with('success', __('GoalType  successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Goal Type'))
        {
            $goalType = GoalType::find($id);
            if($goalType->created_by == \Auth::user()->creatorId())
            {
                $goalTrackings = GoalTracking::where('goal_type', $goalType->id)->get();
                if(count($goalTrackings) == 0)
                {
                    $goalType->delete();
                }else{

                    return redirect()->route('goaltype.index')->with('error', __('This GoalType has Goal. Please remove the Goal from this GoalType.'));

                }

                return redirect()->route('goaltype.index')->with('success', __('GoalType successfully deleted.'));
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
