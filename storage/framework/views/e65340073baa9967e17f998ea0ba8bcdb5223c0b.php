    

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Last Login')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Last Login')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Last Login')); ?></th>
                                <th><?php echo e(__('Role')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $emp = $user->getUSerEmployee($user->id);
                                    $emp_id = '-';
                                    if (!empty($emp)) {
                                        $emp_id = \Auth::user()->employeeIdFormat($emp->id);
                                    }
                                ?>
                                <tr>
                                    <?php if($user->type == 'employee'): ?>
                                        <td><a class="btn btn-primary" href="<?php echo e(route('show.employee.profile', \Illuminate\Support\Facades\Crypt::encrypt($user->id))); ?>"><?php echo e($emp_id); ?> </a></td>
                                    <?php else: ?>
                                        <td><?php echo e(__('-')); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e(!empty($user->last_login) ? $user->last_login : '-'); ?></td>
                                    <td><?php echo e($user->type); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/employee/lastLogin.blade.php ENDPATH**/ ?>