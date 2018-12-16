<?php get_header(); ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>	

		<div id="content">
				
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="singlepost" id="post-<?php the_ID(); ?>"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860graphite"); } ?>
				<h1><?php the_title(); ?></h1>

				<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
					<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
				</div>

			</div>
	
		<?php endwhile; else: ?>
		<?php endif; ?>		

                </div>

		</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>