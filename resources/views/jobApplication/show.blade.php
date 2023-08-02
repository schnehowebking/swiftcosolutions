@extends('layouts.admin')
@section('page-title')
    {{ __('Job Application Details') }}
@endsection
@push('css-page')
    <link href="{{ asset('public/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job.application.candidate') }}">{{ __('Archive Application') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job Application') }}</li>
@endsection

@push('script-page')
    <script src="{{ asset('public/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script>
        var e = $('[data-toggle="tags"]');
        e.length && e.each(function() {
            $(this).tagsinput({
                tagClass: "badge badge-primary"
            })
        });

        $(document).ready(function() {

            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });


            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {

                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                $.ajax({
                    url: '{{ route('job.application.rating', $jobApplication->id) }}',
                    type: 'POST',
                    data: {
                        rating: ratingValue,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                });

            });

        });
        $(document).on('change', '.stages', function() {
            var id = $(this).val();
            var schedule_id = $(this).attr('data-scheduleid');

            $.ajax({
                url: "{{ route('job.application.stage.change') }}",
                type: 'POST',
                data: {
                    "stage": id,
                    "schedule_id": schedule_id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    // show_toastr('Suceess', data.success, 'success');
                    show_toastr('Success', 'The candidate stage successfully chnaged', 'error');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
    </script>
@endpush
@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="text-muted">{{ __('Basic Details') }}</h6>
                    </div>
                    <div class="col text-end">
                        <ul class="list-inline mb-0">
                            @can('Delete Job Application')
                                <li class="list-inline-item">

                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job.application.archive', $jobApplication->id]]) !!}
                                    <a href="#" class="bs-pass-para" data-bs-toggle="tooltip" title=""
                                        data-bs-original-title="Archive" aria-label="Delete">
                                        @if ($jobApplication->is_archive == 0)
                                            <span class="badge bg-info p-2 px-3 rounded">{{ __('Archive') }}</span>
                                        @else
                                            <span class="badge bg-warning p-2 px-3 rounded">{{ __('UnArchive') }}</span>
                                        @endif
                                    </a>
                                    {!! Form::close() !!}

                                </li>
                                @if ($jobApplication->is_archive == 0)
                                    <li class="list-inline-item">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $jobApplication->id], 'id' => 'delete-form-' . $jobApplication->id]) !!}
                                        <a href="#" class="bs-pass-para" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Delete" aria-label="Delete"><span
                                                class="badge bg-danger p-2 px-3 rounded">{{ __('Delete') }}</span></a>
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
                    <div class="d-flex align-items-center" data-toggle="tooltip" data-placement="right"
                        data-title="2 hrs ago" data-original-title="" title="">
                        <div>
                            @php
                            $logo=\App\Models\Utility::get_file('uploads/avatar/');
                            $profiles=\App\Models\Utility::get_file('uploads/job/profile/');
                        @endphp
                        <a href="{{ !empty($jobApplication->profile) ?($profiles . $jobApplication->profile) : $logo."avatar.png" }}" target="_blank" class="avatar rounded-circle avatar-sm">
                            <img src="{{ !empty($jobApplication->profile) ? ($profiles . $jobApplication->profile) : $logo."avatar.png" }}"
                                class="img-fluid rounded-circle" style="width: 50px">
                        </a>
                        </div>
                        <div class="flex-fill ms-3">
                            <div class="h6 text-sm mb-0"> {{ $jobApplication->name }}</div>
                            <p class="text-sm lh-140 mb-0">
                                {{ $jobApplication->email }}
                            </p>
                        </div>
                    </div>
                </h5>

                <div class="py-2 my-4 border-top ">
                    <div class="row align-items-center my-3">
                        @foreach ($stages as $stage)
                            <div class="form-check form-check-inline form-group">
                                <input type="radio" id="stage_{{ $stage->id }}" name="stage"
                                    data-scheduleid="{{ $jobApplication->id }}" value="{{ $stage->id }}"
                                    class="form-check-input stages"
                                    {{ $jobApplication->stage == $stage->id ? 'checked' : '' }}>
                                <label class="form check-label"
                                    for="stage_{{ $stage->id }}">{{ $stage->title }}</label>
                            </div>
                        @endforeach
                    </div>
              </div>
         </div>
     </div>
</div>

  <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="text-muted">{{ __('Basic Information') }}</h6>
                    </div>
                        <div class="col text-end">
                        <div class="col-12 text-end">
                            <a href="#" data-url="{{ route('job.on.board.create', $jobApplication->id) }}"
                            data-ajax-popup="true" class="btn-sm btn btn-primary" data-title="{{ __('Add to Job OnBoard') }}"
                             data-bs-original-title="{{ __('Add to Job OnBoard') }}">
                             <i class="ti ti-plus "></i>{{ __('Add to Job OnBoard') }}</a>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="card-header" style="height: 400px">
                 <dl class="row">

                    <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Phone') }}</span></dt>
                    <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->phone }}</span></dd>
                    @if (!empty($jobApplication->dob))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('DOB') }}</span></dt>
                        <dd class="col-sm-9"><span
                                class="text-sm">{{ \Auth::user()->dateFormat($jobApplication->dob) }}</span></dd>
                    @endif
                    @if (!empty($jobApplication->gender))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Gender') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->gender }}</span></dd>
                    @endif
                    @if (!empty($jobApplication->address))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Address') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->address }}</span>
                        </dd>
                    @endif
                    @if (!empty($jobApplication->city))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('City') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->city }}</span></dd>
                    @endif
                    @if (!empty($jobApplication->state))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('State') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->state }}</span></dd>
                    @endif
                    @if (!empty($jobApplication->country))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Country') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->country }}</span>
                        </dd>
                    @endif
                    @if (!empty($jobApplication->zip_code))
                        <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Zip Code') }}</span></dt>
                        <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->zip_code }}</span>
                        </dd>
                    @endif

                    <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Applied For') }}</span></dt>
                    <dd class="col-sm-9"><span
                            class="text-sm">{{ !empty($jobApplication->jobs) ? $jobApplication->jobs->title : '-' }}</span>
                    </dd>

                    <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Applied at') }}</span></dt>
                    <dd class="col-sm-9"><span
                            class="text-sm">{{ \Auth::user()->dateFormat($jobApplication->created_at) }}</span>
                    </dd>
                    <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('CV / Resume') }}</span></dt>
                    <dd class="col-sm-9">
                        {{-- {{dd($jobApplication->resume)}} --}}
                        @php
                        $resumes=\App\Models\Utility::get_file('uploads/job/resume');
                        @endphp
                        @if (!empty($jobApplication->resume))
                            <span class="text-sm action-btn bg-primary ms-2">
                                <a href="{{ $resumes . '/' . $jobApplication->resume }}"
                                    data-bs-toggle="tooltip" data-bs-original-title="{{ __('download') }}"
                                    download=""><i class="ti ti-download text-white"></i></a>
                            </span>
                            <div class="action-btn bg-secondary ms-2">
                                <a class="mx-3 btn btn-sm align-items-center" href="{{$resumes . '/' . $jobApplication->resume }}" target="_blank"  >
                                    <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>
                                </a>
                            </div>
                        @else
                            -
                        @endif

                    </dd>
                   <dt class="col-sm-3"><span class="h6 text-sm mb-0">{{ __('Cover Letter') }}:</span></dt>
                    <dd class="col-sm-9"><span class="text-sm">{{ $jobApplication->cover_letter }}</span>
                    </dd>

                    </dl>
                    <div class='rating-stars text-right'>
                        <ul id='stars'>
                            <li class='star {{(in_array($jobApplication->rating,[1,2,3,4,5])==true)?'selected':''}}' data-bs-toggle="tooltip"   data-bs-original-title="Poor" data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[2,3,4,5])==true)?'selected':''}}' data-bs-toggle="tooltip"   data-bs-original-title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                            </li>
                         <li class='star {{(in_array($jobApplication->rating,[3,4,5])==true)?'selected':''}}' data-bs-toggle="tooltip"   data-bs-original-title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[4,5])==true)?'selected':''}}' data-bs-toggle="tooltip"   data-bs-original-title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star {{(in_array($jobApplication->rating,[5])==true)?'selected':''}}' data-bs-toggle="tooltip"   data-bs-original-title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                            </li>
                        </ul>
                    </div>
              </div>
        </div>
  </div>

    <div class="col-md-12">
        <div class="card card-fluid">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h6 class="text-muted">{{ __('Additional Details') }}</h6>
                    </div>
                    <div class="col text-end">
                        @can('Create Interview Schedule')
                            <a  data-url="{{ route('interview-schedule.create', $jobApplication->id) }}"
                                data-size="lg" class="btn-sm btn btn-primary" data-ajax-popup="true"
                                data-title="{{ __('Create New Interview Schedule') }}">
                                <i class="ti ti-plus "></i> {{ __('Create New Interview Schedule') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (!empty(json_decode($jobApplication->custom_question)))
                    <div class="list-group list-group-flush mb-4">
                        @foreach (json_decode($jobApplication->custom_question) as $que => $ans)
                            @if (!empty($ans))
                                <div class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <a href="#!" class="d-block h6 text-sm mb-0">{{ $que }}</a>
                                            <p class="card-text text-sm text-muted mb-0">
                                                {{ $ans }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                {{ Form::open(['route' => ['job.application.skill.store', $jobApplication->id], 'method' => 'post']) }}
                <div class="form-group">
                    <label class="form-label">{{ __('Skills') }}</label>
                    <input type="text" class="form-control" value="{{ $jobApplication->skill }}" data-toggle="tags"
                        name="skill" placeholder="{{ __('Type here....') }}" />
                </div>
                @can('Add Job Application Skill')
                    <div class="form-group">
                        <input type="submit" value="{{ __('Add Skills') }}" class="btn-sm btn btn-primary">
                    </div>
                @endcan
                {{ Form::close() }}


                {{ Form::open(['route' => ['job.application.note.store', $jobApplication->id], 'method' => 'post']) }}
                <div class="form-group">
                    <label class="form-label">{{ __('Applicant Notes') }}</label>
                    <textarea name="note" class="form-control" id="" rows="3"></textarea>
                </div>
                @can('Add Job Application Note')
                    <div class="form-group">
                        <input type="submit" value="{{ __('Add Notes') }}" class="btn-sm btn btn-primary">
                    </div>
                @endcan
                {{ Form::close() }}

                <div class="list-group list-group-flush mb-4">
                    @foreach ($notes as $note)
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <a href="#!"
                                        class="d-block h6 text-sm mb-0">{{ !empty($note->noteCreated) ? $note->noteCreated->name : '-' }}</a>
                                    <p class="card-text text-sm text-muted mb-0">
                                        {{ $note->note }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="">
                                        {{ \Auth::user()->dateFormat($note->created_at) }}</a>
                                </div>
                                @can('Delete Job Application Note')
                                    @if ($note->note_created == \Auth::user()->id)
                                        <div class="col-auto text-end">
                                            {{-- <a class="delete-icon" href="#"
                                                data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                data-confirm-yes="document.getElementById('delete-form-{{ $note->id }}').submit();">
                                                <i class="ti ti-trash"></i></a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job.application.note.destroy', $note->id], 'id' => 'delete-form-' . $note->id]) !!}
                                            {!! Form::close() !!} --}}

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job.application.note.destroy', $note->id], 'id' => 'delete-form-' . $note->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                aria-label="Delete"><i class="ti ti-trash text-white"></i></a>
                                            </form>


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

@endsection
