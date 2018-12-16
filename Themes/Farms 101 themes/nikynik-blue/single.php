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
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__('Read the rest of this entry &raquo;','nikynik')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php link_pages(__('<p><strong>Pages:</strong> ','nikynik'), '</p>', __('number','nikynik')); ?>
	
				<p class="postmetadata alt">
					<small>
						<?php _e('This entry was posted','nikynik'); ?> <?php _e('on','nikynik'); ?> <?php the_time(__('l, F jS, Y','nikynik')) ?> @ <?php the_time() ?> <?php _e('on the category','nikynik'); ?> <?php the_category(', ') ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?>.
						<?php _e('You can follow any responses to this entry through the','nikynik'); ?> <?php comments_rss_link('RSS 2.0'); ?> <?php ('feed. '); ?>
<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
<?php _e('You can','nikynik'); ?> <a href="#respond"><?php _e('leave a response','nikynik'); ?></a>, <?php _e('or','nikynik'); ?> <a href="<?php trackback_url(display); ?>"><?php _e('trackback'); ?></a> <?php _e('from your own site.','nikynik'); ?>
<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
<?php _e('Responses are currently closed, but you can','nikynik'); ?> <a href="<?php trackback_url(display); ?> "><?php _e('trackback'); ?></a> <?php _e('from your own site.','nikynik'); ?>
<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.','nikynik'); ?>
<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
<?php _e('Both comments and pings are currently closed.','nikynik'); ?>
<?php } edit_post_link(__('Edit this entry','nikynik'),'',''); ?>
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.','nikynik'); ?></p>
	
<?php endif; ?>
	
	</div>


<?php get_footer(); ?>