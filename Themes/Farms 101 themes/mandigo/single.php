<?php 
	get_header();

	$tag_posttitle_single = get_option('mandigo_tag_posttitle_single');
	$tag_pagetitle        = get_option('mandigo_tag_pagetitle'       );
?>
	<td id="content" class="<?php echo ($alwayssidebars ? 'narrow' : 'wide'); ?>column">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mandigo-fafafa"); } ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo;&nbsp;%link') ?></div>
			<div class="alignright"><?php next_post_link('%link&nbsp;&raquo;') ?></div>
		</div>

		<div class="post" id="post-<?php the_ID(); ?>">
                                <div class="postinfo">
			        	<div class="calborder">
			        	<div class="cal">
                                                <span class="cald<?php echo (get_option('mandigo_dates') ? ' cald2' : '') ?>"><?php the_time((get_option('mandigo_dates') ? 'M' : 'd')) ?></span>
                                                <span class="calm"><?php the_time((get_option('mandigo_dates') ? 'd' : 'm')) ?></span>
                                                <span class="caly"><?php the_time('Y') ?></span>
                                        </div>
                                        </div>
					<?php if (!get_option('mandigo_no_animations')): ?>
					<span class="switch-post">
						<a href="javascript:toggleSidebars();" class="switch-sidebars"><img src="<?php echo $dirs['www']['icons']; ?>bullet_sidebars_hide.png" alt="" class="png" /></a><a href="javascript:togglePost(<?php the_ID(); ?>);" id="switch-post-<?php the_ID(); ?>"><img src="<?php echo $dirs['www']['icons']; ?>bullet_toggle_minus.png" alt="" class="png" /></a>
					</span>
					<?php endif; ?>
                                        <<?php echo $tag_posttitle_single; ?> class="posttitle"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></<?php echo $tag_posttitle_single; ?>>
                                        <small>
						<?php printf(__('Posted by: %s in %s','mandigo'),mandigo_author_link(get_the_author_ID(),get_the_author()),get_the_category_list(', ')) ?><?php if (function_exists('the_tags') && !get_option('mandigo_tags_after')) the_tags(', '. __('tags','mandigo') .': '); ?>
					</small>
                                </div>

			<div class="entry">
				
<?php the_content('<p class="serif">'. __('Read the rest of this entry','mandigo') .' &raquo;</p>'); ?>



				<?php link_pages('<p><strong>'. __('Pages','mandigo') .':</strong> ', '</p>', 'number'); ?>

				<?php if (function_exists('the_tags') && get_option('mandigo_tags_after')) the_tags(); ?>

				<p class="postmetadata alt clear">
					<small>
						<?php printf(__('This entry was posted on %s at %s and is filed under %s.','mandigo'),get_the_time(__('l, F jS, Y','mandigo')),get_the_time(),get_the_category_list(', ')); ?>
						<?php printf(__('You can follow any responses to this entry through the %s feed.','mandigo'),'<a href="'. comments_rss() .'">RSS 2.0</a>'); ?>

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php printf(__('You can <a href="#respond">leave a response</a>, or <a href="%s" rel="trackback">trackback</a> from your own site.','mandigo'),trackback_url(false)); ?>

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php printf(__('Responses are currently closed, but you can <a href="%s" rel="trackback">trackback</a> from your own site.','mandigo'),trackback_url(false)); ?>

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can <a href="#respond">skip to the end</a> and leave a response. Pinging is currently not allowed.','mandigo'); ?>

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.','mandigo'); ?>

						<?php } edit_post_link(__('Edit this entry.','mandigo'),'',''); ?>

					</small>

				</p>
			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<<?php echo $tag_pagetitle; ?>><?php _e('Sorry, no posts matched your criteria.','mandigo'); ?></<?php echo $tag_pagetitle; ?>>

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
