{{ Form::open(['url' => 'allowance', 'method' => 'post']) }}
{{ Form::hidden('employee_id', $employee->id, []) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('allowance_option', __('Allowance Options*'), ['class' => 'col-form-label']) }}
            {{ Form::select('allowance_option', $allowance_options, null, ['class' => 'form-control select2','required' => 'required','placeholder'=>'Select Allowance Option']) }}
        </div>
        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'col-form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Enter Title']) }}
        </div>
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'col-form-label']) }}
            {{ Form::select('type', $Allowancetypes, null, ['class' => 'form-control select2 amount_type','required' => 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label amount_label']) }}
            {{ Form::number('amount', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01','placeholder'=>'Enter Amount','autocomplete'=>'off']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
