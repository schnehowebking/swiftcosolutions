{{ Form::model($complaint, ['route' => ['complaint.update', $complaint->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        @if (\Auth::user()->type != 'employee')
            <div class="form-group col-md-6 col-lg-6">
                {{ Form::label('complaint_from', __('Complaint From'), ['class' => 'col-form-label']) }}
                {{ Form::select('complaint_from', $employees, null, ['class' => 'form-control  select2', 'required' => 'required']) }}
            </div>
        @endif
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('complaint_against', __('Complaint Against'), ['class' => 'col-form-label']) }}
            {{ Form::select('complaint_against', $employees, null, ['class' => 'form-control select2' ,'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('title', __('Title'), ['class' => 'col-form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control','placeholder' =>'Enter Complaint Title' ,'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('complaint_date', __('Complaint Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('complaint_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off' ,'required' => 'required']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description'),'rows' => '3' ,'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
