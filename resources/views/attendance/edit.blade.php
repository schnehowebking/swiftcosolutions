{{-- {{ Form::model($attendanceEmployee, ['route' => ['attendanceemployee.update', $attendanceEmployee->id],'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6 ">
            {{ Form::label('employee_id', __('Employee')) }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control  ']) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('date', __('Date')) }}
            {{ Form::text('date', null, ['class' => 'form-control','id'=>'data_picker4']) }}
        </div>

        <div class="col-md-6">
            {{ Form::label('clock_in', __('Clock In')) }}
            {{ Form::text('clock_in', null, ['class' => 'form-control pc-timepicker-2']) }}
        </div>

        <div class="col-md-6">
            {{ Form::label('clock_out', __('Clock Out')) }}
            {{ Form::text('clock_out', null, ['class' => 'form-control pc-timepicker-1']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
     <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }} --}}


{{ Form::model($attendanceEmployee, ['route' => ['attendanceemployee.update', $attendanceEmployee->id], 'method' => 'PUT']) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-lg-6 col-md-6 ">
        {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
        {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2']) }}
    </div>
    <div class="form-group col-lg-6 col-md-6">
        {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
        {{ Form::text('date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
    </div>

    <div class="form-group col-lg-6 col-md-6">
        {{ Form::label('clock_in', __('Clock In'), ['class' => 'col-form-label']) }}
        {{ Form::text('clock_in', null, ['class' => 'form-control d_clock','id'=>'clock_in']) }}
    </div>

    <div class="form-group col-lg-6 col-md-6">
        {{ Form::label('clock_out', __('Clock Out'), ['class' => 'col-form-label']) }}
        {{ Form::text('clock_out', null, ['class' => 'form-control d_clock ','id'=>'clock_out']) }}
    </div>
</div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}


