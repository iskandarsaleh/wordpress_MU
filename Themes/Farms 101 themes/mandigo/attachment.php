<?php 
	get_header();

	$tag_pagetitle = get_option('mandigo_tag_pagetitle'       );
?>
	<td id="content" class="<?php echo ($alwayssidebars ? 'narrow' : 'wide'); ?>column">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
	<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<<?php echo $tag_pagetitle; ?> class="pagetitle"><a href="<?php echo get_permalink($post->post_parent); ?>" rel="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></<?php echo $tag_pagetitle; ?>>
			<div class="entry">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content('<p class="serif">'. __('Read the rest of this entry','mandigo') .' &raquo;</p>'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

				<?php link_pages('<p><strong>'. __('Pages','mandigo') .':</strong> ', '</p>', 'number'); ?>

				<p class="postmetadata alt">
					<small>
						<?php printf(__('This entry was posted on %s at %s and is filed under %s.','mandigo'),get_the_time(__('l, F jS, Y','mandigo')),get_the_time(),get_the_category_list(', ')); ?>
						<?php printf(__('You can follow any responses to this entry through the %s feed.','mandigo'),'<a href="'. comments_rss() .'">RSS 2.0</a>'); ?>



						<?php edit_post_link(__('Edit this entry.','mandigo'),'',''); ?>

					</small>
				</p>

			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.','mandigo'); ?></p>

<?php endif; ?>

	</td>

<?php
	if (get_option('mandigo_always_show_sidebars')) {
		if (!get_option('mandigo_nosidebars')) {
			include (TEMPLATEPATH . '/sidebar.php');
			if (get_option('mandigo_1024') && get_option('mandigo_3columns')) include (TEMPLATEPATH . '/sidebar2.php');
		}
	}

	get_footer(); 
?>
