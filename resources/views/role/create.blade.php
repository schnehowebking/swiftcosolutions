    {{ Form::open(['url' => 'roles', 'method' => 'post']) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Role Name')]) }}
                </div>
                @error('name')
                    <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group">
                @if (!empty($permissions))
                    <h6 class="my-3">{{ __('Assign Permission to Roles') }} </h6>
                    <table class="table  mb-0" id="dataTable-1">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="align-middle checkbox_middle form-check-input"
                                        name="checkall" id="checkall">
                                </th>
                                <th>{{ __('Module') }} </th>
                                <th>{{ __('Permissions') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                                $modules = [
                                    'User',
                                    'Role',
                                    'Award',
                                    'Transfer',
                                    'Resignation',
                                    'Travel',
                                    'Promotion',
                                    'Complaint',
                                    'Warning',
                                    'Termination',
                                    'Department',
                                    'Designation',
                                    'Document Type',
                                    'Branch',
                                    'Award Type',
                                    'Termination Type',
                                    'Employee',
                                    'Payslip Type',
                                    'Allowance Option',
                                    'Loan Option',
                                    'Deduction Option',
                                    'Set Salary',
                                    'Allowance',
                                    'Commission',
                                    'Loan',
                                    'Saturation Deduction',
                                    'Other Payment',
                                    'Overtime',
                                    'Pay Slip',
                                    'Account List',
                                    'Payee',
                                    'Payer',
                                    'Income Type',
                                    'Expense Type',
                                    'Payment Type',
                                    'Deposit',
                                    'Expense',
                                    'Transfer Balance',
                                    'Event',
                                    'Announcement',
                                    'Leave Type',
                                    'Leave',
                                    'Meeting',
                                    'Ticket',
                                    'Attendance',
                                    'TimeSheet',
                                    'Holiday',
                                    'Plan',
                                    'Assets',
                                    'Document',
                                    'Employee Profile',
                                    'Employee Last Login',
                                    'Indicator',
                                    'Appraisal',
                                    'Goal Tracking',
                                    'Goal Type',
                                    'Competencies',
                                    'Competencies',
                                    'Company Policy',
                                    'Trainer',
                                    'Training',
                                    'Training Type',
                                    'Job Category',
                                    'Job Stage',
                                    'Job',
                                    'Job Application',
                                    'Job OnBoard',
                                    'Job Application Note',
                                    'Job Application Skill',
                                    'Custom Question',
                                    'Interview
                            Schedule',
                                    'Career',
                                    'Report',
                                    'Performance Type',
                                ];
                                if (Auth::user()->type == 'super admin') {
                                    $modules[] = 'Language';
                                }

                            @endphp
                            @foreach ($modules as $module)
                                <tr>
                                    <td><input type="checkbox" class="align-middle ischeck form-check-input"
                                            name="checkall" data-id="{{ str_replace(' ', '', $module) }}"></td>
                                    <td><label class="ischeck form-label"
                                            data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                                    </td>
                                    <td>
                                        <div class="row ">
                                            @if (in_array('Manage ' . $module, (array) $permissions))
                                                @if ($key = array_search('Manage ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Manage', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Create ' . $module, (array) $permissions))
                                                @if ($key = array_search('Create ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Create', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Edit ' . $module, (array) $permissions))
                                                @if ($key = array_search('Edit ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Edit', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Delete ' . $module, (array) $permissions))
                                                @if ($key = array_search('Delete ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Delete', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Show ' . $module, (array) $permissions))
                                                @if ($key = array_search('Show ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Show', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Move ' . $module, (array) $permissions))
                                                @if ($key = array_search('Move ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Move', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Client Permission', (array) $permissions))
                                                @if ($key = array_search('Client Permission ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Client Permission', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Invite User', (array) $permissions))
                                                @if ($key = array_search('Invite User ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Invite User ', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif

                                            @if (in_array('Buy ' . $module, (array) $permissions))
                                                @if ($key = array_search('Buy ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Buy', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (in_array('Add ' . $module, (array) $permissions))
                                                @if ($key = array_search('Add ' . $module, $permissions))
                                                    <div class="col-md-3 custom-control custom-checkbox">
                                                        {{ Form::checkbox('permissions[]', $key, false, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                        {{ Form::label('permission' . $key, 'Add', ['class' => 'form-label font-weight-500']) }}<br>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
    </div>
    {{ Form::close() }}

    <script>
        $(document).ready(function() {
            $("#checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(".ischeck").click(function() {
                var ischeck = $(this).data('id');
                $('.isscheck_' + ischeck).prop('checked', this.checked);
            });
        });
    </script>
