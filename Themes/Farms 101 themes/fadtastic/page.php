<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post" id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?></h1>
					<div class="entrytext">
					
					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			
					</div>
				</div>
			  <?php endwhile; endif; ?>
	
				<?php if ( comments_open() ) comments_template(); ?>
				
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
