{{ Form::open(['url' => 'overtime', 'method' => 'post']) }}
{{ Form::hidden('employee_id', $employee->id, []) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Overtime Title*'), ['class' => 'col-form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control ', 'required' => 'required','placeholder'=>'Enter Title']) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('number_of_days', __('Number of days'), ['class' => 'col-form-label']) }}
            {{ Form::number('number_of_days', null, ['class' => 'form-control ','required' => 'required','step' => '0.01']) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('hours', __('Hours'), ['class' => 'col-form-label']) }}
            {{ Form::number('hours', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('rate', __('Rate'), ['class' => 'col-form-label']) }}
            {{ Form::number('rate', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01']) }}
        </div>
    </div>
</div>
<div class="modal-footer">

    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">

</div>
{{ Form::close() }}
