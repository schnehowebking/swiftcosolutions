<?php
// $logos = asset(Storage::url('uploads/logo/'));
$logos=\App\Models\Utility::get_file('uploads/logo/');

$company_logo = Utility::getValByName('company_logo');
$company_small_logo = Utility::getValByName('company_small_logo');
$users = \Auth::user();
$profile = asset(Storage::url('uploads/avatar/'));
$currantLang = $users->currentLanguage();
$logo = Utility::get_superadmin_logo();
$emailTemplate = App\Models\EmailTemplate::first();
$mode_setting = \App\Models\Utility::mode_layout();

?>
 <nav
    class="dash-sidebar light-sidebar <?php echo e(isset($mode_setting['is_sidebar_transperent']) && $mode_setting['is_sidebar_transperent'] == 'on' ? 'transprent-bg' : ''); ?>">
    <div class="navbar-wrapper">
        <div class="m-header main-logo">
           
            <a href="<?php echo e(route('home')); ?>" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="<?php echo e($logos . $logo); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                    class="logo logo-lg" style="height: 40px;" />
               
            </a>
        
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar">

                <!-- dashboard-->
                <?php if(\Auth::user()->type != 'company'): ?>
                 <li class="dash-item">
                    <a href="<?php echo e(route('home')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span><span
                            class="dash-mtext"><?php echo e(__('Dashboard')); ?></span></a>
                </li> 
                <?php endif; ?>
                <?php if(\Auth::user()->type == 'company'): ?>
                <li
                        class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'null' ? 'active dash-trigger' : ''); ?>">
                        <a href="#" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-home"></i></span><span
                                class="dash-mtext"><?php echo e(__('Dashboard')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu ">
                            <li class="dash-item <?php echo e(( Request::segment(1) == null   || Request::segment(1) == 'report') ? ' active dash-trigger' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('home')); ?>"><?php echo e(__('Overview')); ?></a>
                            </li>
                          
                            <?php if(Gate::check('Manage Report')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class=""><i
                                    class=""></i></span><span
                                class="dash-mtext"><?php echo e(__('Report')); ?></span><span
                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Report')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.income-expense')); ?>"><?php echo e(__('Income Vs Expense')); ?></a>
                                </li>

                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.monthly.attendance')); ?>"><?php echo e(__('Monthly Attendance')); ?></a>
                                </li>

                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.leave')); ?>"><?php echo e(__('Leave')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.account.statement')); ?>"><?php echo e(__('Account Statement')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.payroll')); ?>"><?php echo e(__('Payroll')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.timesheet')); ?>"><?php echo e(__('Timesheet')); ?></a>
                                </li>
                            <?php endif; ?>


                        </ul>
                    </li>
                <?php endif; ?>
                          

                        </ul>
                    </li>
                    <?php endif; ?>
                <!--dashboard-->

                <!-- user-->
                <?php if(\Auth::user()->type == 'super admin'): ?>
                    <li class="dash-item">
                        <a href="<?php echo e(route('user.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-user"></i></span><span
                                class="dash-mtext"><?php echo e(__('Company')); ?></span></a>
                    </li>
                <?php else: ?>
                    <?php if(Gate::check('Manage User') || Gate::check('Manage Role') || Gate::check('Manage Employee Profile') || Gate::check('Manage Employee Last Login')): ?>
                        <li class="dash-item dash-hasmenu">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-users"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Staff')); ?></span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage User')): ?>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('user.index')); ?>"><?php echo e(__('User')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Role')): ?>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Role')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Employee Profile')): ?>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('employee.profile')); ?>"><?php echo e(__('Employee Profile')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Employee Last Login')): ?>
                                    <li class="dash-item">
                                        <a class="dash-link"
                                            href="<?php echo e(route('lastlogin')); ?>"><?php echo e(__('Last Login')); ?></a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- user-->

                <!-- employee-->
                <?php if(Gate::check('Manage Employee')): ?>
                    <?php if(\Auth::user()->type == 'employee'): ?>
                        <?php
                            $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                        ?>
                        <li class="dash-item <?php echo e(Request::segment(1) == 'employee' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"
                                class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-user"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Employee')); ?></span></a>
                        </li>
                    <?php else: ?>
                        <li class="dash-item <?php echo e(Request::segment(1) == 'employee' ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('employee.index')); ?>" class="dash-link"><span
                                    class="dash-micon"><i class="ti ti-user"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Employee')); ?></span></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- employee-->

                <!-- payroll-->
                <?php if(Gate::check('Manage Set Salary') || Gate::check('Manage Pay Slip')): ?>
                    <li
                        class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'setsalary' ? 'dash-trigger active' : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-receipt"></i></span><span
                                class="dash-mtext"><?php echo e(__('Payroll')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu ">
                            <li class="dash-item <?php echo e(Request::segment(1) == 'setsalary' ? 'active' : '-'); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('setsalary.index')); ?>"><?php echo e(__('Set Salary')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('payslip.index')); ?>"><?php echo e(__('Payslip')); ?></a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
                <!-- payroll-->

                <?php if(\Auth::user()->type == 'employee'): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'setsalary' ? 'dash-trigger active' : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-receipt"></i></span><span
                                class="dash-mtext"><?php echo e(__('Payroll')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item <?php echo e(Request::segment(1) == 'setsalary' ? 'active' : '-'); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('setsalary.show', \Auth::user()->id)); ?>"><?php echo e(__('Set Salary')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('payslip.index')); ?>"><?php echo e(__('Payslip')); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- timesheet-->
                <?php if(Gate::check('Manage Attendance') || Gate::check('Manage Leave') || Gate::check('Manage TimeSheet')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-clock"></i></span><span
                                class="dash-mtext"><?php echo e(__('Timesheet')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage TimeSheet')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('timesheet.index')); ?>"><?php echo e(__('Timesheet')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Leave')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('leave.index')); ?>"><?php echo e(__('Manage Leave')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Attendance')): ?>
                                <li class="dash-item dash-hasmenu">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext"><?php echo e(__('Attendance')); ?></span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul class="dash-submenu">
                                        <li class="dash-item">
                                            <a class="dash-link"
                                                href="<?php echo e(route('attendanceemployee.index')); ?>"><?php echo e(__('Marked Attendance')); ?></a>
                                        </li>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Attendance')): ?>
                                            <li class="dash-item">
                                                <a class="dash-link"
                                                    href="<?php echo e(route('attendanceemployee.bulkattendance')); ?>"><?php echo e(__('Bulk Attendance')); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!--timesheet-->

                <!-- performance-->
                <?php if(Gate::check('Manage Indicator') || Gate::check('Manage Appraisal') || Gate::check('Manage Goal Tracking')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-3d-cube-sphere"></i></span><span
                                class="dash-mtext"><?php echo e(__('Performance')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Indicator')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('indicator.index')); ?>"><?php echo e(__('Indicator')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Appraisal')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('appraisal.index')); ?>"><?php echo e(__('Appraisal')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Goal Tracking')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('goaltracking.index')); ?>"><?php echo e(__('Goal Tracking')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!--performance-->

                <!--fianance-->
                <?php if(Gate::check('Manage Account List') || Gate::check('Manage Payee') || Gate::check('Manage Payer') || Gate::check('Manage Deposit') || Gate::check('Manage Expense') || Gate::check('Manage Transfer Balance')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-wallet"></i></span><span
                                class="dash-mtext"><?php echo e(__('Finance')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Account List')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('accountlist.index')); ?>"><?php echo e(__('Account List')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Balance Account List')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('accountbalance')); ?>"><?php echo e(__('Account Balance')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payee')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('payees.index')); ?>"><?php echo e(__('Payees')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payer')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('payer.index')); ?>"><?php echo e(__('Payers')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Deposit')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('deposit.index')); ?>"><?php echo e(__('Deposit')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Expense')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('expense.index')); ?>"><?php echo e(__('Expense')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Transfer Balance')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('transferbalance.index')); ?>"><?php echo e(__('Transfer Balance')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- fianance-->

                <!--trainning-->
                <?php if(Gate::check('Manage Trainer') || Gate::check('Manage Training')): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'training' ? 'dash-trigger active' : ''); ?>">
                        <a href="#!" class="dash-link "><span class="dash-micon"><i
                                    class="ti ti-school"></i></span><span
                                class="dash-mtext"><?php echo e(__('Training')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Training')): ?>
                                <li class="dash-item <?php echo e(Request::segment(1) == 'training' ? ' active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('training.index')); ?>"><?php echo e(__('Training List')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Trainer')): ?>
                                <li class="dash-item ">
                                    <a class="dash-link"
                                        href="<?php echo e(route('trainer.index')); ?>"><?php echo e(__('Trainer')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- tranning-->


                <!-- HR-->
                <?php if(Gate::check('Manage Awards') || Gate::check('Manage Transfer') || Gate::check('Manage Resignation') || Gate::check('Manage Travels') || Gate::check('Manage Promotion') || Gate::check('Manage Complaint') || Gate::check('Manage Warning') || Gate::check('Manage Termination') || Gate::check('Manage Announcement') || Gate::check('Manage Holiday')): ?>
                    <li
                        class="dash-item dash-hasmenu <?php echo e(Request::segment(1) == 'holiday' ? 'dash-trigger active' : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-user-plus"></i></span><span
                                class="dash-mtext"><?php echo e(__('HR Admin Setup')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item <?php echo e(Request::segment(1) == 'award' ? 'active' : ''); ?>">
                                <a class="dash-link" href="<?php echo e(route('award.index')); ?>"><?php echo e(__('Award')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('transfer.index')); ?>"><?php echo e(__('Transfer')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('resignation.index')); ?>"><?php echo e(__('Resignation')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('travel.index')); ?>"><?php echo e(__('Trip')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('promotion.index')); ?>"><?php echo e(__('Promotion')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('complaint.index')); ?>"><?php echo e(__('Complaints')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('warning.index')); ?>"><?php echo e(__('Warning')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('termination.index')); ?>"><?php echo e(__('Termination')); ?></a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link"
                                    href="<?php echo e(route('announcement.index')); ?>"><?php echo e(__('Announcement')); ?></a>
                            </li>
                            <li class="dash-item <?php echo e(Request::segment(1) == 'holiday' ? ' active' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('holiday.index')); ?>"><?php echo e(__('Holidays')); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- HR-->

               <!-- recruitment-->
                <?php if(Gate::check('Manage Job') || Gate::check('Manage Job Application') || Gate::check('Manage Job OnBoard') || Gate::check('Manage Custom Question') || Gate::check('Manage Interview Schedule') || Gate::check('Manage Career')): ?>
                    <li
                        class="dash-item dash-hasmenu  <?php echo e(Request::segment(1) == 'job' || Request::segment(1) == 'job-application' ? 'dash-trigger active' : ''); ?> ">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-license"></i></span><span
                                class="dash-mtext"><?php echo e(__('Recruitment')); ?></span><span
                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job')): ?>
                                <li class="dash-item <?php echo e(Request::segment(1) == 'job' ? 'active' : '-'); ?>">
                                    <a class="dash-link" href="<?php echo e(route('job.index')); ?>"><?php echo e(__('Jobs')); ?></a>
                                </li>
                            <?php endif; ?>
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job')): ?>
                                <li class="dash-item <?php echo e(Request::segment(1) == 'job' ? 'active' : '-'); ?>">
                                    <a class="dash-link" href="<?php echo e(route('job.create')); ?>"><?php echo e(__('Job Create')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job Application')): ?>
                            <li class="dash-item <?php echo e((request()->is('job-application*') ? 'active' : '')); ?>">
                                <a class="dash-link" href="<?php echo e(route('job-application.index')); ?>"><?php echo e(__('Job Application')); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job Application')): ?>

                            <li class="dash-item <?php echo e((request()->is('candidates-job-applications') ? 'active' : '')); ?>">
                                <a class="dash-link" href="<?php echo e(route('job.application.candidate')); ?>"><?php echo e(__('Job Candidate')); ?></a>
                            </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job OnBoard')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('job.on.board')); ?>"><?php echo e(__('Job On-Boarding')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Custom Question')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('custom-question.index')); ?>"><?php echo e(__('Custom Question')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Interview Schedule')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('interview-schedule.index')); ?>"><?php echo e(__('Interview Schedule')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Career')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('career', [\Auth::user()->creatorId(), 'en'])); ?>"
                                        target="_blank"><?php echo e(__('Career')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- recruitment-->
                 <!--contract-->
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Contracts')): ?>
                 <li class="dash-item <?php echo e((Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show') ? 'active' : ''); ?>">
                     <a href="<?php echo e(route('contract.index')); ?>" class="dash-link"><span class="dash-micon"><i class="ti ti-device-floppy"></i></span><span class="dash-mtext"><?php echo e(__('Contracts')); ?></span></a>
                 </li>
                 <?php endif; ?>
                 
                
               

                <!-- ticket-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Ticket')): ?>
                    <li class="dash-item <?php echo e(Request::segment(1) == 'ticket' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('ticket.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-ticket"></i></span><span
                                class="dash-mtext"><?php echo e(__('Ticket')); ?></span></a>
                    </li>
                <?php endif; ?>

                <!-- Event-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Event')): ?>
                    <li class="dash-item">
                        <a href="<?php echo e(route('event.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-calendar-event"></i></span><span
                                class="dash-mtext"><?php echo e(__('Event')); ?></span></a>
                    </li>
                <?php endif; ?>


                <!--meeting-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Meeting')): ?>
                    <li class="dash-item <?php echo e(Request::segment(1) == 'meeting' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('meeting.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-calendar-time"></i></span><span
                                class="dash-mtext"><?php echo e(__('Meeting')); ?></span></a>
                    </li>
                <?php endif; ?>


                <!-- Zoom meeting-->
                <?php if(\Auth::user()->type != 'super admin'): ?>
                    <li class="dash-item <?php echo e(Request::segment(1) == 'zoommeeting' ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zoom-meeting.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-video"></i></span><span
                                class="dash-mtext"><?php echo e(__('Zoom Meeting')); ?></span></a>
                    </li>
                <?php endif; ?>

                <!-- assets-->
                <?php if(Gate::check('Manage Assets')): ?>
                    <li class="dash-item">
                        <a href="<?php echo e(route('account-assets.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-medical-cross"></i></span><span
                                class="dash-mtext"><?php echo e(__('Assets')); ?></span></a>
                    </li>
                <?php endif; ?>


                <!-- document-->
                <?php if(Gate::check('Manage Document')): ?>
                    <li class="dash-item">
                        <a href="<?php echo e(route('document-upload.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-file"></i></span><span
                                class="dash-mtext"><?php echo e(__('Document')); ?></span></a>
                    </li>
                <?php endif; ?>
                
                
                <?php if(\Auth::user()->type == 'company'): ?>
                    <li class="dash-item <?php echo e((Request::route()->getName() == 'email_template.show' || Request::segment(1) == 'email_template_lang' || Request::route()->getName() == 'manageemail.lang') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('manage.email.language',[$emailTemplate ->id,\Auth::user()->lang])); ?>" class="dash-link"><span class="dash-micon"><i class="ti ti-template"></i></span><span class="dash-mtext"><?php echo e(__('Email Templates')); ?></span></a>
                    </li>
                <?php endif; ?>
                <!--company policy-->



                <?php if(Gate::check('Manage Company Policy')): ?>
                    <li class="dash-item">
                        <a href="<?php echo e(route('company-policy.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-pray"></i></span><span
                                class="dash-mtext"><?php echo e(__('Company Policy')); ?></span></a>
                    </li>
                <?php endif; ?>
                     <!--chats-->
                <?php if(\Auth::user()->type != 'super admin'): ?>
                <li class="dash-item">
                    <a href="<?php echo e(url('chats')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-messages"></i></span><span
                            class="dash-mtext"><?php echo e(__('Messenger')); ?></span></a>
                </li>
            <?php endif; ?>
               
                <?php if(\Auth::user()->type == 'super admin'): ?>
                    <li class="dash-item ">
                        <a href="<?php echo e(route('plan_request.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i
                                    class="ti ti-arrow-down-right-circle"></i></span><span
                                class="dash-mtext"><?php echo e(__('Plan Request')); ?></span></a>

                    </li>
                <?php endif; ?>


                <?php if(Auth::user()->type == 'super admin'): ?>
                    <?php if(Gate::check('manage coupon')): ?>
                        <li class="dash-item ">
                            <a href="<?php echo e(route('coupons.index')); ?>" class="dash-link"><span
                                    class="dash-micon"><i class="ti ti-gift"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Coupon')); ?></span></a>

                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(\Auth::user()->type == 'super admin'): ?>
                    <?php if(Gate::check('Manage Order')): ?>
                        <li class="dash-item ">
                            <a href="<?php echo e(route('order.index')); ?>"
                                class="dash-link <?php echo e(request()->is('orders*') ? 'active' : ''); ?>"><span
                                    class="dash-micon"><i class="ti ti-shopping-cart"></i></span><span
                                    class="dash-mtext"><?php echo e(__('Order')); ?></span></a>

                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!--report-->
                <!-- <?php if(Gate::check('Manage Report')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-list"></i></span><span
                                class="dash-mtext"><?php echo e(__('Report')); ?></span><span
                                class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Report')): ?>
                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.income-expense')); ?>"><?php echo e(__('Income Vs Expense')); ?></a>
                                </li>

                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.monthly.attendance')); ?>"><?php echo e(__('Monthly Attendance')); ?></a>
                                </li>

                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.leave')); ?>"><?php echo e(__('Leave')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.account.statement')); ?>"><?php echo e(__('Account Statement')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.payroll')); ?>"><?php echo e(__('Payroll')); ?></a>
                                </li>


                                <li class="dash-item">
                                    <a class="dash-link"
                                        href="<?php echo e(route('report.timesheet')); ?>"><?php echo e(__('Timesheet')); ?></a>
                                </li>
                            <?php endif; ?>


                        </ul>
                    </li>
                <?php endif; ?> -->


                <!--constant-->
                <?php if(Gate::check('Manage Department') ||
                    Gate::check('Manage Designation') ||
                    Gate::check('Manage Document Type') ||
                    Gate::check('Manage Branch') ||
                    Gate::check('Manage Award Type') ||
                    Gate::check('Manage Termination Types') ||
                    Gate::check('Manage Payslip Type') ||
                    Gate::check('Manage Allowance Option') ||
                    Gate::check('Manage Loan Options') ||
                    Gate::check('Manage Deduction Options') ||
                    Gate::check('Manage Expense Type') ||
                    Gate::check('Manage Income Type') ||
                    Gate::check('Manage
                                             Payment Type') ||
                    Gate::check('Manage Leave Type') ||
                    Gate::check('Manage Training Type') ||
                    Gate::check('Manage Job Category') ||
                    Gate::check('Manage Job Stage')): ?>
                    <li class="dash-item dash-hasmenu">
                        <a href="<?php echo e(route('branch.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext"><?php echo e(__('HRM System Setup')); ?></span></a>
                        </li>
                        <!-- <ul class="dash-submenu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Branch')): ?>
                                <li class="dash-item <?php echo e(request()->is('branch*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('branch.index')); ?>"><?php echo e(__('Branch')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Department')): ?>
                                <li class="dash-item <?php echo e(request()->is('department*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('department.index')); ?>"><?php echo e(__('Department')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Designation')): ?>
                                <li class="dash-item <?php echo e(request()->is('designation*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('designation.index')); ?>"><?php echo e(__('Designation')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Document Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('document*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('document.index')); ?>"><?php echo e(__('Document Type')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Award Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('awardtype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('awardtype.index')); ?>"><?php echo e(__('Award Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Termination Types')): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('terminationtype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('terminationtype.index')); ?>"><?php echo e(__('Termination Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payslip Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('paysliptype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('paysliptype.index')); ?>"><?php echo e(__('Payslip Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Allowance Option')): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('allowanceoption*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('allowanceoption.index')); ?>"><?php echo e(__('Allowance Option')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Loan Option')): ?>
                                <li class="dash-item <?php echo e(request()->is('loanoption*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('loanoption.index')); ?>"><?php echo e(__('Loan Option')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Deduction Option')): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('deductionoption*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('deductionoption.index')); ?>"><?php echo e(__('Deduction Option')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Expense Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('expensetype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('expensetype.index')); ?>"><?php echo e(__('Expense Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Income Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('incometype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('incometype.index')); ?>"><?php echo e(__('Income Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Payment Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('paymenttype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('paymenttype.index')); ?>"><?php echo e(__('Payment Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Leave Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('leavetype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('leavetype.index')); ?>"><?php echo e(__('Leave Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Termination Type')): ?>
                                <li
                                    class="dash-item <?php echo e(request()->is('terminationtype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('terminationtype.index')); ?>"><?php echo e(__('Termination Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Goal Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('goaltype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('goaltype.index')); ?>"><?php echo e(__('Goal Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Training Type')): ?>
                                <li class="dash-item <?php echo e(request()->is('trainingtype*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('trainingtype.index')); ?>"><?php echo e(__('Training Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job Category')): ?>
                                <li class="dash-item <?php echo e(request()->is('job-category*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('job-category.index')); ?>"><?php echo e(__('Job Category')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Job Stage')): ?>
                                <li class="dash-item <?php echo e(request()->is('job-stage*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('job-stage.index')); ?>"><?php echo e(__('Job Stage')); ?></a>
                                </li>
                            <?php endif; ?>

                            <li
                                class="dash-item <?php echo e(request()->is('performanceType*') ? 'active' : ''); ?>">
                                <a class="dash-link"
                                    href="<?php echo e(route('performanceType.index')); ?>"><?php echo e(__('Performance Type')); ?></a>
                            </li>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manage Competencies')): ?>
                                <li class="dash-item <?php echo e(request()->is('competencies*') ? 'active' : ''); ?>">

                                    <a class="dash-link"
                                        href="<?php echo e(route('competencies.index')); ?>"><?php echo e(__('Competencies')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li> -->
                <?php endif; ?>
                <!--constant-->


                <?php if(Gate::check('Manage Company Settings') || Gate::check('Manage System Settings')): ?>
                    <li class="dash-item ">
                        <a href="<?php echo e(route('settings.index')); ?>" class="dash-link"><span
                                class="dash-micon"><i class="ti ti-settings"></i></span><span
                                class="dash-mtext"><?php echo e(__('System Setting')); ?></span></a>

                    </li>
                <?php endif; ?>

</ul>

</div>
</div>
</nav>
<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/partial/Admin/menu.blade.php ENDPATH**/ ?>