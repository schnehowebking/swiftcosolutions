        {{ Form::open(['url' => 'deposit', 'method' => 'post']) }}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('account_id', __('Account'), ['class' => 'col-form-label']) }}
                        {{ Form::select('account_id', $accounts, null, ['class' => 'form-control select2', 'placeholder' => __('Choose Account')]) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label']) }}
                        {{ Form::number('amount', null, ['class' => 'form-control', 'placeholder' => __('Amount'), 'step' => '0.01']) }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
                        {{ Form::text('date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('income_category_id', __('Category'), ['class' => 'col-form-label']) }}
                        {{ Form::select('income_category_id', $incomeCategory, null, ['class' => 'form-control select2', 'placeholder' => __('Choose A Category')]) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('payer_id', __('Payer'), ['class' => 'col-form-label']) }}
                        {{ Form::select('payer_id', $payers, null, ['class' => 'form-control select2']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('payment_type_id', __('Payment Method'), ['class' => 'col-form-label']) }}
                        {{ Form::select('payment_type_id', $paymentTypes, null, ['class' => 'form-control select2', 'placeholder' => __('Choose Payment Method')]) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('referal_id', __('Ref#'), ['class' => 'col-form-label']) }}
                        {{ Form::text('referal_id', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'), 'rows' => '5']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
        </div>
        {{ Form::close() }}
