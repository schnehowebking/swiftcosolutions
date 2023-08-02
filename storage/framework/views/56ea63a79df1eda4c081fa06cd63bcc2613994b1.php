<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Job')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Job')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-page'); ?>
    <script>
        $('.copy_link').click(function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('Success', 'Url copied to clipboard', 'success');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
   
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Job')): ?>
        <a href="<?php echo e(route('job.create')); ?>"  data-ajax-popup="true" data-size="md"
            data-title="<?php echo e(__('Create New Job')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                <h6 class="m-0"><?php echo e(__('Jobs')); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h4 class="m-0"><?php echo e($data['total']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted"><?php echo e(__('Active')); ?></small>
                                <h6 class="m-0"><?php echo e(__('Jobs')); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h4 class="m-0"><?php echo e($data['active']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-cast"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-muted"><?php echo e(__('Inactive')); ?></small>
                                <h6 class="m-0"><?php echo e(__('Jobs')); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <h4 class="m-0"><?php echo e($data['in_active']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Created At')); ?></th>
                                <?php if(Gate::check('Edit Job') || Gate::check('Delete Job') || Gate::check('Show Job')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(!empty($job->branches) ? $job->branches->name : __('All')); ?></td>
                                <td><?php echo e($job->title); ?></td>
                                <td><?php echo e(\Auth::user()->dateFormat($job->start_date)); ?></td>
                                <td><?php echo e(\Auth::user()->dateFormat($job->end_date)); ?></td>
                                <td>
                                    <?php if($job->status == 'active'): ?>
                                        <span
                                            class="badge bg-success p-2 px-3 rounded status-badge"><?php echo e(App\Models\Job::$status[$job->status]); ?></span>
                                    <?php else: ?>
                                        <span
                                            class="badge bg-danger p-2 px-3 rounded status-badge"><?php echo e(App\Models\Job::$status[$job->status]); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\Auth::user()->dateFormat($job->created_at)); ?></td>
                                <td class="Action">
                                    <?php if(Gate::check('Edit Job') || Gate::check('Delete Job') || Gate::check('Show Job')): ?>
                                    <span>  
                                         
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Job')): ?>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="<?php echo e(route('job.show', $job->id)); ?>"
                                                class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="<?php echo e(__('Job Detail')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <?php endif; ?>


                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Job')): ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(route('job.edit', $job->id)); ?>" class="mx-3 btn btn-sm  align-items-center"
                                                    data-url=""
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Edit Job')); ?>"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Job')): ?>
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['job.destroy', $job->id], 'id' => 'delete-form-' . $job->id]); ?>

                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="<?php echo e(__('Delete')); ?>">
                                                    <i class="ti ti-trash text-white"></i></a>
                                                <?php echo Form::close(); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp82\htdocs\orondo\main\backup08.07.2023\resources\views/job/index.blade.php ENDPATH**/ ?>