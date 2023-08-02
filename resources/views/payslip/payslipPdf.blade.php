@php
// $logo = asset(Storage::url('uploads/logo/'));
$logo=\App\Models\Utility::get_file('uploads/logo/');

$company_logo = Utility::getValByName('company_logo');
@endphp
@extends('layouts.contractheader')
@section('page-title')
    {{ __('Payslip') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="text-md-right mb-2">
            <a href="#" class="btn btn-warning"   data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="{{ __('Download') }}" onclick="saveAsPDF()"><span class="fa fa-download"></span></a>
        </div>

        <div class="col-8">
            <div class="invoice" id="printableArea">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h4>{{ __('Payslip') }}</h4>
                                <div class="invoice-number">
                                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo.png') }}"
                                        width="170px;" alt="">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>{{ __('Name') }} :</strong> {{ $employee->name }}<br>
                                        <strong>{{ __('Position') }} :</strong> {{ __('Employee') }}<br>
                                        <strong>{{ __('Salary Date') }} :</strong>
                                        {{ \Auth::user()->dateFormat($employee->created_at) }}<br>

                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>{{ \Utility::getValByName('company_name') }} </strong><br>
                                        {{ \Utility::getValByName('company_address') }} ,
                                        {{ \Utility::getValByName('company_city') }},<br>
                                        {{ \Utility::getValByName('company_state') }}-{{ \Utility::getValByName('company_zipcode') }}<br>
                                        <strong>{{ __('Salary Slip') }} :</strong>
                                        {{ \Auth::user()->dateFormat($payslip->salary_month) }}<br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('Earning') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th class="text-right">{{ __('Amount') }}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Basic Salary') }}</td>
                                            <td>-</td>
                                            <td class="text-right">
                                                {{ \Auth::user()->priceFormat($payslip->basic_salary) }}</td>
                                        </tr>

                                        @foreach ($payslipDetail['earning']['allowance'] as $allowance)
                                            <tr>
                                                <td>{{ __('Allowance') }}</td>
                                                <td>{{ $allowance->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($allowance->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($payslipDetail['earning']['commission'] as $commission)
                                            <tr>
                                                <td>{{ __('Commission') }}</td>
                                                <td>{{ $commission->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($commission->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($payslipDetail['earning']['otherPayment'] as $otherPayment)
                                            <tr>
                                                <td>{{ __('Other Payment') }}</td>
                                                <td>{{ $otherPayment->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($otherPayment->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($payslipDetail['earning']['overTime'] as $overTime)
                                            <tr>
                                                <td>{{ __('OverTime') }}</td>
                                                <td>{{ $overTime->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($overTime->amount) }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('Deduction') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th class="text-right">{{ __('Amount') }}</th>
                                        </tr>

                                        @foreach ($payslipDetail['deduction']['loan'] as $loan)
                                            <tr>
                                                <td>{{ __('Loan') }}</td>
                                                <td>{{ $loan->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($loan->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($payslipDetail['deduction']['deduction'] as $deduction)
                                            <tr>
                                                <td>{{ __('Saturation Deduction') }}</td>
                                                <td>{{ $deduction->title }}</td>
                                                <td class="text-right">
                                                    {{ \Auth::user()->priceFormat($deduction->amount) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">

                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{ __('Total Earning') }}</div>
                                        <div class="invoice-detail-value">
                                            {{ \Auth::user()->priceFormat($payslipDetail['totalEarning']) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{ __('Total Deduction') }}</div>
                                        <div class="invoice-detail-value">
                                            {{ \Auth::user()->priceFormat($payslipDetail['totalDeduction']) }}</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{ __('Net Salary') }}</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ \Auth::user()->priceFormat($payslip->net_payble) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3 ">
                        <p class="mt-2">{{ __('Employee Signature') }}</p>
                    </div>
                    <p class="mt-2 "> {{ __('Paid By') }}</p>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
        <script>
            function saveAsPDF() {
                var element = document.getElementById('printableArea');
                var opt = {
                    margin: 0.3,
                    filename: '{{ $employee->name }}',
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

    </div>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: '{{ $employee->name }}',
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
@endsection
