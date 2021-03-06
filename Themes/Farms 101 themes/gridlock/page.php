<?php get_header(); ?>

<div id="main_content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // enter the loop ?>
	
	<h3 class="subhead"><?php bloginfo('name'); ?>: <?php the_title(); ?></h3>
	
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		
	<?php endwhile; else: ?>
	<p><?php _e('No posts were located with the given criteria. <a href="javascript:history.back()">Go back</a> and try again.'); ?></p>
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>