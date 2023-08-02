@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Payroll') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Payroll Report') }}</li>
@endsection
@push('script-page')
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

        $(document).ready(function() {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'pdf',
                        title: filename
                    },
                    {
                        extend: 'excel',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
                    }
                ]
            });
        });
    </script>
@endpush

@section('action-button')
    <div class="float-end">
        <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip"
            title="{{ __('Download') }}" data-original-title="{{ __('Download') }}" style="margin-right: 5px;">
            <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
        </a>
        <a href="{{ route('payroll.report.export') }}" class="btn btn-sm btn-primary float-end" data-bs-toggle="tooltip"
            data-bs-original-title="{{ __('Export') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class=" mt-2 " id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.payroll'], 'method' => 'get', 'id' => 'report_payroll']) }}
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-10">
                            <div class="row">

                                <div class="col-3">
                                    <label class="form-label">{{ __('Type') }}</label> <br>

                                    <div class="form-check form-check-inline form-group">
                                        <input type="radio" id="monthly" value="monthly" name="type"
                                            class="form-check-input"
                                            {{ isset($_GET['type']) && $_GET['type'] == 'monthly' ? 'checked' : 'checked' }}>
                                        <label class="form-check-label" for="monthly">{{ __('Monthly') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline form-group">
                                        <input type="radio" id="yearly" value="yearly" name="type"
                                            class="form-check-input"
                                            {{ isset($_GET['type']) && $_GET['type'] == 'yearly' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="yearly">{{ __('Yearly') }}</label>
                                    </div>

                                </div>

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 month">
                                    <div class="btn-box">
                                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                                        {{ Form::month('month', isset($_GET['month']) ? $_GET['month'] : date('Y-m'), ['class' => 'month-btn form-control']) }}
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 year d-none">
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
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                                        {{ Form::select('branch', $branch, isset($_GET['branch']) ? $_GET['branch'] : '', ['class' => 'form-control select']) }}
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        {{ Form::label('department', __('Department'), ['class' => 'form-label']) }}
                                        {{ Form::select('department', $department, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control select']) }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">

                                    <a href="#" class="btn btn-sm btn-primary"
                                        onclick="document.getElementById('report_payroll').submit(); return false;"
                                        data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                        data-original-title="{{ __('apply') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>

                                    <a href="{{ route('report.payroll') }}" class="btn btn-sm btn-danger "
                                        data-bs-toggle="tooltip" title="{{ __('Reset') }}"
                                        data-original-title="{{ __('Reset') }}">
                                        <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                    </a>


                                </div>

                            </div>
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
                    value="{{ $filterYear['branch'] . ' ' . __('Branch') . ' ' . $filterYear['dateYearRange'] . ' ' . $filterYear['type'] . ' ' . __('Payroll Report of') . ' ' . $filterYear['department'] . ' ' . 'Department' }}"
                    id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Report') }} :</h6>
                    <h7 class="report-text mb-0">{{ $filterYear['type'] . ' ' . __('Payroll Summary') }}</h7>
                </div>
            </div>
            @if ($filterYear['branch'] != 'All')
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="report-text gray-text mb-0">{{ __('Branch') }} :</h6>
                        <h7 class="report-text mb-0">{{ $filterYear['branch'] }}</h7>
                    </div>
                </div>
            @endif
            @if ($filterYear['department'] != 'All')
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h6 class="report-text gray-text mb-0">{{ __('Department') }} :</h6>
                        <h7 class="report-text mb-0">{{ $filterYear['department'] }}</h7>
                    </div>
                </div>
            @endif

            <div class="col">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Duration') }} :</h6>
                    <h7 class="report-text mb-0">{{ $filterYear['dateYearRange'] }}</h7>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Basic Salary') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalBasicSalary']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Net Salary') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalNetSalary']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Allowance') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalAllowance']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Commission') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalCommision']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Loan') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalLoan']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Saturation Deduction') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalSaturationDeduction']) }}
                    </h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Other Payment') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalOtherPayment']) }}</h7>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{ __('Total Overtime') }} :</h6>
                    <h7 class="report-text mb-0">{{ \Auth::user()->priceFormat($filterData['totalOverTime']) }}</h7>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive py-4">
                        <table class="table datatable mb-0" id="report-dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Employee ID') }}</th>
                                    <th>{{ __('Employee') }}</th>
                                    <th>{{ __('Salary') }}</th>
                                    <th>{{ __('Net Salary') }}</th>
                                    <th>{{ __('Month') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payslips as $payslip)
                                    <tr>
                                        <td><a href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($payslip->employee_id)) }}"
                                                class="btn  btn-outline-primary">{{ !empty($payslip->employees) ? \Auth::user()->employeeIdFormat($payslip->employees->employee_id) : '' }}</a>
                                        </td>
                                        <td>{{ !empty($payslip->employees) ? $payslip->employees->name : '' }}</td>
                                        <td>{{ \Auth::user()->priceFormat($payslip->basic_salary) }}</td>
                                        <td>{{ \Auth::user()->priceFormat($payslip->net_payble) }}</td>
                                        <td>{{ $payslip->salary_month }}</td>
                                        <td>
                                            @if ($payslip->status == 0)
                                                <div class="badge bg-danger p-2 px-3 rounded"><a href="#"
                                                        class="text-white">{{ __('UnPaid') }}</a></div>
                                            @else
                                                <div class="badge bg-success p-2 px-3 rounded"><a href="#"
                                                        class="text-white">{{ __('Paid') }}</a></div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
