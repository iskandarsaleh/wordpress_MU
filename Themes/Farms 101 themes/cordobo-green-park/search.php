<?php get_header(); ?>


<?php get_sidebar(); ?>








<div id="content">


	


	<?php if (have_posts()) : ?>





		<h2 class="pagetitle"><?php _e('Search Results');?></h2>


		


				<?php while (have_posts()) : the_post(); ?>





<div class="entry2">





	 <br /><h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>	








	<div class="meta"><?php _e("Posted"); ?> <?php the_time(__('F jS, Y')) ?> <?php the_category(',') ?> <?php _e('by');?> <?php the_author() ?> <?php edit_post_link(__('Edit'), '', ''); ?>


	</div>





</div>

















<?php endwhile; ?>





		<div class="navigation">


		


		<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>


		


		</div>





<?php else : ?>





		<h2 class="center"><?php _e('No posts found. Try a different search?');?></h2>


		


		<div class="entry">





<?php include (TEMPLATEPATH . '/searchform.php'); ?>





</div>








	<?php endif; ?>

















</div>





<!-- End content -->








<?php get_footer(); ?>


