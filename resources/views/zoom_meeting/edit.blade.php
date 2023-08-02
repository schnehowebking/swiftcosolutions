

{{ Form::model($ZoomMeeting, ['route' => ['zoom-meeting.update', $ZoomMeeting->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Meeting Title')]) }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('user', __('User'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::select('user_id[]', $employee_option,null, array('class' => 'form-control select2','id'=>'choices-multiple','multiple'=>'','required'=>'required')) }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('start_date', null, array('class' => 'form-control d_week','required'=>'required')) }}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('duration', __('Duration'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {!! Form::number('duration', null, ['class' => 'form-control', 'required' => true, 'min' => 0]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password')]) }}
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

