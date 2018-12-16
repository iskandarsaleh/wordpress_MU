<?php get_header(); ?>

<div id="main">

<h4>Currently browsing posts found in <?php single_month_title(); ?></h4><br />
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<div class="archive_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>

<div class="main_post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?>
<?php the_excerpt(__('Continue Reading &raquo;')); ?><br /><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?>
<?php _e('Posted at:');?> <?php the_time('F jS, Y - g:i a');?> - <?php comments_popup_link(__('Number of Comments &raquo; 0'), __('Number of Comments &raquo; 1'), __('Number of Comments &raquo; %')); ?><hr />
</div>




<!--
	<?php trackback_rdf(); ?>
	-->



<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<div class="navi" align="right"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></div>

</div> 


<div id="menu">
<?php get_sidebar(); ?>
</div>

</div>
<div class="clearfix"></div>
<div id="footer"><?php get_footer(); ?></div>
</div>

</body>
</html>