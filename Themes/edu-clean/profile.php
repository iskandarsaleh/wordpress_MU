<div id="top-right-panel">

<?php

  global $user_ID, $user_identity;
  get_currentuserinfo();
  if (!$user_ID):

?>

<form name="loginform" action="<?php echo get_settings('siteurl'); ?>/wp-login.php" method="post">

      <h3><?php _e('Log in'); ?></h3>

      <label><?php _e('Username:'); ?></label>
      <p><input name="log" id="user_login" class="inbox" value=""/></p>

       <label><?php _e('Password:'); ?></label>
      <p><input name="pwd" id="user_pass" type="password" value="" class="inbox"/></p>

      <p><input name="submit" type="submit" value="Login" class="submit-button"/>
      <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
      </p>

      <p class="chk"><input name="rememberme" id="rememberme" value="forever" type="checkbox" checked="checked" />&nbsp;<?php _e('remember me'); ?></p>
      <p class="chk"><a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" title="Get a new password sent to you"><?php _e('Lost your password?'); ?></a></p><br />
<p class="chk"><a href="<?php bloginfo('url'); ?>/wp-signup.php" title="Sign up for a new account"><?php _e('Create a new account'); ?></a></p><br />
      </form>

<?php else: ?>

<div id="user-profile">
<h3><?php _e('Your Info.'); ?></h3>

<?php
$tmp_blog_id = $wpdb->get_var("SELECT meta_value FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'primary_blog' AND user_id = '" . $user_ID . "'");
$tmp_blog_domain = $wpdb->get_var("SELECT domain FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");
$tmp_blog_path = $wpdb->get_var("SELECT path FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");

if ($tmp_blog_domain == ''){
	$tmp_blog_domain = $current_site->domain;
}

if ($tmp_blog_path == ''){
	$tmp_blog_path = $current_site->path;

}

$tmp_user_url =  'http://' . $tmp_blog_domain . $tmp_blog_path;
?>

<a href="<?php echo $tmp_user_url; ?>" title="Go to your blog homepage"><?php echo get_avatar($user_ID,'48',get_option('avatar_default')); ?></a>
&nbsp;<a href="<?php echo $tmp_user_url; ?>wp-admin/" title="<?php _e('Dashboard') ?>"><strong><?php _e('Your dashboard'); ?></a></strong>

<br />
&nbsp;<a href="<?php echo $tmp_user_url; ?>wp-admin/post-new.php" title="<?php _e('Posting Area') ?>"><?php _e('Write a post'); ?></a>
<br />
&nbsp;<a href="<?php echo $tmp_user_url; ?>wp-admin/users.php?page=edit_user_avatar" title="<?php _e('Edit your avatar') ?>"><?php _e('Upload new avatar'); ?></a>
<br /><br />
Welcome back, <?php echo $user_identity; ?>, use the links above to get started or you can <?php $mywp_version = get_bloginfo('version'); if ($mywp_version >= '2.7') { ?> <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>"><?php _e('Log out &raquo;'); ?></a> <?php } else { ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Log out &raquo;'); ?></a> <?php } ?>.

<br /><br />
You can get help and support and chat to other users at the <a href="<?php bloginfo('url'); ?>/forums" target="_blank" title="Search, post at and enjoy our discussion space">Forums</a>.
</div>

<?php endif; ?>

</div>