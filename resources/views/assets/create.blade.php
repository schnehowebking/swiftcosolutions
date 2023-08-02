
{{ Form::open(['url' => 'account-assets', 'method' => 'post']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('employee', __('Employee Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::select('employee_id[]', $employee, null, ['class' => 'form-control select2', 'id' => 'choices-multiple', 'multiple' => '', 'required' => 'required']) }}
                </div>
               
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Asset Name')]) }}
                </div>
               
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('amount', __('Amount'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::number('amount', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
                </div>
                
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('purchase_date', __('Purchase Date'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('purchase_date', null, array('class' => 'form-control d_week','required'=>'required','autocomplete'=>'off')) }}
                </div>
               
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('supported_date', __('Support Until'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('supported_date', null, array('class' => 'form-control d_week','required'=>'required','autocomplete'=>'off')) }}
                </div>
                
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) }}
                </div>
                
            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

