<?php get_header(); ?>





<div id="recent">


<div class="container">


<div class="recent-post">


	


	<?php if (have_posts()) : ?>





<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>


<?php /* If this is a category archive */ if (is_category()) { ?>


<h2 class="yellow"><?php echo single_cat_title(); ?> category archive </h2>





<?php /* If this is a daily archive */ } elseif (is_day()) { ?>


<h2 class="yellow"><?php the_time(__('F jS, Y')); ?><?php _e('Archive');?></h2>





<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>


<h2 class="yellow"><?php the_time('F, Y'); ?><?php _e('Archive');?></h2>





<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>


<h2 class="yellow"><?php the_time('Y'); ?><?php _e('Archive');?></h2>





<?php /* If this is a search */ } elseif (is_search()) { ?>


<h2 class="yellow"><?php _e('Search Results');?></h2>





<?php /* If this is an author archive */ } elseif (is_author()) { ?>


<h2 class="yellow"><?php _e('Author Archive');?></h2>





<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>


<h2 class="yellow"><?php _e('Blog Archives');?></h2>





<?php } ?>


	





</div><div class="clear"></div>


</div>


</div>





<div id="posts">


	<div class="container">


	<div class="recent-post">





<?php while (have_posts()) : the_post(); ?>


<!-- BEGIN post -->


<div class="post">


<h2 class="post-title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>


<small><?php the_time(__('F jS, Y')) ?> | <?php the_category(', ') ?> | <?php comments_popup_link('No comments', '1 comment', '% comments','Comments are off for this post'); ?> <?php edit_post_link('Edit this post'); ?></small>


<div class="post-body">


<?php the_excerpt('Continue reading'); ?>


</div>


</div>


<?php endwhile; ?>


<!-- END post -->





<div class="content-navigate clearfix">


<span class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></span>


<span class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></span>


</div>





<?php else : ?>





<h3><?php _e('Not Found');?></h3>


<?php include (TEMPLATEPATH . '/searchform.php'); ?>





<?php endif; ?>





</div>


<div id="sidebar">


		<ul  class="widgets">


				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('MostRecent sidebar') ) : ?>


				<?php endif; ?>	


				<?php if ( !function_exists('dynamic_sidebar')


        || !dynamic_sidebar('Recents sidebar') ) : ?>


				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>


				<?php wp_list_bookmarks(); ?>


				<?php } ?>


				<?php endif; ?>	


		</ul>


	</div>


</div>


<div class="clear"></div>


</div>





<?php get_footer(); ?>