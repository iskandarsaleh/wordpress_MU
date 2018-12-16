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

function j_ShowAbout() { ?>
<li class="about">
  <h2><?php _e('About');?></h2>
  <p><img src="<?php bloginfo('stylesheet_directory');?>/images/you.jpg" alt="You Avatar" class="ileft" id="avatr"  /><?php $userdata = get_userdata(1); ?><?php if ($userdata->description != '') { ?>
<?php _e($userdata->description); ?></p><?php } else { ?>If you want edit me? just go to your profile than add description text as many you like. ^_*<?php } ?></p>
  </li>
<?php }	function j_ShowRecentPosts() {?>
<li class="boxr">
  <h2>Recent Post</h2>
  <ul>
    <?php wp_get_archives('type=postbypost&limit=10');?>
  </ul>
</li>
<?php }	?>
<?php

if ( function_exists('register_sidebars') )
	register_sidebars(1);

/* Some very fast and very simple header exchange magic 
	***	Keep on Trying
	***	Be Creative
*/

define('HEADER_IMAGE', '%s/images/bgpre.gif'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 480);
define('HEADER_IMAGE_HEIGHT', 150);

function admin_header_style() { ?>


<?php }

function header_style() { ?>

<style type="text/css">
#pre {
	background: #67EE4B url(<?php header_image(); ?>) left top no-repeat;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
}
</style>

<?php }

if ( function_exists('add_custom_image_header') ) {
  add_custom_image_header('header_style', 'admin_header_style');
} 

/* There you go, have a nice day */
?>