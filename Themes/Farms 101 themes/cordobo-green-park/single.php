<?php get_header(); ?>
<?php get_sidebar(); ?>


<div id="content">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="entry">
					<div class="latest">

				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

				<div class="meta<?php if(is_home() && $post==$posts[0] && !is_paged()) echo ' firstpost';?>">
					<?php _e("Posted on "); ?> <?php the_time(__('F jS, Y')) ?> <?php _e('in');?> <?php the_category(',') ?> <?php _e('by');?> <?php the_author() ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?>
				</div>
				
	
				<div class="main"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					<?php the_content(''); ?>
					
					<?php wp_link_pages(); ?>
				</div>


				<!--
					<?php trackback_rdf(); ?>
				-->

		</div>
	</div>



	<?php comments_template(); ?>



	<?php endwhile; else: ?>

		<div class="warning">
			<p><?php _e('Sorry, no posts matched your criteria, please try and search again.'); ?>
				
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
				
				</p>
		</div>



	<?php endif; ?>

		<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>



</div> <!-- /content -->


<?php get_footer(); ?>
