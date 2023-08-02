<!DOCTYPE html>
<?php
$logos=\App\Models\Utility::get_file('uploads/logo/');

$logo = Utility::get_superadmin_logo();
$company_favicon = Utility::getValByName('company_favicon');

$dark_mode = Utility::getValByName('dark_mode');
$theme_color = Utility::getValByName('theme_color');
$SITE_RTL=env('SITE_RTL');

$setting = App\Models\Utility::colorset();
$mode_setting = App\Models\Utility::mode_layout();
$color = 'theme-3';
if (!empty($mode_setting['theme_color'])) {
    $color = $mode_setting['theme_color'];
}
?>
<html lang="en">
<html dir="<?php echo e(env('SITE_RTL') == 'on' ? 'rtl' : ''); ?>">


<head>

    <title>
        <?php echo e(Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'HRMGo')); ?>

        - <?php echo $__env->yieldContent('page-title'); ?></title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(asset(Storage::url('uploads/logo')) . '/favicon.png'); ?>" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/stylesheet.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <!-- vendor css -->

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">


    <?php if(env('SITE_RTL') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
     <?php if(isset($mode_setting['dark_mode']) && $mode_setting['dark_mode'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <?php endif; ?>
</head>

<body class="<?php echo e($color); ?>">
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">
                    <a class="navbar-brand" href="#">
                        <img src="<?php echo e($logos . $logo); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                            class="logo logo-lg" />
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#"><?php echo e(__('Support')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo e(__('Terms')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo e(__('Privacy')); ?></a>
                            </li>
                            <li class="nav-item">
                                <?php echo $__env->yieldContent('language-bar'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center text-start">
                    <?php echo $__env->yieldContent('content'); ?>

                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <?php echo e(__('Copyright')); ?> &copy;
                            <?php echo e(Utility::getValByName('footer_text') ? Utility::getValByName('footer_text') : config('app.name', 'LeadGo')); ?>

                            <?php echo e(date('Y')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/vendor-all.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script>
        feather.replace();
    </script>

    <input type="checkbox" class="d-none" id="cust-theme-bg"
        <?php echo e(Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : ''); ?> />
    <input type="checkbox" class="d-none" id="cust-darklayout"
        <?php echo e(Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : ''); ?> />

    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    <script>
    var toster_pos="<?php echo e($SITE_RTL =='on' ?'left' : 'right'); ?>";
    </script>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->yieldPushContent('custom-scripts'); ?>

    <?php if($message = Session::get('success')): ?>
        <script>
            show_toastr('Success', '<?php echo $message; ?>', 'success');
        </script>
    <?php endif; ?>
    <?php if($message = Session::get('error')): ?>
        <script>
            show_toastr('Error', '<?php echo $message; ?>', 'error');
        </script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/layouts/auth.blade.php ENDPATH**/ ?>