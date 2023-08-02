{{ Form::open(['url' => 'plans', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control font-style','placeholder' => __('Enter Plan Name'),'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('price', __('Price'), ['class' => 'col-form-label']) }}
            {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => __('Enter Plan Price')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('duration', __('Duration'), ['class' => 'col-form-label']) }}
            {!! Form::select('duration', $arrDuration, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('max_users', __('Maximum Users'), ['class' => 'col-form-label']) }}
            {{ Form::number('max_users', null, ['class' => 'form-control', 'required' => 'required']) }}
            <span class="small">{{ __('Note: "-1" for Unlimited') }}</span>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('max_employees', __('Maximum Employees'), ['class' => 'col-form-label']) }}
            {{ Form::number('max_employees', null, ['class' => 'form-control', 'required' => 'required']) }}
            <span class="small">{{ __('Note: "-1" for Unlimited') }}</span>
        </div>
        <div class="form-group">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}
