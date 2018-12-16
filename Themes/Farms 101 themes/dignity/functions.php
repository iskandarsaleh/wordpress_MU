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

function ShinyRoad_ShowAbout() { ?>
<div class="about">
  <h4>Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. You can edit this text on your own Profile in WordPress Admin</h4>
  </div>
<?php }	function ShinyRoad_ShowRecentPosts() {?>
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

	/** Some very fast and very simple header exchange magic 
	**	Keep on Trying
	***	Be Creative
*/

define('HEADER_IMAGE', '%s/images/pixr.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 520);
define('HEADER_IMAGE_HEIGHT', 140);

function admin_header_style() { ?>
<style type="text/css">
#pager .pix,#headimg {
        background: #E0303A url(<?php header_image(); ?>) 0 0 no-repeat;
        height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
        width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
</style>

<?php }

function header_style() { ?>

<style type="text/css">
#pager .pix {
	background: #BDE701 url(<?php header_image(); ?>) 0 0 no-repeat;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
}
</style>

<?php }

if ( function_exists('add_custom_image_header') ) {
  add_custom_image_header('header_style', 'admin_header_style');
} 

/* There you go, have a nice day */
?>