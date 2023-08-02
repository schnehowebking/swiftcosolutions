{{ Form::model($overtime, ['route' => ['overtime.update', $overtime->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('title', __('Title')) }}
                {{ Form::text('title', null, ['class' => 'form-control ', 'required' => 'required','placeholder'=>'Enter Title']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('number_of_days', __('Number Of Days')) }}
                {{ Form::number('number_of_days', null, ['class' => 'form-control ', 'required' => 'required','step' => '0.01']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('hours', __('Hours')) }}
                {{ Form::number('hours', null, ['class' => 'form-control ', 'required' => 'required','step' => '0.01']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('rate', __('Rate')) }}
                {{ Form::number('rate', null, ['class' => 'form-control ', 'required' => 'required','step' => '0.01']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
