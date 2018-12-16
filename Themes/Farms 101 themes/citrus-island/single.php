<?php get_header(); ?>
<?php get_sidebar(); ?>
    <div id="main">
				
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	    <?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<!--
			<?php trackback_rdf(); ?>
		-->
		<p class="post-footer align-right">
			<?php the_category(', ') ?> | <span class="date"><?php the_time(__('F jS, Y')) ?></span>by <?php the_author() ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit'), '| ',''); ?>
		    <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Both Comments and Pings are open ?>
			<br /><?php _e('You can');?> <a href="#respond"><?php _e('leave a response');?></a>, <?php _e('or');?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.
			<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			// Only Pings are Open ?>
			<br /><?php _e('Responses are currently closed, but you can');?> <a href="<?php trackback_url(true); ?> " rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.
			<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Comments are open, Pings are not ?>
			<br />You can skip to the end and leave a response. Pinging is currently not allowed.
			<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			// Neither Comments, nor Pings are open ?>
			<br />Both comments and pings are currently closed.			
			<?php } ?>
				
		</p>
		<?php comments_template(); ?>
	    <div>
			<div class="align-left"><small><?php previous_post_link('&laquo; %link') ?></small></div>
			<div class="align-right"><small><?php next_post_link('Next: %link &raquo;') ?></small></div>
		</div>
		<?php endwhile; else: ?>
	    <p><?php _e('Sorry, no posts matched your criteria.');?></p>
        <?php endif; ?>
    </div>
<?php include (TEMPLATEPATH . '/rbar.php'); ?>	
<?php get_footer(); ?>