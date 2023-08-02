<?php

namespace App\Http\Controllers;

use App\Models\Competencies;
use App\Models\Performance_Type;
use Illuminate\Http\Request;

class PerformanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->id)->get();
        return view('performance_type.index', compact('performance_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('Create Performance Type'))
        {
        return view('performance_type.create');
        }
        else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $performance_type = new Performance_Type();
        $performance_type->name = $request->name;
        $performance_type->created_by = \Auth::user()->id;
        $performance_type->save();

        return redirect()->back()->with('success', 'Performance Type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Performance_Type  $performance_Type
     * @return \Illuminate\Http\Response
     */
    public function show(Performance_Type $performance_Type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Performance_Type  $performance_Type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->can('Edit Performance Type'))
        {
                    $performance_type  = Performance_Type::find($id);
                    return view('performance_type.edit', compact('performance_type'));
        }else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Performance_Type  $performance_Type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $performance_type = Performance_Type::findOrFail($id);
        $performance_type->name = $request->name;
        $performance_type->save();

        return redirect()->back()->with('success', 'Performance Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Performance_Type  $performance_Type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance_Type $performance_Type,$id)
    {

        if(\Auth::user()->can('Delete Performance Type'))
        {
            if(\Auth::user()->type == 'company')
            {
                $performance_Type = Performance_Type::findOrFail($id);
                $competencies = Competencies::where('type', $performance_Type->id)->get();
                if(count($competencies) == 0){

                    $performance_Type->delete();
                }else{
                    return redirect()->route('performanceType.index')->with('error', __('This Performance Type has Competencies. Please remove the Competencies from this Performance Type.'));

                }

                return redirect()->route('performanceType.index')->with('success', __('Performance Type successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
    }
}





