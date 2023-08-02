
<?php echo e(Form::open(['url' => 'account-assets', 'method' => 'post'])); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('employee', __('Employee Name'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::select('employee_id[]', $employee, null, ['class' => 'form-control select2', 'id' => 'choices-multiple', 'multiple' => '', 'required' => 'required'])); ?>

                </div>
               
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Asset Name')])); ?>

                </div>
               
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('amount', __('Amount'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::number('amount', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

                </div>
                
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('purchase_date', __('Purchase Date'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('purchase_date', null, array('class' => 'form-control d_week','required'=>'required','autocomplete'=>'off'))); ?>

                </div>
               
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('supported_date', __('Support Until'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('supported_date', null, array('class' => 'form-control d_week','required'=>'required','autocomplete'=>'off'))); ?>

                </div>
                
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3'])); ?>

                </div>
                
            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH D:\xampp82\htdocs\orondo\main\backup08.07.2023\resources\views/assets/create.blade.php ENDPATH**/ ?>