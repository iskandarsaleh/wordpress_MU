<?php
/*
Template Name: Archive Page
*/
?>

<?php get_header(); ?>

<?php include (TEMPLATEPATH . "/sidebar1.php"); ?>	

		<div id="content">
				
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post" id="post-<?php the_ID(); ?>" style="padding-top:0;">
			


						<h2 class="sectionhead"><?php _e('Monthly Archives');?></h2>
						<ul id="archives"><?php wp_get_archives('type=monthly'); ?></ul>

						<h2 class="sectionhead"><?php _e('Category Archives');?></h2>
						<ul id="archives"><?php wp_list_categories('title_li='); ?></ul>

						<h2 class="sectionhead">Post-by-Post Archives</h2>
						<ul id="archives"><?php wp_get_archives('type=postbypost'); ?></ul>


				</div>
	
		<?php endwhile; else: ?>
		<?php endif; ?>		

                </div>

		</div>

<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>