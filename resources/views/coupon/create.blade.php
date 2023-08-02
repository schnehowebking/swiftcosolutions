{{ Form::open(['url' => 'coupons', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('discount', __('Discount'), ['class' => 'col-form-label']) }}
            {{ Form::number('discount', null, ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
            <span class="small">{{ __('Note: Discount in Percentage') }}</span>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('limit', __('Limit'), ['class' => 'col-form-label']) }}
            {{ Form::number('limit', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>

        <div class="form-group col-md-12">
            {{Form::label('code',__('Code') ,['class' => 'col-form-label']) }}
            <div class="d-flex radio-check">
                <div class="form-check form-check-inline form-group col-md-6">
                    {{ Form::radio('code', 'manual', true, ['class' => 'form-check-input code ', 'id' => 'is_manual']) }}
                    {{Form::label('is_manual',__('Manual') ,['class' => 'custom-control-label']) }}
                </div>
                <div class="form-check form-check-inline form-group col-md-6">
                    {{ Form::radio('code', 'auto', false, ['class' => 'form-check-input code ', 'id' => 'is_auto']) }}
                    {{Form::label('is_auto',__('Auto Generate') ,['class' => 'custom-control-label']) }}
                </div>
            </div>
        </div>


        <div class="form-group col-md-12 d-block" id="manual">
            <input class="form-control font-uppercase" name="manualCode" type="text">
        </div>
        <div class="form-group col-md-12 d-none" id="auto">
            <div class="row">
                <div class="col-md-10">
                    <input class="form-control" name="autoCode" type="text" id="auto-code">
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn btn-primary btn btn-sm btn-icon-only rounded-circle shadow-sm"
                        id="code-generate"><i class="ti ti-history text-white "></i></a>
                </div>
            </div>
        </div>



    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}
