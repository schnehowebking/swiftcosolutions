{{ Form::model($customQuestion, ['route' => ['custom-question.update', $customQuestion->id],'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('question', __('Question'), ['class' => 'col-form-label']) }}
            {{ Form::text('question', null, ['class' => 'form-control', 'placeholder' => __('Enter question')]) }}
        </div>
        <div class="form-group">
            {{ Form::label('is_required', __('Is Required'), ['class' => 'col-form-label']) }}
            {{ Form::select('is_required', $is_required, null, ['class' => 'form-control ','required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}
