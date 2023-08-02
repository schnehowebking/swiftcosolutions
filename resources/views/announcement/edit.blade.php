
 {{ Form::model($announcement, ['route' => ['announcement.update', $announcement->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('title', __('Announcement Title'), ['class' => 'col-form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Announcement Title')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('branch_id', __('Branch'), ['class' => 'col-form-label']) }}
                
                {{ Form::select('branch_id', $branch, null, ['class' => 'form-control select2']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('department_id', __('Department'), ['class' => 'col-form-label']) }}

                <div class="department_div">
                    {{-- <select class="form-control select2  department_id" id="department_id" name="department_id[]"
                         placeholder="Select Department" multiple>
                    </select> --}}
                    {{-- @dd($departments,$announcement->department_id) --}}

                    {{-- {{ Form::select('question[]', $job_question, (!empty($company_job->question)) ? explode(',', $company_job->question) : null, array('class' => 'form-control','multiple','data-toggle'=>'select')) }} --}}
                    {{-- @dd((!empty($announcement->department_id)) ? explode(",",$announcement->department_id) :null) --}}
                    {{ Form::select('department_id[]', $departments, (!empty($announcement->department_id)) ? explode(",",$announcement->department_id) :null, ['class' => 'form-control select2 department_id','multiple','id'=>'department_id']) }}
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Announcement start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('Announcement End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('description', __('Announcement Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control','placeholder' => __('Enter Announcement Title'),'rows'=>'3']) }}
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

    </div>
</div>
{{ Form::close() }}
