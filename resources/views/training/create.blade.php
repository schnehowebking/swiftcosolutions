<form action="{{ route('training.store') }}" method="post">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label  class="col-form-label" for="company">Course Title:</label>
                <input type="text" class="form-control" name="course_title" id="company" placeholder="Give course Title">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label  class="col-form-label" for="company">Course Video path:</label>
                        <input type="text" class="form-control" name="course_video_path" id="company" placeholder="Give Course video">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label  class="col-form-label" for="company">Number of course:</label>
                        <input type="number" class="form-control" name="number_of_course" id="company" placeholder="Number of course">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch'), ['class' => 'col-form-label']) }}
                {{ Form::select('branch', $branches, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('trainer_option', __('Trainer Option'), ['class' => 'col-form-label']) }}
                {{ Form::select('trainer_option', $options, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('training_type', __('Training Type'), ['class' => 'col-form-label']) }}
                {{ Form::select('training_type', $trainingTypes, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('trainer', __('Trainer'), ['class' => 'col-form-label']) }}
                {{ Form::select('trainer', $trainers, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('training_cost', __('Training Cost'), ['class' => 'col-form-label']) }}
                {{ Form::number('training_cost', null, ['class' => 'form-control', 'step' => '0.01', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('employee', __('Employee'), ['class' => 'col-form-label']) }}
                {{ Form::select('employee', $employees, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-12">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'),'rows'=>'5']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
</form>
