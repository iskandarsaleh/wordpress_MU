<?php
// check functions
  if ( function_exists('wp_list_bookmarks') ) //used to check WP 2.1 or not
    $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' and post_status = 'publish'");
	else
    $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
  if (0 < $numposts) $numposts = number_format($numposts); 
	$numcmnts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
		if (0 < $numcmnts) $numcmnts = number_format($numcmnts);
// ----------------

function jh_ShowAbout() { ?>
<li class="about">
  <h2>About</h2>
  <p><img src="<?php bloginfo('stylesheet_directory');?>/images/you.jpg" alt="You Avatar" class="iright" id="avatr"  /><?php $userdata = get_userdata(1); ?><?php if ($userdata->description != '') { ?>
<?php _e($userdata->description); ?></p><?php } else { ?>If you want edit me? Go to your profile than add description text. ^_*<?php } ?></p>
  </li>
<?php }	function jh_ShowRecentPosts() {?>
<li class="boxr">
  <h2>Recent Post</h2>
  <ul>
    <?php wp_get_archives('type=postbypost&limit=10');?>
  </ul>
</li>
<?php }	?>
<?php

if ( function_exists('register_sidebars') )
	register_sidebars(2);

		/* Some very fast and very simple header exchange magic 
	***	Keep on Trying
	***	Be Creative
*/


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/headr.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 970);
define('HEADER_IMAGE_HEIGHT', 150);
define( 'NO_HEADER_TEXT', false );

function anubis_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>
<?php
}


add_custom_image_header('', 'anubis_admin_header_style');




/* There you go, have a nice day */
?>
