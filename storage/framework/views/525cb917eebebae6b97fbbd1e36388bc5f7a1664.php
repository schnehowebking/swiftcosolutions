<?php $__env->startSection('page-title'); ?>
     <?php echo e(__('Zoom Meetings Calender')); ?>

<?php $__env->stopSection(); ?>

<?php
    $setting = App\Models\Utility::settings();
?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Zoom Metting')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="<?php echo e(route('zoom-meeting.index')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="<?php echo e(__('List View')); ?>">
        <i class="ti ti-list"></i>
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
   
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-9">
                    <h5><?php echo e(__('Calendar')); ?></h5>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for=""></label>
                        <?php if(isset($setting['is_enabled']) && $setting['is_enabled'] =='on'): ?>
                            <select class="form-control" name="calender_type" id="calender_type" onchange="get_data()">
                                <option value="google_calender"><?php echo e(__('Google Calender')); ?></option>
                                <option value="local_calender" selected="true"><?php echo e(__('Local Calender')); ?></option>
                            </select>
                            <?php endif; ?>
                            <input type="hidden" id="path_admin" value="<?php echo e(url('/')); ?>">
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="col-lg-4">
           
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4"><?php echo e(__("Mettings")); ?></h4>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100">
                        <?php $__currentLoopData = $current_month_event; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item card mb-3">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-calendar-event"></i>
                                        </div>
                                        <div class="ms-3">
                                             <h5 class="  text-primary">
                                                <a href="#" data-size="lg" data-url="<?php echo e(route('zoom-meeting.show',$event->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Event')); ?>" class="text-primary"><?php echo e($event->title); ?></a>
                                            </h5>
                                                <div class="card-text small text-dark"><?php echo e(date('d F Y, h:m A',strtotime($event->start_date))); ?>

                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                    </ul>
                </div>
            </div>
        </div>
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>



<script type="text/javascript">
    $(document).ready(function() {
        get_data();
    });

    function get_data() {
        var calender_type = $('#calender_type :selected').val();
        $('#calendar').removeClass('local_calender');
        $('#calendar').removeClass('google_calender');
        if(calender_type==undefined){
                calender_type='local_calender';
            }
        $('#calendar').addClass(calender_type);

        $.ajax({
            url: $("#path_admin").val() + "/zoom-meeting/get_zoom_meeting_data",
            method: "POST",
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
                'calender_type': calender_type
            },
            success: function(data) {
                (function() {
                    var etitle;
                    var etype;
                    var etypeclass;
                    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        buttonText: {
                            timeGridDay: "<?php echo e(__('Day')); ?>",
                            timeGridWeek: "<?php echo e(__('Week')); ?>",
                            dayGridMonth: "<?php echo e(__('Month')); ?>"
                        },
                        themeSystem: 'bootstrap',
                        slotDuration: '00:10:00',
                        navLinks: true,
                        droppable: true,
                        selectable: true,
                        selectMirror: true,
                        editable: true,
                        dayMaxEvents: true,
                        handleWindowResize: true,
                        events: data,
                    });
                    calendar.render();
                })();
            }
        });

    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/zoom_meeting/calendar.blade.php ENDPATH**/ ?>