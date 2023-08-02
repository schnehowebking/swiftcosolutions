<?php

namespace App\Http\Controllers;

use App\Models\InterviewSchedule as LocalInterviewSchedule;
use App\Models\JobApplication;
use App\Models\JobStage;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class InterviewScheduleController extends Controller
{

    public function index()
    {
        $sdf ='';
        $schedules   = LocalInterviewSchedule::where('created_by', \Auth::user()->creatorId())->get();
        $arrSchedule = [];
        $today_date = date('m');
        $current_month_event = LocalInterviewSchedule::select('id', 'candidate','date','employee', 'time','comment')->whereNotNull(['date'])->whereMonth('date',$today_date)->get();

        foreach($schedules as $key => $schedule)
        {
            $arr['id']     = $schedule['id'];
            $arr['title']  = !empty($schedule->applications) ? !empty($schedule->applications->jobs) ? $schedule->applications->jobs->title : '' : '';
            $arr['start']  = $schedule['date'];
            $arr['url']    = route('interview-schedule.show', $schedule['id']);
            $arr['className'] = ' event-primary';
            $arrSchedule[] = $arr;
            $sdf = !empty($current_month_event[$key]->applications) ? (!empty($current_month_event[$key]->applications->jobs) ? $current_month_event[$key]->applications->jobs->title : '') : '';
        }
        // $arrSchedule = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrSchedule)));
        $arrSchedule=json_encode($arrSchedule);

        return view('interviewSchedule.index', compact('arrSchedule', 'schedules','current_month_event','sdf'));
    }

    public function create($candidate=0)
    {

        // $employees = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->orWhere('id', \Auth::user()
        // ->creatorId())->get()->pluck('name', 'id');
        $employees = User::where('type', 'employee')->get()->pluck('name', 'id');

        $employees->prepend('--', '');

        $candidates = JobApplication::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $candidates->prepend('--', '');

        return view('interviewSchedule.create', compact('employees', 'candidates','candidate'));
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Interview Schedule'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'candidate' => 'required',
                                   'employee' => 'required',
                                   'date' => 'required',
                                   'time' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $schedule             = new LocalInterviewSchedule();
            $schedule->candidate  = $request->candidate;
            $schedule->employee   = $request->employee;
            $schedule->date       = $request->date;
            $schedule->time       = $request->time;
            $schedule->comment    = $request->comment;
            $schedule->created_by = \Auth::user()->creatorId();
            $schedule->save();

            // Google Celander
            if ($request->get('synchronize_type')  == 'google_calender') {

                $type = 'interview_schedule';
                $request1 = new GoogleEvent();
                $request1->title = Self::index()->sdf;
                $request1->start_date = $request->date;
                $request1->end_date = $request->date;
                
                Utility::addCalendarData($request1, $type);
            }

            return redirect()->back()->with('success', __('Interview schedule successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(LocalInterviewSchedule $interviewSchedule)
    {
        $stages=JobStage::where('created_by',\Auth::user()->creatorId())->get();
        return view('interviewSchedule.show', compact('interviewSchedule','stages'));
    }

    public function edit(LocalInterviewSchedule $interviewSchedule)
    {
        // $employees = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->orWhere('id', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $employees = User::where('type', 'employee')->get()->pluck('name', 'id');

        $employees->prepend('--', '');

        $candidates = JobApplication::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $candidates->prepend('--', '');

        return view('interviewSchedule.edit', compact('employees', 'candidates', 'interviewSchedule'));
    }

    public function update(Request $request, LocalInterviewSchedule $interviewSchedule)
    {
        if(\Auth::user()->can('Edit Interview Schedule'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'candidate' => 'required',
                                   'employee' => 'required',
                                   'date' => 'required',
                                   'time' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $interviewSchedule->candidate = $request->candidate;
            $interviewSchedule->employee  = $request->employee;
            $interviewSchedule->date      = $request->date;
            $interviewSchedule->time      = $request->time;
            $interviewSchedule->comment   = $request->comment;
            $interviewSchedule->save();

            return redirect()->back()->with('success', __('Interview schedule successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(LocalInterviewSchedule $interviewSchedule)
    {
        $interviewSchedule->delete();

        return redirect()->back()->with('success', __('Interview schedule successfully deleted.'));
    }

    public function get_interview_schedule_data(Request $request)
    {
        $arrayJson = [];
        if ($request->get('calender_type') == 'google_calender') {
            $type = 'interview_schedule';
            $arrayJson =  Utility::getCalendarData($type);
            // dd($type,$arrayJson);
        } else {
            $data = LocalInterviewSchedule::get();

            foreach ($data as $val) {
                // dd($val);
                $end_date = date_create($val->end_date);
                date_add($end_date, date_interval_create_from_date_string("1 days"));
                $arrayJson[] = [
                    "id" => $val->id,
                    "title" => Self::index()->sdf,
                    "start" => $val->date,
                    "end" => date_format($end_date, "Y-m-d H:i:s"),
                    "className" => $val->color,
                    "textColor" => '#FFF',
                    "allDay" => true,
                    "url" => route('interview-schedule.show', $val['id']),
                ];
            }
        }

        return $arrayJson;
    }

}
