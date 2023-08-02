
{{ Form::open(['url' => 'trainer', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
                {{ Form::select('branch', $branches, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('firstname', __('First Name'), ['class' => 'col-form-label']) }}
                {{ Form::text('firstname', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('lastname', __('Last Name'), ['class' => 'col-form-label']) }}
                {{ Form::text('lastname', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('contact', __('Contact'), ['class' => 'col-form-label']) }}
                {{ Form::text('contact', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('email', __('Email'), ['class' => 'col-form-label']) }}
                {{ Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{ Form::label('expertise', __('Expertise'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('expertise', null, ['class' => 'form-control', 'placeholder' => __('Expertise'),'rows'=>'3']) }}
        </div>
        <div class="form-group col-lg-12">
            {{ Form::label('address', __('Address'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => __('Address'),'rows'=>'3']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
