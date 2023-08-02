@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Leave Report') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Leave Report') }}</li>
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
    <script>
        $('input[name="type"]:radio').on('change', function(e) {
            var type = $(this).val();
            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else {
                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');
    </script>
@endpush
@section('action-button')
    <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip" title="{{ __('Download') }}"
        data-original-title="{{ __('Download') }}" style="margin-right: 5px;">
        <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
    </a>
    <a href="{{ route('leave.report.export') }}" class="btn btn-sm btn-primary float-end" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>
@endsection




@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class="mt-2 " id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.leave'], 'method' => 'get', 'id' => 'report_leave']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}<br>

                            <div class="form-check form-check-inline form-group">
                                <input type="radio" id="monthly" value="monthly" name="type" class="form-check-input"
                                    {{ isset($_GET['type']) && $_GET['type'] == 'monthly' ? 'checked' : 'checked' }}>
                                {{ Form::label('monthly', __('Monthly'), ['class' => 'form-label']) }}
                            </div>
                            <div class="form-check form-check-inline form-group">
                                <input type="radio" id="yearly" value="yearly" name="type"
                                    class="form-check-input yearly"
                                    {{ isset($_GET['type']) && $_GET['type'] == 'yearly' ? 'checked' : '' }}>
                                {{ Form::label('yearly', __('Yearly'), ['class' => 'form-label']) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                {{ Form::text('month', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), ['class' => 'month-btn form-control d_filter']) }}
                            </div>
                        </div>



                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 year d-none">
                            <div class="btn-box">
                                {{ Form::label('year', __('Year'), ['class' => 'form-label']) }}
                                <select class="form-control select" id="year" name="year" tabindex="-1"
                                    aria-hidden="true">
                                    @for ($filterYear['starting_year']; $filterYear['starting_year'] <= $filterYear['ending_year']; $filterYear['starting_year']++)
                                        <option
                                            {{ isset($_GET['year']) && $_GET['year'] == $filterYear['starting_year'] ? 'selected' : '' }}
                                            {{ !isset($_GET['year']) && date('Y') == $filterYear['starting_year'] ? 'selected' : '' }}
                                            value="{{ $filterYear['starting_year'] }}">
                                            {{ $filterYear['starting_year'] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                {{ Form::select('branch', $branch, isset($_GET['branch']) ? $_GET['branch'] : '', ['class' => 'form-control select', 'id' => 'branch']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control select']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_leave').submit(); return false;"
                                data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                data-original-title="{{ __('apply') }}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>

                            <a href="{{ route('report.leave') }}" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"
                                title="{{ __('Reset') }}" data-original-title="{{ __('Reset') }}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div id="printableArea" class="">
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
                                        value="{{ $filterYear['branch'] . ' ' . __('Branch') . ' ' . $filterYear['dateYearRange'] . ' ' . $filterYear['type'] . ' ' . __('Leave Report of') . ' ' . $filterYear['department'] . ' ' . 'Department' }}"
                                        id="filename">
                                    <h5 class="mb-0">{{ __('Report') }}</h5>
                                    <div>
                                        <p class="text-muted text-sm mb-0">
                                            {{ $filterYear['type'] . ' ' . __('Leave Summary') }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($filterYear['branch'] != 'All')
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
                                            {{ $filterYear['branch'] }} </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($filterYear['department'] != 'All')
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
                                        <p class="text-muted text-sm mb-0">{{ $filterYear['department'] }}</p>
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
                                    <i class="ti ti-calendar"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Duration') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ $filterYear['dateYearRange'] }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-circle-check"></i>
                                </div>

                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Approved Leaves') }} </h5>
                                    <p class="text-muted text-sm mb-0">{{ $filter['totalApproved'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-secondary">
                                    <i class="ti ti-circle-x"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Rejected Leave') }}</h5>
                                    <p class="text-muted text-sm mb-0">
                                        {{ $filter['totalReject'] }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-circle-minus"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Pending Leaves') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ $filter['totalPending'] }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5> --}}

                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Employee ID') }}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Approved Leaves') }}</th>
                                <th>{{ __('Rejected Leaves') }}</th>
                                <th>{{ __('Pending Leaves') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                                <tr>
                                    <td><a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($leave['employee_id'])) }}"
                                            class="btn btn-sm btn-primary rounded">{{ \Auth::user()->employeeIdFormat($leave['employee_id']) }}</a>
                                    </td>
                                    <td>{{ $leave['employee'] }}</td>
                                    <td>
                                        <div class="btn btn-sm btn-info rounded">{{ $leave['approved'] }}
                                            <a href="#" class="text-white"
                                                data-url="{{ route('report.employee.leave', [$leave['id'], 'Approved', isset($_GET['type']) ? $_GET['type'] : 'no', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), isset($_GET['year']) ? $_GET['year'] : date('Y')]) }}"
                                                data-ajax-popup="true" data-size="lg"
                                                data-title="{{ __('Approved Leave Detail') }}" data-bs-toggle="tooltip"
                                                title="{{ __('View') }}"
                                                data-original-title="{{ __('View') }}">{{ __('View') }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn btn-sm btn-danger rounded">{{ $leave['reject'] }}
                                            <a href="#" class="text-white"
                                                data-url="{{ route('report.employee.leave', [$leave['id'], 'Reject', isset($_GET['type']) ? $_GET['type'] : 'no', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), isset($_GET['year']) ? $_GET['year'] : date('Y')]) }}"
                                                class="table-action table-action-delete" data-size="lg"
                                                data-ajax-popup="true" data-title="{{ __('Rejected Leave Detail') }}"
                                                data-bs-toggle="tooltip" title="{{ __('View') }}"
                                                data-original-title="{{ __('View') }}">{{ __('View') }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="m-view-btn btn btn-sm btn-warning rounded">
                                            {{ $leave['pending'] }}
                                            <a href="#" class="text-white"
                                                data-url="{{ route('report.employee.leave', [$leave['id'], 'Pending', isset($_GET['type']) ? $_GET['type'] : 'no', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), isset($_GET['year']) ? $_GET['year'] : date('Y')]) }}"
                                                class="table-action table-action-delete" data-size="lg"
                                                data-ajax-popup="true" data-title="{{ __('Pending Leave Detail') }}"
                                                data-bs-toggle="tooltip" title="{{ __('View') }}"
                                                data-original-title="{{ __('View') }}">{{ __('View') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
