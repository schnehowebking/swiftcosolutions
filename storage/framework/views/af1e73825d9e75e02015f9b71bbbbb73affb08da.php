<style>
    :root {
        --messengerColor: <?php echo e($messengerColor); ?>,
    }
/* NProgress background */
#nprogress .bar{
	background: <?php echo e($messengerColor); ?> !important;
}
#nprogress .peg {
    box-shadow: 0 0 10px <?php echo e($messengerColor); ?>, 0 0 5px <?php echo e($messengerColor); ?> !important;
}
#nprogress .spinner-icon {
  border-top-color: <?php echo e($messengerColor); ?> !important;
  border-left-color: <?php echo e($messengerColor); ?> !important;
}

.m-header svg{
    color: <?php echo e($messengerColor); ?>;
}

.m-list-active,
.m-list-active:hover,
.m-list-active:focus{
	background: <?php echo e($messengerColor); ?>;
}

.m-list-active b{
	background: #fff !important;
	color: <?php echo e($messengerColor); ?> !important;
}

.messenger-list-item td b{
    background: <?php echo e($messengerColor); ?>;
}

.messenger-infoView nav a{
    color: <?php echo e($messengerColor); ?>;
}

.messenger-infoView-btns a.default{
	color: <?php echo e($messengerColor); ?>;
}

.mc-sender p{
  background: <?php echo e($messengerColor); ?>;
}

.messenger-sendCard button svg{
    color: <?php echo e($messengerColor); ?>;
}

.messenger-listView-tabs a,
.messenger-listView-tabs a:hover,
.messenger-listView-tabs a:focus{
    color: <?php echo e($messengerColor); ?>;
}

.active-tab{
	border-bottom: 2px solid <?php echo e($messengerColor); ?>;
}

.lastMessageIndicator{
    color: <?php echo e($messengerColor); ?> !important;
}

.messenger-favorites div.avatar{
    box-shadow: 0px 0px 0px 2px <?php echo e($messengerColor); ?>;
}

.dark-mode-switch{
    color: <?php echo e($messengerColor); ?>;
}
.m-list-active .activeStatus{
    border-color: <?php echo e($messengerColor); ?> !important;
}

.messenger [type='text']:focus {
    outline: 1px solid <?php echo e($messengerColor); ?>;
    border-color: <?php echo e($messengerColor); ?> !important;
    border-color: <?php echo e($messengerColor); ?>;
    box-shadow: 0 0 2px <?php echo e($messengerColor); ?>;
}
</style>
<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/vendor/Chatify/layouts/messengerColor.blade.php ENDPATH**/ ?>