@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Timesheet Report') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Timesheet Report') }}</li>
@endsection

@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4'
                }
            };
            html2pdf().set(opt).from(element).save();

        }
    </script>
@endpush

@section('action-button')
    <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip" title="{{ __('Download') }}"
        data-original-title="{{ __('Download') }}" style="margin-right: 5px;">
        <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
    </a>
    <a href="{{ route('timesheet.report.export') }}" class="btn btn-sm btn-primary float-end" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>
@endsection

@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 ">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.timesheet'], 'method' => 'get', 'id' => 'report_timesheet']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {{ Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-01'), ['class' => 'month-btn form-control ']) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-01'), ['class' => 'month-btn form-control ']) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                {{ Form::select('branch', $branch, isset($_GET['branch']) ? $_GET['branch'] : '', ['class' => 'month-btn form-control select']) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'month-btn form-control select']) }}
                            </div>
                        </div>


                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_timesheet').submit(); return false;"
                                data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                data-original-title="{{ __('apply') }}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>

                            <a href="{{ route('report.timesheet') }}" class="btn btn-sm btn-danger "
                                data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                data-original-title="{{ __('Reset') }}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div id="printableArea">

        <div class="row mt-3">
            <div class="col">
                <input type="hidden"
                    value="{{ $filterYear['branch'] . ' ' . __('Branch') . ' ' . __('Timesheet Report') . ' ' }}{{ $filterYear['start_date'] . ' to ' . $filterYear['end_date'] . ' ' . __('of') . ' ' . $filterYear['department'] . ' ' . 'Department' }}"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Title') }} :</h6>
                    <small class="text-muted">{{ __('Timesheet Report') }}</small>
                </div>
            </div>
            @if ($filterYear['branch'] != 'All')
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="report-text gray-text mb-0">{{ __('Branch') }} :</h6>
                        <small class="text-muted">{{ $filterYear['branch'] }}</small>
                    </div>
                </div>
            @endif
            @if ($filterYear['department'] != 'All')
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="report-text gray-text mb-0">{{ __('Department') }} :</h6>
                        <small class="text-muted">{{ $filterYear['department'] }}</small>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Duration') }} :</h6>
                    <small class="text-muted">{{ $filterYear['start_date'] . ' to ' . $filterYear['end_date'] }}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card p-4 mb-4">
                    <small class="text-muted">{{ __('Total Working Employee') }} :</small>
                    <h5 class="report-text mb-0">{{ $filterYear['totalEmployee'] }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="card p-4 mb-4 ">
                    <small class="text-muted">{{ __('Total Working Hours') }} :</small>
                    <h6 class="report-text mb-0">{{ $filterYear['totalHours'] }}</h6>
                </div>
            </div>
        </div>
        <div class=" row ">
            @foreach ($timesheetFilters as $timesheetFilter)
                <div class="col-3">
                    <div class="card p-4 mb-4 timesheet-card">

                        <h6 class="report-text mb-0">{{ $timesheetFilter->name }} </h6>
                        <small class="report-text text-muted ">{{ __('Total Working Hours') }} :
                            {{ $timesheetFilter->total }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Employee ID') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Hours') }}</th>
                                <th>{{ __('Description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheets as $timesheet)
                                <tr>

                                    <td><a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($timesheet->employee_id)) }}"
                                            class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($timesheet->employee_id) }}</a>
                                    </td>
                                    <td>{{ !empty($timesheet->employee) ? $timesheet->employee->name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($timesheet->date) }}</td>
                                    <td>{{ $timesheet->hours }}</td>
                                    <td>{{ $timesheet->remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
