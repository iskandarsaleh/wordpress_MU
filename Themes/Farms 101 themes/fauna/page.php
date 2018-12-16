<?php get_header(); ?>

	<div id="body">
		
		<div id="main" class="entry">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div class="box">
				<div class="entry">
					<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
					
					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content('Continue reading this entry &raquo;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					
					<?php wp_link_pages(); ?>
				</div>				
				
				<?php edit_post_link('Edit This', ' &#8212; '); ?>
			
				<hr />
				
			</div>

			<?php if ( comments_open() ) comments_template(); // Get wp-comments.php template ?>

			<?php endwhile; else: ?>
				<div class="box">
					<h2><?php _e('Not Found') ?></h2>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				</div>		
			<?php endif; ?>
			
			<hr />
	
		</div>
		
		<?php get_sidebar(); ?>
		
	</div>

	<?php get_footer(); ?>