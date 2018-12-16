<?php 
get_header();
?>

	
	<div id="colOne">
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2)) : ?>
		<h2>Recent update</h2>
		<ul>
			<?php get_archives('postbypost', 10); ?>	
		</ul>
		
			<div align="center"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/feed.png" border="0" alt="Subscribe to RSS feed"/></a></div>
		<?php endif; ?>
	</div>
	<div id="colTwo">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<p class="file"><small><?php the_time(__('F jS, Y')) ?>  by <?php the_author() ?></small></p><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
		<p><?php the_content(__('(more...)')); ?></p><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
		<p><?php _e('Posted in ');?> <?php the_category(', ') ?> | <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?> | <?php edit_post_link(__('Edit'), ' | ', ''); ?> | <?php wp_link_pages(); ?>
    <?php comments_popup_link(__('0 Comments'), __('1 Comments'), __('% Comments')); ?></p>		
		<?php comments_template(); // Get wp-comments.php template ?>
<?php endwhile; else: ?><?php endif; ?>
<?php next_posts_link(__('&laquo; Previous Entries')) ?> <?php previous_posts_link(__('Next Entries &raquo;')) ?>
	</div>
<?php get_sidebar();?>	
<?php get_footer(); ?>
