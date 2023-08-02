<script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
<script >
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher("<?php echo e(config('chatify.pusher.key')); ?>", {
    encrypted: true,
    cluster: "<?php echo e(config('chatify.pusher.options.cluster')); ?>",
    authEndpoint: '<?php echo e(route("pusher.auth")); ?>',
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });

    // Bellow are all the methods/variables that using php to assign globally.
    const allowedImages = <?php echo json_encode(config('chatify.attachments.allowed_images')); ?> || [];
    const allowedFiles = <?php echo json_encode(config('chatify.attachments.allowed_files')); ?> || [];
    const getAllowedExtensions = [...allowedImages, ...allowedFiles];
    const getMaxUploadSize = <?php echo e(Chatify::getMaxUploadSize()); ?>;
</script>
<script src="<?php echo e(asset('js/chatify/code.js')); ?>"></script>
<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/vendor/Chatify/layouts/footerLinks.blade.php ENDPATH**/ ?>