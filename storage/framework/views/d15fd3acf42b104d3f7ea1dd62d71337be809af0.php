<?php echo e(Form::open(['route' => ['job.on.board.store', $id], 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if($id == 0): ?>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('application', __('Interviewer'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('application', $applications, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        <?php endif; ?>
        <div class="form-group col-md-12">
            <?php echo Form::label('joining_date', __('Joining Date'), ['class' => 'col-form-label']); ?>

            <?php echo Form::date('joining_date', null, ['class' => 'form-control ','autocomplete'=>'off']); ?>

        </div>
       
        <div class="form-group col-md-6">
            <?php echo Form::label('days_of_week', __('Days Of Week'), ['class' => 'col-form-label']); ?>

            <?php echo Form::number('days_of_week', null, ['class' => 'form-control ','autocomplete'=>'off','min'=>'0']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo Form::label('salary', __('Salary'), ['class' => 'col-form-label']); ?>

            <?php echo Form::number('salary', null, ['class' => 'form-control ','autocomplete'=>'off','min'=>'0']); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('salary_type', __('Salary Type'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('salary_type', $salary_type, null, ['class' => 'form-control select'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('salary_duration', __('Salary Duration'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('salary_duration', $salary_duration, null, ['class' => 'form-control select'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('job_type', __('Job Type'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('job_type', $job_type, null, ['class' => 'form-control select'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('status', __('Status'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('status', $status, null, ['class' => 'form-control select'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/jobApplication/onboardCreate.blade.php ENDPATH**/ ?>