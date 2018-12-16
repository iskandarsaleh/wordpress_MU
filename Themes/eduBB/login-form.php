<div id="login">

<p>Log in below with your edublogs account: <small>[<a href="http://edublogs.org/wp-signup.php">Don't have an edublogs account? Grab a free one here!</a>]</small></p>

<form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php">

<?php _e('Username:'); ?> <input name="user_login" id="user_login" class="log-in" type="text" value="<?php echo attribute_escape( $_COOKIE[ bb_get_option( 'usercookie' ) ] ); ?>" />

<?php _e('Password:'); ?> <input name="password" id="password" class="log-in" type="password" />


<!--<p id="register">
<?php _e('Remember Me'); ?> <input name="remember" type="checkbox" id="remember" value="1" tabindex="3"<?php echo $remember_checked; ?> />
<?php printf(__('<a href="%1$s">Register</a>'), bb_get_option('uri').'register.php') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="bb-login.php">Forgot password?</a>
</p>-->

<input name="re" type="hidden" value="<?php global $re; echo $re; ?>" />

<?php wp_referer_field(); ?>

<input name="Submit" id="submit" class="sinput" type="submit" value="<?php echo attribute_escape( __('Login &raquo;') ); ?>" />

</form>

</div>