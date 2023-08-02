<div class="col-form-label">
    <div class="col-md-12">
        <div class="col-form-label">
            <form>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0">{{ __('Employee Detail') }}</h5>
                        <h5 class="emp-title black-text">
                            {{ !empty($payslip->employees) ? \Auth::user()->employeeIdFormat($payslip->employees->employee_id) : '' }}
                        </h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0">{{ __('Basic Salary') }}</h5>
                        <h5 class="emp-title black-text">{{ !empty($payslip->basic_salary) ? \Auth::user()->priceFormat($payslip->basic_salary) : '-' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="emp-title mb-0">{{ __('Payroll Month') }}</h5>
                        <h5 class="emp-title black-text">{{ !empty($payslip->salary_month)  ? \Auth::user()->dateFormat($payslip->salary_month) : '-' }}</h5>
                    </div>

                    <div class="col-lg-12 our-system">
                        <div class="row">
                            <ul class="nav nav-tabs my-4">
                                <li>
                                    <a data-toggle="tab" href="#allowance"
                                        class="active">{{ __('Allowance') }}</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#commission">{{ __('Commission') }}</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#loan">{{ __('Loan') }}</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#deduction">{{ __('Saturation Deduction') }}</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#payment">{{ __('Other Payment') }}</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#overtime">{{ __('Overtime') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="allowance" class="tab-pane in active">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php

                                                        $allowances = json_decode($payslip->allowance);


                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Type') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>


                                                        <tbody class="list">
                                                            @foreach ($allowances as $allownace)
                                                                @php
                                                                    $employess = \App\Models\Employee::find($allownace->employee_id);
                                                                    $empallow = ($allownace->amount * $employess->salary) / 100;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $allownace->title }}</td>
                                                                    <td>{{ ucfirst($allownace->type) }}</td>
                                                                    @if ($allownace->type != 'percentage')
                                                                        <td>{{ \Auth::user()->priceFormat($allownace->amount) }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $allownace->amount }}%
                                                                            ({{ \Auth::user()->priceFormat($empallow) }})
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="commission" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php
                                                        $commissions = json_decode($payslip->commission);
                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Type') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">

                                                            @foreach ($commissions as $commission)
                                                                @php
                                                                    $employess = \App\Models\Employee::find($commission->employee_id);
                                                                    $empcomm = ($commission->amount * $employess->salary) / 100;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $commission->title }}</td>
                                                                    <td>{{ ucfirst($commission->type) }}</td>
                                                                    @if ($commission->type != 'percentage')
                                                                        <td>{{ \Auth::user()->priceFormat($commission->amount) }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $commission->amount }}%
                                                                            ({{ \Auth::user()->priceFormat($empcomm) }})
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="loan" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php
                                                        $loans = json_decode($payslip->loan);
                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Type') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            @foreach ($loans as $loan)
                                                                @php
                                                                    $employess = \App\Models\Employee::find($loan->employee_id);
                                                                    $emploan = ($loan->amount * $employess->salary) / 100;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $loan->title }}</td>
                                                                    <td>{{ ucfirst($loan->type) }}</td>
                                                                    @if ($loan->type != 'percentage')
                                                                        <td>{{ \Auth::user()->priceFormat($loan->amount) }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $loan->amount }}%
                                                                            ({{ \Auth::user()->priceFormat($emploan) }})
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="deduction" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php
                                                        $saturation_deductions = json_decode($payslip->saturation_deduction);
                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Type') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            @foreach ($saturation_deductions as $deduction)
                                                                @php
                                                                    $employess = \App\Models\Employee::find($deduction->employee_id);
                                                                    $empdeduction = ($deduction->amount * $employess->salary) / 100;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $deduction->title }}</td>
                                                                    <td>{{ ucfirst($deduction->type) }}</td>
                                                                    @if ($deduction->type != 'percentage')
                                                                        <td>{{ \Auth::user()->priceFormat($deduction->amount) }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $deduction->amount }}%
                                                                            ({{ \Auth::user()->priceFormat($empdeduction) }})
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="payment" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php
                                                        $other_payments = json_decode($payslip->other_payment);
                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Type') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            @foreach ($other_payments as $payment)
                                                                @php
                                                                    $employess = \App\Models\Employee::find($payment->employee_id);
                                                                    $emppayment = ($payment->amount * $employess->salary) / 100;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $payment->title }}</td>
                                                                    <td>{{ ucfirst($payment->type) }}</td>
                                                                    @if ($payment->type != 'percentage')
                                                                        <td>{{ \Auth::user()->priceFormat($payment->amount) }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $payment->amount }}%
                                                                            ({{ \Auth::user()->priceFormat($emppayment) }})
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="overtime" class="tab-pane">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card bg-none mb-0">
                                                <div class="table-responsive">
                                                    @php
                                                        $overtimes = json_decode($payslip->overtime);
                                                    @endphp
                                                    <table class="table align-items-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('Title') }}</th>
                                                                <th>{{ __('Amount') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="list">
                                                            @foreach ($overtimes as $overtime)
                                                                <tr>
                                                                    <td>{{ $overtime->title }}</td>
                                                                    <td>{{ \Auth::user()->priceFormat($overtime->rate) }}
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 py-3">
            <h5 class="emp-title mb-0">{{ __('Net Salary') }}</h5>
            <h5 class="emp-title black-text">{{ \Auth::user()->priceFormat($payslip->net_payble) }}</h5>
        </div>
    </div>
</div>
