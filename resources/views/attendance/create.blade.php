{{-- {{Form::open(array('url'=>'attendanceemployee','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            {{Form::label('employee_id',__('Employee'))}}
            {{Form::select('employee_id',$employees,null,array('class'=>'form-control  '))}}
        </div>
        <div class="col-md-6">
            {{Form::label('date',__('Date'))}}
            {{Form::text('date',null,array('class'=>'form-control  ','id'=>'data_picker1'))}}
        </div>
        <div class="col-md-6">
            {{Form::label('clock_in',__('Clock In'))}}
            {{Form::text('clock_in',null,array('class'=>'form-control pc-timepicker-1'))}}
        </div>
        <div class="col-md-6">
            {{Form::label('clock_out',__('Clock Out'))}}
            {{Form::text('clock_out',null,array('class'=>'form-control pc-timepicker-2'))}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}} --}}

{{ Form::open(['url' => 'attendanceemployee', 'method' => 'post']) }}
<div class="card-body p-0">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2']) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('clock_in', __('Clock In'), ['class' => 'col-form-label']) }}
            {{ Form::text('clock_in', null, ['class' => 'form-control timepicker']) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('clock_out', __('Clock Out'), ['class' => 'col-form-label']) }}
            {{ Form::text('clock_out', null, ['class' => 'form-control timepicker']) }}
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
