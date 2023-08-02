<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Branch;
use App\Models\Competencies;
use App\Models\Employee;
use App\Models\Performance_Type;
use Illuminate\Http\Request;
use App\Models\Indicator;

class AppraisalController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Appraisal'))
        {
            $user = \Auth::user();
            if($user->type == 'employee')
            {
                $employee   = Employee::where('user_id', $user->id)->first();
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();
                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->where('branch', $employee->branch_id)->where('employee', $employee->id)->get();
            }
            else
            {
                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->get();
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();
            }

            return view('appraisal.index', compact('appraisals','competencyCount'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('Create Appraisal'))
        {
            $employee   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name','id');
            $employee->prepend('Select Employee', '');
            
            $brances = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('appraisal.create', compact('employee', 'brances', 'performance_types'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Appraisal'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'brances' => 'required',
                                   'employee' => 'required',
                                   'rating'=> 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $appraisal                 = new Appraisal();
            $appraisal->branch         = $request->brances;
            $appraisal->employee       = $request->employee;
            $appraisal->appraisal_date = $request->appraisal_date;
            $appraisal->rating         = json_encode($request->rating, true);
            $appraisal->remark         = $request->remark;
            $appraisal->created_by     = \Auth::user()->creatorId();
            $appraisal->save();

            return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully created.'));
        }
    }

    public function show(Appraisal $appraisal)
    {
        $rating = json_decode($appraisal->rating, true);
        $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        $employee = Employee::find($appraisal->employee);
        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();
     
        $ratings = json_decode($indicator->rating, true);
        return view('appraisal.show', compact('appraisal', 'performance_types', 'ratings','rating'));
    }


    public function edit(Appraisal $appraisal)
    {
        if(\Auth::user()->can('Edit Appraisal'))
        {
            $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();

            $employee   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name','id');
            $employee->prepend('Select Employee', '');
            
            $brances = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            $rating = json_decode($appraisal->rating,true);

            return view('appraisal.edit', compact('brances', 'employee', 'appraisal', 'performance_types','rating'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Appraisal $appraisal)
    {
        if(\Auth::user()->can('Edit Appraisal'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'brances' => 'required',
                                   'employees' => 'required',
                                   'rating'=> 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $appraisal->branch         = $request->brances;
            $appraisal->employee       = $request->employees;
            $appraisal->appraisal_date = $request->appraisal_date;
            $appraisal->rating         = json_encode($request->rating, true);
            $appraisal->remark         = $request->remark;
            $appraisal->save();

            return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully updated.'));
        }
    }


    public function destroy(Appraisal $appraisal)
    {
        if(\Auth::user()->can('Delete Appraisal'))
        {
            if($appraisal->created_by == \Auth::user()->creatorId())
            {
                $appraisal->delete();

                return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully deleted.'));
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
    public function empByStar(Request $request)
    {
        $employee = Employee::find($request->employee);
        
        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();
     
        $ratings = json_decode($indicator->rating, true);
        
        $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        
        $viewRender = view('appraisal.star', compact('ratings','performance_types'))->render();
        // dd($viewRender);
        return response()->json(array('success' => true, 'html'=>$viewRender));
  
    }
    public function empByStar1(Request $request)
    {
        $employee = Employee::find($request->employee);
        
        $appraisal = Appraisal::find($request->appraisal);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();
     
        $ratings = json_decode($indicator->rating, true);
        $rating = json_decode($appraisal->rating,true);
        $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        $viewRender = view('appraisal.staredit', compact('ratings','rating','performance_types'))->render();
        // dd($viewRender);
        return response()->json(array('success' => true, 'html'=>$viewRender));
  
    }
    public function getemployee(Request $request)
    {
        $data['employee'] = Employee::where('branch_id',$request->branch_id)->get();

    

        // $employees = Employee::where('branch_id', $request->branch)->get()->pluck('name', 'id')->toArray();
   
        return response()->json($data);


    }      
}
