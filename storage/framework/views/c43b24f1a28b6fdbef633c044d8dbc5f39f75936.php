<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Appraisal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <style>
        @import url(<?php echo e(asset('css/font-awesome.css')); ?>);

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/bootstrap-toggle.js')); ?>"></script>
    <script>
        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function() {
                alert($(this).val());
                $(this).attr("checked");
            });
        });

        $(document).ready(function() {
            var employee = $('.employee').val();
            getEmployee(employee);
        });

        $(document).on('change', 'select[name=branch]', function() {
            var branch = $(this).val();
            getEmployee(branch);
        });

        function getEmployee(did) {
            $.ajax({
                url: '<?php echo e(route('branch.employee.json')); ?>',
                type: 'POST',
                data: {
                    "branch": did,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    // $('#employee').empty();
                    // $('#employee').append('<option value=""><?php echo e(__('Select Branch')); ?></option>');
                    // $.each(data, function(key, value) {
                    //     $('#employee').append('<option value="' + key + '">' + value + '</option>');
                    // });

                    $('.employee').empty();
                    var emp_selct = ` <select class="form-control  employee" name="employee" id="choices-multiple"
                                            placeholder="Select Employee" >
                                            </select>`;
                    $('.employee_div').html(emp_selct);

                    $('.employee').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function(key, value) {
                        $('.employee').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Appraisal')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Appraisal')): ?>
        <a href="#" data-url="<?php echo e(route('appraisal.create')); ?>" data-ajax-popup="true" data-size="lg"
            data-title="<?php echo e(__('Create New Appraisal')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
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
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Designation')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Target Rating')); ?></th>
                                <th><?php echo e(__('Overall Rating')); ?></th>
                                <th><?php echo e(__('Appraisal Date')); ?></th>
                                <?php if(Gate::check('Edit Appraisal') || Gate::check('Delete Appraisal') || Gate::check('Show Appraisal')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $__currentLoopData = $appraisals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appraisal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $designation=!empty($appraisal->employees) ?  $appraisal->employees->designation->id : '-';
                            $targetRating =  Utility::getTargetrating($designation,$competencyCount);
                            if(!empty($appraisal->rating)&&($competencyCount!=0))
                            {
                                $rating = json_decode($appraisal->rating,true);
                                $starsum = array_sum($rating);
                                $overallrating = $starsum/$competencyCount;
                            }
                            else{
                                $overallrating = 0;
                            }
                            ?>
                                <?php
                                    if (!empty($appraisal->rating)) {
                                        $rating = json_decode($appraisal->rating, true);
                                        if (!empty($rating)) {
                                            $starsum = array_sum($rating);
                                            $overallrating = $starsum / count($rating);
                                        } else {
                                            $overallrating = 0;
                                        }
                                    } else {
                                        $overallrating = 0;
                                    }
                                ?>
                                <tr>
                                    <td><?php echo e(!empty($appraisal->branches) ? $appraisal->branches->name : ''); ?></td>
                                    <td><?php echo e(!empty($appraisal->employees) ?  $appraisal->employees->department->name : '-'); ?>

                                    </td>
                                    <td><?php echo e(!empty($appraisal->employees) ? $appraisal->employees->designation->name : '-'); ?>

                                    </td>
                                    <td><?php echo e(!empty($appraisal->employees) ? $appraisal->employees->name : '-'); ?></td>
                                    <td >
                                        <?php for($i=1; $i<=5; $i++): ?>
                                         <?php if($targetRating < $i): ?>
                                            <?php if(is_float($targetRating) && (round($targetRating) == $i)): ?>
                                            <i class="text-warning fas fa-star-half-alt"></i>
                                            <?php else: ?>
                                            <i class="fas fa-star"></i>
                                            <?php endif; ?>
                                         <?php else: ?>
                                         <i class="text-warning fas fa-star"></i>
                                         <?php endif; ?>
                                        <?php endfor; ?>

                                       <span class="theme-text-color">(<?php echo e(number_format($targetRating,1)); ?>)</span>
                                    </td>
                                    <td>

                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($overallrating < $i): ?>
                                                <?php if(is_float($overallrating) && round($overallrating) == $i): ?>
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <i class="text-warning fas fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="theme-text-color">(<?php echo e(number_format($overallrating, 1)); ?>)</span>
                                    </td>
                                    <td><?php echo e($appraisal->appraisal_date); ?></td>
                                    <td class="Action">
                                        <?php if(Gate::check('Edit Appraisal') || Gate::check('Delete Appraisal') || Gate::check('Show Appraisal')): ?>
                                            <span>


                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Appraisal')): ?>



                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="<?php echo e(route('appraisal.show', $appraisal->id)); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Appraisal Detail')); ?>"
                                                            data-bs-original-title="<?php echo e(__('View')); ?>">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Appraisal')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="<?php echo e(route('appraisal.edit', $appraisal->id)); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Edit Appraisal')); ?>"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Appraisal')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['appraisal.destroy', $appraisal->id], 'id' => 'delete-form-' . $appraisal->id]); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/appraisal/index.blade.php ENDPATH**/ ?>