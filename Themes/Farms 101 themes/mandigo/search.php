<?php 
	get_header();

	$tag_posttitle_multi = get_option('mandigo_tag_posttitle_multi');
	$tag_pagetitle       = get_option('mandigo_tag_pagetitle'      );
?>
	<td id="content" class="narrowcolumn">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mandigo-fafafa"); } ?>

	<?php if (have_posts()) : ?>

		<<?php echo $tag_pagetitle; ?> class="pagetitle"><?php _e('Search Results','mandigo'); ?></<?php echo $tag_pagetitle; ?>>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo;&nbsp;'. __('Previous Entries','mandigo')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries','mandigo') .'&nbsp;&raquo;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>">
				<?php if (!get_option('mandigo_no_animations')): ?>
				<span class="switch-post">
					<a href="javascript:toggleSidebars();" class="switch-sidebars"><img src="<?php echo $dirs['www']['icons']; ?>bullet_sidebars_hide.png" alt="" class="png" /></a><a href="javascript:togglePost(<?php the_ID(); ?>);" id="switch-post-<?php the_ID(); ?>"><img src="<?php echo $dirs['www']['icons']; ?>bullet_toggle_minus.png" alt="" class="png" /></a>
				</span>
				<?php endif; ?>
				<<?php echo $tag_posttitle_multi; ?> class="posttitle posttitle-search"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s','mandigo'),the_title('','',false)); ?>"><?php the_title(); ?></a></<?php echo $tag_posttitle_multi; ?>>
				<small><?php the_time('l, F jS, Y') ?></small>

			<?php if (get_option('mandigo_full_search_results')): ?>
				<div class="entry">
				<?php the_content(__('Read the rest of this entry','mandigo') .' &raquo;'); ?>
				</div>
				<div class="clear"></div>

			<?php endif; ?>
				<p class="postmetadata alt"><?php printf(__('Posted by: %s in %s','mandigo'),mandigo_author_link(get_the_author_ID(),get_the_author()),get_the_category_list(', ')) ?> | <?php if (function_exists('the_tags')) the_tags(__('tags','mandigo') .': ',', ',' | '); ?><?php edit_post_link(__('Edit','mandigo'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments','mandigo'). ' &#187;', __('1 Comment','mandigo'). ' &#187;', __('% Comments','mandigo'). ' &#187;'); ?></p>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo;&nbsp;'. __('Previous Entries','mandigo')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries','mandigo') .'&nbsp;&raquo;') ?></div>
		</div>

	<?php else : ?>

		<<?php echo $tag_pagetitle; ?> class="center"><?php _e('No posts found. Try a different search?','mandigo'); ?></<?php echo $tag_pagetitle; ?>>
		<p class="center"><?php _e('Sorry, no posts matched your search criteria. Please try and search again.','mandigo'); ?></p>

	<?php endif; ?>

	</td>

<?php
	if (!get_option('mandigo_nosidebars')) {
		include (TEMPLATEPATH . '/sidebar.php');
		if (get_option('mandigo_1024') && get_option('mandigo_3columns')) include (TEMPLATEPATH . '/sidebar2.php');
	}

	get_footer(); 
?>
