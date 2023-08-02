{{ Form::open(['url' => 'payslip/bulkpayment/' . $date, 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ __('Total Unpaid Employee') }} <b>{{ count($unpaidEmployees) }}</b> {{ _('out of') }}
            <b>{{ count($Employees) }}</b>
        </div>
    </div>
</div>
<div class="modal-footer">
    
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Bulk Payment') }}" class="btn btn-primary">
</div>
{{ Form::close() }}


