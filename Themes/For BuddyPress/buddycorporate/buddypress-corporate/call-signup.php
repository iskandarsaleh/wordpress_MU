<?php
$tn_buddycorp_call_signup_text = get_option('tn_buddycorp_call_signup_text');
$tn_buddycorp_call_signup_button_text = get_option('tn_buddycorp_call_signup_button_text');
?>


<div id="call-action">
<p>
<?php
if($tn_buddycorp_call_signup_text == ''){ ?>
Welcome to your BuddyPress Corporate theme!<br />
<span>Change or remove the text here using the <a href="wp-admin/themes.php?page=functions.php">theme options</a></span>
<?php } else {  ?>
 <?php echo stripslashes($tn_buddycorp_call_signup_text); ?>
<?php } ?>
</p>


<?php if ( !is_user_logged_in() ) { ?>
<div class="bpc-button">
<?php if($bp_existed == 'true') { ?> <a href="<?php echo get_settings('home'); ?>/register"><?php } else { ?><a href="<?php echo get_settings('siteurl'); ?>/wp-login.php?action=register"><?php } ?>
<?php
if($tn_buddycorp_call_signup_button_text == ''){ ?>
Join Us Here
<?php } else { ?>
<?php echo stripslashes($tn_buddycorp_call_signup_button_text); ?>
<?php } ?>
</a>
</div>
<?php } ?>

</div>
