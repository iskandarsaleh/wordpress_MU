<div id="header">

<?php
$tn_buddycom_call_signup_text = get_option('tn_buddycom_call_signup_text');
$tn_buddycom_call_signup_button_text = get_option('tn_buddycom_call_signup_button_text');
?>

<div id="intro-text">
<?php
if($tn_buddycom_call_signup_text == ''){ ?>
<h2>Welcome to the BuddyPress Community Theme</h2>
<span>Simply change this text in your theme options</span>
<?php } else {  ?>
<?php echo stripslashes($tn_buddycom_call_signup_text); ?>
<?php } ?>
</div>

<?php if (!is_user_logged_in() ) { ?>
<div id="signup-button"><a href="<?php echo get_settings('home'); ?>/register">
<?php
if($tn_buddycom_call_signup_button_text == ''){ ?>
Join Us Here
<?php } else { ?>
<?php echo stripslashes($tn_buddycom_call_signup_button_text); ?>
<?php } ?>
</a></div>
<?php } else { ?>
<?php bp_login_bar() ?>
<?php } ?>
</div>