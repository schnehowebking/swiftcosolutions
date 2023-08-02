@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Account Statement') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Account Statement Report') }}</li>
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
    <a href="{{ route('accountstatement.report.export') }}" class="btn btn-sm btn-primary float-end"
        data-bs-toggle="tooltip" data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>
@endsection




@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.account.statement'], 'method' => 'get', 'id' => 'report_acc_filter']) }}
                    <div class="d-flex align-items-center justify-content-end">


                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('start_month', __('Start Month'), ['class' => 'form-label']) }}
                                {{ Form::text('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-m'), ['class' => 'month-btn form-control d_filter']) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                {{ Form::label('end_month', __('End Month'), ['class' => 'form-label']) }}
                                {{ Form::text('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-m'), ['class' => 'month-btn form-control d_filter']) }}
                            </div>
                        </div>


                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 ">
                            <div class="btn-box">
                                {{ Form::label('account', __('Account'), ['class' => 'form-label']) }}
                                {{ Form::select('account', $accountList, isset($_GET['account']) ? $_GET['account'] : '', ['class' => ' form-control select']) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 ">
                            <div class="btn-box">
                                {{ Form::label('type', __('Type'), ['class' => 'form-label']) }}
                                <select class="form-control select" id="type" name="type" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="income"
                                        {{ isset($_GET['account']) && $_GET['type'] == 'income' ? 'selected' : '' }}>
                                        {{ __('Income') }}</option>
                                    <option value="expense"
                                        {{ isset($_GET['account']) && $_GET['type'] == 'expense' ? 'selected' : '' }}>
                                        {{ __('Expense') }}</option>
                                </select>

                            </div>
                        </div>



                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_acc_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="{{ __('Apply') }}"
                                data-original-title="{{ __('apply') }}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>

                            <a href="{{ route('report.account.statement') }}" class="btn btn-sm btn-danger "
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
                                        value="{{ __('Account Statement') . ' ' . $filterYear['type'] . ' ' . 'Report of' . ' ' . $filterYear['startDateRange'] . ' to ' . $filterYear['endDateRange'] }}"
                                        id="filename">
                                    <h5 class="mb-0">{{ __('Report') }}</h5>
                                    <div>
                                        <p class="text-muted text-sm mb-0">
                                            {{ __('Account Statement Summary') }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($filterYear['type'] != 'All')
                <div class="col">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-secondary">
                                        <i class="ti ti-sitemap"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ __('Transaction Type') }}</h5>
                                        <p class="text-muted text-sm mb-0">
                                            {{ $filterYear['type'] }} </p>
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
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-calendar"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ __('Duration') }}</h5>
                                    <p class="text-muted text-sm mb-0">
                                        {{ $filterYear['startDateRange'] . ' to ' . $filterYear['endDateRange'] }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            @foreach ($accounts as $account)
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-layout-list"></i>
                                    </div>

                                    <div class="ms-3">

                                        <h5 class="mb-0">
                                            {{ $account->account_name }}
                                        </h5>

                                        <p class="text-muted text-sm mb-0">
                                            @if (isset($_GET['type']) && $_GET['type'] == 'expense')
                                                {{ __('Total Debit') }} :
                                            @else
                                                {{ __('Total Credit') }} :
                                            @endif {{ \Auth::user()->priceFormat($account->total) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



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
                                <th>{{ __('Account') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountData as $account)
                                <tr>
                                    <td>{{ !empty($account->accounts) ? $account->accounts->account_name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($account->date) }}</td>
                                    <td>{{ \Auth::user()->priceFormat($account->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
