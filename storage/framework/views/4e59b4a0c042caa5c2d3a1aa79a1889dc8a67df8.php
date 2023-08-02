<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Job On-Boarding')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Interview Schedule')): ?>
        <a href="#" data-url="<?php echo e(route('job.on.board.create', 0)); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Job On-Boarding')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Job On-Boarding')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Job')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Applied at')); ?></th>
                                <th><?php echo e(__('Joining at')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jobOnBoards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($job->applications) ? $job->applications->name : '-'); ?></td>
                                    <td><?php echo e(!empty($job->applications) ? (!empty($job->applications->jobs) ? $job->applications->jobs->title : '-') : '-'); ?>

                                    </td>
                                    <td><?php echo e(!empty($job->applications) ? (!empty($job->applications->jobs) ? (!empty($job->applications->jobs) ? (!empty($job->applications->jobs->branches) ? $job->applications->jobs->branches->name : '-') : '-') : '-') : '-'); ?>

                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat(!empty($job->applications) ? $job->applications->created_at : '-')); ?>

                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($job->joining_date)); ?></td>
                                    <td>
                                        <?php if($job->status == 'pending'): ?>
                                            <span
                                                class="badge bg-warning p-2 px-3 rounded"><?php echo e(\App\Models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php elseif($job->status == 'cancel'): ?>
                                            <span
                                                class="badge bg-danger p-2 px-3 rounded"><?php echo e(\App\models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php else: ?>
                                            <span
                                                class="badge bg-success p-2 px-3 rounded"><?php echo e(\App\models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="Action">
                                        <span>
                                            

                                            <?php if($job->status == 'confirm' && $job->convert_to_employee == 0): ?>
                                                <div class="action-btn bg-dark ms-2">
                                                    <a href="<?php echo e(route('job.on.board.convert', $job->id)); ?>"
                                                        class="mx-3 btn btn-sm  align-items-center" data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Convert to Employee ')); ?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo e(__('Convert to Employee')); ?>">
                                                        <i class="ti ti-arrows-right-left text-white"></i>
                                                    </a>
                                                </div>
                                            <?php elseif($job->status == 'confirm' && $job->convert_to_employee != 0): ?>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="<?php echo e(route('employee.show', \Crypt::encrypt($job->convert_to_employee))); ?>"
                                                        class="mx-3 btn btn-sm  align-items-center" data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Employee Detail ')); ?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo e(__('Employee Detail')); ?>">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>



                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                    data-url="<?php echo e(route('job.on.board.edit', $job->id)); ?>"
                                                    data-ajax-popup="true" data-title="<?php echo e(__('Edit Job On-Boarding')); ?>"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>



                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['job.on.board.delete', $job->id], 'id' => 'delete-form-' . $job->id]); ?>

                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="<?php echo e(__('Delete')); ?>">
                                                    <i class="ti ti-trash text-white"></i></a>
                                                <?php echo Form::close(); ?>

                                            </div>

                                            <?php if($job->status == 'confirm' ): ?>
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="<?php echo e(route('offerlatter.download.pdf',$job->id)); ?>" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('OfferLetter PDF')); ?>" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                            </div>
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="<?php echo e(route('offerlatter.download.doc',$job->id)); ?>" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('OfferLetter DOC')); ?>" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                            </div>
                                        <?php endif; ?>

                                        </span>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/jobApplication/onboard.blade.php ENDPATH**/ ?>