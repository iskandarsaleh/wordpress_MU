<?php get_header(); ?>

<div id="main_content">
	
	 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<h3 class="subhead"><?php the_time('j F Y'); ?></h3>
	
	<h2 id="headline"><a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

	<p><?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?></P>
	
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><em>No posts were found with this query. If you think you've reached this in error,
		 <a href="mailto:<?php bloginfo('admin_email'); ?>">e-mail the administrator(s)</a> of this site.</em></p>
	
	<?php endif; ?>
		
</div>


<?php get_sidebar(); ?>

<?php get_footer(); ?>