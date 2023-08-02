@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Income Vs Expense') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Income Vs Expense Report') }}</li>
@endsection
@section('action-button')
   <!--  <a class="btn btn-sm btn-primary collapsed" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
        aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{ __('Filter') }}">
        <i class="ti ti-filter"></i>
    </a> -->

    <a href="#" onclick="saveAsPDF()" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title=""
        data-bs-original-title="Download">
        <span class="btn-inner--icon"><i class="ti ti-download "></i></span>
    </a>
@endsection

@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        (function() {
            var options = {
                chart: {
                    height: 250,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '25%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },

                series: {!! json_encode($data) !!},
                xaxis: {
                    categories: {!! json_encode($labels) !!},
                },
                colors: ['#3ec9d6', '#FF3A6E'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
                markers: {
                    size: 4,
                    colors: ['#3ec9d6', '#FF3A6E', ],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#user-chart"), options);
            chart.render();
        })();


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
        <div class=" mt-2 " id="" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.income-expense'], 'method' => 'get', 'id' => 'report_income_expense']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::label('start_month', __('Start Month'), ['class' => 'form-label']) }}
                                {{ Form::text('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : '', ['class' => 'month-btn form-control d_filter ', 'autocomplete' => 'off','placeholder'=>'Select start month']) }}

                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::label('end_month', __('End Month'), ['class' => 'form-label']) }}
                                {{ Form::text('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : '', ['class' => 'month-btn form-control d_filter', 'autocomplete' => 'off' ,'placeholder'=>'Select end month']) }}

                            </div>
                        </div>

                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_income_expense').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('report.income-expense') }}" class="btn btn-sm btn-danger"
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
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-file-report"></i>
                                </div>
                                <input type="hidden"
                                    value="{{ __('Income vs Expense Report of') . ' ' }}{{ $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}"
                                    id="filename">
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Report') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ __('Income vs Expense Summary') }}</p>
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
                                    <i class="ti ti-calendar-time"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Duration') }}</h5>
                                    <p class="text-muted text-sm mb-0">
                                        {{ $filter['startDateRange'] . ' to ' . $filter['endDateRange'] }}</p>
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
                                    <i class="ti ti-wallet"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Total Income') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ \Auth::user()->priceFormat($incomeCount) }}</p>
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
                                    <i class="ti ti-report-money"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Total Expense') }}</h5>
                                    <p class="text-muted text-sm mb-0">{{ \Auth::user()->priceFormat($expenseCount) }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <div class="card">
                <div class=" rounded p-3">
                    <div id="user-chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
