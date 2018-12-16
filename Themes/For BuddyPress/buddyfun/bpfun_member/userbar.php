<?php
/*
 * /userbar.php
 * This is the top level navigation in the theme. It displays the nav links for 
 * each component. If there is no user logged in, it will display a small login form.
 *
 * Loaded on URL: All URLs
 */
?>

<div id="userbar">
	
<?php do_action( 'bp_user_bar_before' ) ?>

<?php if ( is_user_logged_in() ) : ?>


<?php bp_login_bar() ?>


<ul id="bp-nav">
<?php bp_get_nav() ?>
</ul>


<?php else : ?>


<img src="<?php echo BP_PLUGIN_URL . '/bp-core/images/mystery-man.jpg' ?>" alt="No User" width="20" height="20" />
<p><?php _e( 'You must log in to access your account.', 'buddypress' ) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><a href="<?php echo get_settings('home'); ?>/wp-login.php?redirect_to=<?php echo get_settings('home'); ?>"><?php _e( 'login here', 'buddypress' ) ?></a><?php _e( ' or ', 'buddypress' ) ?><a href="<?php echo get_settings('home'); ?>/register"><?php _e( 'signup here', 'buddypress' ) ?></a></small> </p>


<?php endif; ?>

	
<?php do_action( 'bp_user_bar_after' ) ?>
	

	
</div>