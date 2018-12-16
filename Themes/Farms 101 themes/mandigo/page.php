<?php
	global $dirs;

	get_header();

	$tag_posttitle_single = get_option('mandigo_tag_posttitle_single');
?>
	<td id="content" class="narrowcolumn">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mandigo-fafafa"); } ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<?php if (!get_option('mandigo_no_animations')): ?>
			<span class="switch-post">
				<a href="javascript:toggleSidebars();" class="switch-sidebars"><img src="<?php echo $dirs['www']['icons']; ?>bullet_sidebars_hide.png" alt="" class="png" /></a><a href="javascript:togglePost(<?php the_ID(); ?>);" id="switch-post-<?php the_ID(); ?>"><img src="<?php echo $dirs['www']['icons']; ?>bullet_toggle_minus.png" alt="" class="png" /></a>
			</span>
		<?php endif; ?>
		<<?php echo $tag_posttitle_single; ?> class="posttitle"><?php the_title(); ?></<?php echo $tag_posttitle_single; ?>>
			<div class="entry">
				
				
				<?php the_content('<p class="serif">'. __('Read the rest of this page','mandigo') .' &raquo;</p>'); ?>
				
	

				<?php link_pages('<p><strong>'. __('Pages','mandigo') .':</strong> ', '</p>', 'number'); ?>

			<div class="clear"></div>
			</div>
		</div>
	<?php edit_post_link('<img src="'. $dirs['www']['scheme'] .'images/edit.gif" alt="" /> '. __('Edit this page','mandigo'), '<p>', '</p>'); ?>

	<?php if ( comments_open() ) comments_template(); // Get wp-comments.php template ?>
	<?php endwhile; endif; ?>


	</td>

<?php
	if (!get_option('mandigo_nosidebars')) {
		include (TEMPLATEPATH . '/sidebar.php');
		if (get_option('mandigo_1024') && get_option('mandigo_3columns')) include (TEMPLATEPATH . '/sidebar2.php');
	}

	get_footer(); 
?>
