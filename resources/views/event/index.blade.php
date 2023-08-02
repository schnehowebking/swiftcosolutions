@extends('layouts.admin')

@section('page-title')
    {{ __('Event') }}
@endsection

@php
    $setting = App\Models\Utility::settings();
@endphp


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Event') }}</li>
@endsection

@section('action-button')
    @can('Create Event')
        <a href="#" data-url="{{ route('event.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Event') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection


@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-9">
                        <h5>{{ __('Calendar') }}</h5>
                        
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for=""></label>
                            @if(isset($setting['is_enabled']) && $setting['is_enabled'] =='on')
                                <select class="form-control" name="calender_type" id="calender_type" onchange="get_data()">
                                    <option value="google_calender">{{ __('Google Calender') }}</option>
                                    <option value="local_calender" selected="true">{{ __('Local Calender') }}</option>
                                </select>
                                @endif
                                <input type="hidden" id="path_admin" value="{{ url('/') }}">
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
                <h4 class="mb-4">{{ __('Upcoming Events') }}</h4>
                <ul class="event-cards list-group list-group-flush mt-3 w-100">
                    <li class="list-group-item card mb-3">
                        <div class="row align-items-center justify-content-between">

                            <div class=" align-items-center">
                                @if (!$events->isEmpty())
                                    @foreach ($current_month_event as $event)
                                        <div class="card mb-3 border shadow-none">
                                            <div class="px-3">
                                                <div class="row align-items-center">
                                                    <div class="col ml-n2">
                                                        <h5 class="text-sm mb-0 fc-event-title-container">
                                                            <a href="#" data-size="lg"
                                                                data-url="{{ route('event.edit', $event->id) }}"
                                                                data-ajax-popup="true" data-title="{{ __('Edit Event') }}"
                                                                class="fc-event-title text-primary">
                                                                {{ $event->title }}
                                                            </a>
                                                        </h5><br>

                                                        <p class="card-text small text-dark mt-0">
                                                            {{ __('Start Date : ') }}
                                                            {{ \Auth::user()->dateFormat($event->start_date) }}<br>
                                                            {{ __('End Date : ') }}
                                                            {{ \Auth::user()->dateFormat($event->end_date) }}
                                                        </p>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center">

                                    </div>
                                @endif
                            </div>
                        </div>

                    </li>

                </ul>
            </div>
        </div>
    </div>
    </div>
@endsection


@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            get_data();
        });

        function get_data() {
            var calender_type = $('#calender_type :selected').val();
            console.log(calender_type);
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('google_calender');
            if(calender_type==undefined){
                calender_type='local_calender';
            }
            $('#calendar').addClass(calender_type);

            $.ajax({
                url: $("#path_admin").val() + "/event/get_event_data",
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
        $(document).ready(function() {
            var b_id = $('#branch_id').val();
            getDepartment(b_id);
        });
        $(document).on('change', 'select[name=branch_id]', function() {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(bid) {

            $.ajax({
                url: '{{ route('event.getdepartment') }}',
                type: 'POST',
                data: {
                    "branch_id": bid,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {


                    $('.department_id').empty();
                    var emp_selct = ` <select class="form-control  department_id" name="department_id[]" id="choices-multiple"
                                            placeholder="Select Department" multiple >
                                            </select>`;
                    $('.department_div').html(emp_selct);

                    $('.department_id').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {
                        $('.department_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });


                }
            });
        }

        $(document).on('change', '.department_id', function() {
            var department_id = $(this).val();
            getEmployee(department_id);
        });

        function getEmployee(did) {
            $.ajax({
                url: '{{ route('event.getemployee') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('.employee_id').empty();
                    var emp_selct = ` <select class="form-control  employee_id" name="employee_id[]" id="choices-multiple1"
                                            placeholder="Select Employee" multiple >
                                            </select>`;
                    $('.employee_div').html(emp_selct);

                    $('.employee_id').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {
                        $('.employee_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple1', {
                        removeItemButton: true,
                    });

                }
            });
        }
    </script>
@endpush
