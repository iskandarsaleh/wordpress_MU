<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="page">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<h1><?php the_title(); ?></h1>
			<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
								<p><?php the_content(__('Read the rest of this page &rarr;')); ?></p>
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
			</div>
			
			<?php endwhile; endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>