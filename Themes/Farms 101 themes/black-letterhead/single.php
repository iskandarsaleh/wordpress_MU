<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_post('&laquo; %','','yes') ?></div>
			<div class="alignright"><?php next_post(' % &raquo;','','yes') ?></div>
		</div>
	
		<div class="post">
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
			<div class="entrytext">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;').'</p>'); ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php printf(__('This entry was posted on %s at %s and is filed under %s %s.'),
							get_the_time(get_option('date_format')),
							get_the_time(get_option('time_format')),
							get_the_category_list(', '),
							get_the_tag_list(__('with tags').' ', ', ')
							); ?>
						<?php printf(__('You can follow any responses to this entry through the %s feed'), "<a href='".attribute_escape(get_post_comments_feed_link())."'>RSS 2.0</a>"); ?>

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php printf(__('You can <a href="%s">leave a response</a>, or <a href="%s">trackback</a> from your own site.'), '#respond', get_trackback_url()); ?>
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php printf(__('Responses are currently closed, but you can <a href="%s">trackback</a> from your own site.'), get_trackback_url()); ?>
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.'); ?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.'); ?>
						
						<?php } edit_post_link(__('Edit this entry.'),'',''); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>
