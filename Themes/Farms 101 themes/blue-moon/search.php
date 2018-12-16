<?php


get_header();


?>





<div id="content">	


<h2 class="archives"><?php _e('Search Results');?></h2>





  <?php if (have_posts()) : ?>


	<?php while (have_posts()) : the_post(); ?>


  	<div class="entry">


    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>


	  <div class="entrymeta">


		<?php the_time('F dS, Y ');?>


	</div>


  </div>


  <?php endwhile; else: ?>


  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>





  <?php endif; ?>


  <p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>


</div>





<?php get_sidebar(); ?>





<?php get_footer(); ?>


