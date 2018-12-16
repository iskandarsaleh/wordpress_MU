<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft"><?php previous_post('« %','','yes') ?></div>
			<div class="alignright"><?php next_post(' % »','','yes') ?></div>
		</div>
	
		<div class="post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<div class="entrytext">
				<?php the_content('<p class="serif">Read the rest of this entry »</p>'); ?>
	
				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
	

				<p class="postmetadata graybox">
					<small>
						<?php _e('This entry was posted');?>
						<?php /* This is uncommented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?> 
						<?php _e('on');?> <?php the_time(__('l, F jS, Y')) ?> <?php _e('at');?> <?php the_time() ?>
						<?php _e('and is filed under');?> <?php the_category(', ') ?>. <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?>
						You can follow any responses to this entry through the <a href="<?php bloginfo_rss('comments_rss2_url'); ?>">RSS 2.0</a>
						feed. 
						
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php _e('You can');?> <a href="#respond"><?php _e('leave a response');?></a>, <?php _e('or');?> <a href="<?php trackback_url(display); ?>">trackback</a> from your own site.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php _e('Responses are currently closed, but you can');?> <a href="<?php trackback_url(display); ?>"><?php _e('trackback');?></a> <?php _e('from your own site.');?>

							<?php _e('Both comments and pings are currently closed.');?>
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
        <?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.');?>
			
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
	
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>