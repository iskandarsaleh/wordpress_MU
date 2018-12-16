<?php get_header(); ?>

	<div id="content" class="widecolumn">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="navigation">
			<div class="alignleft">&nbsp;</div>
			<div class="alignright">&nbsp;</div>
		</div>
<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link'); ?>: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>
		<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?>
				<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<p class="postmetadata alt">
					<small>
<!--						eleni change on 25/2/08This entry was posted-->
<?php printf(__('This entry was posted on %s at %s and is filed under %s %s.'),
							get_the_time(get_option('date_format')),
							get_the_time(get_option('time_format')),
							get_the_category_list(', '),
							get_the_tag_list(__('with tags').' ', ', ')
							); ?>
												<?php _e('You can follow any responses to this entry through the');?> <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed');?>.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php printf(__('You can <a href="%s">leave a response</a>, or <a href="%s"  rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.'), '#respond', get_trackback_url()); ?>

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php printf(__('Responses are currently closed, but you can <a href="%s" rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.'),trackback_url(false)); ?>

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.'); ?>

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.');?>

						<?php } edit_post_link(__('Edit this entry.'),'',''); ?>

					</small>
				</p>

			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no attachments matched your criteria.');?></p>

<?php endif; ?>

	</div>

<?php get_footer(); ?>
