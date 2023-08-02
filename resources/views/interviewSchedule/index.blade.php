@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Interview Schedule') }}
@endsection

@php
    $setting = App\Models\Utility::settings();
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Interview Schedule') }}</li>
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/dist/fullcalendar.min.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            get_data();
        });

        function get_data() {
            var calender_type = $('#calender_type :selected').val();

            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('google_calender');
            if(calender_type==undefined){
                calender_type='local_calender';
            }
            $('#calendar').addClass(calender_type);

            $.ajax({
                url: $("#path_admin").val() + "/interview-schedule/get_interview-schedule_data",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'calender_type': calender_type
                },
                success: function(data) {
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "{{ __('Day') }}",
                                timeGridWeek: "{{ __('Week') }}",
                                dayGridMonth: "{{ __('Month') }}"
                            },
                            themeSystem: 'bootstrap',
                            slotDuration: '00:10:00',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            events: data,
                        });
                        calendar.render();
                    })();
                }
            });

        }
    </script>

    <script>
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
                    console.log(data);
                    show_toastr('success', data.success, 'success');
                }
            });
        });
    </script>
@endpush
@section('action-button')
    @can('Create Interview Schedule')
        <a href="#" data-url="{{ route('interview-schedule.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Interview Schedule') }}" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('content')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h5>{{ __('Calendar') }}</h5>
                        <input type="hidden" id="path_admin" value="{{ url('/') }}">
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for=""></label>
                            @if (isset($setting['is_enabled']) && $setting['is_enabled'] == 'on')
                                <select class="form-control" name="calender_type" id="calender_type" onchange="get_data()">
                                    <option value="google_calender">{{ __('Google Calender') }}</option>
                                    <option value="local_calender" selected="true">{{ __('Local Calender') }}</option>
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div id='calendar' class='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">{{ __('Schedule List') }}</h4>
                <ul class="event-cards list-group list-group-flush mt-3 w-100">
                    <li class="list-group-item card mb-3">
                        @foreach ($current_month_event as $schedule)
                            <div class="row align-items-center justify-content-between">
                                <div class=" align-items-center">
                                    <div class="card mb-3 border shadow-none">
                                        <div class="px-3">
                                            <div class="row align-items-center">

                                                <div class="col ml-n2 text-sm mb-0 fc-event-title-container">
                                                    <h5 class="tcard-text small text-primary">
                                                        {{ !empty($schedule->applications) ? (!empty($schedule->applications->jobs) ? $schedule->applications->jobs->title : '') : '' }}
                                                    </h5>
                                                    <div class="card-text small text-dark">
                                                        {{ !empty($schedule->applications) ? $schedule->applications->name : '' }}
                                                    </div>
                                                    <div class="card-text small text-dark">
                                                        {{ \Auth::user()->dateFormat($schedule->date) . ' ' . \Auth::user()->timeFormat($schedule->time) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto text-right">
                                                    <div class="d-inline-flex mb-4">
                                                        @can('Edit Interview Schedule')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{ route('interview-schedule.edit', $schedule->id) }}"
                                                                    data-ajax-popup="true" data-title="{{ __('Edit ') }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Interview Schedule')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['interview-schedule.destroy', $schedule->id],
                                                                    'id' => 'delete-form-' . $schedule->id,
                                                                ]) !!}
                                                                <a href="#!"
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    title="{{ __('Delete') }}">
                                                                    <i class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
