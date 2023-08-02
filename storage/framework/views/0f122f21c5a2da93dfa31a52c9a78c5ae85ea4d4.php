<?php
$profile=\App\Models\Utility::get_file('/'.config('chatify.user_avatar.folder'));    

$company_favicon = Utility::getValByName('company_favicon');

$dark_mode = Utility::getValByName('dark_mode');

$setting = App\Models\Utility::colorset();
$mode_setting = App\Models\Utility::mode_layout();
$color = 'theme-3';
if (!empty($mode_setting['theme_color'])) {
    $color = $mode_setting['theme_color'];
}
?>



<?php if($get == 'saved'): ?>
    <table class="messenger-list-item m-li-divider" data-contact="<?php echo e(Auth::user()->id); ?>">
        <tr data-action="0">
            
            <td width="100%">
            <div class="avatar av-m" style="background-color: #d9efff; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <span class="far fa-bookmark" style="font-size: 22px; color: #68a5ff;"></span>
            </div>
            </td>
            
            <td  style="position: relative" width="100%">
                <p data-id="<?php echo e(Auth::user()->id); ?>" data-type="user" style="text-align: start">Saved Messages <span>You</span></p>
                <span style="justify-content: left; display:flex;"> Save messages secretly</span>
            </td>
        </tr>
    </table>
<?php endif; ?>


<?php if($get == 'users'): ?>
<table class="messenger-list-item" data-contact="<?php echo e($user->id); ?>">
    <tr data-action="0">
        
        <td style="position: relative">
            <?php if($user->active_status): ?>
                <span class="activeStatus"></span>
            <?php endif; ?>
          
            <?php if(!empty($user->avatar)): ?>
            <div class="avatar av-m" style="background-image: url('<?php echo e($user->avatar); ?>');"></div>
        <?php else: ?>
            <div class="avatar av-m" style="background-image: url('<?php echo e($profile.'/avatar.png'); ?>');"></div>
        <?php endif; ?>
        </td>
        
        <td width="100%">
        <p data-id="<?php echo e($user->id); ?>" data-type="user" style="text-align: start">
            <?php echo e(strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name); ?>

            <span><?php echo e($lastMessage->created_at->diffForHumans()); ?></span></p>
        <span style="justify-content: left; display:flex;">
            
            <?php echo $lastMessage->from_id == Auth::user()->id
                ? '<span class="lastMessageIndicator">You :</span>'
                : ''; ?>

            
            <?php if($lastMessage->attachment == null): ?>
            <?php echo strlen($lastMessage->body) > 30
                ? trim(substr($lastMessage->body, 0, 30)).'..'
                : $lastMessage->body; ?>

            <?php else: ?>
            <span class="fas fa-file"></span> Attachment
            <?php endif; ?>
        </span>
        
            <?php echo $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : ''; ?>

        </td>

    </tr>
</table>
<?php endif; ?>


<?php if($get == 'search_item'): ?>
<table class="messenger-list-item" data-contact="<?php echo e($user->id); ?>">
    <tr data-action="0">
        
        <td>
            <?php if( !empty($user->avatar) ): ?>
            <div class="avatar av-m" style="background-image: url('<?php echo e($user->avatar); ?>');"></div>
            <?php else: ?>
                <div class="avatar av-m" style="background-image: url('<?php echo e($profile.'/avatar.png'); ?>');"></div>
            <?php endif; ?>
        </td>
        
        <td>
            <p data-id="<?php echo e($user->id); ?>" data-type="user">
            <?php echo e(strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name); ?>

        </td>

    </tr>
</table>
<?php endif; ?>


<?php if($get == 'sharedPhoto'): ?>
<div class="shared-photo chat-image" style="background-image: url('<?php echo e($image); ?>')"></div>
<?php endif; ?>


<?php /**PATH /home/swifrmnh/hrm.swiftcosolutions.com/resources/views/vendor/Chatify/layouts/listItem.blade.php ENDPATH**/ ?>