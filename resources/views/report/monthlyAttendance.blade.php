@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Monthly Attendance') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Monthly Attendance Report') }}</li>
@endsection
@section('action-button')
    <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip" title="{{ __('Download') }}"
        data-original-title="{{ __('Download') }}">
        <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
    </a>
    <a href="{{ route('report.attendance', [isset($_GET['month']) ? $_GET['month'] : date('Y-m'), isset($_GET['branch']) && !empty($_GET['branch']) ? $_GET['branch'] : 0, isset($_GET['department']) && !empty($_GET['department']) ? $_GET['department'] : 0]) }}"
        class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="" data-bs-original-title="Export">
        <span class="btn-inner--icon"><i class="ti ti-file-download text-white-off "></i></span>
    </a>
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
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endpush

@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class="mt-2 " id="" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.monthly.attendance'], 'method' => 'get', 'id' => 'report_monthly_attendance']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::label('month', __(' Month'), ['class' => 'form-label']) }}
                                {{ Form::date('month', isset($_GET['month']) ? $_GET['month'] : '', ['class' => 'month-btn form-control  ', 'autocomplete' => 'off', 'placeholder' => 'Select month']) }}

                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                {{ Form::select('branch', $branch, isset($_GET['branch']) ? $_GET['branch'] : '', ['class' => 'form-control select']) }}

                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control select']) }}

                            </div>
                        </div>

                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_monthly_attendance').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('report.monthly.attendance') }}" class="btn btn-sm btn-danger"
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


    <div id="printableArea">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-report"></i>
                                </div>
                                <div class="ms-3">
                                    <input type="hidden"
                                        value="{{ $data['branch'] . ' ' . __('Branch') . ' ' . $data['curMonth'] . ' ' . __('Attendance Report of') . ' ' . $data['department'] . ' ' . 'Department' }}"
                                        id="filename">
                                    <h5 class="mb-0">{{ __('Report') }}</h5>
                                    <div>
                                        <p class="text-muted text-sm mb-0">{{ __('Attendance Summary') }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($data['branch'] != 'All')
                <div class="col">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-secondary">
                                        <i class="ti ti-sitemap"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ __('Branch') }}</h5>
                                        <p class="text-muted text-sm mb-0">
                                            {{ $data['branch'] }} </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($data['department'] != 'All')
                <div class="col">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-template"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ __('Department') }}</h5>
                                        <p class="text-muted text-sm mb-0">{{ $data['department'] }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-secondary">
                                    <i class="ti ti-sum"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Duration') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ $data['curMonth'] }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-file-report"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Attendance') }}</h5>
                                    <div>
                                        <p class="text-muted text-sm mb-0">{{ __('Total present') }}:
                                            {{ $data['totalPresent'] }}</p>
                                        <p class="text-muted text-sm mb-0">{{ __('Total leave') }}:
                                            {{ $data['totalLeave'] }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-secondary">
                                    <i class="ti ti-clock"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Overtime') }}</h5>
                                    <p class="text-muted text-sm mb-0">
                                        {{ __('Total overtime in hours') }} :
                                        {{ number_format($data['totalOvertime'], 2) }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-info-circle"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Early leave') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ __('Total early leave in hours') }}:
                                        {{ number_format($data['totalEarlyLeave'], 2) }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-secondary">
                                    <i class="ti ti-alarm"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Employee late') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ __('Total late in hours') }} :
                                        {{ number_format($data['totalLate'], 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive py-4 attendance-table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="active">{{ __('Name') }}</th>
                                    @foreach ($dates as $date)
                                        <th>{{ $date }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeesAttendance as $attendance)
                                    <tr>
                                        <td>{{ $attendance['name'] }}</td>
                                        @foreach ($attendance['status'] as $status)
                                            <td>
                                                @if ($status == 'P')
                                                    <i class="badge bg-success p-2  rounded">{{ __('P') }}</i>
                                                @elseif($status == 'A')
                                                    <i class="badge bg-danger p-2  rounded">{{ __('A') }}</i>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
