<?php $__env->startSection('page-title'); ?>
   <?php echo e(__(" Contract")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__("Home")); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__("Contract ")); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-button'); ?>
    <div class="row align-items-center m-1">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Contract')): ?>
            <?php if(\Auth::user()->type =='company'): ?>
                <div class="btn btn-sm btn-primary btn-icon">
                    <a href="#" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Create Contract')); ?>" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create Contract')); ?>" data-url="<?php echo e(route('contract.create')); ?>"><i class="ti ti-plus text-white"></i></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
        
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class='col-xl-12'>
    <div class="row">
        <div class="col-xl-3 col-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20"><?php echo e(__('Total Contracts')); ?></h6>
                            <h3 class="text-primary"><?php echo e($cnt_contract['total']); ?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake bg-success text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20"><?php echo e(__('This Month Total Contracts')); ?></h6>
                            <h3 class="text-info"><?php echo e($cnt_contract['this_month']); ?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake bg-info text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20"><?php echo e(__('This Week Total Contracts')); ?></h6>
                            <h3 class="text-warning"><?php echo e($cnt_contract['this_week']); ?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake bg-warning text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-b-20"><?php echo e(__('Last 30 Days Total Contracts')); ?></h6>
                            <h3 class="text-danger"><?php echo e($cnt_contract['last_30days']); ?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake bg-danger text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
                <div class="card table-card">
                    <div class="card-header card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0 pc-dt-simple" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th width="60px"><?php echo e(__('#')); ?></th>
                                        <th><?php echo e(__('Employee Name')); ?></th>
                                        <th><?php echo e(__('subject')); ?></th>

                                        <th><?php echo e(__('Value')); ?></th>
                                        <th><?php echo e(__('Type')); ?></th>
                                        <th><?php echo e(__('Start Date')); ?></th>
                                        <th><?php echo e(__('End Date')); ?></th>
                                        <th><?php echo e(__('Status')); ?></th>
                                        <th width="150px"><?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="Id">
                                                
                                                    <a href="<?php echo e(route('contract.show',$contract->id)); ?>" class="btn btn-outline-primary"><?php echo e(Auth::user()->contractNumberFormat($contract->id)); ?></a>
                                                    
                                                    
                                                
                                            </td>
                                            <td><?php echo e($contract->employee->name); ?></td>
                                            <td><?php echo e($contract->subject); ?></td>
                                            <td><?php echo e(Auth::user()->priceFormat($contract->value)); ?></td>
                                            <td><?php echo e($contract->contract_type->name); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($contract->start_date)); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($contract->end_date)); ?></td>
                                            <td>
                                                <?php if($contract->status == 'accept'): ?>
                                                        <span class="status_badge badge bg-primary  p-2 px-3 rounded"><?php echo e(__('Accept')); ?></span>
                                                    <?php elseif($contract->status == 'decline'): ?>
                                                        <span class="status_badge badge bg-danger p-2 px-3 rounded"><?php echo e(__('Decline')); ?></span>
                                                    <?php elseif($contract->status == 'pending'): ?>  
                                                         <span class="status_badge badge bg-warning p-2 px-3 rounded"><?php echo e(__('Pending')); ?></span>
                                                    <?php endif; ?>
                                            </td>
                                            <td class="Action">
                                                <span>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Contract')): ?>
                                                        <?php if((\Auth::user()->type == 'company')&&($contract->status=='accept')): ?>
                                                        
                                                            <div class="action-btn btn-primary ms-2">
                                                                <a href="#" data-size="lg" data-url="<?php echo e(route('contracts.copy',$contract->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Copy Contract')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Duplicate')); ?>" ><i class="ti ti-copy text-white"></i></a>
                                                            </div>
                                                    
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                  
                                                        <?php if(\Auth::user()->type == 'company'||\Auth::user()->type == 'employee'): ?>
                                                    
                                                            <div class="action-btn btn-warning ms-2">
                                                                <a href="<?php echo e(route('contract.show',$contract->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('View Contract')); ?>" ><i class="ti ti-eye text-white"></i></a>
                                                            </div>
                                                    
                                                        <?php endif; ?>
                                                   


                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Contract')): ?>
                                                        <?php if(\Auth::user()->type == 'company'): ?>
                                                            <div class="action-btn btn-info ms-2">
                                                                <a href="#" data-size="lg" data-url="<?php echo e(URL::to('contract/'.$contract->id.'/edit')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Contract')); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Edit Contract')); ?>" ><i class="ti ti-pencil text-white"></i></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>


                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Contract')): ?>
                                                        <?php if(\Auth::user()->type == 'company'): ?>
                                                            <div class="action-btn bg-danger ms-2">
                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['contract.destroy', $contract->id]]); ?>

                                                                    <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Delete Contract')); ?>">
                                                                    <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                                    </a>
                                                                <?php echo Form::close(); ?>

                                                            </div>
                                                        <?php endif; ?>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/contracts/index.blade.php ENDPATH**/ ?>