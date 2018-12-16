<?php bb_get_header(); ?>

<h3 class="bbcrumb">
<a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a><?php bb_forum_bread_crumb(); ?><?php forum_pages(); ?>
</h3>

<h2><?php isset($_POST['user_login']) ? _e('Log in Failed') : _e('Log in') ; ?></h2>

<div id="login">

<form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php">

<?php if ( $user_exists ) : ?>
<?php _e('Username:'); ?> <input name="user_login" id="user_login" class="log-in" type="text"  value="<?php echo $user_login; ?>" />
<?php _e('Password:'); ?> <input name="password" id="password" class="log-in" type="text" /><br /><?php _e('Incorrect password'); ?>

<?php elseif ( isset($_POST['user_login']) ) : ?>

<?php _e('Username:'); ?> <input name="user_login" id="user_login" class="log-in" type="text"  value="<?php echo $user_login; ?>" />

<?php _e('Password:'); ?> <input name="password" id="password" class="log-in" type="text" />

<p><?php _e('This username does not exist.'); ?> <a href="<?php bb_option('uri'); ?>register.php?user=<?php echo $user_login; ?>"><?php _e('Register it?'); ?></a>
</p>

<?php else : ?>

<?php _e('Username:'); ?> <input name="user_login" id="user_login" class="log-in" type="text" />
<?php _e('Password:'); ?> <input name="password" id="password" class="log-in" type="text" />

<?php endif; ?>

<input name="re" type="hidden" value="<?php echo $re; ?>" />

<input name="Submit" id="submit" class="sinput" type="submit" value="<?php echo attribute_escape( isset($_POST['user_login']) ? __('Try Again &raquo;'): __('Log in &raquo;') ); ?>" />

</form>



<?php if ( $user_exists ) : ?>

<form method="post" action="<?php bb_option('uri'); ?>bb-reset-password.php">

<p><?php _e('If you would like to recover the password for this account, you may use the following button to start the recovery process:'); ?></p>

<input name="user_login" type="hidden" value="<?php echo $user_login; ?>" />

<input type="submit" class="sinput" value="<?php echo attribute_escape( __('Recover Password &raquo;') ); ?>" />

</form>

<?php endif; ?>

</div>

<?php bb_get_footer(); ?>