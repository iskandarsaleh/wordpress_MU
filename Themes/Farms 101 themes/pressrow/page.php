<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("250x250-pressrow-top"); } ?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post" id="post-<?php the_ID(); ?>">
						<h2 style="padding-top: 0;"><?php the_title(); ?></h2>
						<div class="entry">
							
							
							<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>
							
				
							<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
						</div>
					</div>
					
				<?php if ( comments_open() ) comments_template(); // Get wp-comments.php template ?>

				<?php endwhile; endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

<?php get_footer(); ?>