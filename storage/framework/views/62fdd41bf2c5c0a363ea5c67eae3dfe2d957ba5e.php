<?php echo e(Form::open(['url' => 'payslip/bulkpayment/' . $date, 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(__('Total Unpaid Employee')); ?> <b><?php echo e(count($unpaidEmployees)); ?></b> <?php echo e(_('out of')); ?>

            <b><?php echo e(count($Employees)); ?></b>
        </div>
    </div>
</div>
<div class="modal-footer">
    
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Bulk Payment')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>



<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/payslip/bulkcreate.blade.php ENDPATH**/ ?>