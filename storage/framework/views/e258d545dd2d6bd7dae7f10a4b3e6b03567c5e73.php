<?php $__env->startSection('page-title'); ?>
  <?php echo e(__('Manage Assets')); ?>

<?php $__env->stopSection(); ?>
<?php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Assets')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="<?php echo e(route('assets.export')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="<?php echo e(__('Export')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-file-export"></i>
    </a>

    <a href="#" data-url="<?php echo e(route('assets.file.import')); ?>" data-ajax-popup="true"
        data-title="<?php echo e(__('Import  Asset CSV file')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="<?php echo e(__('Import')); ?>">
        <i class="ti ti-file"></i>
    </a>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Assets')): ?>
        <a href="#" data-url="<?php echo e(route('account-assets.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create Assets')); ?>" data-size="lg" data-bs-toggle="tooltip" title=""
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
                                <th> <?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th> <?php echo e(__('Purchase Date')); ?></th>
                                <th> <?php echo e(__('Support Until')); ?></th>
                                <th> <?php echo e(__('Amount')); ?></th>
                                <th> <?php echo e(__('Description')); ?></th>
                                <?php if(Gate::check('Edit Assets') || Gate::check('Delete Assets')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($asset->name); ?></td>
                                    <td>
                                        <div class="avatar-group">
                                            <?php $__currentLoopData = $asset->users($asset->employee_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                                    <img alt="" <?php if(!empty($user->avatar)): ?> src="<?php echo e($profile.'/'.$user->avatar); ?>" <?php else: ?> src="<?php echo e(asset('/storage/uploads/avatar/avatar.png')); ?>" <?php endif; ?> data-original-title="<?php echo e((!empty($user)?$user->name:'')); ?>" data-bs-toggle="tooltip" height="30px" width="30px" style="border-radius:50%                " data-original-title="<?php echo e((!empty($user)?$user->name:'')); ?>" class="">
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($asset->purchase_date)); ?>

                                    </td>
                                    <td>
                                        <?php echo e(\Auth::user()->dateFormat($asset->supported_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($asset->amount)); ?></td>
                                    <td><?php echo e($asset->description); ?></td>
                                    <td class="Action">
                                        <span>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Assets')): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" data-size="lg" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="<?php echo e(route('account-assets.edit', $asset->id)); ?>"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="<?php echo e(__('Edit Assets')); ?>"
                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Assets')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id], 'id' => 'delete-form-' . $asset->id]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i class="ti ti-trash text-white "></i></a>
                                                    </form>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp82\htdocs\orondo\main\backup08.07.2023\resources\views/assets/index.blade.php ENDPATH**/ ?>