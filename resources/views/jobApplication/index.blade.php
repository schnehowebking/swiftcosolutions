@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Job Application') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job Application') }}</li>
@endsection


@push('css-page')
    <link href="{{ asset('libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
@endpush


@push('script-page')
    {{-- <script src="{{ asset('libs/dragula/dist/dragula.min.js') }}"></script>
    <script src="{{ asset('libs/autosize/dist/autosize.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>

    <script>
        $(document).on('change', '#jobs', function() {

            var id = $(this).val();

            $.ajax({
                url: "{{ route('get.job.application') }}",
                type: 'POST',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    var job = JSON.parse(data);
                    // console.log(job)
                    var applicant = job.applicant;
                    var visibility = job.visibility;
                    var question = job.custom_question;

                    (applicant.indexOf("gender") != -1) ? $('.gender').removeClass('d-none'): $(
                        '.gender').addClass('d-none');
                    (applicant.indexOf("dob") != -1) ? $('.dob').removeClass('d-none'): $('.dob')
                        .addClass('d-none');
                    (applicant.indexOf("address") != -1) ? $('.address').removeClass('d-none'): $(
                        '.address').addClass('d-none');

                    (visibility.indexOf("profile") != -1) ? $('.profile').removeClass('d-none'): $(
                        '.profile').addClass('d-none');
                    (visibility.indexOf("resume") != -1) ? $('.resume').removeClass('d-none'): $(
                        '.resume').addClass('d-none');
                    (visibility.indexOf("letter") != -1) ? $('.letter').removeClass('d-none'): $(
                        '.letter').addClass('d-none');

                    $('.question').addClass('d-none');

                    if (question.length > 0) {
                        question.forEach(function(id) {
                            $('.question_' + id + '').removeClass('d-none');
                        });
                    }


                }
            });
        });

        @can('Move Job Application')
            ! function(a) {
                "use strict";

                var t = function() {
                    this.$body = a("body")
                };
                t.prototype.init = function() {
                // console.log(t);
                    a('[data-plugin="dragula"]').each(function() {

                        //   console.log(t);
                        var t = a(this).data("containers"),

                            n = [];
                        if (t)
                            for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]);
                        else n = [a(this)[0]];
                        var r = a(this).data("handleclass");
                        r ? dragula(n, {
                            moves: function(a, t, n) {
                                return n.classList.contains(r)
                            }
                        }) : dragula(n).on('drop', function(el, target, source, sibling) {
                            var order = [];
                            $("#" + target.id + " > div").each(function() {
                                order[$(this).index()] = $(this).attr('data-id');
                            });

                            var id = $(el).attr('data-id');

                            var old_status = $("#" + source.id).data('status');
                            var new_status = $("#" + target.id).data('status');
                            var stage_id = $(target).attr('data-id');


                            $("#" + source.id).parent().find('.count').text($("#" + source.id +
                                " > div").length);
                            $("#" + target.id).parent().find('.count').text($("#" + target.id +
                                " > div").length);
                            $.ajax({
                                url: '{{ route('job.application.order') }}',
                                type: 'POST',
                                data: {
                                    application_id: id,
                                    stage_id: stage_id,
                                    order: order,
                                    new_status: new_status,
                                    old_status: old_status,
                                    "_token": $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data) {
                                    show_toastr('Success', 'Lead successfully updated',
                                        'success');
                                },
                                error: function(data) {
                                    data = data.responseJSON;
                                    show_toastr('Error', data.error, 'error')
                                }
                            });
                        });
                    })
                }, a.Dragula = new t, a.Dragula.Constructor = t
            }(window.jQuery),
            function(a) {
                "use strict";

                a.Dragula.init()

            }(window.jQuery);
        @endcan
    </script>
@endpush
@section('action-button')
   <!--  <a class="btn btn-sm btn-primary collapsed" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
        aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{ __('Filter') }}">
        <i class="ti ti-filter"></i>
    </a> -->


    @can('Create Job Application')
        <a href="#" data-url="{{ route('job-application.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Job Application') }}" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection
