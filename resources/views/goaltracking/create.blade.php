{{-- {{ Form::open(['url' => 'goaltracking', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
                {{ Form::select('branch', $brances, null, ['class' => 'form-control ', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('goal_type', __('GoalTypes'), ['class' => 'col-form-label']) }}
                {{ Form::select('goal_type', $goalTypes, null, ['class' => 'form-control ', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control ', 'id' => 'data_picker1']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control ', 'id' => 'data_picker2' ]) }}
            </div>
        </div>
            <div class="form-group">
                {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label']) }}
                {{ Form::text('subject', null, ['class' => 'form-control' ]) }}
        </div>
            <div class="form-group">
                {{ Form::label('target_achievement', __('Target Achievement'), ['class' => 'col-form-label']) }}
                {{ Form::text('target_achievement', null, ['class' => 'form-control' ]) }}
            </div>
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control' ]) }}
            </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">

</div>
{{ Form::close() }} --}}


{{ Form::open(['url' => 'goaltracking', 'method' => 'post']) }}
<div class="modal-body">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
            {{ Form::select('branch', $brances, null, ['class' => 'form-control select2', 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('goal_type', __('GoalTypes'), ['class' => 'col-form-label']) }}
            {{ Form::select('goal_type', $goalTypes, null, ['class' => 'form-control select2', 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('start_date', null, ['class' => 'form-control d_week','autocomplete'=>'off' ,'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('end_date', null, ['class' => 'form-control d_week','autocomplete'=>'off' ,'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label']) }}
            {{ Form::text('subject', null, ['class' => 'form-control' ,'placeholder'=>'enter goal subject' ,'required' => 'required']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('target_achievement', __('Target Achievement'), ['class' => 'col-form-label']) }}
            {{ Form::text('target_achievement', null, ['class' => 'form-control' ,'placeholder'=>'enter target achievement']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control' ,'rows'=>'3' ,'placeholder'=>'enter description']) }}
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
<input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
