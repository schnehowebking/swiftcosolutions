
    {{ Form::model($contract, array('route' => array('contract.update', $contract->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
       
        <div class="col-md-6 form-group">
            {{ Form::label('employee_name', __('Employee Name'),['class'=>'col-form-label']) }}
            {{ Form::select('employee_name', $employee,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('subject', __('Subject'),['class'=>'col-form-label']) }}
            {{ Form::text('subject', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('value', __('Value'),['class'=>'col-form-label']) }}
            {{ Form::number('value', null, array('class' => 'form-control','required'=>'required','min' => '1')) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('type', __('Type'),['class'=>'col-form-label']) }}
            {{ Form::select('type', $contractType,null, array('class' => 'form-control select2','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'),['class'=>'col-form-label']) }}
            {{ Form::date('start_date', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'),['class'=>'col-form-label']) }}
            {{ Form::date('end_date', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-md-12 form-group">
            {{ Form::label('description', __('Description'),['class'=>'col-form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>
        {{-- <div class="col-md-12 mb-2">
            <label class="col-form-label">{{__('Status')}}</label>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline m-1" >
                    <input  type="radio" id="start" name="status" value="Start" class="form-check-input" {{ ($contract->status == 'Start') ? 'checked' : '' }} />
                    <label class="form-check-labe" for="start">{{__('Start')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline m-1">
                    <input type="radio" id="close" name="status" value="Close" class="form-check-input" {{ ($contract->status == 'Close') ? 'checked' : '' }} />
                    <label class="form-check-labe" for="close">{{__('Close')}}</label>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Update')}}</button>
   
</div>
    
    {{ Form::close() }}

