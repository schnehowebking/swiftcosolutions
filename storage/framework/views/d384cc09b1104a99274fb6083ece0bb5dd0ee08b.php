<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Indicator')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Indicator')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Indicator')): ?>
        <a href="#" data-url="<?php echo e(route('indicator.create')); ?>" data-ajax-popup="true" data-size="lg"
            data-title="<?php echo e(__('Create New Indicator')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
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
                                <th><?php echo e(__('Overall Rating')); ?></th>
                                <th><?php echo e(__('Added By')); ?></th>
                                <th><?php echo e(__('Created At')); ?></th>
                                <?php if(Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if (!empty($indicator->rating)) {
                                        $rating = json_decode($indicator->rating, true);
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
                                    <td><?php echo e(!empty($indicator->branches) ? $indicator->branches->name : ''); ?></td>
                                    <td><?php echo e(!empty($indicator->departments) ? $indicator->departments->name : ''); ?>

                                    </td>
                                    <td><?php echo e(!empty($indicator->designations) ? $indicator->designations->name : ''); ?>

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
                                    <td><?php echo e(!empty($indicator->user) ? $indicator->user->name : ''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($indicator->created_at)); ?></td>
                                    <td class="Action">
                                        <?php if(Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator')): ?>
                                            <span>


                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Indicator')): ?>

                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="<?php echo e(route('indicator.show', $indicator->id)); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Indicator Detail ')); ?>"
                                                            data-bs-original-title="<?php echo e(__('View')); ?>">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Indicator')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="<?php echo e(route('indicator.edit', $indicator->id)); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Edit Indicator')); ?>"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Indicator')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]); ?>

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
            var d_id = $('.department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '<?php echo e(route('employee.json')); ?>',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    // $('#designation_id').empty();
                    // $('#designation_id').append('<option value=""><?php echo e(__('Select Designation')); ?></option>');
                    // $.each(data, function(key, value) {
                    //     $('#designation_id').append('<option value="' + key + '">' + value +
                    //         '</option>');
                    // });


                    $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation" id="choices-multiple"
                                            placeholder="Select Designation" >
                                            </select>`;
                    $('.designation_div').html(emp_selct);

                    $('.designation_id').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id').append('<option value="' + key + '">' + value +
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/indicator/index.blade.php ENDPATH**/ ?>