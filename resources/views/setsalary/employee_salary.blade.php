@extends('layouts.admin')

@section('page-title')
    {{ __('Employee Set Salary') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('setsalary') }}">{{ __('Set Salary') }}</a></li>
    <li class="breadcrumb-item">{{ __('Employee Set Salary') }}</li>
@endsection

@section('content')
        <div class="col-12">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Employee Salary') }}</h5>
                                </div>
                                @can('Create Set Salary')
                                    <div class="col-6 text-end">

                                        <a  data-url="{{ route('employee.basic.salary', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Set Basic Sallary') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Set Salary') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>

                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="project-info d-flex text-sm">
                                <div class="project-info-inner mr-3 col-6">
                                    <b class="m-0"> {{ __('Payslip Type') }} </b>
                                    <div class="project-amnt pt-1">{{ $employee->salary_type() }}</div>
                                </div>
                                <div class="project-info-inner mr-3 col-6">
                                    <b class="m-0"> {{ __('Salary') }} </b>
                                    <div class="project-amnt pt-1">{{ $employee->salary }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- allowance -->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Allowance') }}</h5>
                                </div>
                                @can('Create Allowance')
                                    <div class="col-6 text-end">
                                        <a  data-url="{{ route('allowances.create', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Create Allowance') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee Name') }}</th>
                                            <th>{{ __('Allownace Option') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allowances as $allowance)
                                            <tr>
                                                <td>{{ !empty($allowance->employee()) ? $allowance->employee()->name : '' }}
                                                </td>
                                                <td>{{ !empty($allowance->allowance_option()) ? $allowance->allowance_option()->name : '' }}
                                                </td>
                                                <td>{{ $allowance->title }}</td>

                                                <td>{{ ucfirst($allowance->type) }}</td>
                                                @if ($allowance->type == 'fixed')
                                                    <td>{{ \Auth::user()->priceFormat($allowance->amount) }}</td>
                                                @else
                                                    <td>{{ $allowance->amount }}%
                                                        ({{ \Auth::user()->priceFormat($allowance->tota_allow) }})
                                                    </td>
                                                @endif
                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Allowance')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{ URL::to('allowance/' . $allowance->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-size="md"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit Allowance') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Allowance')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['allowance.destroy', $allowance->id], 'id' => 'delete-form-' . $allowance->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commission -->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Commission') }}</h5>
                                </div>
                                @can('Create Commission')
                                    <div class="col text-end">
                                        <a  data-url="{{ route('commissions.create', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Create Commission') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>

                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                        <tr>
                                            <th>{{ __('Employee Name') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($commissions as $commission)
                                            <tr>
                                                <td>{{ !empty($commission->employee()) ? $commission->employee()->name : '' }}
                                                </td>
                                                <td>{{ $commission->title }}</td>

                                                <td>{{ ucfirst($commission->type) }}</td>
                                                @if ($commission->type == 'fixed')
                                                    <td>{{ \Auth::user()->priceFormat($commission->amount) }}</td>
                                                @else
                                                    <td>{{ $commission->amount }}%
                                                        ({{ \Auth::user()->priceFormat($commission->tota_allow) }})
                                                    </td>
                                                @endif

                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Commission')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{ URL::to('commission/' . $commission->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-size="md"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit Commission') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Commission')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['commission.destroy', $commission->id], 'id' => 'delete-form-' . $commission->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- loan-->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Loan') }}</h5>
                                </div>
                                @can('Create Loan')
                                    <div class="col text-end">
                                        <a  data-url="{{ route('loans.create', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Create Loan') }}"
                                            data-bs-toggle="tooltip" title="" data-size="lg" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>

                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Loan Options') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Loan Amount') }}</th>
                                            <th>{{ __('Start Date') }}</th>
                                            <th>{{ __('End Date') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loans as $loan)
                                            <tr>
                                                <td>{{ !empty($loan->employee()) ? $loan->employee()->name : '' }}</td>
                                                <td>{{ !empty($loan->loan_option()) ? $loan->loan_option()->name : '' }}
                                                </td>
                                                <td>{{ $loan->title }}</td>
                                                <td>{{ ucfirst($loan->type) }}</td>
                                                @if ($loan->type == 'fixed')
                                                    <td>{{ \Auth::user()->priceFormat($loan->amount) }}</td>
                                                @else
                                                    <td>{{ $loan->amount }}%
                                                        ({{ \Auth::user()->priceFormat($loan->tota_allow) }})
                                                    </td>
                                                @endif

                                                <td>{{ \Auth::user()->dateFormat($loan->start_date) }}</td>
                                                <td>{{ \Auth::user()->dateFormat($loan->end_date) }}</td>

                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Loan')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{ URL::to('loan/' . $loan->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-size="lg"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit Loan') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Loan')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['loan.destroy', $loan->id], 'id' => 'delete-form-' . $loan->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Saturation -->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Saturation Deduction') }}</h5>
                                </div>
                                @can('Create Saturation Deduction')
                                    <div class="col text-end">
                                        <a  data-url="{{ route('saturationdeductions.create', $employee->id) }}"
                                            data-ajax-popup="true" data-size="lg" data-title="{{ __('Create Saturation Deduction') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee Name') }}</th>
                                            <th>{{ __('Deduction Option') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($saturationdeductions as $saturationdeduction)
                                            <tr>
                                                <td>{{ !empty($saturationdeduction->employee()) ? $saturationdeduction->employee()->name : '' }}
                                                </td>
                                                <td>{{ !empty($saturationdeduction->deduction_option()) ? $saturationdeduction->deduction_option()->name : '' }}
                                                </td>
                                                <td>{{ $saturationdeduction->title }}</td>
                                                <td>{{ ucfirst($saturationdeduction->type) }}</td>
                                                @if ($saturationdeduction->type == 'fixed')
                                                    <td>{{ \Auth::user()->priceFormat($saturationdeduction->amount) }}
                                                    </td>
                                                @else
                                                    <td>{{ $saturationdeduction->amount }}%
                                                        ({{ \Auth::user()->priceFormat($saturationdeduction->tota_allow) }})
                                                    </td>
                                                @endif

                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Saturation Deduction')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{  URL::to('saturationdeduction/' . $saturationdeduction->id . '/edit')  }}"
                                                                    data-ajax-popup="true" data-size="lg"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit Saturation Deduction') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Saturation Deduction')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['saturationdeduction.destroy', $saturationdeduction->id], 'id' => 'delete-form-' . $saturationdeduction->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- other payment-->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Other Payment') }}</h5>
                                </div>
                                @can('Create Other Payment')
                                    <div class="col text-end">

                                        <a  data-url="{{ route('otherpayments.create', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Create Other Payment') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($otherpayments as $otherpayment)
                                            <tr>
                                                <td>{{ !empty($otherpayment->employee()) ? $otherpayment->employee()->name : '' }}
                                                </td>
                                                <td>{{ $otherpayment->title }}</td>
                                                <td>{{ ucfirst($otherpayment->type) }}</td>
                                                @if ($otherpayment->type == 'fixed')
                                                    <td>{{ \Auth::user()->priceFormat($otherpayment->amount) }}</td>
                                                @else
                                                    <td>{{ $otherpayment->amount }}%
                                                        ({{ \Auth::user()->priceFormat($otherpayment->tota_allow) }})
                                                    </td>
                                                @endif

                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Other Payment')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{ URL::to('otherpayment/' . $otherpayment->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-size="md"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit Other Payment') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Other Payment')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['otherpayment.destroy', $otherpayment->id], 'id' => 'delete-form-' . $otherpayment->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--overtime-->
                <div class="col-md-6">
                    <div class="card set-card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5>{{ __('Overtime') }}</h5>
                                </div>
                                @can('Create Overtime')
                                    <div class="col text-end">
                                        <a  data-url="{{ route('overtimes.create', $employee->id) }}"
                                            data-ajax-popup="true" data-title="{{ __('Create Overtime') }}"
                                            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
                                            data-bs-original-title="{{ __('Create') }}">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class=" card-body table-border-style" style=" overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Employee Name') }}</th>
                                            <th>{{ __('Overtime Title') }}</th>
                                            <th>{{ __('Number of days') }}</th>
                                            <th>{{ __('Hours') }}</th>
                                            <th>{{ __('Rate') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($overtimes as $overtime)
                                            <tr>
                                                <td>{{ !empty($overtime->employee()) ? $overtime->employee()->name : '' }}
                                                </td>
                                                <td>{{ $overtime->title }}</td>
                                                <td>{{ $overtime->number_of_days }}</td>
                                                <td>{{ $overtime->hours }}</td>
                                                <td>{{ \Auth::user()->priceFormat($overtime->rate) }}</td>
                                                <td class="Action">
                                                    <span>
                                                        @can('Edit Overtime')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a  class="mx-3 btn btn-sm  align-items-center"
                                                                    data-url="{{  URL::to('overtime/' . $overtime->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-size="md"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-title="{{ __('Edit OverTime') }}"
                                                                    data-bs-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('Delete Overtime')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['overtime.destroy', $overtime->id], 'id' => 'delete-form-' . $overtime->id]) !!}
                                                                <a 
                                                                    class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                                        class="ti ti-trash text-white text-white"></i></a>
                                                                </form>
                                                            </div>
                                                        @endcan
                                                    </span>
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
    
@endsection

@push('script-page')
    <script type="text/javascript">
        $(document).on('change', '.amount_type', function() {

            var val = $(this).val();
            var label_text = 'Amount';
            if (val == 'percentage') {
                var label_text = 'Percentage';
            }
            $('.amount_label').html(label_text);
        });


        $(document).on('change', 'select[name=department_id]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });



        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#designation_id').empty();
                    $('#designation_id').append(
                        '<option value="">{{ __('Select any Designation') }}</option>');
                    $.each(data, function(key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' +
                            value + '</option>');
                    });
                }
            });
        }
    </script>
@endpush
