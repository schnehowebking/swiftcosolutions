{{-- {{ Form::model($timeSheet, array('route' => array('timesheet.update', $timeSheet->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        @if (\Auth::user()->type != 'employee')
            <div class="form-group">
                {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                {!! Form::select('employee_id', $employees, null, ['class' => 'form-control font-style select2', 'id'=>'choices-multiple' , 'required' => 'required']) !!}
            </div>
        @endif
        <div class="form-group col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('date', '', ['class' => 'form-control' ,'id' => 'data_picker2' ,'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('hours', __('Hours'), ['class' => 'col-form-label']) }}
            {{ Form::number('hours', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group ">
            {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}
            {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '2']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">

</div>
{{ Form::close() }} --}}

{{ Form::model($timeSheet, ['route' => ['timesheet.update', $timeSheet->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        @if (\Auth::user()->type != 'employee')
            <div class="form-group col-md-12">
                {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                {!! Form::select('employee_id', $employees, null, ['class' => 'form-control font-style select2', 'id'=>'choices-multiple','required' => 'required']) !!}
            </div>
        @endif
        <div class="form-group col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('hours', __('Hours'), ['class' => 'col-form-label']) }}
            {{ Form::number('hours', null, ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}
            {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '2' ,'placeholder'=>'Enter remark']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}
