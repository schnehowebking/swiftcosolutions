<?php $__env->startSection('page-title'); ?>
    <?php echo e($emailTemplate->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Email Template')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('pre-purpose-css-page'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/plugins/tinymce/tinymce.min.js')); ?>"></script>
<script>
    if ($(".pc-tinymce-2").length) {
        tinymce.init({
            selector: '.pc-tinymce-2',
            height: "400",
            content_style: 'body { font-family: "Inter", sans-serif; }'
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
<div class="row">
               
    <div class="text-end mb-3">
        <?php echo e(Form::model($currEmailTempLang, array('route' => array('email_template.update', $currEmailTempLang->parent_id), 'method' => 'PUT'))); ?>

         

        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            
                            <span
                                class="drp-text hide-mob text-primary"><?php echo e(Str::upper($currEmailTempLang->lang)); ?></span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                             aria-labelledby="dropdownLanguage">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('manage.email.language', [$emailTemplate->id, $lang])); ?>"
                                   class="dropdown-item <?php echo e($currEmailTempLang->lang == $lang ? 'text-primary' : ''); ?>"><?php echo e(Str::upper($lang)); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            <span
                                class="drp-text hide-mob text-primary"><?php echo e(__('Template: ')); ?><?php echo e($emailTemplate->name); ?></span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            <?php $__currentLoopData = $EmailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $EmailTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('manage.email.language', [$EmailTemplate->id,(Request::segment(3)?Request::segment(3):\Auth::user()->lang)])); ?>"
                                   class="dropdown-item <?php echo e($emailTemplate->name == $EmailTemplate->name ? 'text-primary' : ''); ?>"><?php echo e($EmailTemplate->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
        
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body ">
                <h5 class= "font-weight-bold pb-3"><?php echo e(__('Placeholders')); ?></h5>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header card-body">
                                    <div class="row text-xs">

                                        <?php if($emailTemplate->slug=='new_user'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Email')); ?> : <span class="pull-right text-primary">{email}</span></p>
                                                <p class="col-4"><?php echo e(__('Password')); ?> : <span class="pull-right text-primary">{password}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='new_employee'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span class="pull-right text-primary">{employee_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Password')); ?> : <span class="pull-right text-primary">{employee_password}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Email')); ?> : <span class="pull-right text-primary">{employee_email}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Branch')); ?> : <span class="pull-right text-primary">{employee_branch}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Department')); ?> : <span class="pull-right text-primary">{employee_department}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Designation')); ?> : <span class="pull-right text-primary">{employee_designation}</span></p>
                                            </div>
                                        <?php elseif($emailTemplate->slug=='new_payroll'): ?>
                                            <div class="row">
                                                
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Email')); ?> : <span class="pull-right text-primary">{payslip_email}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span class="pull-right text-primary">{name}</span></p>
                                                <p class="col-4"><?php echo e(__('Salary Month')); ?> : <span class="pull-right text-primary">{salary_month}</span></p>
                                                <p class="col-4"><?php echo e(__('URL')); ?> : <span class="pull-right text-primary">{url}</span></p>
    
                                            </div>
                                        <?php elseif($emailTemplate->slug=='new_ticket'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Ticket Title')); ?> : <span class="pull-right text-primary">{ticket_title}</span></p>
                                                <p class="col-4"><?php echo e(__('Ticket Employee Name')); ?> : <span class="pull-right text-primary">{ticket_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Ticket Code')); ?> : <span class="pull-right text-primary">{ticket_code}</span></p>
                                                <p class="col-4"><?php echo e(__('Ticket Description')); ?> : <span class="pull-right text-primary">{ticket_description}</span></p>
                                            </div>
                                        <?php elseif($emailTemplate->slug=='new_award'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span class="pull-right text-primary">{award_name}</span></p>
                                            
                                            </div>
                                        <?php elseif($emailTemplate->slug=='employee_transfer'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span class="pull-right text-primary">{transfer_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Transfer Date')); ?> : <span class="pull-right text-primary">{transfer_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Transfer Department')); ?> : <span class="pull-right text-primary">{transfer_department}</span></p>
                                                <p class="col-4"><?php echo e(__('Transfer Branch')); ?> : <span class="pull-right text-primary">{transfer_branch}</span></p>
                                                <p class="col-4"><?php echo e(__('Transfer Desciption')); ?> : <span class="pull-right text-primary">{transfer_description}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='employee_resignation'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee Name')); ?> : <span class="pull-right text-primary">{assign_user}</span></p>
                                                <p class="col-4"><?php echo e(__('Last Working Date')); ?> : <span class="pull-right text-primary">{resignation_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Resignation Date')); ?> : <span class="pull-right text-primary">{notice_date}</span></p>
                                            </div>
                                        <?php elseif($emailTemplate->slug=='employee_trip'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee ')); ?> : <span class="pull-right text-primary">{employee_trip_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Purpose of Trip')); ?> : <span class="pull-right text-primary">{purpose_of_visit}</span></p>
                                                <p class="col-4"><?php echo e(__('Start Date')); ?> : <span class="pull-right text-primary">{start_date}</span></p>
                                                <p class="col-4"><?php echo e(__('End Date')); ?> : <span class="pull-right text-primary">{end_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Country')); ?> : <span class="pull-right text-primary">{place_of_visit}</span></p>
                                                <p class="col-4"><?php echo e(__('Description')); ?> : <span class="pull-right text-primary">{trip_description}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='employee_promotion'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee')); ?> : <span class="pull-right text-primary">{employee_promotion_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Designation')); ?> : <span class="pull-right text-primary">{promotion_designation}</span></p>
                                                <p class="col-4"><?php echo e(__('Promotion Title')); ?> : <span class="pull-right text-primary">{promotion_title}</span></p>
                                                <p class="col-4"><?php echo e(__('Promotion Date')); ?> : <span class="pull-right text-primary">{promotion_date}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='employee_complaints'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee')); ?> : <span class="pull-right text-primary">{employee_complaints_name}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='employee_warning'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee')); ?> : <span class="pull-right text-primary">{employee_warning_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Subject')); ?> : <span class="pull-right text-primary">{warning_subject}</span></p>
                                                <p class="col-4"><?php echo e(__('Description')); ?> : <span class="pull-right text-primary">{warning_description}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='employee_termination'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee')); ?> : <span class="pull-right text-primary">{employee_termination_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Notice Date')); ?> : <span class="pull-right text-primary">{notice_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Termination Date')); ?> : <span class="pull-right text-primary">{termination_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Termination Type')); ?> : <span class="pull-right text-primary">{termination_type}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='leave_status'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('App Name')); ?> : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Company Name')); ?> : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4"><?php echo e(__('App Url')); ?> : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4"><?php echo e(__('Leave email')); ?> : <span class="pull-right text-primary">{leave_email}</span></p>
                                                <p class="col-4"><?php echo e(__('Leave Status')); ?> : <span class="pull-right text-primary">{leave_status}</span></p>
                                                <p class="col-4"><?php echo e(__('Employee')); ?> : <span class="pull-right text-primary">{leave_status_name}</span></p>
                                                <p class="col-4"><?php echo e(__('Leave Reason')); ?> : <span class="pull-right text-primary">{leave_reason}</span></p>
                                                <p class="col-4"><?php echo e(__('Leave Start Date')); ?> : <span class="pull-right text-primary">{leave_start_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Leave End Date')); ?> : <span class="pull-right text-primary">{leave_end_date}</span></p>
                                                <p class="col-4"><?php echo e(__(' Total Days')); ?> : <span class="pull-right text-primary">{total_leave_days}</span></p>
                                            </div>
                                            <?php elseif($emailTemplate->slug=='contract'): ?>
                                            <div class="row">
                                                
                                                <p class="col-4"><?php echo e(__('Contract Subject')); ?> : <span class="pull-right text-primary">{contract_subject}</span></p>
                                                <p class="col-4"><?php echo e(__('Contract Employee')); ?> : <span class="pull-right text-primary">{contract_employee}</span></p>
                                                <p class="col-4"><?php echo e(__('Contract Start Date')); ?> : <span class="pull-right text-primary">{contract_start_date}</span></p>
                                                <p class="col-4"><?php echo e(__('Contract End Date')); ?> : <span class="pull-right text-primary">{contract_end_date}</span></p>
                                            </div>
                                            <?php endif; ?>
                                    </div>
                                
                                </div>
                            </div>
                    </div>
                    
                    <?php echo e(Form::model($currEmailTempLang, array('route' => array('email_template.update', $currEmailTempLang->parent_id), 'method' => 'PUT'))); ?>

                        <div class="row">
                            <div class="form-group col-6">
                                <?php echo e(Form::label('subject', __('Subject'), ['class' => 'col-form-label text-dark'])); ?>

                                <?php echo e(Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-6">
                                <?php echo e(Form::label('from', __('From'), ['class' => 'col-form-label text-dark'])); ?>

                                <?php echo e(Form::text('from', $emailTemplate->from, ['class' => 'form-control font-style', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-12">
                                <?php echo e(Form::label('content',__('Email Message'),['class'=>'form-label text-dark'])); ?>

                                <?php echo e(Form::textarea('content',$currEmailTempLang->content,array('class'=>'pc-tinymce-2','required'=>'required'))); ?>

                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 text-end">
                            <?php echo e(Form::hidden('lang',null)); ?>

                            <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn btn-print-invoice  btn-primary m-r-10">
                        </div>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/email_templates/show.blade.php ENDPATH**/ ?>