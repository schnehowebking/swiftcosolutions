<?php $__env->startSection('page-title'); ?>
   <?php echo e(__('Manage Ticket')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Ticket')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Ticket')): ?>
        <a href="#" data-url="<?php echo e(route('ticket.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Ticket')); ?>" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="col-xxl-8">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="card ticket-card">
                    <div class="card-body">
                        <div class="theme-avtar bg-info">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2"></p>
                        <h6 class="mb-3"><?php echo e(__('Total Ticket')); ?></h6>
                        <h3 class="mb-0"><?php echo e($countTicket); ?> </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card ticket-card">
                    <div class="card-body">
                        <div class="theme-avtar bg-primary">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2"></p>
                        <h6 class="mb-3"><?php echo e(__('Open Ticket')); ?></h6>
                        <h3 class="mb-0"><?php echo e($countOpenTicket); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card ticket-card">
                    <div class="card-body">
                        <div class="theme-avtar bg-warning">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2"></p>
                        <h6 class="mb-3"><?php echo e(__('Hold Ticket')); ?></h6>
                        <h3 class="mb-0"><?php echo e($countonholdTicket); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card ticket-card">
                    <div class="card-body">
                        <div class="theme-avtar bg-danger">
                            <i class="ti ti-ticket"></i>
                        </div>
                        <p class="text-muted text-sm mt-4 mb-2"></p>
                        <h6 class="mb-3"><?php echo e(__('Close Ticket')); ?></h6>
                        <h3 class="mb-0"><?php echo e($countCloseTicket); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4">
        <div class="card">
            <div class="card-header">
                <div class="float-end">

                </div>
                <h5><?php echo e(__('Ticket By Status')); ?></h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div id="projects-chart"></div>
                    </div>
                    <div class="col-6">
                        <div class="row mt-3">
                            <div class="col-6">
                                <span class="d-flex align-items-center mb-2">
                                    <i class="f-10 lh-1 fas fa-circle text-danger"></i>
                                    <span class="ms-2 text-sm"><?php echo e(__('Close')); ?> </span>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="d-flex align-items-center mb-2">
                                    <i class="f-10 lh-1 fas fa-circle text-warning"></i>
                                    <span class="ms-2 text-sm"><?php echo e(__('Hold')); ?></span>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="d-flex align-items-center mb-2">
                                    <i class="f-10 lh-1 fas fa-circle text-info"></i>
                                    <span class="ms-2 text-sm"><?php echo e(__('Total')); ?></span>
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="d-flex align-items-center mb-2">
                                    <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                    <span class="ms-2 text-sm"><?php echo e(__('Open')); ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
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
                                <th><?php echo e(__('New')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Ticket Code')); ?></th>
                                <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'company')): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Priority')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Created By')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if(\Auth::user()->type == 'employee'): ?>
                                            <?php if($ticket->ticketUnread() > 0): ?>
                                                <i title="New Message" class="fas fa-circle circle text-success"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if($ticket->ticketUnread() > 0): ?>
                                                <i title="New Message" class="fas fa-circle circle text-success"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($ticket->title); ?></td>
                                    <td><?php echo e($ticket->ticket_code); ?></td>
                                    <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'company')): ?>
                                        <td><?php echo e(!empty(\Auth::user()->getUser($ticket->employee_id)) ? \Auth::user()->getUser($ticket->employee_id)->name : ''); ?>

                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if($ticket->priority == 'medium'): ?>
                                            <div class="badge bg-info p-2 px-3 rounded status-badde3"><?php echo e(__('Medium')); ?></div>
                                        <?php elseif($ticket->priority == 'low'): ?>
                                            <div class="badge bg-warning p-2 px-3 rounded status-badde3"><?php echo e(__('Low')); ?></div>
                                        <?php elseif($ticket->priority == 'high'): ?>
                                            <div class="badge bg-success p-2 px-3 rounded status-badde3"><?php echo e(__('Success')); ?></div>
                                        <?php elseif($ticket->priority == 'critical'): ?>
                                            <div class="badge bg-danger p-2 px-3 rounded status-badde3"><?php echo e(__('Critical')); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($ticket->end_date)); ?></td>
                                    <td><?php echo e(!empty($ticket->createdBy) ? $ticket->createdBy->name : ''); ?></td>
                                    <td>
                                        <p style="white-space: nowrap;
                                            width: 200px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;"><?php echo e($ticket->description); ?></p>
                                    </td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="<?php echo e(URL::to('ticket/' . $ticket->id . '/reply')); ?>"
                                                    class="mx-3 btn btn-sm  align-items-center" data-bs-toggle="tooltip"
                                                    title="" data-title="<?php echo e(__('Replay')); ?>"
                                                    data-bs-original-title="Reply">
                                                    <i class="ti ti-arrow-back-up text-white"></i>
                                                </a>
                                            </div>
                                            <?php if(\Auth::user()->type == 'company' || $ticket->ticket_created == \Auth::user()->id): ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Ticket')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['ticket.destroy', $ticket->id], 'id' => 'delete-form-' . $ticket->id]); ?>

                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i class="ti ti-trash text-white "></i></a>
                                                        </form>
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        (function() {
            var options = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: <?php echo e($ticket_arr); ?>,
                colors: ["#3ec9d6", '#6fd943', '#fd7e14', '#ff3a6e'],
                labels: ["Total", "Open", "Hold", "Close"],
                legend: {
                    show: false
                }
            };
            var chart = new ApexCharts(document.querySelector("#projects-chart"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/ticket/index.blade.php ENDPATH**/ ?>