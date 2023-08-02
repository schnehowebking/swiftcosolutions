{{-- @extends('layouts.admin')
@section('page-title')
    {{ __('Manage Timesheet') }}
@endsection

@section('action-button')
    @can('Create TimeSheet')
        <a href="#" data-url="{{ route('timesheet.create') }}"
            class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Create') }}"
            data-title="{{ __('Create New') }}">
            <i class=" ti ti-plus"></i>
        </a>
        <a href="{{ route('timesheet.export') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="{{ __('Export') }}" class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="#" class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
            data-url="{{ route('timesheet.file.import') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="{{ __('Import') }}" data-title="{{ __('Import Timesheet CSV file') }}">
            <i class="ti ti-file"></i>
        </a>
    @endcan
@endsection

@section('content')
    <div class="row">
        <!-- [ basic-table ] start -->
        <div class="col-12">
            <div class="card">
                <div class=" card-header card-body table-border-style">
                    <h5></h5>
                    @if (\Auth::user()->type != 'employee')
                        {{ Form::open(['route' => ['timesheet.index'], 'method' => 'get', 'id' => 'timesheet_filter']) }}
                        <div class="row d-flex justify-content-end ">
                            <div class="col-xl-2 col-lg-2 col-md-3">

                                <div class="btn-box">
                                    {{ Form::label('start_date', __('Start Date'), ['class' => 'text-type col-form-label']) }}
                                    {{ Form::text('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'month-btn form-control','id' => 'data_picker1']) }}
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3">

                                <div class="btn-box">
                                    {{ Form::label('end_date', __('End Date'), ['class' => 'text-type col-form-label']) }}
                                    {{ Form::text('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control','id' => 'data_picker2']) }}
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-3">

                                <div class="btn-box">
                                    {{ Form::label('employee', __('Employee'), ['class' => 'text-type col-form-label']) }}
                                    {{ Form::select('employee', $employeesList, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control ']) }}
                                </div>
                            </div>
                            <div class="col-auto mt-auto mb-3 ">
                                <a href="#" class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                    onclick="document.getElementById('timesheet_filter').submit(); return false;"
                                    data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('timesheet.index') }}"
                                    class="action-btn btn-warning me-1 btn btn-sm d-inline-flex align-items-center"
                                    data-toggle="tooltip" data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
                                </a>

                            </div>
                        </div>
                        {{ Form::close() }}
                    @endif
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    @if (\Auth::user()->type != 'employee')
                                        <th>{{ __('Employee') }}</th>
                                    @endif
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Hours') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timeSheets as $timeSheet)
                                    <tr>
                                        @if (\Auth::user()->type != 'employee')
                                            <td>{{ !empty($timeSheet->employee) ? $timeSheet->employee->name : '' }}</td>
                                        @endif
                                        <td>{{ \Auth::user()->dateFormat($timeSheet->date) }}</td>
                                        <td>{{ $timeSheet->hours }}</td>
                                        <td>{{ $timeSheet->remark }}</td>
                                        <td class="d-flex">

                                            @can('Edit TimeSheet')
                                                <a href="#" data-size="md"
                                                    data-url="{{ route('timesheet.edit', $timeSheet->id) }}"
                                                    data-ajax-popup="true" data-title="{{ __('Edit Timesheet') }}"
                                                    class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Timesheet') }}"><i class="ti ti-pencil  "></i></a>
                                            @endcan
                                            @can('Delete TimeSheet')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['timesheet.destroy', $timeSheet->id], 'id' => 'delete-form-' . $timeSheet->id]) !!}
                                                <a href="#!"
                                                    class="action-btn btn-danger btn btn-sm d-inline-flex align-items-center bs-pass-para show_confirm">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                                {!! Form::close() !!}
                                            @endcan
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
@endsection --}}
@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Timesheet') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Timesheet') }}</li>
@endsection

@section('action-button')
    <!-- <a class="btn btn-sm btn-primary collapsed" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
        aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="{{ __('Filter') }}">
        <i class="ti ti-filter"></i>
    </a> -->

    <a href="{{ route('timesheet.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>

    <a href="#" data-url="{{ route('timesheet.file.import') }}" data-ajax-popup="true"
        data-title="{{ __('Import Timesheet CSV file') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Import') }}">
        <i class="ti ti-file-import"></i>
    </a>


    @can('Create TimeSheet')
        <a href="#" data-url="{{ route('timesheet.create') }}" data-ajax-popup="true" data-size="md"
            data-title="{{ __('Create New Timesheet') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('content')

    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="multiCollapseExample1" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['timesheet.index'], 'method' => 'get', 'id' => 'timesheet_filter']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                {{ Form::text('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'month-btn form-control d_week ', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                {{ Form::text('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control d_week', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::label('employee', __('Employee'), ['class' => 'form-label']) }}
                                {{ Form::select('employee', $employeesList, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control select ','id'=>'employee_id']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('timesheet_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('timesheet.index')}}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="card-body py-0">
                    {{-- @if (\Auth::user()->type != 'employee')
                        {{ Form::open(['route' => ['timesheet.index'], 'method' => 'get', 'id' => 'timesheet_filter']) }}
                        <div class="row d-flex justify-content-end mt-2">
                            <div class="col-xl-2 col-lg-2 col-md-3">
                                <div class="all-select-box">
                                    <div class="btn-box">
                                        {{ Form::label('start_date', __('Start Date'), ['class' => 'text-type']) }}
                                        {{ Form::text('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'month-btn form-control datepicker']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3">
                                <div class="all-select-box">
                                    <div class="btn-box">
                                        {{ Form::label('end_date', __('End Date'), ['class' => 'text-type']) }}
                                        {{ Form::text('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control datepicker']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-3">
                                <div class="all-select-box">
                                    <div class="btn-box">
                                        {{ Form::label('employee', __('Employee'), ['class' => 'text-type']) }}
                                        {{ Form::select('employee', $employeesList, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control select2']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto mt-auto mb-3 ">
                                <a href="#" class="apply-btn"
                                    onclick="document.getElementById('timesheet_filter').submit(); return false;"
                                    data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                </a>
                                <a href="{{ route('timesheet.index') }}" class="reset-btn" data-toggle="tooltip"
                                    data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
                                </a>

                            </div>
                        </div>
                        {{ Form::close() }}
                    @endif --}}

                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    @if (\Auth::user()->type != 'employee')
                                        <th>{{ __('Employee') }}</th>
                                    @endif
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Hours') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th width="200ox">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($timeSheets as $timeSheet)
                                    <tr>
                                        @if (\Auth::user()->type != 'employee')
                                            <td>{{ !empty($timeSheet->employee) ? $timeSheet->employee->name : '' }}</td>
                                        @endif
                                        <td>{{ \Auth::user()->dateFormat($timeSheet->date) }}</td>
                                        <td>{{ $timeSheet->hours }}</td>
                                        <td>{{ $timeSheet->remark }}</td>
                                        <td class="Action">

                                            <span>
                                                @can('Edit TimeSheet')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('timesheet.edit', $timeSheet->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Timesheet') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete TimeSheet')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['timesheet.destroy', $timeSheet->id], 'id' => 'delete-form-' . $timeSheet->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
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
    @endsection
