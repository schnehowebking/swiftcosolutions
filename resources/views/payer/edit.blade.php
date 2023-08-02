
{{ Form::model($payer, ['route' => ['payer.update', $payer->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('payer_name', __('Payer Name'), ['class' => 'col-form-label']) }}
                {{ Form::text('payer_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Payer Name')]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('contact_number', __('Contact Number'), ['class' => 'col-form-label']) }}
                {{ Form::text('contact_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Contact Number')]) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
