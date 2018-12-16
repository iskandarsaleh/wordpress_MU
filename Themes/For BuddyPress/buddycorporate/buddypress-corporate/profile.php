
<form id="search-form" method="get" action="<?php bloginfo ('home'); ?>">
<input name="s" id="search-terms" type="text" value="Search here" onfocus="if (this.value == 'Search here') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search here';}" size="10" tabindex="1" />
<input type="submit" name="search-submit" id="search-submit" value="<?php echo attribute_escape(__('Search')); ?>" />
</form>

<?php
  global $user_ID, $user_identity, $user_url, $user_email;
  get_currentuserinfo();
  if (!$user_ID):
?>


<form name="loginform" id="login-form" action="<?php echo get_settings('siteurl'); ?>/wp-login.php" method="post">
<input type="text" name="log" id="user_login" value="Username" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}" />
<input type="password" name="pwd" id="user_pass" class="input" value="" />
<input type="checkbox" name="rememberme" id="rememberme" value="forever" title="Remember Me" />
<input type="submit" name="wp-submit" id="wp-submit" value="<?php echo attribute_escape(__('Login')); ?>"/>
<input type="button" name="signup-submit" id="signup-submit" value="Sign Up" onclick="location.href='<?php echo get_settings('siteurl'); ?>/wp-login.php?action=register'" />
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
</form>

<?php else: ?>

<?php
$pathtotheme = get_bloginfo('stylesheet_directory');
$md5 = md5($user_email);
$default = urlencode("$pathtotheme/images/mygif.gif");
?>


<div id="logout-link">
<?php echo "<img style='width: 20px; height: 20px;' src='http://www.gravatar.com/avatar.php?gravatar_id=$md5&size=20&default=$default' alt='$user_identity' />"; ?>&nbsp;
<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><strong><?php echo $user_identity; ?></strong></a> / <?php $mywp_version = get_bloginfo('version'); if ($mywp_version >= '2.7') { ?> <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>"><?php _e('Log out'); ?></a> <?php } else { ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Log out'); ?></a> <?php } ?>
</div>

<?php endif; ?>
