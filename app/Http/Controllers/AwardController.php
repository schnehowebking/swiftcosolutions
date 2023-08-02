<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\AwardType;
use App\Models\Employee;
use App\Mail\AwardSend;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AwardController extends Controller
{
    public function index()
    {
        $usr = \Auth::user();
        if($usr->can('Manage Award'))
        {
            $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get();
            $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get();

            if(Auth::user()->type == 'employee')
            {
                $emp    = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $awards = Award::where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $awards = Award::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('award.index', compact('awards', 'employees', 'awardtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('Create Award'))
        {
            $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('award.create', compact('employees', 'awardtypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('Create Award'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'award_type' => 'required',
                                   'date' => 'required',
                                   'gift' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $award              = new Award();
            $award->employee_id = $request->employee_id;
            $award->award_type  = $request->award_type;
            $award->date        = $request->date;
            $award->gift        = $request->gift;
            $award->description = (!empty($request->description) ? $request->description : '');
            $award->created_by  = \Auth::user()->creatorId();
            $award->save();
 
           //slack
           $setting = Utility::settings(Auth::user()->creatorId());
           $awardtype = AwardType::find($request->award_type);
           $emp = Employee::find($request->employee_id);
           if(isset($setting['award_notificaation']) && $setting['award_notificaation'] ==1){
               $msg = $awardtype->name.' '. __("created for").' '.$emp->name.' '. __("from").' '.$request->date.'.';
               Utility::send_slack_msg($msg);
           }

             //telegram
             $setting = Utility::settings(Auth::user()->creatorId());
             $awardtype = AwardType::find($request->award_type);
             $emp = Employee::find($request->employee_id);
             if(isset($setting['telegram_award_notification']) && $setting['telegram_award_notification'] ==1){
               $msg = $awardtype->name.' '. __("created for").' '.$emp->name.' '. __("from").' '.$request->date.'.';
               Utility::send_telegram_msg($msg);
             }

             // twilio  
             $setting = Utility::settings(\Auth::user()->creatorId());
             $awardtype = AwardType::find($request->award_type);
             $emp = Employee::find($request->employee_id);
             if (isset($setting['twilio_award_notification']) && $setting['twilio_award_notification'] == 1) {
                 $msg = $awardtype->name . ' ' . __("created for") . ' ' . $emp->name . ' ' . __("from") . ' ' . $request->date . '.';
                 Utility::send_twilio_msg($emp->phone,$msg);
             }

            $setings = Utility::settings();
            if($setings['new_award'] == 1)
            {$employee     = Employee::find($award->employee_id);
                $uArr = [
                    'award_name'=>$employee->name,
                    
                ];

                 $resp = Utility::sendEmailTemplate('new_award', [$employee->email], $uArr);
                return redirect()->route('award.index')->with('success', __('Award  successfully created.'). ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

            return redirect()->route('award.index')->with('success', __('Award  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Award $award)
    {
        return redirect()->route('award.index');
    }

    public function edit(Award $award)
    {
        if(\Auth::user()->can('Edit Award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('award.edit', compact('award', 'awardtypes', 'employees'));
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

    public function update(Request $request, Award $award)
    {
        if(\Auth::user()->can('Edit Award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'employee_id' => 'required',
                                       'award_type' => 'required',
                                       'date' => 'required',
                                       'gift' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $award->employee_id = $request->employee_id;
                $award->award_type  = $request->award_type;
                $award->date        = $request->date;
                $award->gift        = $request->gift;
                $award->description = $request->description;
                $award->save();

                return redirect()->route('award.index')->with('success', __('Award successfully updated.'));
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

    public function destroy(Award $award)
    {
        if(\Auth::user()->can('Delete Award'))
        {
            if($award->created_by == \Auth::user()->creatorId())
            {
                $award->delete();

                return redirect()->route('award.index')->with('success', __('Award successfully deleted.'));
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
