<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<div id="headerimg">
		<a href="<?php echo get_settings('home'); ?>"><img src="<?php header_image() ?>" width="480" height="200" /></a>
	</div>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-jakarta-top"); } ?>
<div id="content" class="widecolumn">

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<h2><?php _e('Archives by Month:');?></h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2><?php _e('Archives by Subject:');?></h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

</div>	

<?php get_footer(); ?>
