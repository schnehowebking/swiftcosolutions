<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Account Statement')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Account Statement Report')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4'
                }
            };
            html2pdf().set(opt).from(element).save();

        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()" data-bs-toggle="tooltip" title="<?php echo e(__('Download')); ?>"
        data-original-title="<?php echo e(__('Download')); ?>" style="margin-right: 5px;">
        <span class="btn-inner--icon"><i class="ti ti-download"></i></span>
    </a>
    <a href="<?php echo e(route('accountstatement.report.export')); ?>" class="btn btn-sm btn-primary float-end"
        data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Export')); ?>">
        <i class="ti ti-file-export"></i>
    </a>
<?php $__env->stopSection(); ?>




<?php $__env->startSection('content'); ?>
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['report.account.statement'], 'method' => 'get', 'id' => 'report_acc_filter'])); ?>

                    <div class="d-flex align-items-center justify-content-end">


                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                <?php echo e(Form::label('start_month', __('Start Month'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('start_month', isset($_GET['start_month']) ? $_GET['start_month'] : date('Y-m'), ['class' => 'month-btn form-control d_filter'])); ?>

                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 month">
                            <div class="btn-box">
                                <?php echo e(Form::label('end_month', __('End Month'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('end_month', isset($_GET['end_month']) ? $_GET['end_month'] : date('Y-m'), ['class' => 'month-btn form-control d_filter'])); ?>

                            </div>
                        </div>


                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 ">
                            <div class="btn-box">
                                <?php echo e(Form::label('account', __('Account'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('account', $accountList, isset($_GET['account']) ? $_GET['account'] : '', ['class' => ' form-control select'])); ?>

                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2 ">
                            <div class="btn-box">
                                <?php echo e(Form::label('type', __('Type'), ['class' => 'form-label'])); ?>

                                <select class="form-control select" id="type" name="type" tabindex="-1"
                                    aria-hidden="true">
                                    <option value="income"
                                        <?php echo e(isset($_GET['account']) && $_GET['type'] == 'income' ? 'selected' : ''); ?>>
                                        <?php echo e(__('Income')); ?></option>
                                    <option value="expense"
                                        <?php echo e(isset($_GET['account']) && $_GET['type'] == 'expense' ? 'selected' : ''); ?>>
                                        <?php echo e(__('Expense')); ?></option>
                                </select>

                            </div>
                        </div>



                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('report_acc_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                data-original-title="<?php echo e(__('apply')); ?>">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>

                            <a href="<?php echo e(route('report.account.statement')); ?>" class="btn btn-sm btn-danger "
                                data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                data-original-title="<?php echo e(__('Reset')); ?>">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>


    <div id="printableArea" class="">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-report"></i>
                                </div>
                                <div class="ms-3">
                                    <input type="hidden"
                                        value="<?php echo e(__('Account Statement') . ' ' . $filterYear['type'] . ' ' . 'Report of' . ' ' . $filterYear['startDateRange'] . ' to ' . $filterYear['endDateRange']); ?>"
                                        id="filename">
                                    <h5 class="mb-0"><?php echo e(__('Report')); ?></h5>
                                    <div>
                                        <p class="text-muted text-sm mb-0">
                                            <?php echo e(__('Account Statement Summary')); ?></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($filterYear['type'] != 'All'): ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-secondary">
                                        <i class="ti ti-sitemap"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0"><?php echo e(__('Transaction Type')); ?></h5>
                                        <p class="text-muted text-sm mb-0">
                                            <?php echo e($filterYear['type']); ?> </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-calendar"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0"><?php echo e(__('Duration')); ?></h5>
                                    <p class="text-muted text-sm mb-0">
                                        <?php echo e($filterYear['startDateRange'] . ' to ' . $filterYear['endDateRange']); ?>

                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-primary">
                                        <i class="ti ti-layout-list"></i>
                                    </div>

                                    <div class="ms-3">

                                        <h5 class="mb-0">
                                            <?php echo e($account->account_name); ?>

                                        </h5>

                                        <p class="text-muted text-sm mb-0">
                                            <?php if(isset($_GET['type']) && $_GET['type'] == 'expense'): ?>
                                                <?php echo e(__('Total Debit')); ?> :
                                            <?php else: ?>
                                                <?php echo e(__('Total Credit')); ?> :
                                            <?php endif; ?> <?php echo e(\Auth::user()->priceFormat($account->total)); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        </div>


    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                

                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Account')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Amount')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $accountData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($account->accounts) ? $account->accounts->account_name : ''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($account->date)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($account->amount)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/report/account_statement.blade.php ENDPATH**/ ?>