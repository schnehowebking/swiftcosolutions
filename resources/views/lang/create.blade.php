{{-- <div class="col-form-label">
    {{ Form::open(['route' => ['store.language']]) }}
    <div class="row">
        <div class="form-group">
            {{ Form::label('code', __('Language Code'), ['class' => 'col-form-label']) }}
            {{ Form::text('code', '', ['class' => 'form-control', 'required' => 'required']) }}
            @error('code')
                <span class="invalid-code" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" value="{{ __('Create') }}" class="btn-create badge-blue">
    <input type="button" value="{{ __('Cancel') }}" class="btn-create bg-gray" data-bs-dismiss="modal">
</div>
{{ Form::close() }} --}}


{{ Form::open(array('route' => array('store.language'))) }}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('code', __('Language Code'),['class' => 'col-form-label']) }}
        {{ Form::text('code', '', array('class' => 'form-control','required'=>'required')) }}
        @error('code')
        <span class="invalid-code" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="modal-footer pr-0">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    {{Form::submit(__('Create'),array('class'=>'btn  btn-primary'))}}
</div>
{{ Form::close() }}

