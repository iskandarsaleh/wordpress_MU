<?php get_header(); ?>

	<div id="content" class="widecolumn"><br /><br /><br /><br />
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-top"); } ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	

	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:','contempt'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
			<div class="entry">
		
			<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>','contempt')); ?>
	
				<?php link_pages(__('<p><strong>'.__('Pages:').'</strong> ','contempt'), '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php _e('This entry was posted on','contempt'); ?>

						<?php the_time(get_option('date_format')) ?> <?php _e('at','contempt'); ?> <?php the_time() ?>
						<?php _e('and is filed under','contempt'); ?> <?php the_category(', ') ?>. <?php the_tags( __( 'Tagged' ) . ': ', ', ', '.'); ?>
						<?php _e('You can follow any responses to this entry through the','contempt'); ?> <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed','contempt'); ?>. 
						
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
						<?php _e('You can','contempt'); ?> <a href="#respond"><?php _e('leave a response','contempt'); ?></a>, <?php _e('or','contempt'); ?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('trackback','contempt'); ?></a> <?php _e('from your own site','contempt'); ?>.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
						<?php _e('Responses are currently closed, but you can','contempt'); ?> <a href="<?php trackback_url(true); ?> " rel="trackback"><?php _e('trackback','contempt'); ?></a> <?php _e('from your own site','contempt'); ?>.
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
						<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.','contempt'); ?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
						<?php _e('Both comments and pings are currently closed.','contempt'); ?>			
						
						<?php } edit_post_link(__('Edit this entry.','contempt'),'',''); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.','contempt'); ?></p>
	
<?php endif; ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-bottom"); } ?>
	</div>
	
	

<?php get_sidebar(); ?>	
	
<?php get_footer(); ?>