@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="multiCollapseExample1" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['job-application.index'], 'method' => 'get', 'id' => 'applicarion_filter']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {{Form::date('start_date',$filter['start_date'],array('class'=>'month-btn form-control '))}}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control ', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('job', __('Job'), ['class' => 'form-label']) }}
                                {{ Form::select('job', $jobs, $filter['job'], ['class' => 'form-control select ', 'id' => 'job_id']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('applicarion_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('job-application.index') }}" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="card overflow-hidden">
        <div class="container-kanban">
            @php

                $json = [];
                foreach ($stages as $stage) {
                    $json[] = 'kanban-blacklist-' . $stage->id;
                }
            @endphp
            <div class="kanban-board" data-toggle="dragula" data-containers='{!! json_encode($json) !!}'>
                @foreach ($stages as $stage)
                    @php $applications = $stage->applications($filter) @endphp

                    <div class="kanban-col px-0">
                        <div class="card-list card-list-flush">
                            <div class="card-list-title row align-items-center mb-3">
                                <div class="col">
                                    <h6 class="mb-0 text-white">{{ $stage->title }}</h6>
                                </div>
                                <div class="col text-right">
                                    <span class="badge badge-secondary rounded-pill">{{ count($applications) }}</span>
                                </div>
                            </div>

                            <div class="card-list-body" id="kanban-blacklist-{{ $stage->id }}"
                                data-id="{{ $stage->id }}">
                                @foreach ($applications as $application)
                                    <div class="card card-progress draggable-item border shadow-none"
                                        data-id="{{ $application->id }}">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h6 class="text-sm"><a
                                                            href="{{ route('job-application.show', \Crypt::encrypt($application->id)) }}">{{ $application->name }}</a>
                                                    </h6>
                                                </div>
                                                <div class="col-auto text-right">
                                                    <div class="actions">
                                                        <div class="dropdown">
                                                            <a href="#" class="action-item" data-toggle="dropdown"
                                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right"
                                                                x-placement="bottom-end"
                                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 31px, 0px);">
                                                                @can('Show Job Application')
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('job-application.show', \Crypt::encrypt($application->id)) }}">
                                                                        {{ __('Show') }}</a>
                                                                @endcan
                                                                @can('Delete Job Application')
                                                                    <a class="dropdown-item" href="#"
                                                                        data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                                        data-confirm-yes="document.getElementById('delete-form-{{ $application->id }}').submit();">
                                                                        {{ __('Delete') }}</a>

                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $application->id], 'id' => 'delete-form-' . $application->id]) !!}
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-md-12">
                                                    <span class="static-rating static-rating-sm d-block">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $application->rating)
                                                                <i class="star fas fa-star voted"></i>
                                                            @else
                                                                <i class="star fas fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                            <small>{{ !empty($application->jobs) ? $application->jobs->title : '' }}</small>
                                            <div class="row align-items-center">
                                                <div class="col-auto text-sm">
                                                    <div class="actions d-inline-block">
                                                        <i class="fas fa-clock mr-2" data-ajax-popup="true"
                                                            data-title="{{ __('Applied at') }}"></i>{{ \Auth::user()->dateFormat($application->created_at) }}
                                                    </div>
                                                </div>
                                                <div class="col text-right">
                                                    <div class="avatar-group hover-avatar-ungroup">
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img src="{{ !empty($application->profile) ? asset('/storage/uploads/job/profile/' . $application->profile) : asset('/storage/uploads/avatar/avatar.png') }}"
                                                                class="" style="width: 100px">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="empty-container" data-placeholder="Empty"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}


    <div class="card overflow-hidden mt-0">
        <div class="container-kanban">
            @php
                $json = [];
                foreach ($stages as $stage) {
                    $json[] = 'kanban-blacklist-' . $stage->id;
                }

            @endphp

            <div class="row kanban-wrapper horizontal-scroll-cards" data-plugin="dragula"
                data-containers='{!! json_encode($json) !!}'>
                @foreach ($stages as $key => $stage)
                    @php $applications = $stage->applications($filter) @endphp

                    <div class="col">
                        <div class="card">

                            <div class="card-header">
                                <div class="float-end">
                                    <span class="btn btn-sm btn-primary btn-icon count">
                                        {{ count($applications) }}
                                    </span>
                                </div>
                                <h4 class="mb-0">{{ $stage->title }}</h4>
                            </div>

                            {{-- <div class="card-body kanban-box" id="task-list-{{ $stage->id }}" --}}
                            <div class="card-body kanban-box" id="{{ $json[$key] }}"
                                data-id="{{ $stage->id }}">
                                @foreach ($applications as $application)
                                    <div class="card" data-id="{{ $application->id }}">
                                        <div class="pt-3 ps-3">
                                        </div>
                                        <div class="card-header border-0 pb-0 position-relative">
                                            <h5><a
                                                    href="{{ route('job-application.show', \Crypt::encrypt($application->id)) }}">{{ $application->name }}</a>
                                            </h5>
                                            <!-- <div class="card-header-right">

                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('Show Job Application')
                                                            <a class="dropdown-item"
                                                                href="{{ route('job-application.show', \Crypt::encrypt($application->id)) }}"
                                                                class="dropdown-item"> {{ __('Show') }}</a>
                                                        @endcan
                                                        @can('Delete Job Application')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $application->id], 'id' => 'delete-form-' . $application->id]) !!}
                                                            <a href="#!" class="dropdown-item bs-pass-para">
                                                                <span> {{ __('Delete') }} </span>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        @endcan


                                                    </div>
                                                </div>

                                            </div> -->


                                            <div class="card-header-right">
                                                <div class="btn-group card-option">
                                                    <button type="button" class="btn dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="feather icon-more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('Show Job Application')
                                                            <a href="{{ route('job-application.show', \Crypt::encrypt($application->id)) }}"
                                                                class="dropdown-item" data-ajax-popup="true"><i
                                                                    class="ti ti-eye "></i><span
                                                                    class="ms-2">{{ __('Show') }}</span></a>
                                                        @endcan

                                                        @can('Delete Job Application')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $application->id], 'id' => 'delete-form-' . $application->id]) !!}
                                                            <a href="#" class="bs-pass-para dropdown-item"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"><i
                                                                    class="ti ti-trash"></i><span
                                                                    class="ms-2">{{ __('Delete') }}</span></a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <ul class="list-inline mb-0 mt-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <span class="static-rating static-rating-sm d-block">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $application->rating)
                                                                        <i class="star fas fa-star voted"></i>
                                                                    @else
                                                                        <i class="star fas fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <small
                                                        class="text-md">{{ !empty($application->jobs) ? $application->jobs->title : '' }}</small>


                                                    <li class="list-inline-item d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="{{ __('Job Title') }}">
                                                        <i class="ti ti-clock me-2" data-ajax-popup="true"
                                                            data-title="{{ __('Applied at') }}"></i>{{ \Auth::user()->dateFormat($application->created_at) }}
                                                    </li>
                                                </ul>
                                                @php
                                                $logo=\App\Models\Utility::get_file('uploads/avatar/');
                                                $profile=\App\Models\Utility::get_file('uploads/job/profile/');
                                                @endphp
                                                <div class="avatar-group hover-avatar-ungroup">
                                                    <a href="#" class="user-group">

                                                            <img src="{{ !empty($application->profile) ?$profile . ($application->profile) : $logo."avatar.png" }}"
                                                            class="hweb " style="width: 28px">
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="empty-container" data-placeholder="Empty"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
