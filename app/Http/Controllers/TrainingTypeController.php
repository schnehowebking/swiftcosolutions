<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Training Type'))
        {
            $trainingtypes = TrainingType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('trainingtype.index', compact('trainingtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('Create Training Type'))
        {
            return view('trainingtype.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Training Type'))
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

            $trainingtype             = new TrainingType();
            $trainingtype->name       = $request->name;
            $trainingtype->created_by = \Auth::user()->creatorId();
            $trainingtype->save();

            return redirect()->route('trainingtype.index')->with('success', __('TrainingType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(TrainingType $trainingType)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('Edit Training Type'))
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {

                return view('trainingtype.edit', compact('trainingType'));
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


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('Edit Training Type'))
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',

                                   ]
                );

                $trainingType->name = $request->name;
                $trainingType->save();

                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully updated.'));
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


    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Training Type'))
        {

            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $trainings = Training::where('training_type',$trainingType->id)->get();
                if(count($trainings) == 0){

                    $trainingType->delete();
                }else
                {
                    return redirect()->route('trainingtype.index')->with('error', __('This TrainingType has Training List. Please remove the Training List from this TrainingType.'));

                }
                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully deleted.'));
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
