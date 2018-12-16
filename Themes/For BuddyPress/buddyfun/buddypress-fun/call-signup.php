<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="call-action">

<?php
$tn_buddyfun_call_signup_text = get_option('tn_buddyfun_call_signup_text');
$tn_buddyfun_call_signup_button_text = get_option('tn_buddyfun_call_signup_button_text');
?>

<div class="call-join">
<?php
if($tn_buddyfun_call_signup_text == ''){ ?>
Welcome to your BuddyPress Fun theme!<br />
<small>Change or remove the text here using the theme options</small>
<?php } else {  ?>
<?php echo stripslashes($tn_buddyfun_call_signup_text); ?>
<?php } ?>
</div>

<?php if ( !is_user_logged_in() ) { ?>
<div class="call-button">
<p><?php if($bp_existed == 'true') { ?><a href="<?php echo get_settings('home'); ?>/register"><?php } else { ?><a href="<?php echo get_settings('siteurl'); ?>/wp-login.php?action=register"><?php } ?>
<?php
if($tn_buddyfun_call_signup_button_text == ''){ ?>
Join Us Here
<?php } else { ?>
<?php echo stripslashes($tn_buddyfun_call_signup_button_text); ?>
<?php } ?>
</a></p>
</div>
<?php } ?>

</div>