@extends('layouts.admin')
@section('page-title')
    {{ __('Payslip') }}
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Employee Salary') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">{{ __('Home') }}</a></div>
                    <div class="breadcrumb-item">{{ __('Employee Salary') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>{{ __('Employee Salary') }}</h4>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable1">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Payroll Month') }}</th>
                                                <th>{{ __('Salary') }}</th>
                                                <th>{{ __('Net Salary') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th class="" width="200px">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($payslip as $payslip)
                                                <tr>
                                                    <td>{{ !empty(\App\PaySlip::employee($payslip->employee_id))? \App\PaySlip::employee($payslip->employee_id)->name: '' }}
                                                    </td>
                                                    <td>{{ $payslip->salary_month }}</td>
                                                    <td>{{ $payslip->basic_salary }}</td>
                                                    <td>{{ $payslip->net_payble }}</td>
                                                    <td>
                                                        @if ($payslip->status == 1)
                                                            <div class="badge badge-success"><a
                                                                    class="text-white">{{ __('Paid') }}</a></div>
                                                        @else
                                                            <div class="badge badge-danger"><a
                                                                    class="text-white">{{ __('Unpaid') }}</a></div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#"
                                                            data-url="{{ route('payslip.showemployee', $payslip->id) }}"
                                                            class="btn btn-sm btn-warning btn-round btn-icon"
                                                            data-ajax-popup="true"
                                                            data-title="{{ __('View Employee Detail') }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="{{ __('View Employee Detail') }}">
                                                            {{ __('View') }}
                                                        </a>
                                                        <a href="#"
                                                            data-url="{{ route('payslip.pdf', [$payslip->employee_id, $payslip->salary_month]) }}"
                                                            data-size="md-pdf"
                                                            class="btn btn-sm btn-info btn-round btn-icon"
                                                            data-ajax-popup="true"
                                                            data-title="{{ __('Payslip') }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="{{ __('Payslip') }}">
                                                            {{ __('Payslip') }}
                                                        </a>
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
            </div>
        </section>
    </div>
@endsection
