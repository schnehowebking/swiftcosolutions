{{Form::open(array('url'=>'transferbalance','method'=>'post'))}}
<div class="modal-body">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('from_account_id',__('From Account'),['class'=>'col-form-label'])}}
            {{Form::select('from_account_id',$accounts,null,array('class'=>'form-control select2','placeholder'=>__('Choose Account')))}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('to_account_id',__('To Account'),['class'=>'col-form-label'])}}
            {{Form::select('to_account_id',$accounts,null,array('class'=>'form-control select2','placeholder'=>__('Choose Account')))}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('date',__('Date'),['class'=>'col-form-label'])}}
            {{Form::text('date',null,array('class'=>'form-control d_week', 'autocomplete' => 'off'))}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('amount',__('Amount'),['class'=>'col-form-label'])}}
            {{Form::number('amount',null,array('class'=>'form-control','step'=>'0.01'))}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('payment_type_id',__('Payment Method'),['class'=>'col-form-label'])}}
            {{Form::select('payment_type_id',$paymentTypes,null,array('class'=>'form-control select2','placeholder'=>__('Choose Payment Method')))}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{Form::label('referal_id',__('Ref#'),['class'=>'col-form-label'])}}
            {{Form::text('referal_id',null,array('class'=>'form-control'))}}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{Form::label('description',__('Description'),['class'=>'col-form-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Description'),'rows'=>'3'))}}
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>

{{Form::close()}}
