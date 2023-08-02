<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Goal Tracking')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Goal Tracking')): ?>
        <a href="#" data-url="<?php echo e(route('goaltracking.create')); ?>" data-ajax-popup="true" data-size="lg"
            data-title="<?php echo e(__('Create New Goal Tracking')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Goal Tracking')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Goal Type')); ?></th>
                                <th><?php echo e(__('Subject')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Target Achievement')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Rating')); ?></th>
                                <th width="20%"><?php echo e(__('Progress')); ?></th>
                                <?php if(Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $__currentLoopData = $goalTrackings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goalTracking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($goalTracking->goalType) ? $goalTracking->goalType->name : ''); ?>

                                    </td>
                                    <td><?php echo e($goalTracking->subject); ?></td>
                                    <td><?php echo e(!empty($goalTracking->branches) ? $goalTracking->branches->name : ''); ?>

                                    </td>
                                    <td><?php echo e($goalTracking->target_achievement); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($goalTracking->start_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($goalTracking->end_date)); ?></td>
                                    <td>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($goalTracking->rating < $i): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="text-warning fas fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <span class="progress-percentage"><small
                                                    class="font-weight-bold"></small><?php echo e($goalTracking->progress); ?>%</span>
                                            <div class="progress progress-xs mt-2 w-100">
                                                <div class="progress-bar bg-<?php echo e(Utility::getProgressColor($goalTracking->progress)); ?>"
                                                    role="progressbar" aria-valuenow="<?php echo e($goalTracking->progress); ?>"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: <?php echo e($goalTracking->progress); ?>%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="Action">
                                        <?php if(Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking')): ?>
                                            <span>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Goal Tracking')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="<?php echo e(route('goaltracking.edit', $goalTracking->id)); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Edit Goal Tracking')); ?>"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Goal Tracking')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id], 'id' => 'delete-form-' . $goalTracking->id]); ?>

                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/goaltracking/index.blade.php ENDPATH**/ ?>