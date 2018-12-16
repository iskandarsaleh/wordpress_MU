<?php get_header()?>	
	<div id="main">
	<div id="content">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div class="post">
				<?php require('post.php'); ?>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
			<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
		<p align="center"><?php posts_nav_link() ?></p>		
	</div>
	<div id="sidebar">
	<?php if ($posts) { ?>
	<h2><?php _e('Archived Entry') ?></h2>
	<ul>
	<li><?php _e('<strong>Post Date :</strong>') ?></li>
	<li><?php the_time(get_option('date_format')) ?> <?php _e('at');?> <?php the_time() ?></li>
	<li><?php _e('<strong>Category :</strong>') ?></li>
	<li><?php the_category(__(', ')); ?></li>
	<?php the_tags( '<li>' . __( 'Tags' ) . ': ', ', ', '</li>'); ?>
	<li><?php _e('<strong>Do More :</strong>') ?></li>
	<li><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php _e('You can');?> <a href="#respond"><?php _e('leave a response');?></a>, <?php _e('or');?> <a href="<?php trackback_url(display); ?>">trackback</a> from your own site.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php _e('Responses are currently closed, but you can');?> <a href="<?php trackback_url(display); ?>"><?php _e('trackback');?></a> <?php _e('from your own site.');?>


						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.') ?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.') ?>			
						
						<?php } edit_post_link(__('Edit this entry.'),'',''); ?></li>
	</ul>
	<?php }; ?>	
	</div>
<?php  get_footer();?>
</div>
</div>
</body>
</html>
