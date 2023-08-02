<?php
    use App\Models\Utility;
    $users = \Auth::user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
    // $profile = asset(Storage::url('uploads/avatar/'));
    $profile = \App\Models\Utility::get_file('uploads/avatar');

    $mode_setting = \App\Models\Utility::mode_layout();
?>
<header
    class="dash-header  <?php echo e(isset($mode_setting['is_sidebar_transperent']) && $mode_setting['is_sidebar_transperent'] == 'on' ? 'transprent-bg' : ''); ?>">
    <div class="header-wrapper">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#!" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="theme-avtar">
                            <img alt="#"
                                src="<?php echo e(!empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png'); ?>"
                                class="header-avtar" style="width: 100%">
                        </span>
                        <span class="hide-mob ms-2"> <?php echo e(Auth::user()->name); ?>

                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="<?php echo e(route('profile')); ?>" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span><?php echo e(__('My Profile')); ?></span>
                        </a>

                        <a href="<?php echo e(route('logout')); ?>" class="dropdown-item"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="ti ti-power"></i>
                            <span><?php echo e(__('Logout')); ?></span>
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?></form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">

                <?php
                    $unseenCounter = App\Models\ChMessage::where('to_id', Auth::user()->id)
                        ->where('seen', 0)
                        ->count();
                ?>

                
                <?php
                    $unreadCounter = App\Models\ChMessage::where('to_id', Auth::user()->id)
                        ->where('seen', 0)
                        ->count();
                ?>

                <?php if(Auth::user()->type != 'super admin'): ?>
                    <li class="dash-h-item">
                        <a class="dash-head-link me-0" href="<?php echo e(url('/chats')); ?>">
                            <i class="ti ti-message-circle"></i>
                            <span
                                class="bg-danger dash-h-badge message-counter custom_messanger_counter"><?php echo e($unseenCounter); ?><span
                                    class="sr-only"></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(\Auth::user()->type != 'super admin'): ?>
                    <li class="dropdown dash-h-item drp-notification">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0 " data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false" id="msg-btn">
                            <i class="ti ti-message-2"></i>
                            <span
                                class="bg-danger dash-h-badge message-counter custom_messanger_counter"><?php echo e($unreadCounter); ?>

                                <span class="sr-only"></span>
                            </span>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                            <div class="noti-header">
                                <h5 class="m-0"><?php echo e(__('Messages')); ?></h5>
                                <a href="#"
                                    class="dash-head-link mark_all_as_read_message"><?php echo e(__('Clear All')); ?></a>
                            </div>

                            <div class="noti-body dropdown-list-message-msg">
                                <div style="display: flex;">
                                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                                    
                                    <div class="count-listOfContacts">
                                    </div>
                                </div>
                            </div>
                            <div class="noti-footer">
                                <div class="d-grid">
                                    <a href="<?php echo e(route('chats')); ?>"
                                        class="btn dash-head-link justify-content-center text-primary mx-0">View all</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <?php
                    $currantLang = basename(\App::getLocale());
                ?>
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage">
                        <i class="ti ti-world nocolor"></i>
                        <span class="drp-text hide-mob"><?php echo e(Str::upper($currantLang)); ?></span>
                        <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                        <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('change.language', $lang)); ?>"
                                class="dropdown-item <?php echo e(basename(App::getLocale()) == $lang ? 'text-danger' : ''); ?>"><?php echo e(Str::upper($lang)); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Auth::user()->type == 'company'): ?>
                            <div class="dropdown-divider m-0"></div>
                            <a href="<?php echo e(route('manage.language', [basename(App::getLocale())])); ?>"
                                class="dropdown-item text-primary"><?php echo e(__('Manage Language')); ?></a>
                        <?php endif; ?>
                        
                    </div>
                </li>

            </ul>
        </div>
    </div>
</header>

<?php $__env->startPush('scripts'); ?>
    
    <script>
        // console.log($('#msg-btn'));
        $('#msg-btn').click(function() {
            let contactsPage = 1;
            let contactsLoading = false;
            let noMoreContacts = false;
            $.ajax({
                url: url + "/getContacts",
                method: "GET",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    page: contactsPage,
                    type: 'custom',
                },
                dataType: "JSON",
                success: (data) => {

                    if (contactsPage < 2) {
                        $(".count-listOfContacts").html(data.contacts);

                    } else {
                        $(".count-listOfContacts").append(data.contacts);
                    }
                    $('.count-listOfContacts').find('.messenger-list-item').each(function(e) {
                        $('.noti-body .activeStatus').remove()
                        $('.noti-body .avatar').remove()
                        $(this).find('span').remove()
                        $(this).find('p').addClass("d-inline")
                        $(this).find('b').css({
                            "position": "absolute",
                            "right": "50px"
                        });
                        $(this).find('tr').remove('td')

                    })
                },
                error: (error) => {
                    setContactsLoading(false);
                    console.error(error);
                },
            });
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xampp82\htdocs\orondo\main\backup08.07.2023\resources\views/partial/Admin/header.blade.php ENDPATH**/ ?>