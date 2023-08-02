 {{-- <div class="row">
        <div class="col-md-4">
            <div class="card card-fluid">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <h6 class="text-muted">{{__('Basic Details')}}</h6>
                        </div>
                        <div class="col text-right">
                            <ul class="list-inline mb-0">
                                @can('Delete Job Application')
                                    <li class="list-inline-item">

                                        <a href="#" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('archive-form-{{$jobApplication->id}}').submit();">
                                            @if($jobApplication->is_archive==0)
                                                <span class="badge badge-pill badge-soft-info">{{__('Archive')}}</span>
                                            @else
                                                <span class="badge badge-pill badge-soft-warning">{{__('UnArchive')}}</span>
                                            @endif
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['job.application.archive', $jobApplication->id],'id'=>'archive-form-'.$jobApplication->id]) !!}
                                        {!! Form::close() !!}

                                    </li>
                                    @if($jobApplication->is_archive==0)
                                        <li class="list-inline-item">
                                            <a href="#" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$jobApplication->id}}').submit();"><span class="badge badge-pill badge-soft-danger">{{__('Delete')}}</span></a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $jobApplication->id],'id'=>'delete-form-'.$jobApplication->id]) !!}
                                            {!! Form::close() !!}
                                        </li>
                                    @endif
                                @endcan
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <h5 class="h4">
                        <div class="d-flex align-items-center" data-toggle="tooltip" data-placement="right" data-title="2 hrs ago" data-original-title="" title="">
                            <div>
                                <a href="#" class="avatar rounded-circle avatar-sm">
                                    <img src="{{!empty($jobApplication->profile)? asset('/storage/uploads/job/profile/'.$jobApplication->profile):asset('/storage/uploads/avatar/avatar.png')}}" class="">
                                </a>
                            </div>
                            <div class="flex-fill ml-3">
                                <div class="h6 text-sm mb-0"> {{$jobApplication->name}}</div>
                                <p class="text-sm lh-140 mb-0">
                                    {{ $jobApplication->email}}
                                </p>
                            </div>
                        </div>
                    </h5>

                    <div class="py-2 my-4 border-top ">
                        <div class="row align-items-center my-3">
                            @foreach($stages as $stage)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="stage_{{$stage->id}}" name="stage" data-scheduleid="{{$jobApplication->id}}" value="{{$stage->id}}" class="custom-control-input stages" {{($jobApplication->stage==$stage->id)?'checked':''}}>
                                    <label class="custom-control-label" for="stage_{{$stage->id}}">{{$stage->title}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-right">
                            <a href="#" data-url="{{route('job.on.board.create', $jobApplication->id)}}" data-ajax-popup="true" class="btn btn-xs btn-white btn-icon-only width-auto">  {{__('Add to Job OnBoard')}}</a>
                        </div>
                    </div>

                    <div class="py-4 my-4 border-top border-bottom">
                        <h6 class="text-sm">{{__('Cover Letter')}}:</h6>
                        <p class="text-sm mb-0">
                            {{$jobApplication->cover_letter}}
                        </p>
                    </div>
                    <dl class="row">
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('Phone')}}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{$jobApplication->phone}}</span></dd>
                        @if(!empty($jobApplication->dob))
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('DOB')}}</span></dt>
                            <dd class="col-sm-9"><span class="text-sm">{{\Auth::user()->dateFormat($jobApplication->dob)}}</span></dd>
                        @endif
                        @if(!empty($jobApplication->gender))
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('Gender')}}</span></dt>
                            <dd class="col-sm-9"><span class="text-sm">{{$jobApplication->gender}}</span></dd>
                        @endif
                        @if(!empty($jobApplication->country))
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('Country')}}</span></dt>
                            <dd class="col-sm-9"><span class="text-sm">{{$jobApplication->country}}</span></dd>
                        @endif
                        @if(!empty($jobApplication->state))
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('State')}}</span></dt>
                            <dd class="col-sm-9"><span class="text-sm">{{$jobApplication->state}}</span></dd>
                        @endif
                        @if(!empty($jobApplication->city))
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('City')}}</span></dt>
                            <dd class="col-sm-9"><span class="text-sm">{{$jobApplication->city}}</span></dd>
                        @endif

                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('Applied For')}}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ !empty($jobApplication->jobs)?$jobApplication->jobs->title:'-' }}</span></dd>

                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('Applied at')}}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{\Auth::user()->dateFormat($jobApplication->created_at)}}</span></dd>
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{__('CV / Resume')}}</span></dt>
                        <dd class="col-sm-9">
                            @if(!empty($jobApplication->resume))
                                <span class="text-sm">
                                <a href="{{asset(Storage::url('uploads/job/resume')).'/'.$jobApplication->resume}}" target="_blank"><i class="fas fa-download"></i></a>
                            </span>
                            @else
                                -
                            @endif
                        </dd>

                    </dl>
                    <div class='rating-stars text-right'>
                        <ul id='stars'>
                            <li class='star {{(in_array($jobApplication->rating,[1,2,3,4,5])==true)?'selected':''}}' data-toggle="tooltip" data-title="Poor" data-value='1'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[2,3,4,5])==true)?'selected':''}}' data-toggle="tooltip" data-title='Fair' data-value='2'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[3,4,5])==true)?'selected':''}}' data-toggle="tooltip" data-title='Good' data-value='3'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[4,5])==true)?'selected':''}}' data-toggle="tooltip" data-title='Excellent' data-value='4'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[5])==true)?'selected':''}}' data-toggle="tooltip" data-title='WOW!!!' data-value='5'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-fluid">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-muted">{{__('Additional Details')}}</h6>
                        </div>
                        <div class="col text-right">
                            @can('Create Interview Schedule')
                                <a href="#" data-url="{{ route('interview-schedule.create',$jobApplication->id) }}" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="{{__('Create New Interview Schedule')}}">
                                    <i class="fa fa-plus"></i> {{__('Create Interview Schedule')}}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty(json_decode($jobApplication->custom_question)))
                        <div class="list-group list-group-flush mb-4">
                            @foreach(json_decode($jobApplication->custom_question) as $que => $ans)
                                @if(!empty($ans))
                                    <div class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="#!" class="d-block h6 text-sm mb-0">{{$que}}</a>
                                                <p class="card-text text-sm text-muted mb-0">
                                                    {{$ans}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    {{Form::open(array('route'=>array('job.application.skill.store',$jobApplication->id),'method'=>'post'))}}
                    <div class="form-group">
                        <label class="form-control-label">{{__('Skills')}}</label>
                        <input type="text" class="form-control" value="{{$jobApplication->skill}}" data-toggle="tags" name="skill" placeholder="{{__('Type here....')}}"/>
                    </div>
                    @can('Add Job Application Skill')
                        <div class="form-group">
                            <input type="submit" value="{{__('Add Skills')}}" class="btn-create badge-blue">
                        </div>
                    @endcan
                    {{Form::close()}}


                    {{Form::open(array('route'=>array('job.application.note.store',$jobApplication->id),'method'=>'post'))}}
                    <div class="form-group">
                        <label class="form-control-label">{{__('Applicant Notes')}}</label>
                        <textarea name="note" class="form-control" id="" rows="3"></textarea>
                    </div>
                    @can('Add Job Application Note')
                        <div class="form-group">
                            <input type="submit" value="{{__('Add Notes')}}" class="btn-create badge-blue">
                        </div>
                    @endcan
                    {{Form::close()}}

                    <div class="list-group list-group-flush mb-4">
                        @foreach($notes as $note)
                            <div class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <a href="#!" class="d-block h6 text-sm mb-0">{{!empty($note->noteCreated)?$note->noteCreated->name:'-'}}</a>
                                        <p class="card-text text-sm text-muted mb-0">
                                            {{$note->note}}
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class=""> {{\Auth::user()->dateFormat($note->created_at)}}</a>
                                    </div>
                                    @can('Delete Job Application Note')
                                        @if($note->note_created==\Auth::user()->id)
                                            <div class="col-auto text-right">
                                                <a class="delete-icon" href="#" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$note->id}}').submit();"> <i class="fas fa-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['job.application.note.destroy', $note->id],'id'=>'delete-form-'.$note->id]) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> --}}