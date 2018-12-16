<?php get_header(); ?>



<!-- content ................................. -->

<div id="content" class="archive">



<?php if (have_posts()) : ?>



	<h2><?php _e('Search Results for ');?> <em>&#8216;<?php echo wp_specialchars($s, 1); ?>&#8217;</em></h2>



<?php while (have_posts()) : the_post(); ?>



	<div class="entry">



		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>



		<?php ($post->post_excerpt != "")? the_excerpt() : BX_shift_down_headlines(get_the_content()); ?>



		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink() ?>" class="more">Continue Reading</a><?php } ?>

   		<?php comments_popup_link(__('Add comment'), __('1 comment'), __('% comments'), __('commentlink'), ''); ?>

   		<em class="date"><?php the_time(__('F jS, Y')) ?><!-- at <?php the_time('h:ia')  ?>--></em>

   		<!--<em class="author"><?php the_author(); ?></em>-->

   		<?php edit_post_link(__('Edit'), '<span class="editlink">','</span>'); ?>

   		</p>



	</div>





<?php endwhile; ?>



	<p><!-- this is ugly -->

	<span class="next"><?php previous_posts_link('Next Posts') ?></span>

	<span class="previous"><?php next_posts_link('Previous Posts') ?></span>

	</p>



<?php else : ?>



	<h2>No Results for <em>&#8216;<?php echo $s ?>&#8217;</em></h2>

	<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>



<?php endif; ?>



</div> <!-- /content -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>