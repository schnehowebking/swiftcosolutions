<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Zoom Metting')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Zoom Metting')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="<?php echo e(route('zoom_meeting.calender')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="<?php echo e(__('Calender View')); ?>">
        <i class="ti ti-calendar"></i>
    </a>
    <?php if(\Auth::user()->type == 'company'): ?>
        <a href="#" data-url="<?php echo e(route('zoom-meeting.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Zoom Meeting')); ?>" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Meeting Time')); ?></th>
                                <th><?php echo e(__('Duration')); ?></th>
                                <th><?php echo e(__('User')); ?></th>
                                <th><?php echo e(__('Join URL')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ZoomMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ZoomMeeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($ZoomMeeting->title); ?></td>
                                    <td><?php echo e($ZoomMeeting->start_date); ?></td>
                                    <td><?php echo e($ZoomMeeting->duration); ?> <?php echo e(__(' Minute')); ?></td>
                                    <td>
                                        <div class="user-group">
                                            <?php $__currentLoopData = $ZoomMeeting->users($ZoomMeeting->user_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($projectUser->name); ?>" <?php if($projectUser->avatar): ?> src="<?php echo e(asset(Storage::url('uploads/avatar/')).'/'.$projectUser->avatar); ?>" <?php else: ?> src="<?php echo e(asset(Storage::url('uploads/avatar/'))); ?>" <?php endif; ?> class="rounded-circle " width="25" height="25">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($ZoomMeeting->created_by == \Auth::user()->id && $ZoomMeeting->checkDateTime()): ?>
                                            <a href="<?php echo e($ZoomMeeting->start_url); ?>" class="text-secondary">
                                                <p class="mb-0"><b><?php echo e(__('Start meeting')); ?></b> <i
                                                        class="ti ti-external-link"></i></p>
                                            </a>
                                        <?php elseif($ZoomMeeting->checkDateTime()): ?>
                                            <a href="<?php echo e($ZoomMeeting->join_url); ?>" class="text-secondary">
                                                <p class="mb-0"><b><?php echo e(__('Join meeting')); ?></b> <i
                                                        class="ti ti-external-link"></i></p>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($ZoomMeeting->checkDateTime()): ?>
                                            <?php if($ZoomMeeting->status == 'waiting'): ?>
                                                <span
                                                    class="badge bg-info p-2 px-3 rounded"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                                            <?php else: ?>
                                                <span
                                                    class="badge bg-success p-2 px-3 rounded"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-danger p-2 px-3 rounded"><?php echo e(__('End')); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $ZoomMeeting->id], 'id' => 'delete-form-' . $ZoomMeeting->id]); ?>

                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                    aria-label="Delete"><i
                                                        class="ti ti-trash text-white text-white"></i></a>
                                                </form>
                                            </div>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/zoom_meeting/index.blade.php ENDPATH**/ ?>